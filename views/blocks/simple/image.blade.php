@php
    $src = page_media_url($data['url'] ?? null);
    $alt = $data['alt'] ?? '';
@endphp

@if($src)
    <img src="{{ $src }}" alt="{{ $alt }}" style="display:block; width:100%; height:auto; user-select:none;"/>
@endif
