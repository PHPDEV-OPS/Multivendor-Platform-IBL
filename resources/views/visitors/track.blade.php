@extends('layouts.main')

@section('content')
<div class="order_tracking_area section_spacing6">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-8 col-md-10">
                    <div class="tracking_form">

                        <h3 class="font_30 f_w_700 mb_5">Track Your Order</h3>
                        <p class="mb-4">Enter your Order ID in the box below and press the "Track" button.</p>
                        <p class="text-muted mb-4"><small>Example: ORD-TMR3NJQ8</small></p>

                        <form action="{{ route('track-order.search') }}" method="post">
                            @csrf

                            @if(session('error'))
                                <div class="alert alert-danger mb-3">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-lg-12 mb_20">
                                    <label class="primary_label2 style2">Order Tracking Number <span>*</span></label>
                                    <input id="order_number" name="order_number"
                                    value="{{ old('order_number') }}"
                                    placeholder="Enter your order number (e.g., ORD-TMR3NJQ8)"
                                    onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Enter your order number (e.g., ORD-TMR3NJQ8)'"
                                    class="primary_input3 rounded-0 style2"
                                    type="text"
                                    required>
                                                                    </div>
                                                                                                                                    <div class="col-12">
                                    <button class="amaz_primary_btn  rounded-0  w-100 text-uppercase  text-center">Track Now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
.order_tracking_area {
    padding: 80px 0;
    background: #f8f9fa;
    min-height: 60vh;
    display: flex;
    align-items: center;
}

.tracking_form {
    background: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    text-align: center;
}

.tracking_form h3 {
    color: #333;
    margin-bottom: 10px;
}

.tracking_form p {
    color: #666;
    margin-bottom: 30px;
}

.primary_label2.style2 {
    display: block;
    margin-bottom: 10px;
    font-weight: 600;
    color: #333;
    text-align: left;
}

.primary_label2.style2 span {
    color: #ff6d68;
}

.primary_input3.style2 {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 12px 15px;
    font-size: 14px;
    width: 100%;
    transition: border-color 0.3s ease;
}

.primary_input3.style2:focus {
    border-color: #ff6f20;
    outline: none;
    box-shadow: 0 0 0 2px rgba(255, 111, 32, 0.1);
}

.amaz_primary_btn {
    background: #ff6f20;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.3s ease;
}

.amaz_primary_btn:hover {
    background: #e55a1a;
}

@media (max-width: 768px) {
    .order_tracking_area {
        padding: 40px 0;
    }

    .tracking_form {
        padding: 30px 20px;
    }
}
</style>
@endsection
