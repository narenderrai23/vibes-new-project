@props(['small' => 'true'])

<button
    type="button"
    onclick="window.history.back();"
    class="btn btn-warning {{ $small == 'true' ? 'btn-sm' : '' }} m-1"
    data-toggle="tooltip"
    title="{{ __('Return Back') }}"
    aria-label="{{ __('Return Back') }}"
>
    <i class="ti ti-arrow-back-up" aria-hidden="true"></i>
    {!! $slot->isNotEmpty() ? '&nbsp;' . $slot : '' !!}
</button>
