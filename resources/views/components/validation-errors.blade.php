@if ($errors->any())
    <div class="my-4 rounded-lg border border-red-300 bg-red-50 p-4 dark:bg-gray-800" role="alert" aria-live="polite">
        <ul class="list-disc list-inside space-y-1 text-sm text-red-600 dark:text-red-400">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
