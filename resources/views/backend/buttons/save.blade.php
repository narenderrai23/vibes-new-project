{{--
    Button: Save (submit)
    Variables: $small (bool, optional), $label (string, optional)
--}}
@php
    $btnSmall = ($small ?? false) ? ' btn-sm' : '';
    $btnLabel = $label ?? __('Save');
@endphp

<button
    type="submit"
    class="btn btn-success{{ $btnSmall }} m-1"
    data-toggle="tooltip"
    title="{{ $btnLabel }}"
    aria-label="{{ $btnLabel }}"
>
    <i class="ti ti-device-floppy" aria-hidden="true"></i>
    &nbsp;{{ $btnLabel }}
</button>
