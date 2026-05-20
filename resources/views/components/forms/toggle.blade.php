@props([
    'disabled' => false,
    'checked'  => false,
    'required' => false,
])

<label class="relative inline-flex cursor-pointer items-center">
    <input
        type="checkbox"
        role="switch"
        {{ $disabled ? 'disabled' : '' }}
        {{ $required ? 'required' : '' }}
        {{ $checked ? 'checked' : '' }}
        {{ $attributes->merge(['class' => 'sr-only peer']) }}
    >
    <div class="peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-indigo-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 peer-focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-700 dark:peer-focus:ring-offset-gray-800 disabled:opacity-50 disabled:cursor-not-allowed"></div>
    @if ($slot->isNotEmpty())
        <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $slot }}</span>
    @endif
</label>
