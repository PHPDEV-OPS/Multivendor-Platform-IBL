<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorProfile;
use Symfony\Component\HttpFoundation\Response;

class CheckVendorVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Only check verification for users with vendor role
        if ($user->role === 'vendor') {
            $vendorProfile = VendorProfile::where('user_id', $user->id)->first();
            
            // If no vendor profile exists or status is not approved, redirect to waiting page
            if (!$vendorProfile || $vendorProfile->status !== 'approved') {
                // Allow access to the waiting page itself to prevent redirect loops
                if ($request->routeIs('vendor.waiting')) {
                    return $next($request);
                }
                
                return redirect()->route('vendor.waiting');
            }
        }

        return $next($request);
    }
}
