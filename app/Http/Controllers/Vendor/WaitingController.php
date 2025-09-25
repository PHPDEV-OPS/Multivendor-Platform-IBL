<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorProfile;

class WaitingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $vendorProfile = VendorProfile::where('user_id', $user->id)->first();
        
        return view('vendor.waiting', compact('vendorProfile'));
    }
}
