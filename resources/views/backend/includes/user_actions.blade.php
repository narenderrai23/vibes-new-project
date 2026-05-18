<div class="text-end">
    <a
        href="{{ route("backend.users.show", $data) }}"
        class="btn btn-outline-success btn-sm mt-1"
        data-toggle="tooltip"
        title="{{ __("labels.backend.show") }}"
    >
        <i class="ph-light ph-monitor"></i>
    </a>
    <a
        href="{{ route("backend.users.edit", $data) }}"
        class="btn btn-outline-primary btn-sm mt-1"
        data-toggle="tooltip"
        title="{{ __("labels.backend.edit") }}"
    >
        <i class="ph-light ph-wrench"></i>
    </a>
    <a
        href="{{ route("backend.users.changePassword", $data) }}"
        class="btn btn-outline-info btn-sm mt-1"
        data-toggle="tooltip"
        title="{{ __("labels.backend.changePassword") }}"
    >
        <i class="ph-light ph-key"></i>
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
            <i class="ph-light ph-prohibit"></i>
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
            <i class="ph-light ph-check"></i>
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
            <i class="ph-light ph-trash"></i>
        </a>
    @endif

    @if ($data->email_verified_at == null)
        <a
            href="{{ route("backend.users.emailConfirmationResend", $data->id) }}"
            class="btn btn-outline-primary btn-sm mt-1"
            data-toggle="tooltip"
            title="@lang("Send confirmation email")"
        >
            <i class="ph-light ph-envelope"></i>
        </a>
    @endif
</div>
