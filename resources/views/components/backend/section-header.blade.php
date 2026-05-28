{{-- resources/views/components/backend/section-header.blade.php --}}

@props([
    'title' => null,
    'breadcrumbs' => [],
])

<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">

    {{-- Left Side --}}
    <div>

        {{-- Title --}}
        <h5 class="mb-1 d-flex align-items-center gap-2 flex-wrap">

            @if ($title)
                {{ $title }}
            @else
                {{ $slot }}
            @endif

        </h5>

        {{-- Breadcrumbs --}}
        @if (count($breadcrumbs))
            <nav>
                <ol class="breadcrumb mb-0">
                    @foreach ($breadcrumbs as $breadcrumb)

                        @if (!$loop->last)
                            <li class="breadcrumb-item">
                                <a href="{{ $breadcrumb['url'] ?? 'javascript:void(0);' }}">
                                    @if (isset($breadcrumb['icon']))
                                        <i class="{{ $breadcrumb['icon'] }}"></i>
                                    @endif

                                    {{ $breadcrumb['label'] }}
                                </a>
                            </li>
                        @else
                            <li class="breadcrumb-item active">
                                {{ $breadcrumb['label'] }}
                            </li>
                        @endif

                    @endforeach
                </ol>
            </nav>
        @endif

    </div>

    {{-- Right Toolbar --}}
    @isset($toolbar)
        <div class="d-flex align-items-center gap-2">
            {{ $toolbar }}
        </div>
    @endisset

</div>