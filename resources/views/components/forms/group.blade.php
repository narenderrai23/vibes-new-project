@props([
    'label'    => '',
    'name'     => '',
    'required' => false,
    'help'     => '',
])

@php
    $errorId = $name && $errors->has($name) ? $name . '-error' : null;
    $ariaDescribedby = collect([
        $name ? $name . '-label' : null,
        $help ? $name . '-help' : null,
        $errorId,
    ])->filter()->implode(' ');
@endphp

<div {{ $attributes->merge(['class' => 'mb-4']) }}>
    @if ($label)
        <label
            for="{{ $name }}"
            id="{{ $name }}-label"
            class="block font-medium text-sm text-gray-700 dark:text-gray-300"
        >
            {{ $label }}
            @if ($required)
                <span class="text-red-500" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    <div class="mt-1">
        {{ $slot->withAttributes(['aria-describedby' => $ariaDescribedby]) }}
    </div>

    @if ($help)
        <p id="{{ $name }}-help" class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $help }}</p>
    @endif

    @if ($name && $errors->has($name))
        <ul
            id="{{ $errorId }}"
            class="mt-2 text-sm text-red-600 dark:text-red-400 space-y-1"
            role="alert"
            aria-live="polite"
        >
            @foreach ($errors->get($name) as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @endif
</div>
