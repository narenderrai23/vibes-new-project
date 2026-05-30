<div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">

    <div class="my-auto mb-2">

        {{-- Page Title --}}
        @if (!empty(trim($title ?? '')))
            <h2 class="mb-1">{!! $title !!}</h2>
        @endif

        {{-- Breadcrumb --}}
        <nav>
            <ol class="breadcrumb mb-0">

                {{-- Home --}}
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="ti ti-smart-home"></i>
                    </a>
                </li>

                {{-- Dynamic Items --}}
                {{ $slot }}

            </ol>
        </nav>
    </div>

    {{-- Right Icons --}}
    <div class="head-icons ms-2">
        <a href="javascript:void(0);"
           data-bs-toggle="tooltip"
           data-bs-placement="top"
           data-bs-original-title="Collapse"
           id="collapse-header">

            <i class="ti ti-chevrons-up"></i>
        </a>
    </div>

</div>