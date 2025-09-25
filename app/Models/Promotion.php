<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Promotion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'type',
        'discount_value',
        'minimum_order_amount',
        'maximum_discount',
        'usage_limit',
        'used_count',
        'per_user_limit',
        'applicable_products',
        'applicable_categories',
        'excluded_products',
        'start_date',
        'end_date',
        'is_active',
        'is_first_time_only',
        'is_new_customer_only',
        'banner_image',
        'banner_title',
        'banner_subtitle',
        'banner_link',
        'banner_position',
        'banner_is_active',
    ];

    protected $casts = [
        'applicable_products' => 'array',
        'applicable_categories' => 'array',
        'excluded_products' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'is_first_time_only' => 'boolean',
        'is_new_customer_only' => 'boolean',
        'banner_is_active' => 'boolean',
        'discount_value' => 'decimal:2',
        'minimum_order_amount' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
    ];

    // Promotion Types
    const TYPE_PERCENTAGE = 'percentage';
    const TYPE_FIXED_AMOUNT = 'fixed_amount';
    const TYPE_FREE_SHIPPING = 'free_shipping';
    const TYPE_BUY_ONE_GET_ONE = 'buy_one_get_one';
    const TYPE_FLASH_SALE = 'flash_sale';

    // Banner Positions
    const POSITION_TOP = 'top';
    const POSITION_SIDEBAR = 'sidebar';
    const POSITION_FOOTER = 'footer';
    const POSITION_HOME_BANNER = 'home_banner';
    const POSITION_CATEGORY_BANNER = 'category_banner';
    const POSITION_CTA_BANNER = 'cta_banner';

    // Status
    const STATUS_ACTIVE = 'active';
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_PAUSED = 'paused';
    const STATUS_EXPIRED = 'expired';

    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return self::STATUS_PAUSED;
        }

        $now = Carbon::now();

        if ($this->start_date->isFuture()) {
            return self::STATUS_SCHEDULED;
        }

        if ($this->end_date->isPast()) {
            return self::STATUS_EXPIRED;
        }

        return self::STATUS_ACTIVE;
    }

    public function getIsExpiredAttribute()
    {
        return $this->end_date->isPast();
    }

    public function getIsScheduledAttribute()
    {
        return $this->start_date->isFuture();
    }

    public function getIsActiveNowAttribute()
    {
        return $this->is_active &&
               $this->start_date->isPast() &&
               $this->end_date->isFuture();
    }

    public function getUsagePercentageAttribute()
    {
        if (!$this->usage_limit) {
            return 0;
        }

        return round(($this->used_count / $this->usage_limit) * 100, 2);
    }

    public function getRemainingUsageAttribute()
    {
        if (!$this->usage_limit) {
            return null;
        }

        return $this->usage_limit - $this->used_count;
    }

    public function getFormattedDiscountAttribute()
    {
        switch ($this->type) {
            case self::TYPE_PERCENTAGE:
                return $this->discount_value . '% OFF';
            case self::TYPE_FIXED_AMOUNT:
                return 'KES ' . number_format($this->discount_value, 0) . ' OFF';
            case self::TYPE_FREE_SHIPPING:
                return 'Free Shipping';
            case self::TYPE_BUY_ONE_GET_ONE:
                return 'Buy One Get One';
            case self::TYPE_FLASH_SALE:
                return 'Flash Sale';
            default:
                return $this->discount_value;
        }
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    public function scopeBanners($query)
    {
        return $query->whereNotNull('banner_image')
                    ->where('banner_is_active', true);
    }

    public function scopeByPosition($query, $position)
    {
        return $query->where('banner_position', $position);
    }

    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', now());
    }

    public function scopeScheduled($query)
    {
        return $query->where('start_date', '>', now());
    }

    // Relationships
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function applicableProducts()
    {
        return $this->belongsToMany(Product::class, 'promotion_products', 'promotion_id', 'product_id');
    }

    public function applicableCategories()
    {
        return $this->belongsToMany(Category::class, 'promotion_categories', 'promotion_id', 'category_id');
    }

    // Methods
    public function canBeUsedBy(User $user)
    {
        // Check if promotion is active
        if (!$this->is_active_now) {
            return false;
        }

        // Check if user is new customer only
        if ($this->is_new_customer_only && $user->orders()->count() > 0) {
            return false;
        }

        // Check if it's first time only
        if ($this->is_first_time_only && $user->orders()->where('promotion_id', $this->id)->exists()) {
            return false;
        }

        // Check usage limit
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        // Check per user limit
        $userUsage = $user->orders()->where('promotion_id', $this->id)->count();
        if ($userUsage >= $this->per_user_limit) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($orderTotal)
    {
        if ($orderTotal < $this->minimum_order_amount) {
            return 0;
        }

        switch ($this->type) {
            case self::TYPE_PERCENTAGE:
                $discount = ($orderTotal * $this->discount_value) / 100;
                if ($this->maximum_discount) {
                    $discount = min($discount, $this->maximum_discount);
                }
                return $discount;

            case self::TYPE_FIXED_AMOUNT:
                return min($this->discount_value, $orderTotal);

            case self::TYPE_FREE_SHIPPING:
                return 0; // Shipping cost should be calculated separately

            default:
                return 0;
        }
    }

    public function incrementUsage()
    {
        $this->increment('used_count');
    }

    public function getBannerImageUrlAttribute()
    {
        if ($this->banner_image) {
            $path = storage_path('app/public/' . $this->banner_image);
            if (file_exists($path)) {
                return asset('storage/' . $this->banner_image);
            }
        }
        return null;
    }

    public static function getTypes()
    {
        return [
            self::TYPE_PERCENTAGE => 'Percentage Discount',
            self::TYPE_FIXED_AMOUNT => 'Fixed Amount Discount',
            self::TYPE_FREE_SHIPPING => 'Free Shipping',
            self::TYPE_BUY_ONE_GET_ONE => 'Buy One Get One',
            self::TYPE_FLASH_SALE => 'Flash Sale',
        ];
    }

    public static function getBannerPositions()
    {
        return [
            self::POSITION_TOP => 'Top Banner',
            self::POSITION_SIDEBAR => 'Sidebar Banner',
            self::POSITION_FOOTER => 'Footer Banner',
            self::POSITION_HOME_BANNER => 'Home Page Banner',
            self::POSITION_CATEGORY_BANNER => 'Category Page Banner',
            self::POSITION_CTA_BANNER => 'CTA Banner (Ads Bar)',
        ];
    }
}
