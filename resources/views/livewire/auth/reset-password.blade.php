<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Reset password')" :description="__('Please enter your new password below')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="resetPassword" class="flex flex-col gap-6">
        {{-- Email Address --}}
        <x-forms.group name="email" label="Email Address" required>
            <x-forms.input class="w-full" type="email" wire:model="email" required />
        </x-forms.group>

        {{-- Password --}}
        <x-forms.group name="password" label="Password" required>
            <x-forms.input class="w-full" type="password" wire:model="password" required />
        </x-forms.group>

        {{-- Confirm Password --}}
        <x-forms.group name="password_confirmation" label="Confirm Password" required>
            <x-forms.input class="w-full" type="password" wire:model="password_confirmation" required />
        </x-forms.group>

        <div class="flex items-center justify-end">
            <x-ui.button class="w-full" variant="primary" type="submit">
                {{ __('Reset password') }}
            </x-ui.button>
        </div>
    </form>
</div>
