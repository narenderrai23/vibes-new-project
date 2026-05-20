@props(['href' => '', 'small' => 'true', 'text' => 'Public View'])

<a
    class="btn btn-light {{ $small == 'true' ? 'btn-sm' : '' }}"
    href="{{ $href }}"
    target="_blank"
    rel="noopener noreferrer"
    aria-label="{{ __($text) }}"
>
    <i class="ti ti-external-link" aria-hidden="true"></i>
    {!! $text != '' ? '&nbsp;' . $text : '' !!}
    {!! $slot->isNotEmpty() ? '&nbsp;' . $slot : '' !!}
</a>
