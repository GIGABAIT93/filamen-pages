@php
    $img     = page_media_url($data['image'] ?? null);
    $overlay = !empty($data['overlay']);
    $title   = $data['title'] ?? null;
    $subtitle= $data['subtitle'] ?? null;
@endphp

@if ($img)
    <div style="position:relative; width:100%; overflow:hidden; border-radius:12px;">
        <img
            src="{{ $img }}"
            alt=""
            loading="lazy"
            decoding="async"
            style="display:block; width:100%; height:auto;"
        >

        @if ($overlay)
            <div
                style="position:absolute; top:0; right:0; bottom:0; left:0;
                   background:rgba(0,0,0,.30); pointer-events:none;">
            </div>
        @endif

        @if ($title || $subtitle)
            <div
                style="position:absolute; top:0; right:0; bottom:0; left:0;
                   display:flex; flex-direction:column; align-items:center; justify-content:center;
                   text-align:center; padding:24px;">
                @if ($title)
                    <div
                        style="color:#fff; font-size:clamp(24px,3vw,32px); font-weight:600; line-height:1.2;
                           text-shadow:0 1px 1px rgba(0,0,0,.5), 0 4px 12px rgba(0,0,0,.35);">
                        {{ $title }}
                    </div>
                @endif
                @if ($subtitle)
                    <div
                        style="color:rgba(255,255,255,.92); margin-top:8px; font-size:clamp(14px,1.6vw,18px); line-height:1.5;
                           text-shadow:0 1px 1px rgba(0,0,0,.4), 0 3px 10px rgba(0,0,0,.3);">
                        {{ $subtitle }}
                    </div>
                @endif
            </div>
        @endif
    </div>
@endif
