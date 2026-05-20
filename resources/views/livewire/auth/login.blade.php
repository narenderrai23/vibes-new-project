<div class="flex flex-col gap-6">
    <x-auth-header
        :title="__('Log in to your account')"
        :description="__('Enter your email and password below to log in')"
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        {{-- Email Address --}}
        <x-forms.group name="email" label="Email Address" required>
            <x-forms.input class="w-full" type="email" wire:model="email" required />
        </x-forms.group>

        {{-- Password --}}
        <x-forms.group name="password" label="Password" required>
            <x-forms.input class="w-full" type="password" wire:model="password" required />
        </x-forms.group>

        <div class="flex items-center justify-between">
            <!-- Remember Me -->
            <x-forms.checkbox wire:model="remember">{{ __('Remember me') }}</x-forms.checkbox>

            @if (Route::has('password.request'))
                <x-ui.link class="text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('Forgot your password?') }}
                </x-ui.link>
            @endif
        </div>

        <div class="flex items-center justify-end">
            <x-ui.button class="w-full" variant="primary" type="submit">
                {{ __('Log in') }}
            </x-ui.button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 text-center text-sm tracking-widest text-zinc-600 dark:text-zinc-400">
            {{ __("Don't have an account?") }}
            <x-ui.link :href="route('register')" wire:navigate>{{ __('Sign up') }}</x-ui.link>
        </div>
    @endif
</div>
