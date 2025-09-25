<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings');
    }

    public function update(Request $request)
    {
        // Handle settings update logic here
        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully.');
    }
}
