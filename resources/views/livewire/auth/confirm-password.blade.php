<div class="flex flex-col gap-6">
    <x-auth-header
        :title="__('Confirm password')"
        :description="__('This is a secure area of the application. Please confirm your password before continuing.')"
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="confirmPassword" class="flex flex-col gap-6">
        {{-- Password --}}
        <x-forms.group name="password" label="Password" required>
            <x-forms.input class="w-full" type="password" wire:model="password" required />
        </x-forms.group>

        <x-ui.button class="w-full" variant="primary" type="submit">
            {{ __('Confirm') }}
        </x-ui.button>
    </form>
</div>
