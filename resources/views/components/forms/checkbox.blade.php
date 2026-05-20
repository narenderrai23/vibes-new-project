@props([
    'disabled'  => false,
    'required'  => false,
    'checked'   => false,
    'autofocus' => false,
])

<div class="flex items-center">
    <input
        type="checkbox"
        {{ $disabled ? 'disabled' : '' }}
        {{ $required ? 'required' : '' }}
        {{ $checked ? 'checked' : '' }}
        {{ $autofocus ? 'autofocus' : '' }}
        {{ $attributes->merge(['class' => 'rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800']) }}
        @if ($attributes->has('wire:model'))
            id="{{ $attributes->get('wire:model') }}"
            @if ($slot->isNotEmpty())
                aria-labelledby="{{ $attributes->get('wire:model') }}-label"
            @else
                aria-label="{{ $attributes->get('wire:model') }}"
            @endif
        @endif
    >
    @if ($slot->isNotEmpty())
        <label
            @if ($attributes->has('wire:model')) id="{{ $attributes->get('wire:model') }}-label" @endif
            class="ml-2 text-sm text-gray-600 dark:text-gray-400"
        >
            {{ $slot }}
        </label>
    @endif
</div>
