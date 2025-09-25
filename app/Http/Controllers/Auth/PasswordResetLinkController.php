<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
            ]);

            // Check if user exists
            $user = \App\Models\User::where('email', $request->email)->first();
            
            if (!$user) {
                return back()->withInput($request->only('email'))
                    ->withErrors(['email' => 'We can\'t find a user with that email address.']);
            }

            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $status = Password::sendResetLink(
                $request->only('email')
            );

            // Log the status for debugging
            \Log::info('Password reset link status: ' . $status);

            return $status == Password::RESET_LINK_SENT
                        ? back()->with('status', __($status))
                        : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
        } catch (\Exception $e) {
            \Log::error('Password reset error: ' . $e->getMessage());
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'An error occurred while processing your request. Please try again.']);
        }
    }
}
