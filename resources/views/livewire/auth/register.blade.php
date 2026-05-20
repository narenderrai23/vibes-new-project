<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <x-forms.group name="name" label="Full Name" required>
            <x-forms.input class="w-full" type="text" wire:model="name" required />
        </x-forms.group>

        <!-- Email Address -->
        <x-forms.group name="email" label="Email Address" required>
            <x-forms.input class="w-full" type="email" wire:model="email" required />
        </x-forms.group>

        <!-- Password -->
        <x-forms.group name="password" label="Password" required>
            <x-forms.input class="w-full" type="password" wire:model="password" required />
        </x-forms.group>

        <!-- Confirm Password -->
        <x-forms.group name="password_confirmation" label="Confirm Password" required>
            <x-forms.input class="w-full" type="password" wire:model="password_confirmation" required />
        </x-forms.group>

        <div class="flex items-center justify-end">
            <x-ui.button class="w-full" variant="primary" type="submit">
                {{ __('Create account') }}
            </x-ui.button>
        </div>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600 tracking-widest dark:text-zinc-400">
        {{ __('Already have an account?') }}

        <x-ui.link class="text-sm" :href="route('login')" wire:navigate>
            {{ __('Log in') }}
        </x-ui.link>
    </div>
</div>
