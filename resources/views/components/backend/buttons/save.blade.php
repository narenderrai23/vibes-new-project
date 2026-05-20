@props(['small' => ''])

<button
    type="submit"
    class="btn btn-success m-1{{ $small == 'true' ? ' btn-sm' : '' }}"
    data-toggle="tooltip"
    title="{{ __('Save') }}"
    aria-label="{{ __('Save') }}"
>
    <i class="ti ti-device-floppy" aria-hidden="true"></i>
    &nbsp;{{ __('Save') }}
</button>
