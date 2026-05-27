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
<<<<<<< HEAD
            return redirect()->intended(route('admin.dashboard'));
=======
            return redirect()->intended(route('backend.dashboard'));
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634
        }

        return view('auth.verify-email');
    }

    public function send(Request $request): RedirectResponse
    {
        if (Auth::user()->hasVerifiedEmail()) {
<<<<<<< HEAD
            return redirect()->intended(route('admin.dashboard'));
=======
            return redirect()->intended(route('backend.dashboard'));
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634
        }

        Auth::user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
