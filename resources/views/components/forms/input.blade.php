@props([
    'type'      => 'text',
    'disabled'  => false,
    'required'  => false,
    'placeholder' => '',
    'autofocus' => false,
])

<input
    type="{{ $type }}"
    {{ $disabled ? 'disabled' : '' }}
    {{ $required ? 'required' : '' }}
    {{ $autofocus ? 'autofocus' : '' }}
    @if ($placeholder) placeholder="{{ $placeholder }}" @endif
    {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm disabled:opacity-50 disabled:cursor-not-allowed']) }}
    @if ($attributes->has('name') && !$attributes->has('aria-label') && !$attributes->has('aria-labelledby'))
        aria-labelledby="{{ $attributes->get('name') }}-label"
    @endif
>
