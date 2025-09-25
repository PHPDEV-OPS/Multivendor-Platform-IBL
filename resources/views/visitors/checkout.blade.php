@extends('layouts.main')

@section('content')
<style>
.checkout_wrapper {
    background: #fff;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.order_summary_wrapper {
    background: #fff;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: sticky;
    top: 20px;
}

.summary_item {
    font-size: 14px;
}

.summary_label {
    color: #6c757d;
}

.summary_value {
    font-weight: 500;
}

.summary_total {
    border-top: 2px solid #e9ecef !important;
}

.amaz_primary_btn {
    background: #ff6b35;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    font-weight: 500;
}

.amaz_primary_btn:hover {
    background: #e55a2b;
    color: white;
    transform: translateY(-2px);
}

.payment_method_card {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.payment_method_card:hover {
    border-color: #ff6b35;
}

.payment_method_card.selected {
    border-color: #ff6b35;
    background-color: #fff5f2;
}

@media (max-width: 768px) {
    .checkout_wrapper,
    .order_summary_wrapper {
        padding: 20px;
        margin-bottom: 20px;
    }

    .order_summary_wrapper {
        position: static;
    }
}
</style>

<div class="amaz_section section_spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__title text-center mb_30">
                    <h2>Checkout</h2>
                </div>
            </div>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
            @csrf

            <!-- Hidden fields for cart summary -->
            <input type="hidden" name="subtotal" value="{{ $cartSummary['subtotal'] }}">
            <input type="hidden" name="shipping" value="{{ $cartSummary['shipping'] }}">
            <input type="hidden" name="tax" value="{{ $cartSummary['tax'] }}">
            <input type="hidden" name="discount" value="{{ $cartSummary['discount'] }}">
            <input type="hidden" name="total" value="{{ $cartSummary['total'] }}">
            <input type="hidden" name="item_count" value="{{ $cartSummary['item_count'] }}">
            <div class="row">
                <!-- Checkout Forms Column -->
                <div class="col-lg-8 col-md-12">
                    <!-- Billing Information -->
                    <div class="checkout_wrapper">
                        <h4 class="mb_30">Billing Information/Shipping Information</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="billing_name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="billing_name" name="billing_name"
                                       value="{{ auth()->user()->name ?? '' }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="billing_email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="billing_email" name="billing_email"
                                       value="{{ auth()->user()->email ?? '' }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="billing_phone" class="form-label">Mpesa Payment Phone Number *</label>
                                <input type="tel" class="form-control" id="billing_phone" name="billing_phone"
                                       placeholder="254712345678"
                                       pattern="254[0-9]{9}"
                                       title="Please enter a valid Kenyan phone number starting with 254 (e.g., 254712345678)"
                                       maxlength="12" required>
                                <small class="form-text text-muted">Format: 254XXXXXXXXX (e.g., 254712345678)</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="billing_country" class="form-label">Country *</label>
                                <select class="form-control" id="billing_country" name="billing_country" required>
                                    <option value="">Select Country</option>
                                    <option value="Kenya" selected>Kenya</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Tanzania">Tanzania</option>
                                    <option value="Rwanda">Rwanda</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="billing_address" class="form-label">Address *</label>
                            <textarea class="form-control" id="billing_address" name="billing_address" rows="3" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="billing_city" class="form-label">City *</label>
                                <input type="text" class="form-control" id="billing_city" name="billing_city" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="billing_state" class="form-label">State/County *</label>
                                <input type="text" class="form-control" id="billing_state" name="billing_state" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="billing_postal_code" class="form-label">Postal Code *</label>
                                <input type="text" class="form-control" id="billing_postal_code" name="billing_postal_code" required>
                            </div>
                        </div>
                    </div>


                    <!-- Order Notes -->
                    <div class="checkout_wrapper">
                        <h4 class="mb_30">Order Notes (Optional)</h4>
                        <textarea class="form-control" name="notes" rows="3" placeholder="Any special instructions for your order..."></textarea>
                    </div>
                </div>

                <!-- Order Summary Column -->
                <div class="col-lg-4 col-md-12">
                    <div class="order_summary_wrapper">
                        <div class="order_summary_header mb_30">
                            <h4 class="m-0 fw-bold">Order Summary</h4>
                        </div>

                        <div class="order_summary_content">
                            @foreach($cartItems as $cartItem)
                                <div class="summary_item d-flex justify-content-between align-items-center mb_15">
                                    <div>
                                        <span class="summary_label">{{ $cartItem->product->name }}</span>
                                        <br>
                                        <small class="text-muted">Qty: {{ $cartItem->quantity }}</small>
                                    </div>
                                    <span class="summary_value">KSh {{ number_format($cartItem->subtotal, 0) }}</span>
                                </div>
                            @endforeach

                            <hr>

                            <div class="summary_item d-flex justify-content-between align-items-center mb_15">
                                <span class="summary_label">Subtotal:</span>
                                <span class="summary_value">KSh {{ number_format($cartSummary['subtotal'], 0) }}</span>
                            </div>

                            <div class="summary_item d-flex justify-content-between align-items-center mb_15">
                                <span class="summary_label">Shipping:</span>
                                <span class="summary_value">KSh {{ number_format($cartSummary['shipping'], 0) }}</span>
                            </div>

                            <div class="summary_item d-flex justify-content-between align-items-center mb_15">
                                <span class="summary_label">Tax (16% VAT):</span>
                                <span class="summary_value">KSh {{ number_format($cartSummary['tax'], 0) }}</span>
                            </div>

                            <div class="summary_item d-flex justify-content-between align-items-center mb_15">
                                <span class="summary_label">Discount:</span>
                                <span class="summary_value text-success">- KSh {{ number_format($cartSummary['discount'], 0) }}</span>
                            </div>

                            <div class="summary_total d-flex justify-content-between align-items-center py_20 border-top">
                                <span class="summary_label fw-bold fs-5">Total:</span>
                                <span class="summary_value fw-bold fs-5">KSh {{ number_format($cartSummary['total'], 0) }}</span>
                            </div>

                            <div class="checkout_actions mt_30">
                                <button type="submit" class="amaz_primary_btn w-100 mb_15">
                                    <i class="fas fa-lock me-2"></i>
                                    Place Order
                                </button>
                                <a href="{{ route('cart') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Back to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Phone number formatting and validation
    const phoneInput = document.getElementById('billing_phone');

    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove non-digits

        // If user starts typing without 254, add it
        if (value.length > 0 && !value.startsWith('254')) {
            // If they start with 0, replace with 254
            if (value.startsWith('0')) {
                value = '254' + value.substring(1);
            }
            // If they start with 7, 1, or other valid Kenyan prefixes, add 254
            else if (value.match(/^[71]/)) {
                value = '254' + value;
            }
        }

        // Limit to 12 characters (254 + 9 digits)
        if (value.length > 12) {
            value = value.substring(0, 12);
        }

        e.target.value = value;
    });



});
</script>
@endsection
