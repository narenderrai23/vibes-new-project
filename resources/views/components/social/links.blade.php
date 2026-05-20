@props([
    'facebook'  => null,
    'instagram' => null,
    'twitter'   => null,
    'youtube'   => null,
    'whatsapp'  => null,
    'website'   => null,
    'spacing'   => 'space-x-6',
])

<div {{ $attributes->merge(['class' => "flex justify-center {$spacing}"]) }}>
    @if ($website)
        <x-social.website :url="$website" />
    @endif

    @if ($instagram)
        <x-social.instagram :url="$instagram" />
    @endif

    @if ($facebook)
        <x-social.facebook :url="$facebook" />
    @endif

    @if ($twitter)
        <x-social.twitter :url="$twitter" />
    @endif

    @if ($youtube)
        <x-social.youtube :url="$youtube" />
    @endif

    @if ($whatsapp)
        <x-social.whatsapp :url="$whatsapp" />
    @endif
</div>
