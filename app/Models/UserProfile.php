<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_code',
        'date_of_birth',
        'gender',
        'phone',
        'shipping_address',
        'billing_address',
        'preferred_payment_method',
        'preferences',
        'total_spent',
        'total_orders',
        'referral_code',
        'referred_by',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'preferences' => 'array',
        'total_spent' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
