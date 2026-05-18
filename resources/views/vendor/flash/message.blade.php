@foreach (session('flash_notification', collect())->toArray() as $message)
    <?php
    $variable = $message['level'];

    switch ($variable) {
        case 'primary':
            $icon = '<i class="ph-light ph-info"></i>';
            break;
        case 'secondary':
            $icon = '<i class="ph-light ph-info"></i>';
            break;
        case 'success':
            $icon = '<i class="ph-light ph-check-circle"></i>';
            break;
        case 'danger':
            $icon = '<i class="ph-light ph-warning"></i>';
            break;
        case 'warning':
            $icon = '<i class="ph-light ph-warning"></i>';
            break;
        case 'info':
            $icon = '<i class="ph-light ph-info"></i>';
            break;
        case 'light':
            $icon = '<i class="ph-light ph-megaphone"></i>';
            break;
        case 'dark':
            $icon = '<i class="ph-light ph-question"></i>';
            break;
        default:
            $icon = '<i class="ph-light ph-megaphone"></i>';
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
