<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\VendorProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['nullable', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255', 'unique:'.User::class, function ($attribute, $value, $fail) {
                    // Check if it's a valid email or phone number
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL) && !preg_match('/^[0-9+\-\s\(\)]+$/', $value)) {
                        $fail('The '.$attribute.' must be a valid email address or phone number.');
                    }
                }],
                'role' => ['required', 'in:user,vendor'],
                'referral_code' => ['nullable', 'string', 'max:255'],
                'password' => ['required', 'confirmed', 'min:8'],
                // Vendor specific fields
                'company_name' => ['required_if:role,vendor', 'string', 'max:255'],
                'business_type' => ['nullable', 'string', 'max:255'],
                'business_address' => ['required_if:role,vendor', 'string'],
                'contact_person' => ['required_if:role,vendor', 'string', 'max:255'],
                'contact_phone' => ['required_if:role,vendor', 'string', 'max:255'],

                // Additional contact details
                'alternative_phone' => ['nullable', 'string', 'max:255'],
                'whatsapp_number' => ['nullable', 'string', 'max:255'],
                'physical_address' => ['required_if:role,vendor', 'string'],
                'postal_address' => ['nullable', 'string', 'max:255'],
                'city' => ['required_if:role,vendor', 'string', 'max:255'],
                'county' => ['required_if:role,vendor', 'string', 'max:255'],
                'postal_code' => ['nullable', 'string', 'max:10'],

                // Business details - MANDATORY for vendors
                'business_registration_number' => ['required_if:role,vendor', 'string', 'max:255'],
                'kra_pin' => ['required_if:role,vendor', 'string', 'max:255', 'regex:/^[A-Z]\d{9}[A-Z]$/'],
                'business_start_date' => ['required_if:role,vendor', 'date', 'before_or_equal:today'],
                'number_of_employees' => ['required_if:role,vendor', 'string', 'max:255'],
                'business_description' => ['required_if:role,vendor', 'string', 'min:10'],

                // Document uploads (5MB = 5120KB) - MANDATORY for vendors
                'kra_certificate' => ['required_if:role,vendor', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
                'certificate_of_registration' => ['required_if:role,vendor', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
                'id_card_front' => ['required_if:role,vendor', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
                'id_card_back' => ['required_if:role,vendor', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            ], [
                // Custom validation messages
                'kra_pin.regex' => 'KRA PIN must be in the format: A123456789X (1 letter, 9 digits, 1 letter)',
                'business_start_date.before_or_equal' => 'Business start date cannot be in the future',
                'business_description.min' => 'Business description must be at least 10 characters long',
                'kra_certificate.required_if' => 'KRA Certificate is required for vendor registration',
                'kra_certificate.mimes' => 'KRA Certificate must be a PDF, JPG, JPEG, or PNG file',
                'kra_certificate.max' => 'KRA Certificate file size must not exceed 5MB',
                'certificate_of_registration.required_if' => 'Certificate of Registration is required for vendor registration',
                'certificate_of_registration.mimes' => 'Certificate of Registration must be a PDF, JPG, JPEG, or PNG file',
                'certificate_of_registration.max' => 'Certificate of Registration file size must not exceed 5MB',
                'id_card_front.required_if' => 'Front side of National ID is required for vendor registration',
                'id_card_front.mimes' => 'National ID (Front) must be a JPG, JPEG, or PNG file',
                'id_card_front.max' => 'National ID (Front) file size must not exceed 5MB',
                'id_card_back.required_if' => 'Back side of National ID is required for vendor registration',
                'id_card_back.mimes' => 'National ID (Back) must be a JPG, JPEG, or PNG file',
                'id_card_back.max' => 'National ID (Back) file size must not exceed 5MB',
                'business_registration_number.required_if' => 'Business Registration Number is required for vendor registration',
                'kra_pin.required_if' => 'KRA PIN is required for vendor registration',
                'business_start_date.required_if' => 'Business Start Date is required for vendor registration',
                'number_of_employees.required_if' => 'Number of Employees is required for vendor registration',
                'business_description.required_if' => 'Business Description is required for vendor registration',
            ]);

            // Combine first_name and last_name into name field
            $name = trim($request->first_name . ' ' . $request->last_name);

            $user = User::create([
                'name' => $name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'phone' => $request->contact_phone ?? null,
            ]);

            // Create role-specific profile
            if ($request->role === 'vendor') {
                $this->createVendorProfile($user, $request);
            } else {
                $this->createUserProfile($user, $request);
            }

            // Store referral code in session for later use if needed
            if ($request->referral_code) {
                session(['referral_code' => $request->referral_code]);
            }

            event(new Registered($user));

            Auth::login($user);

            // For vendors, always redirect to waiting page first
            if ($request->role === 'vendor') {
                return redirect()->route('vendor.waiting');
            }

            return redirect(route($user->getDashboardRoute(), absolute: false));
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Registration error: ' . $e->getMessage());
            Log::error('Request data: ' . json_encode($request->all()));

            // Re-throw the exception to show validation errors
            throw $e;
        }
    }

    /**
     * Create vendor profile
     */
    private function createVendorProfile(User $user, Request $request): void
    {
        // Handle file uploads
        $documentPaths = [];
        $documents = ['kra_certificate', 'certificate_of_registration', 'id_card_front', 'id_card_back'];

        foreach ($documents as $document) {
            if ($request->hasFile($document)) {
                try {
                    $file = $request->file($document);
                    $filename = $document . '_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('vendor-documents', $filename, 'public');
                    $documentPaths[$document] = $path;

                    Log::info("Document uploaded successfully: {$document} -> {$path}");
                } catch (\Exception $e) {
                    Log::error("Failed to upload document {$document}: " . $e->getMessage());
                    throw new \Exception("Failed to upload {$document}. Please try again.");
                }
            }
        }

        VendorProfile::create([
            'user_id' => $user->id,
            'vendor_code' => 'VEND' . strtoupper(Str::random(8)),
            'company_name' => $request->company_name,
            'business_type' => $request->business_type,
            'business_address' => $request->business_address,
            'contact_person' => $request->contact_person,
            'contact_phone' => $request->contact_phone,
            'contact_email' => $request->email,
            'status' => 'pending',

            // Additional contact details
            'alternative_phone' => $request->alternative_phone,
            'whatsapp_number' => $request->whatsapp_number,
            'physical_address' => $request->physical_address,
            'postal_address' => $request->postal_address,
            'city' => $request->city,
            'county' => $request->county,
            'postal_code' => $request->postal_code,

            // Business details
            'business_registration_number' => $request->business_registration_number,
            'kra_pin' => $request->kra_pin,
            'business_start_date' => $request->business_start_date,
            'number_of_employees' => $request->number_of_employees,
            'business_description' => $request->business_description,

            // Document uploads
            'kra_certificate' => $documentPaths['kra_certificate'] ?? null,
            'certificate_of_registration' => $documentPaths['certificate_of_registration'] ?? null,
            'id_card_front' => $documentPaths['id_card_front'] ?? null,
            'id_card_back' => $documentPaths['id_card_back'] ?? null,
        ]);
    }

    /**
     * Create user profile
     */
    private function createUserProfile(User $user, Request $request): void
    {
        UserProfile::create([
            'user_id' => $user->id,
            'customer_code' => 'CUST' . strtoupper(Str::random(8)),
            'referral_code' => $request->referral_code,
        ]);
    }
}
