<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    public function profile(?string $username = null): View
    {
        $authUser = Auth::user();
        $username = $username ?? ($authUser?->username ?? '');

        $user = User::whereUsername($username)->firstOrFail();

        $module_name_singular = $user;

        return view('pages.frontend.users.profile', compact('user', 'module_name_singular'));
    }

    public function editProfile(): View
    {
        /** @var User $user */
        $user = Auth::user();

        return view('pages.frontend.users.profile-edit', compact('user'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'first_name'    => ['required', 'string', 'max:191'],
            'last_name'     => ['required', 'string', 'max:191'],
            'mobile'        => ['nullable', 'string', 'max:191'],
            'gender'        => ['nullable', 'string', 'max:191'],
            'date_of_birth' => ['nullable', 'date'],
            'address'       => ['nullable', 'string', 'max:191'],
            'bio'           => ['nullable', 'string'],
            'url'           => ['nullable', 'url', 'max:191'],
            'url_text'      => ['nullable', 'string', 'max:191'],
            'avatar'        => ['nullable', 'image', 'max:2048'],
        ]);

        $user->update(collect($validated)->except('avatar')->toArray());

        if ($request->hasFile('avatar')) {
            if ($user->getMedia('users')->first()) {
                $user->getMedia('users')->first()->delete();
            }
            $media = $user->addMedia($request->file('avatar'))->toMediaCollection('users');
            $user->update(['avatar' => $media->getUrl()]);
        }

        flash('Update successful!')->success()->important();

        return redirect()->route('frontend.users.profile', $user->username);
    }

    public function changePassword(): View
    {
        return view('pages.frontend.users.change-password');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update(['password' => $request->password]);

        flash('Password updated successfully!')->success()->important();

        return redirect()->route('frontend.users.profile', $user->username);
    }

    public function resendEmailConfirmation(): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            flash($user->name.', You already confirmed your email address.')->success()->important();

            return back();
        }

        Log::info($user->name.' ('.$user->id.') - User requested for email verification.');
        $user->sendEmailVerificationNotification();

        flash('Email Sent! Please Check Your Inbox.')->success()->important();

        return back();
    }

    public function unlinkProvider(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'provider_id' => ['required', 'integer'],
        ]);

        $userProvider = UserProvider::findOrFail($request->provider_id);

        if ($user->id !== $userProvider->user_id) {
            abort(403);
        }

        $providerName = $userProvider->provider ?? 'provider';
        $userProvider->delete();

        flash('Successfully unlinked '.$providerName.' from your account!')->success();

        return back();
    }
}
