<?php

namespace App\Http\Controllers\Auth;

use App\Events\Frontend\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create($validated);

        $username = intval(config('app.initial_username')) + $user->id;
        $user->username = strval($username);
        $user->last_ip = $request->getClientIp();
        $user->save();

        event(new UserRegistered($user));

        Auth::login($user);

<<<<<<< HEAD
        return redirect()->route('admin.dashboard');
=======
        return redirect()->route('backend.dashboard');
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634
    }
}
