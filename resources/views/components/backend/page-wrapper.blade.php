@props(['breadcrumbs' => '', 'toolbar' => '', 'footer' => ''])

<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            @includeIf('flash::message')
            @includeIf('backend.includes.errors')

            <div class="row align-items-center mw-100">
                <div class="col">
                    <h1 class="page-title">
                        <span class="text-truncate">{{ $title }}</span>
                    </h1>

                    @if ($breadcrumbs->isNotEmpty())
                        <div class="mt-2">
                            <ol class="breadcrumb breadcrumb-bullets" aria-label="breadcrumbs">
                                {{ $breadcrumbs }}
                            </ol>
                        </div>
                    @endif
                </div>

                @if ($toolbar->isNotEmpty())
                    <div class="col-auto">
                        <div class="btn-list">
                            {{ $toolbar }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    {{ $slot }}
                </div>
                @if ($footer->isNotEmpty())
                    <div class="card-footer">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-backend.includes.footer />
</div>
