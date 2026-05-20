{{--
    Button: Delete
    Variables: $route (string), $title (string, optional), $small (bool, optional), $class (string, optional), $confirm (string, optional)
--}}
@php
    $btnRoute   = $route   ?? '';
    $btnTitle   = $title   ?? __('Delete');
    $btnSmall   = ($small  ?? false) ? 'btn-sm' : '';
    $btnClass   = $class   ?? '';
    $btnConfirm = $confirm ?? __('Are you sure?');
@endphp

<a
    class="btn btn-danger {{ $btnSmall }} {{ $btnClass }} m-1"
    href="{{ $btnRoute }}"
    data-method="DELETE"
    data-token="{{ csrf_token() }}"
    data-toggle="tooltip"
    data-confirm="{{ $btnConfirm }}"
    title="{{ $btnTitle }}"
    aria-label="{{ $btnTitle }}"
>
    <i class="ti ti-trash" aria-hidden="true"></i>
    @if(isset($label)) &nbsp;{{ $label }} @endif
</a>
