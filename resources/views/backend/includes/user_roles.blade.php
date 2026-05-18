@if ($data->getRoleNames()->count() > 0)
    <ul class="list-unstyled mb-0">
        @foreach ($data->getRoleNames() as $role)
            <li class="d-flex align-items-center gap-1">
                <i class="ph-light ph-shield-check"></i>
                {{ ucwords($role) }}
            </li>
        @endforeach
    </ul>
@endif
