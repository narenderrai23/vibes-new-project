<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    public function notice(): View|RedirectResponse
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->intended(route('backend.dashboard'));
        }

        return view('auth.verify-email');
    }

    public function send(Request $request): RedirectResponse
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->intended(route('backend.dashboard'));
        }

        Auth::user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
