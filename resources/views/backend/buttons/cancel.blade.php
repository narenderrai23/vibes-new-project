{{--
    Button: Cancel (go back)
    Variables: $small (bool, optional), $label (string, optional)
--}}
@php
    $btnSmall = ($small ?? false) ? ' btn-sm' : '';
    $btnLabel = $label ?? __('Cancel');
@endphp

<button
    type="button"
    onclick="window.history.back()"
    class="btn btn-warning{{ $btnSmall }} m-1"
    data-toggle="tooltip"
    title="{{ $btnLabel }}"
    aria-label="{{ $btnLabel }}"
>
    <i class="ti ti-arrow-back-up" aria-hidden="true"></i>
    &nbsp;{{ $btnLabel }}
</button>
