<div class="text-end">
    <a
        href="{{ route("backend.users.show", $data) }}"
        class="btn btn-outline-success btn-sm mt-1"
        data-toggle="tooltip"
        title="{{ __("labels.backend.show") }}"
    >
        <i class="ti ti-device-desktop"></i>
    </a>
    <a
        href="{{ route("backend.users.edit", $data) }}"
        class="btn btn-outline-primary btn-sm mt-1"
        data-toggle="tooltip"
        title="{{ __("labels.backend.edit") }}"
    >
        <i class="ti ti-tool"></i>
    </a>
    <a
        href="{{ route("backend.users.changePassword", $data) }}"
        class="btn btn-outline-info btn-sm mt-1"
        data-toggle="tooltip"
        title="{{ __("labels.backend.changePassword") }}"
    >
        <i class="ti ti-key"></i>
    </a>

    @if ($data->status != 2 && $data->id != 1)
        <a
            href="{{ route("backend.users.block", $data) }}"
            class="btn btn-outline-danger btn-sm mt-1"
            data-method="PATCH"
            data-token="{{ csrf_token() }}"
            data-toggle="tooltip"
            title="{{ __("labels.backend.block") }}"
            data-confirm="@lang("Are you sure?")"
        >
            <i class="ti ti-ban"></i>
        </a>
    @endif

    @if ($data->status == 2)
        <a
            href="{{ route("backend.users.unblock", $data) }}"
            class="btn btn-outline-info btn-sm mt-1"
            data-method="PATCH"
            data-token="{{ csrf_token() }}"
            data-toggle="tooltip"
            title="{{ __("labels.backend.unblock") }}"
            data-confirm="@lang("Are you sure?")"
        >
            <i class="ti ti-check"></i>
        </a>
    @endif

    @if ($data->id != 1)
        <a
            href="{{ route("backend.users.destroy", $data) }}"
            class="btn btn-outline-danger btn-sm mt-1"
            data-method="DELETE"
            data-token="{{ csrf_token() }}"
            data-toggle="tooltip"
            title="{{ __("labels.backend.delete") }}"
            data-confirm="@lang("Are you sure?")"
        >
            <i class="ti ti-trash"></i>
        </a>
    @endif

    @if ($data->email_verified_at == null)
        <a
            href="{{ route("backend.users.emailConfirmationResend", $data->id) }}"
            class="btn btn-outline-primary btn-sm mt-1"
            data-toggle="tooltip"
            title="@lang("Send confirmation email")"
        >
            <i class="ti ti-mail"></i>
        </a>
    @endif
</div>
