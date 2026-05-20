<div class="text-end">
    @can("edit_{$module_name}")
        <a
            class="btn btn-outline-primary btn-sm m-1"
            href="{{ route("backend.{$module_name}.edit", $data) }}"
            data-toggle="tooltip"
            title="{{ __('Edit') }} {{ ucwords(Str::singular($module_name)) }}"
            aria-label="{{ __('Edit') }} {{ ucwords(Str::singular($module_name)) }}"
        >
            <i class="ti ti-tool" aria-hidden="true"></i>
        </a>
    @endcan

    <a
        class="btn btn-info btn-sm m-1"
        href="{{ route("backend.{$module_name}.show", $data) }}"
        data-toggle="tooltip"
        title="{{ __('Show') }} {{ ucwords(Str::singular($module_name)) }}"
        aria-label="{{ __('Show') }} {{ ucwords(Str::singular($module_name)) }}"
    >
        <i class="ti ti-device-desktop" aria-hidden="true"></i>
    </a>
</div>
