<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VendorProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MerchantApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = VendorProfile::with('user');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name or company
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.merchant-applications.index', compact('applications'));
    }

    public function show($id)
    {
        $application = VendorProfile::with('user')->findOrFail($id);
        
        return view('admin.merchant-applications.show', compact('application'));
    }

    public function approve($id)
    {
        $application = VendorProfile::with('user')->findOrFail($id);
        
        $application->update([
            'status' => 'approved',
            'rejection_reason' => null
        ]);

        // Update user role to vendor if user exists
        if ($application->user) {
            $application->user->update(['role' => 'vendor']);
        }

        // Send approval email
        $this->sendApprovalEmail($application);

        return redirect()->route('admin.merchant-applications.index')
            ->with('success', 'Merchant application approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $application = VendorProfile::with('user')->findOrFail($id);

        $application->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        // Send rejection email
        $this->sendRejectionEmail($application, $request->rejection_reason);

        return redirect()->route('admin.merchant-applications.index')
            ->with('success', 'Merchant application rejected.');
    }

    public function suspend($id)
    {
        $application = VendorProfile::with('user')->findOrFail($id);
        
        $application->update([
            'status' => 'suspended',
            'rejection_reason' => 'Account suspended by administrator.'
        ]);

        // Update user role back to user if user exists
        if ($application->user) {
            $application->user->update(['role' => 'user']);
        }

        return redirect()->route('admin.merchant-applications.index')
            ->with('success', 'Merchant account suspended.');
    }

    public function reactivate($id)
    {
        $application = VendorProfile::with('user')->findOrFail($id);
        
        $application->update([
            'status' => 'approved',
            'rejection_reason' => null
        ]);

        // Update user role to vendor if user exists
        if ($application->user) {
            $application->user->update(['role' => 'vendor']);
        }

        return redirect()->route('admin.merchant-applications.index')
            ->with('success', 'Merchant account reactivated.');
    }

    public function destroy($id)
    {
        $application = VendorProfile::with('user')->findOrFail($id);
        
        // Update user role back to user if user exists
        if ($application->user) {
            $application->user->update(['role' => 'user']);
        }

        // Delete the vendor profile
        $application->delete();

        return redirect()->route('admin.merchant-applications.index')
            ->with('success', 'Merchant application deleted successfully.');
    }

    private function sendApprovalEmail(VendorProfile $application)
    {
        // You can implement email sending here
        // For now, we'll just log it
        $email = $application->user ? $application->user->email : $application->contact_email;
        \Log::info('Merchant application approved for: ' . $email);
    }

    private function sendRejectionEmail(VendorProfile $application, $reason)
    {
        // You can implement email sending here
        // For now, we'll just log it
        $email = $application->user ? $application->user->email : $application->contact_email;
        \Log::info('Merchant application rejected for: ' . $email . ' Reason: ' . $reason);
    }

    public function export()
    {
        $applications = VendorProfile::with('user')->get();
        
        $filename = 'merchant-applications-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($applications) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'ID', 'User Name', 'Email', 'Company Name', 'Business Type', 
                'Contact Person', 'Contact Phone', 'Status', 'Applied Date'
            ]);

            // Add data
            foreach ($applications as $application) {
                fputcsv($file, [
                    $application->id,
                    $application->user ? $application->user->name : 'Unknown User',
                    $application->user ? $application->user->email : $application->contact_email,
                    $application->company_name,
                    $application->business_type,
                    $application->contact_person,
                    $application->contact_phone,
                    $application->status,
                    $application->created_at ? $application->created_at->format('Y-m-d H:i:s') : 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
