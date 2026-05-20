@props(['for' => '', 'value' => '', 'required' => false])

<label
    {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-gray-300']) }}
    @if ($for) for="{{ $for }}" id="{{ $for }}-label" @endif
>
    {{ $value ?? $slot }}
    @if ($required)
        <span class="text-red-500" aria-hidden="true">*</span>
    @endif
</label>
