{{--
    Button: Return Back
    Variables: $small (bool, optional), $label (string, optional)
--}}
@php
    $btnSmall = ($small ?? true) ? ' btn-sm' : '';
    $btnLabel = $label ?? __('Return Back');
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
    @if(isset($label)) &nbsp;{{ $btnLabel }} @endif
</button>
