<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updatePersonal(Request $request)
    {
        try {
            $user = Auth::user();

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
                'phone' => 'nullable|string|max:20',
                'date_of_birth' => 'nullable|date',
                'gender' => 'nullable|in:male,female,other,prefer-not',
                'bio' => 'nullable|string|max:1000',
            ]);

            $updated = $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'date_of_birth' => $validatedData['date_of_birth'],
                'gender' => $validatedData['gender'],
                'bio' => $validatedData['bio'],
            ]);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Personal information updated successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update personal information'
                ], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateBusiness(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'business_name' => 'nullable|string|max:255',
            'business_type' => 'nullable|in:individual,partnership,corporation,llc',
            'tax_id' => 'nullable|string|max:50',
            'business_website' => 'nullable|url|max:255',
            'business_description' => 'nullable|string|max:1000',
            'years_in_business' => 'nullable|integer|min:0|max:50',
            'number_of_employees' => 'nullable|integer|min:1|max:1000',
        ]);

        $user->update([
            'business_name' => $request->business_name,
            'business_type' => $request->business_type,
            'tax_id' => $request->tax_id,
            'business_website' => $request->business_website,
            'business_description' => $request->business_description,
            'years_in_business' => $request->years_in_business,
            'number_of_employees' => $request->number_of_employees,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Business information updated successfully!'
        ]);
    }

    public function updateAddress(Request $request)
    {
        try {
            $user = Auth::user();

            $validatedData = $request->validate([
                'primary_address' => 'required|array',
                'primary_address.street' => 'required|string|max:255',
                'primary_address.city' => 'required|string|max:100',
                'primary_address.state' => 'required|string|max:100',
                'primary_address.postal_code' => 'required|string|max:20',
                'primary_address.country' => 'required|string|max:100',
                'shipping_address' => 'nullable|array',
                'same_as_primary' => 'nullable|boolean',
            ]);

            $addressData = [
                'primary_address' => $validatedData['primary_address'],
            ];

            if (!$request->has('same_as_primary') && isset($validatedData['shipping_address'])) {
                $addressData['shipping_address'] = $validatedData['shipping_address'];
            } else {
                $addressData['shipping_address'] = $validatedData['primary_address'];
            }

            $updated = $user->update($addressData);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Address information updated successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update address information'
                ], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateSocialMedia(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
        ]);

        $user->update([
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'instagram_url' => $request->instagram_url,
            'linkedin_url' => $request->linkedin_url,
            'youtube_url' => $request->youtube_url,
            'tiktok_url' => $request->tiktok_url,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Social media links updated successfully!'
        ]);
    }

    public function updateProfilePicture(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $user = Auth::user();

            // Delete old profile picture if exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Store new profile picture
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');

            $updated = $user->update([
                'profile_image' => $path,
            ]);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Profile picture updated successfully!',
                    'image_url' => Storage::url($path)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update profile picture'
                ], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect!'
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully!'
        ]);
    }

    public function updateNotificationSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'marketing_emails' => 'boolean',
        ]);

        $user->update([
            'email_notifications' => $request->email_notifications ?? false,
            'sms_notifications' => $request->sms_notifications ?? false,
            'push_notifications' => $request->push_notifications ?? false,
            'marketing_emails' => $request->marketing_emails ?? false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notification settings updated successfully!'
        ]);
    }

    public function exportData()
    {
        $user = Auth::user();

        $userData = [
            'personal_information' => [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'date_of_birth' => $user->date_of_birth,
                'gender' => $user->gender,
                'bio' => $user->bio,
            ],
            'business_information' => [
                'business_name' => $user->business_name,
                'business_type' => $user->business_type,
                'tax_id' => $user->tax_id,
                'business_website' => $user->business_website,
                'business_description' => $user->business_description,
                'years_in_business' => $user->years_in_business,
                'number_of_employees' => $user->number_of_employees,
            ],
            'addresses' => [
                'primary_address' => $user->primary_address,
                'shipping_address' => $user->shipping_address,
            ],
            'social_media' => [
                'facebook_url' => $user->facebook_url,
                'twitter_url' => $user->twitter_url,
                'instagram_url' => $user->instagram_url,
                'linkedin_url' => $user->linkedin_url,
                'youtube_url' => $user->youtube_url,
                'tiktok_url' => $user->tiktok_url,
            ],
            'account_info' => [
                'created_at' => $user->created_at,
                'email_verified_at' => $user->email_verified_at,
                'last_login_at' => $user->last_login_at,
            ]
        ];

        $filename = 'user_data_' . $user->id . '_' . now()->format('Y-m-d_H-i-s') . '.json';

        return response()->json($userData)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
