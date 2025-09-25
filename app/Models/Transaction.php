<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'order_id',
        'user_id',
        'vendor_id',
        'amount',
        'commission_amount',
        'vendor_amount',
        'type',
        'status',
        'payment_method',
        'payment_gateway',
        'gateway_transaction_id',
        'gateway_response',
        'description',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'vendor_amount' => 'decimal:2',
        'gateway_response' => 'array',
        'processed_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'completed' => 'status-active',
            'pending' => 'status-pending',
            'failed' => 'status-inactive',
            'cancelled' => 'status-inactive',
            default => 'status-pending',
        };
    }
}
