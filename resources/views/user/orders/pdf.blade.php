<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans Mono', 'Courier New', monospace;
            font-size: 9px;
            line-height: 1.2;
            color: #000;
            background: #fff;
            width: 80mm;
            margin: 0;
            padding: 0;
        }

        .receipt-container {
            width: 80mm;
            padding: 2mm;
            margin: 0;
        }

        .receipt-header {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 3mm;
            margin-bottom: 3mm;
        }

        .company-name {
            font-size: 12px;
            font-weight: bold;
            color: #000;
            margin-bottom: 1mm;
            text-transform: uppercase;
        }

        .receipt-title {
            font-size: 10px;
            color: #000;
            margin-bottom: 1mm;
        }

        .order-header-info {
            font-size: 8px;
            color: #000;
        }

        .order-info {
            width: 100%;
            margin-bottom: 3mm;
        }

        .section-title {
            font-size: 9px;
            font-weight: bold;
            color: #000;
            margin-bottom: 1mm;
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 1mm;
        }

        .info-row {
            margin-bottom: 1mm;
            font-size: 8px;
            display: flex;
            justify-content: space-between;
        }

        .info-label {
            font-weight: bold;
            color: #000;
        }

        .info-value {
            color: #000;
            text-align: right;
        }

        .customer-info {
            margin-bottom: 3mm;
            font-size: 8px;
            text-align: center;
        }

        .status-badge {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .items-section {
            margin: 3mm 0;
        }

        .items-header {
            font-size: 9px;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 1mm;
            margin-bottom: 2mm;
        }

        .item-row {
            margin-bottom: 2mm;
            font-size: 8px;
            border-bottom: 1px dotted #000;
            padding-bottom: 1mm;
        }

        .item-name {
            font-weight: bold;
            margin-bottom: 0.5mm;
        }

        .item-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5mm;
        }

        .item-total {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .order-summary {
            margin-top: 3mm;
            border-top: 1px dashed #000;
            padding-top: 2mm;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1mm;
            font-size: 8px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 1mm;
            margin-top: 2mm;
        }

        .receipt-footer {
            margin-top: 4mm;
            text-align: center;
            border-top: 1px dashed #000;
            padding-top: 2mm;
            font-size: 7px;
        }

        .thank-you {
            font-size: 9px;
            font-weight: bold;
            margin-bottom: 1mm;
        }

        .separator {
            text-align: center;
            margin: 2mm 0;
            font-size: 8px;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Receipt Header -->
        <div class="receipt-header">
            <div class="company-name">TUNUNUE-LTD</div>
            <div class="receipt-title">RECEIPT</div>
            <div class="order-header-info">{{ $order->created_at->format('d/m/Y H:i') }}</div>
        </div>

        <!-- Order Information -->
        <div class="section-title">ORDER DETAILS</div>
        <div class="info-row">
            <span class="info-label">Order #:</span>
            <span class="info-value">{{ $order->order_number }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Date:</span>
            <span class="info-value">{{ $order->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status:</span>
            <span class="info-value">{{ strtoupper($order->status) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Payment:</span>
            <span class="info-value">{{ strtoupper($order->payment_status) }}</span>
        </div>

        <!-- Customer Information -->
        <div class="customer-info">
            <strong>{{ $order->user->name ?? 'Customer' }}</strong><br>
            {{ $order->user->phone ?? '' }}
        </div>

        <!-- Order Items -->
        <div class="items-section">
            <div class="items-header">ITEMS</div>
            @foreach($order->items as $item)
            <div class="item-row">
                <div class="item-name">{{ $item->product_name }}</div>
                <div class="item-details">
                    <span>{{ $item->quantity }} x KSh {{ number_format($item->unit_price, 0) }}</span>
                    <span>KSh {{ number_format($item->total_price, 0) }}</span>
                </div>
                @if($item->product_sku)
                    <div style="font-size: 7px; color: #666;">SKU: {{ $item->product_sku }}</div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>KSh {{ number_format($order->subtotal, 0) }}</span>
            </div>
            @if($order->shipping_amount > 0)
            <div class="summary-row">
                <span>Shipping:</span>
                <span>KSh {{ number_format($order->shipping_amount, 0) }}</span>
            </div>
            @endif
            @if($order->tax_amount > 0)
            <div class="summary-row">
                <span>Tax:</span>
                <span>KSh {{ number_format($order->tax_amount, 0) }}</span>
            </div>
            @endif
            @if($order->discount_amount > 0)
            <div class="summary-row">
                <span>Discount:</span>
                <span>-KSh {{ number_format($order->discount_amount, 0) }}</span>
            </div>
            @endif
            <div class="total-row">
                <span>TOTAL:</span>
                <span>KSh {{ number_format($order->total_amount, 0) }}</span>
            </div>
        </div>

        <div class="separator">================================</div>

        <!-- Receipt Footer -->
        <div class="receipt-footer">
            <div class="thank-you">THANK YOU!</div>
            <div>support@tununue.com</div>
            <div>{{ now()->format('d/m/Y H:i') }}</div>
        </div>
    </div>
</body>
</html>
