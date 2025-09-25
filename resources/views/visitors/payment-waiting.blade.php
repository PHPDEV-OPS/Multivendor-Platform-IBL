@extends('layouts.main')

@section('content')
<style>
.waiting_wrapper {
    background: #fff;
    border-radius: 8px;
    padding: 40px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    text-align: center;
    margin: 40px 0;
}

.waiting_icon {
    width: 80px;
    height: 80px;
    background: #ffc107;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 30px;
    animation: pulse 2s infinite;
}

.waiting_icon i {
    font-size: 40px;
    color: white;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.payment_steps {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 30px;
    margin: 30px 0;
    text-align: left;
}

.step {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    padding: 15px;
    background: white;
    border-radius: 6px;
    border-left: 4px solid #28a745;
}

.step_number {
    width: 30px;
    height: 30px;
    background: #28a745;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-weight: bold;
}

.order_info {
    background: #e3f2fd;
    border-radius: 8px;
    padding: 20px;
    margin: 20px 0;
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

.refresh_btn {
    background: #17a2b8;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.refresh_btn:hover {
    background: #138496;
}
</style>

<div class="amaz_section section_spacing">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="waiting_wrapper">
                    <div class="waiting_icon">
                        <i class="fas fa-clock"></i>
                    </div>

                    <h2 class="mb-3">Payment Pending</h2>
                    <p class="text-muted mb-4">Your order has been created successfully. Please complete the M-Pesa payment to confirm your order.</p>

                    <div id="status-indicator" class="alert alert-info" style="display: none;">
                        <i class="fas fa-spinner fa-spin me-2"></i>
                        <span id="status-text">Checking payment status...</span>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="order_info">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Order Number:</strong><br>
                                <span class="text-primary h5">{{ $order->order_number }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Amount to Pay:</strong><br>
                                <span class="text-success h5">KSh {{ number_format($order->total_amount, 0) }}</span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <strong>Payment Phone:</strong><br>
                                <span class="text-info">{{ $order->billing_address['phone'] }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Payment Status:</strong><br>
                                <span class="badge bg-warning">{{ ucfirst($order->payment_status) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="payment_steps">
                        <h5 class="mb-4">Complete Your M-Pesa Payment</h5>

                        <div class="step">
                            <div class="step_number">1</div>
                            <div>
                                <strong>Check Your Phone</strong><br>
                                <small class="text-muted">You should receive an M-Pesa payment request on {{ $order->billing_address['phone'] }}</small>
                            </div>
                        </div>

                        <div class="step">
                            <div class="step_number">2</div>
                            <div>
                                <strong>Enter Your M-Pesa PIN</strong><br>
                                <small class="text-muted">Open the M-Pesa notification and enter your PIN to authorize the payment</small>
                            </div>
                        </div>

                        <div class="step">
                            <div class="step_number">3</div>
                            <div>
                                <strong>Wait for Confirmation</strong><br>
                                <small class="text-muted">You'll receive an M-Pesa confirmation SMS and we'll update your order status</small>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Didn't receive the payment request?</strong>
                        Please check your phone or refresh this page. If you continue to have issues, contact our support team.
                    </div>

                    <div class="action_buttons mt-4">
                        <button onclick="window.location.reload()" class="refresh_btn me-3">
                            <i class="fas fa-sync-alt me-2"></i>
                            Refresh Status
                        </button>
                    </div>

                    <div class="mt-4">
                        <small class="text-muted">
                            Having trouble? <a href="{{ route('contact-us') }}">Contact Support</a> |
                            <a href="{{ route('home') }}">Continue Shopping</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Check payment status via AJAX every 10 seconds
function checkPaymentStatus() {
    console.log('Checking payment status for order: {{ $order->order_number }}');

    // Show status indicator
    const statusIndicator = document.getElementById('status-indicator');
    const statusText = document.getElementById('status-text');
    statusIndicator.style.display = 'block';
    statusText.textContent = 'Checking payment status...';

    fetch('{{ route("order.status", $order->order_number) }}')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Payment status response:', data);

            // If payment is successful, redirect to success page
            if (data.payment_status === 'paid') {
                console.log('Payment successful! Redirecting to success page...');
                statusIndicator.className = 'alert alert-success';
                statusText.innerHTML = '<i class="fas fa-check me-2"></i>Payment successful! Redirecting...';

                setTimeout(() => {
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else {
                        // Fallback redirect if redirect_url is missing
                        window.location.href = '{{ route("order.success", $order->order_number) }}';
                    }
                }, 1000);
                return;
            }

            // If payment failed, redirect to checkout
            if (data.payment_status === 'failed') {
                console.log('Payment failed! Redirecting to checkout...');
                statusIndicator.className = 'alert alert-danger';
                statusText.innerHTML = '<i class="fas fa-times me-2"></i>Payment failed! Please try again later';

                setTimeout(() => {
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else {
                        // Fallback redirect if redirect_url is missing
                        window.location.href = '{{ route("checkout") }}';
                    }
                }, 2000);
                return;
            }

            // Payment still pending
            console.log('Payment still pending, checking again in 10 seconds...');
            console.log('Current status:', data.payment_status);
            statusIndicator.className = 'alert alert-info';
            statusText.innerHTML = '<i class="fas fa-clock me-2"></i>Please wait as we Confirm Your Payment';

            // Hide status indicator after 3 seconds
            setTimeout(() => {
                statusIndicator.style.display = 'none';
            }, 3000);
        })
        .catch(error => {
            console.error('Error checking payment status:', error);
            statusIndicator.className = 'alert alert-warning';
            statusText.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Error checking status. Retrying...';

            // Hide status indicator after 3 seconds
            setTimeout(() => {
                statusIndicator.style.display = 'none';
            }, 3000);
        });
}

// Start checking payment status immediately and then every 10 seconds
console.log('Starting payment status monitoring...');
checkPaymentStatus();
const statusInterval = setInterval(checkPaymentStatus, 10000);

// Fallback: Auto-refresh the page every 60 seconds as backup
setTimeout(function() {
    console.log('Fallback refresh triggered after 60 seconds');
    window.location.reload();
}, 60000);

// Stop checking when page is about to unload
window.addEventListener('beforeunload', function() {
    clearInterval(statusInterval);
});
</script>
@endsection
