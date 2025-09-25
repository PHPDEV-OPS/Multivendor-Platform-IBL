<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt - {{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            background: #fff;
            padding: 20px;
        }

        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
        }

        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .receipt-title {
            font-size: 18px;
            color: #666;
            margin-bottom: 10px;
        }

        .order-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .order-details, .customer-details {
            flex: 1;
            min-width: 300px;
            margin-bottom: 20px;
        }

        .order-details {
            margin-right: 20px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding: 2px 0;
        }

        .info-label {
            font-weight: 600;
            color: #555;
        }

        .info-value {
            color: #333;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-paid {
            background-color: #d4edda;
            color: #155724;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-delivered {
            background-color: #d4edda;
            color: #155724;
        }

        .status-processing {
            background-color: #cce7ff;
            color: #004085;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }

        .items-table th,
        .items-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .items-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #333;
        }

        .items-table td {
            vertical-align: top;
        }

        .product-name {
            font-weight: 600;
            color: #333;
        }

        .product-sku {
            font-size: 12px;
            color: #666;
            margin-top: 2px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .order-summary {
            margin-top: 30px;
            border-top: 2px solid #333;
            padding-top: 20px;
        }

        .summary-table {
            width: 100%;
            max-width: 400px;
            margin-left: auto;
        }

        .summary-table td {
            padding: 8px 0;
            border: none;
        }

        .summary-table .total-row {
            font-size: 18px;
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 12px;
        }

        .receipt-footer {
            margin-top: 40px;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 20px;
            color: #666;
        }

        .thank-you {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        @media print {
            body {
                padding: 0;
                font-size: 12px;
            }

            .receipt-container {
                max-width: none;
                margin: 0;
            }

            .no-print {
                display: none !important;
            }
        }

        @media (max-width: 600px) {
            .order-info {
                flex-direction: column;
            }

            .order-details {
                margin-right: 0;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Receipt Header -->
        <div class="receipt-header">
            <div class="company-name">Tununue-LTD</div>
            <div class="receipt-title">Order Receipt</div>
            <div style="font-size: 14px; color: #666;">
                Order #{{ $order->order_number }} | {{ $order->created_at->format('F d, Y') }}
            </div>
        </div>

        <!-- Order and Customer Information -->
        <div class="order-info">
            <div class="order-details">
                <div class="section-title">Order Information</div>
                <div class="info-row">
                    <span class="info-label">Order Number:</span>
                    <span class="info-value">{{ $order->order_number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Order Date:</span>
                    <span class="info-value">{{ $order->created_at->format('F d, Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Order Status:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Status:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Method:</span>
                    <span class="info-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                </div>
                @if($order->paid_at)
                <div class="info-row">
                    <span class="info-label">Payment Date:</span>
                    <span class="info-value">{{ $order->paid_at->format('F d, Y') }}</span>
                </div>
                @endif
            </div>

            <div class="customer-details">
                <div class="section-title">Customer Information</div>
                <div class="info-row">
                    <span class="info-label">Name:</span>
                    <span class="info-value">{{ $order->user->name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $order->user->email ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone:</span>
                    <span class="info-value">{{ $order->user->phone ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Shipping Address:</span>
                    <span class="info-value">
                        @if(is_array($order->shipping_address))
                            {{ $order->shipping_address['address'] ?? '' }}<br>
                            {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }}<br>
                            {{ $order->shipping_address['postal_code'] ?? '' }}
                        @else
                            {{ $order->shipping_address ?? 'N/A' }}
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <div class="product-name">{{ $item->product_name }}</div>
                        @if($item->product_sku)
                            <div class="product-sku">SKU: {{ $item->product_sku }}</div>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">KSh {{ number_format($item->unit_price, 0) }}</td>
                    <td class="text-right">KSh {{ number_format($item->total_price, 0) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Order Summary -->
        <div class="order-summary">
            <table class="summary-table">
                <tr>
                    <td>Subtotal:</td>
                    <td class="text-right">KSh {{ number_format($order->subtotal, 0) }}</td>
                </tr>
                @if($order->shipping_amount > 0)
                <tr>
                    <td>Shipping:</td>
                    <td class="text-right">KSh {{ number_format($order->shipping_amount, 0) }}</td>
                </tr>
                @endif
                @if($order->tax_amount > 0)
                <tr>
                    <td>Tax:</td>
                    <td class="text-right">KSh {{ number_format($order->tax_amount, 0) }}</td>
                </tr>
                @endif
                @if($order->discount_amount > 0)
                <tr>
                    <td>Discount:</td>
                    <td class="text-right">-KSh {{ number_format($order->discount_amount, 0) }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td><strong>Total:</strong></td>
                    <td class="text-right"><strong>KSh {{ number_format($order->total_amount, 0) }}</strong></td>
                </tr>
            </table>
        </div>

        <!-- Receipt Footer -->
        <div class="receipt-footer">
            <div class="thank-you">Thank you for your business!</div>
            <p>For any questions about this order, please contact us at support@tununue.com</p>
            <p style="margin-top: 10px; font-size: 12px;">
                This is a computer-generated receipt. No signature required.
            </p>
        </div>
    </div>

    <script>
        // Auto-print when page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
