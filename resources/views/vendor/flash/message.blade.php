@foreach (session('flash_notification', collect())->toArray() as $message)
    <?php
    $variable = $message['level'];

    switch ($variable) {
        case 'primary':
            $icon = '<i class="ti ti-info-circle"></i>';
            break;
        case 'secondary':
            $icon = '<i class="ti ti-info-circle"></i>';
            break;
        case 'success':
            $icon = '<i class="ti ti-check-circle"></i>';
            break;
        case 'danger':
            $icon = '<i class="ti ti-alert-triangle"></i>';
            break;
        case 'warning':
            $icon = '<i class="ti ti-alert-triangle"></i>';
            break;
        case 'info':
            $icon = '<i class="ti ti-info-circle"></i>';
            break;
        case 'light':
            $icon = '<i class="ti ti-speakerphone"></i>';
            break;
        case 'dark':
            $icon = '<i class="ti ti-help-circle"></i>';
            break;
        default:
            $icon = '<i class="ti ti-speakerphone"></i>';
            break;
    }
    ?>

    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message'],
        ])
    @else
        <div class="alert alert-{{ $message['level'] }} {{ $message['important'] ? 'alert-dismissible' : '' }}"
            role="alert" fade show>

            {!! $icon !!}&nbsp;{!! $message['message'] !!}

            @if ($message['important'])
                <button class="btn-close" data-coreui-dismiss="alert" type="button" aria-label="Close"></button>
            @endif
        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
