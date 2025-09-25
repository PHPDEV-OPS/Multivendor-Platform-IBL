<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Role constants
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    const ROLE_VENDOR = 'vendor';
    const ROLE_CUSTOMER = 'user'; // Alias for user role

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'phone',
        'address',
        'profile_image',
        // Personal Information
        'date_of_birth',
        'gender',
        'bio',
        // Business Information
        'business_name',
        'business_type',
        'tax_id',
        'business_website',
        'business_description',
        'years_in_business',
        'number_of_employees',
        // Address Information
        'primary_address',
        'shipping_address',
        // Social Media
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'tiktok_url',
        // Notification Settings
        'email_notifications',
        'sms_notifications',
        'push_notifications',
        'marketing_emails',
        // Account Tracking
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'date_of_birth' => 'date',
            'primary_address' => 'array',
            'shipping_address' => 'array',
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'marketing_emails' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is vendor
     */
    public function isVendor(): bool
    {
        return $this->role === 'vendor';
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Check if user has specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    /**
     * Get the appropriate dashboard route based on role
     */
    public function getDashboardRoute(): string
    {
        return match($this->role) {
            'admin' => 'admin.dashboard',
            'vendor' => $this->getVendorDashboardRoute(),
            'user' => 'user.dashboard',
            default => 'user.dashboard', // Default to user dashboard instead of generic dashboard
        };
    }

    /**
     * Get vendor dashboard route based on verification status
     */
    private function getVendorDashboardRoute(): string
    {
        $vendorProfile = $this->vendorProfile;

        // If no vendor profile exists or status is not approved, redirect to waiting page
        if (!$vendorProfile || $vendorProfile->status !== 'approved') {
            return 'vendor.waiting';
        }

        return 'vendor.dashboard';
    }

    /**
     * Relationship with admin profile
     */
    public function adminProfile()
    {
        return $this->hasOne(AdminProfile::class);
    }

    /**
     * Relationship with vendor profile
     */
    public function vendorProfile()
    {
        return $this->hasOne(VendorProfile::class);
    }

    /**
     * Relationship with user profile
     */
    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Relationship with orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relationship with products (for vendors)
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'vendor_id');
    }
}
