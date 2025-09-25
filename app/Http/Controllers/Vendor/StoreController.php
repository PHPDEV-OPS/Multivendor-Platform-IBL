<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreController extends Controller
{
    public function index()
    {
        $vendor = Auth::user();
        $profile = $vendor->vendorProfile;
        
        // Get vendor statistics
        $stats = [
            'total_products' => $vendor->products()->count(),
            'active_products' => $vendor->products()->where('status', 'active')->count(),
            'total_orders' => $vendor->orders()->count(),
            'total_revenue' => $vendor->orders()->sum('total_amount'),
            'average_rating' => $vendor->products()->avg('rating') ?? 0,
            'total_reviews' => $vendor->products()->sum('review_count'),
        ];

        return view('vendor.store.index', compact('vendor', 'profile', 'stats'));
    }

    public function update(Request $request)
    {
        $vendor = Auth::user();
        $profile = $vendor->vendorProfile;

        $request->validate([
            'company_name' => 'required|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:255',
            'business_license' => 'nullable|string|max:255',
            'business_address' => 'required|string',
            'contact_person' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'store_description' => 'nullable|string',
            'store_policy' => 'nullable|string',
            'shipping_policy' => 'nullable|string',
            'return_policy' => 'nullable|string',
            'social_facebook' => 'nullable|url',
            'social_twitter' => 'nullable|url',
            'social_instagram' => 'nullable|url',
            'social_linkedin' => 'nullable|url',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'bank_account_name' => 'nullable|string|max:255',
            'bank_swift_code' => 'nullable|string|max:255',
        ]);

        // Update vendor profile
        $profileData = [
            'company_name' => $request->company_name,
            'business_type' => $request->business_type,
            'tax_id' => $request->tax_id,
            'business_license' => $request->business_license,
            'business_address' => $request->business_address,
            'contact_person' => $request->contact_person,
            'contact_phone' => $request->contact_phone,
            'contact_email' => $request->contact_email,
        ];

        // Update bank details
        $bankDetails = [
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_number,
            'bank_account_name' => $request->bank_account_name,
            'bank_swift_code' => $request->bank_swift_code,
        ];

        $profileData['bank_details'] = $bankDetails;

        $profile->update($profileData);

        // Update user profile if needed
        $vendor->update([
            'name' => $request->contact_person,
            'email' => $request->contact_email,
        ]);

        // Update additional store information
        $storeData = [
            'store_description' => $request->store_description,
            'store_policy' => $request->store_policy,
            'shipping_policy' => $request->shipping_policy,
            'return_policy' => $request->return_policy,
            'social_facebook' => $request->social_facebook,
            'social_twitter' => $request->social_twitter,
            'social_instagram' => $request->social_instagram,
            'social_linkedin' => $request->social_linkedin,
        ];

        // Store additional data in settings or create a separate table
        // For now, we'll store it in the vendor profile as JSON
        $profile->update([
            'store_settings' => $storeData
        ]);

        return redirect()->route('vendor.store')
            ->with('success', 'Store information updated successfully!');
    }

    public function uploadLogo(Request $request)
    {
        $request->validate([
            'store_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $vendor = Auth::user();
        $profile = $vendor->vendorProfile;

        if ($request->hasFile('store_logo')) {
            // Delete old logo if exists
            if ($profile->store_logo) {
                Storage::disk('public')->delete($profile->store_logo);
            }

            $logoPath = $this->uploadImage($request->file('store_logo'), 'store-logos');
            $profile->update(['store_logo' => $logoPath]);

            return response()->json([
                'success' => true,
                'message' => 'Store logo uploaded successfully!',
                'logo_url' => Storage::url($logoPath)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded'
        ], 400);
    }

    public function uploadBanner(Request $request)
    {
        $request->validate([
            'store_banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $vendor = Auth::user();
        $profile = $vendor->vendorProfile;

        if ($request->hasFile('store_banner')) {
            // Delete old banner if exists
            if ($profile->store_banner) {
                Storage::disk('public')->delete($profile->store_banner);
            }

            $bannerPath = $this->uploadImage($request->file('store_banner'), 'store-banners');
            $profile->update(['store_banner' => $bannerPath]);

            return response()->json([
                'success' => true,
                'message' => 'Store banner uploaded successfully!',
                'banner_url' => Storage::url($bannerPath)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded'
        ], 400);
    }

    private function uploadImage($image, $folder)
    {
        $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs("uploads/images/{$folder}", $filename, 'public');
        return $path;
    }
}
