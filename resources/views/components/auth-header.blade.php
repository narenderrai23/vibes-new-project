@props(['title', 'description'])

<div class="flex w-full flex-col text-center">
    <h1 class="text-2xl text-zinc-800 font-semibold dark:text-zinc-200">{{ $title }}</h1>
    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ $description }}</p>
</div>
