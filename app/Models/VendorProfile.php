<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vendor_code',
        'company_name',
        'business_type',
        'tax_id',
        'business_license',
        'business_address',
        'contact_person',
        'contact_phone',
        'contact_email',
        'commission_rate',
        'status',
        'rejection_reason',
        'bank_details',
        'store_logo',
        'store_banner',
        'store_settings',
        // Document uploads
        'kra_certificate',
        'certificate_of_registration',
        'id_card_front',
        'id_card_back',
        // Additional contact details
        'alternative_phone',
        'whatsapp_number',
        'physical_address',
        'postal_address',
        'city',
        'county',
        'postal_code',
        // Business details
        'business_registration_number',
        'kra_pin',
        'business_start_date',
        'number_of_employees',
        'business_description',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'bank_details' => 'array',
        'store_settings' => 'array',
        'business_start_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
