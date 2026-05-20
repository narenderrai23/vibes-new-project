<div class="mt-4 flex flex-col gap-6">
    <div class="text-center">
        {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="text-center font-medium text-green-600 dark:text-green-400">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="flex flex-col items-center justify-between space-y-3">
        <x-ui.link wire:click="sendVerification" class="w-full">
            {{ __('Resend Verification Email') }}
        </x-ui.link>

        <x-ui.link wire:click="logout">{{ __('Log out') }}</x-ui.link>
    </div>
</div>
