<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserProfile;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use MpesaSdk\StkPush;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $cartSummary = $this->getCartSummary($cartItems);

        return view('visitors.checkout', compact('cartItems', 'cartSummary'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'billing_name' => 'required|string|max:255',
            'billing_email' => 'required|email',
            'billing_phone' => 'required|string|regex:/^254[0-9]{9}$/|size:12',
            'billing_address' => 'required|string',
            'billing_city' => 'required|string|max:100',
            'billing_state' => 'required|string|max:100',
            'billing_postal_code' => 'required|string|max:20',
            'billing_country' => 'required|string|max:100',
            'subtotal' => 'required|numeric|min:0',
            'shipping' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'item_count' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);
        $stkpush = new StkPush();
        $phone_number = $request->billing_phone;
        $amount = (int) round($request->total); // Convert to integer, no decimals
        $reference ="Tununue_Orders";
        $description = $request->billing_country;

        $cartItems = $this->getCartItems();

        // Create or get user
        $user = Auth::user();
        if (!$user) {
            // Check if user already exists with this email
            $existingUser = User::where('email', $request->billing_email)->first();

            if ($existingUser) {
                // User exists, update their information if needed
                $existingUser->update([
                    'name' => $request->billing_name,
                    // Don't update email as it's the same
                    // Don't update password to preserve existing password
                ]);

                // Update or create user profile with billing information
                $profileData = [
                    'phone' => $request->billing_phone,
                    'shipping_address' => $request->billing_address . ', ' . $request->billing_city . ', ' . $request->billing_country,
                ];

                // Only add customer_code if creating new profile
                if (!$existingUser->userProfile) {
                    $profileData['customer_code'] = $this->generateUniqueCustomerCode();
                }

                $existingUser->userProfile()->updateOrCreate(
                    ['user_id' => $existingUser->id],
                    $profileData
                );

                $user = $existingUser;

                Log::info('Existing user found and updated for checkout', [
                    'user_id' => $existingUser->id,
                    'email' => $request->billing_email,
                    'name' => $request->billing_name
                ]);

                // Optionally send notification email to existing user
                // Mail::to($existingUser->email)->send(new OrderPlacedNotification($order));
            } else {
                // Create new user
                $user = User::create([
                    'name' => $request->billing_name,
                    'email' => $request->billing_email,
                    'password' => bcrypt(Str::random(16)),
                    'email_verified_at' => now(),
                    'role' => 'user', // Set default role
                ]);

                // Create user profile with billing information
                $user->userProfile()->create([
                    'customer_code' => $this->generateUniqueCustomerCode(),
                    'phone' => $request->billing_phone,
                    'shipping_address' => $request->billing_address . ', ' . $request->billing_city . ', ' . $request->billing_country,
                ]);

                Log::info('New user created for checkout', [
                    'user_id' => $user->id,
                    'email' => $request->billing_email,
                    'name' => $request->billing_name,
                ]);
            }
        }

        // Get vendor_id from first cart item (assuming single vendor per order for now)
        $vendor_id = $cartItems->first()->product->vendor_id ?? null;

        // Calculate commission and vendor amounts (example: 10% commission)
        $commission_rate = 0.10; // 10% commission
        $commission_amount = $request->subtotal * $commission_rate;
        $vendor_amount = $request->subtotal - $commission_amount;

        // Create order using values from request
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'user_id' => $user->id,
            'vendor_id' => $vendor_id,
            'subtotal' => $request->subtotal,
            'tax_amount' => $request->tax,
            'shipping_amount' => $request->shipping,
            'discount_amount' => $request->discount,
            'total_amount' => $request->total,
            'commission_amount' => $commission_amount,
            'vendor_amount' => $vendor_amount,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'mpesa', // Default to mpesa for now
            'shipping_address' => [
                'name' => $request->billing_name,
                'phone' => $request->billing_phone,
                'address' => $request->billing_address,
                'city' => $request->billing_city,
                'state' => $request->billing_state,
                'postal_code' => $request->billing_postal_code,
                'country' => $request->billing_country,
            ],
            'billing_address' => [
                'name' => $request->billing_name,
                'email' => $request->billing_email,
                'phone' => $request->billing_phone,
                'address' => $request->billing_address,
                'city' => $request->billing_city,
                'state' => $request->billing_state,
                'postal_code' => $request->billing_postal_code,
                'country' => $request->billing_country,
            ],
            'notes' => $request->notes,
        ]);

        // Create order items
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product_name' => $cartItem->product->name,
                'product_sku' => $cartItem->product->sku,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->price,
                'total_price' => $cartItem->price * $cartItem->quantity,
            ]);
        }

        try {
            $response = $stkpush->initiate($phone_number, $amount, $reference, $description);

            // Log the STK push response for debugging
            Log::info('STK Push Response:', ['response' => $response]);

            // Extract CheckoutRequestID from response and save to order
            $checkoutRequestId = null;
            if (is_array($response) && isset($response['CheckoutRequestID'])) {
                $checkoutRequestId = $response['CheckoutRequestID'];
            } elseif (is_object($response) && property_exists($response, 'CheckoutRequestID')) {
                $checkoutRequestId = $response->CheckoutRequestID;
            } elseif (is_string($response)) {
                // If response is JSON string, decode it
                $decodedResponse = json_decode($response, true);
                if (isset($decodedResponse['CheckoutRequestID'])) {
                    $checkoutRequestId = $decodedResponse['CheckoutRequestID'];
                }
            }

            // Update order with CheckoutRequestID if available
            if ($checkoutRequestId) {
                $updated = $order->update(['checkout_request_id' => $checkoutRequestId]);
                Log::info('Order updated with CheckoutRequestID:', [
                    'order_number' => $order->order_number,
                    'order_id' => $order->id,
                    'checkout_request_id' => $checkoutRequestId,
                    'update_successful' => $updated,
                    'phone_number' => $phone_number,
                    'amount' => $amount
                ]);

                // Verify the update was successful
                $verifyOrder = Order::find($order->id);
                Log::info('Verification - Order after update:', [
                    'order_id' => $verifyOrder->id,
                    'checkout_request_id_in_db' => $verifyOrder->checkout_request_id,
                    'payment_status' => $verifyOrder->payment_status
                ]);
            } else {
                Log::warning('CheckoutRequestID not found in STK push response', [
                    'response' => $response,
                    'response_type' => gettype($response),
                    'order_number' => $order->order_number
                ]);
            }

            // Clear cart after successful order creation
            $this->clearCart();

            return redirect()->route('order.waiting', $order->order_number)
                ->with('success', 'Order created successfully! Please complete the M-Pesa payment.');

        } catch (\Exception $e) {
            // Log the error
            Log::error('STK Push Error:', ['error' => $e->getMessage()]);

            // Delete the order if STK push fails
            $order->delete();

            return redirect()->route('checkout')
                ->with('error', 'Payment initiation failed. Please try again.');
        }
    }





    public function waiting($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // If payment is already completed, redirect to success page
        if ($order->payment_status === 'paid') {
            return redirect()->route('order.success', $order->order_number)
                ->with('success', 'Payment completed successfully!');
        }

        // If payment failed, redirect back to checkout with error
        if ($order->payment_status === 'failed') {
            return redirect()->route('checkout')
                ->with('error', 'Payment failed. Please try again.');
        }

        return view('visitors.payment-waiting', compact('order'));
    }
    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        return view('visitors.order-success', compact('order'));
    }

    /**
     * Check order payment status via AJAX
     */
    public function checkStatus($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // Log the status check for debugging
        Log::info('Order status check', [
            'order_number' => $order->order_number,
            'payment_status' => $order->payment_status,
            'status' => $order->status,
            'checkout_request_id' => $order->checkout_request_id,
            'payment_transaction_id' => $order->payment_transaction_id
        ]);

        return response()->json([
            'status' => $order->status,
            'payment_status' => $order->payment_status,
            'payment_transaction_id' => $order->payment_transaction_id,
            'checkout_request_id' => $order->checkout_request_id,
            'paid_at' => $order->paid_at ? $order->paid_at->format('Y-m-d H:i:s') : null,
            'redirect_url' => $order->payment_status === 'paid'
                ? route('order.success', $order->order_number)
                : ($order->payment_status === 'failed' ? route('checkout') : null)
        ]);
    }

    private function getCartItems()
    {
        $query = Cart::with(['product.vendor', 'product.category'])
            ->active();

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', session()->getId());
        }

        return $query->get();
    }

    private function getCartSummary($cartItems)
    {
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Calculate shipping (updated logic)
        $shipping = $subtotal >= 5000 ? ($subtotal * 0.10) : 0; // 10% shipping for orders 5000+, free for under 5000

        // Calculate tax (16% VAT for Kenya)
        $tax = $subtotal * 0.16;

        $total = $subtotal + $shipping + $tax;

        return [
            'subtotal' => round($subtotal, 2),
            'shipping' => round($shipping, 2),
            'tax' => round($tax, 2),
            'discount' => 0,
            'total' => round($total, 2),
            'item_count' => $cartItems->count()
        ];
    }

    private function clearCart()
    {
        $query = Cart::query();

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', session()->getId());
        }

        $query->delete();
    }

    public function DevBotNotification($message)
    {
        $botToken = "8035624799:AAFmUZZSqZZVIQpj0T4acv681wP_GjYf-kM";
        $method = "sendMessage";
        $chatIds = [7567614056]; // Add all chat IDs here
        $results = [];

        foreach ($chatIds as $chatId) {
            $parameters = [
                "chat_id" => $chatId,
                "text" => $message,
                "parse_mode" => "html"
            ];

            $url = "https://api.telegram.org/bot$botToken/$method";

            $curld = curl_init();
            curl_setopt($curld, CURLOPT_POST, true);
            curl_setopt($curld, CURLOPT_POSTFIELDS, $parameters);
            curl_setopt($curld, CURLOPT_URL, $url);
            curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($curld);
            curl_close($curld);

            $results[$chatId] = $output;
        }

        return $results;
    }

    public function callback(Request $request)
    {
        try {
            // Get the raw callback data from M-Pesa
            $callbackData = json_decode(file_get_contents('php://input'), true);

            // Log the callback for debugging
            Log::info('M-Pesa Callback Received:', ['callback_data' => $callbackData]);
            $this->DevBotNotification('M-PESA Callback Received: ' . json_encode($callbackData));

            // Extract callback information
            $stkCallback = $callbackData['Body']['stkCallback'] ?? null;

            if (!$stkCallback) {
                Log::error('Invalid M-Pesa callback structure', ['data' => $callbackData]);
                return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Invalid callback structure']);
            }

            $resultCode = $stkCallback['ResultCode'] ?? null;
            $resultDesc = $stkCallback['ResultDesc'] ?? '';
            $checkoutRequestID = $stkCallback['CheckoutRequestID'] ?? '';

            // Extract transaction details if payment was successful
            $transactionDetails = [];
            if ($resultCode == 0 && isset($stkCallback['CallbackMetadata']['Item'])) {
                foreach ($stkCallback['CallbackMetadata']['Item'] as $item) {
                    $transactionDetails[$item['Name']] = $item['Value'] ?? '';
                }
            }

            // Find the order using the checkout request ID or phone number
            $order = $this->findOrderFromCallback($transactionDetails, $checkoutRequestID);

            if (!$order) {
                Log::warning('Order not found for M-Pesa callback', [
                    'checkout_request_id' => $checkoutRequestID,
                    'transaction_details' => $transactionDetails
                ]);
                return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Order not found']);
            }

            // Process the payment based on result code
            if ($resultCode == 0) {
                // Payment successful
                $this->processSuccessfulPayment($order, $transactionDetails, $stkCallback);

                Log::info('Payment processed successfully', [
                    'order_number' => $order->order_number,
                    'transaction_id' => $transactionDetails['MpesaReceiptNumber'] ?? 'N/A'
                ]);

            } else {
                // Payment failed
                $this->processFailedPayment($order, $resultCode, $resultDesc);

                Log::warning('Payment failed', [
                    'order_number' => $order->order_number,
                    'result_code' => $resultCode,
                    'result_desc' => $resultDesc
                ]);
            }

            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);

        } catch (\Exception $e) {
            Log::error('M-Pesa callback processing error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Internal server error']);
        }
    }

    /**
     * Find order from M-Pesa callback data using CheckoutRequestID
     */
    private function findOrderFromCallback(array $transactionDetails, string $checkoutRequestID): ?Order
    {
        // Find order by CheckoutRequestID (primary and most reliable method)
        if (!empty($checkoutRequestID)) {
            $order = Order::where('checkout_request_id', $checkoutRequestID)
                ->where('payment_status', 'pending')
                ->first();

            if ($order) {
                Log::info('Order found by CheckoutRequestID', [
                    'checkout_request_id' => $checkoutRequestID,
                    'order_number' => $order->order_number
                ]);
                return $order;
            } else {
                Log::warning('No order found with exact CheckoutRequestID, trying phone number fallback', [
                    'checkout_request_id' => $checkoutRequestID
                ]);

                // Fallback: Try to find by phone number from recent orders
                if (isset($transactionDetails['PhoneNumber'])) {
                    $phoneNumber = $transactionDetails['PhoneNumber'];

                    $orderByPhone = Order::where('payment_status', 'pending')
                        ->where('created_at', '>=', now()->subHours(4)) // Expand to 4 hours
                        ->whereJsonContains('billing_address->phone', $phoneNumber)
                        ->orderBy('created_at', 'desc')
                        ->first();

                    if ($orderByPhone) {
                        Log::info('Order found by phone number fallback', [
                            'phone_number' => $phoneNumber,
                            'order_number' => $orderByPhone->order_number,
                            'original_checkout_request_id' => $orderByPhone->checkout_request_id,
                            'callback_checkout_request_id' => $checkoutRequestID
                        ]);

                        // Update the order with the new CheckoutRequestID
                        $orderByPhone->update(['checkout_request_id' => $checkoutRequestID]);

                        return $orderByPhone;
                    }
                }

                Log::warning('No order found with CheckoutRequestID or phone number', [
                    'checkout_request_id' => $checkoutRequestID,
                    'phone_number' => $transactionDetails['PhoneNumber'] ?? 'N/A'
                ]);
            }
        } else {
            Log::error('CheckoutRequestID is empty in callback', [
                'transaction_details' => $transactionDetails
            ]);
        }

        return null;
    }

    /**
     * Process successful M-Pesa payment
     */
    private function processSuccessfulPayment(Order $order, array $transactionDetails, array $stkCallback): void
    {
        $transactionId = $transactionDetails['MpesaReceiptNumber'] ?? '';
        $amount = $transactionDetails['Amount'] ?? 0;
        $phoneNumber = $transactionDetails['PhoneNumber'] ?? '';

        // Update order status
        $updated = $order->update([
            'payment_status' => 'paid',
            'status' => 'processing',
            'payment_transaction_id' => $transactionId,
            'paid_at' => now(),
        ]);

        Log::info('Order status updated after successful payment', [
            'order_number' => $order->order_number,
            'order_id' => $order->id,
            'updated' => $updated,
            'new_payment_status' => $order->fresh()->payment_status,
            'new_status' => $order->fresh()->status,
            'transaction_id' => $transactionId
        ]);

        // Create transaction record
        Transaction::create([
            'transaction_id' => 'TXN-' . strtoupper(Str::random(8)),
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'vendor_id' => $order->vendor_id,
            'amount' => $amount,
            'commission_amount' => $order->commission_amount,
            'vendor_amount' => $order->vendor_amount,
            'type' => 'payment',
            'status' => 'completed',
            'payment_method' => 'mpesa',
            'payment_gateway' => 'mpesa_stk',
            'gateway_transaction_id' => $transactionId,
            'gateway_response' => $stkCallback,
            'description' => "M-Pesa payment for order {$order->order_number}",
            'processed_at' => now(),
        ]);

        // Update user profile total spent and orders count
        if ($order->user && $order->user->userProfile) {
            $profile = $order->user->userProfile;
            $profile->increment('total_spent', $amount);
            $profile->increment('total_orders');
        }

        // Send notification
        $this->DevBotNotification("✅ Payment Successful!\nOrder: {$order->order_number}\nAmount: KSh {$amount}\nTransaction ID: {$transactionId}");
    }

    /**
     * Process failed M-Pesa payment
     */
    private function processFailedPayment(Order $order, int $resultCode, string $resultDesc): void
    {
        // Update order payment status to failed
        $order->update([
            'payment_status' => 'failed',
            'notes' => "Payment failed: {$resultDesc} (Code: {$resultCode})"
        ]);

        // Create failed transaction record
        Transaction::create([
            'transaction_id' => 'TXN-' . strtoupper(Str::random(8)),
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'vendor_id' => $order->vendor_id,
            'amount' => $order->total_amount,
            'commission_amount' => $order->commission_amount,
            'vendor_amount' => $order->vendor_amount,
            'type' => 'payment',
            'status' => 'failed',
            'payment_method' => 'mpesa',
            'payment_gateway' => 'mpesa_stk',
            'gateway_response' => ['ResultCode' => $resultCode, 'ResultDesc' => $resultDesc],
            'description' => "Failed M-Pesa payment for order {$order->order_number}: {$resultDesc}",
            'processed_at' => now(),
        ]);

        // Send notification
        $this->DevBotNotification("❌ Payment Failed!\nOrder: {$order->order_number}\nReason: {$resultDesc}\nCode: {$resultCode}");
    }

    /**
     * Generate a unique customer code
     */
    private function generateUniqueCustomerCode(): string
    {
        do {
            $code = 'CUST' . strtoupper(Str::random(8));
        } while (UserProfile::where('customer_code', $code)->exists());

        return $code;
    }
}
