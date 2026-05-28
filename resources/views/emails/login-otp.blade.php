@component('mail::message')
# {{ __('Your login code') }}

{{ __('Use the following one-time code to sign in. It expires in 10 minutes.') }}

@component('mail::panel')
# {{ $code }}
@endcomponent

{{ __('If you did not request this code, ignore this email.') }}

{{ __('Login area') }}: {{ $area }}

{{ __('Thanks') }},<br>
{{ config('app.name') }}
@endcomponent
