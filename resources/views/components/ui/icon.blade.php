@props(['name' => '', 'size' => '24', 'class' => ''])

@if ($name)
    <i class="{{ $name }} {{ $class }}" aria-hidden="true"></i>
@else
    {{ $slot }}
@endif
