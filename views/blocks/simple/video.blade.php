@php
    $raw     = (string) data_get($data, 'url');
    $caption = (string) data_get($data, 'caption', '');

    $embedUrl   = null;
    $useVideo   = false;

    if ($raw !== '') {
        $url = trim($raw);
        $host = parse_url($url, PHP_URL_HOST) ?: '';
        $path = parse_url($url, PHP_URL_PATH) ?: '';
        $query = [];
        parse_str(parse_url($url, PHP_URL_QUERY) ?: '', $query);

        if (str_contains($host, 'youtube.com') || str_contains($host, 'youtu.be')) {
            $id = $query['v'] ?? ltrim($path, '/');
            $id = preg_replace('~[^A-Za-z0-9_-]~', '', (string) $id);
            if ($id) {
                $embedUrl = 'https://www.youtube.com/embed/' . $id . '?rel=0';
            }
        }
        elseif (str_contains($host, 'vimeo.com')) {
            if (preg_match('~(\d+)~', $path, $m)) {
                $embedUrl = 'https://player.vimeo.com/video/' . $m[1];
            }
        }
        elseif (preg_match('~\.(mp4|webm|ogg)(\?.*)?$~i', $path)) {
            $useVideo = true;
            $embedUrl = $url;
        }
        else {
            $embedUrl = $url;
        }
    }
@endphp

@if ($embedUrl)
    <figure style="margin:0;">
        @if ($useVideo)
            <video
                    src="{{ $embedUrl }}"
                    controls
                    playsinline
                    preload="metadata"
                    style="display:block; width:100%; aspect-ratio:16/9; background:#000; border:0; border-radius:12px;"
            ></video>
        @else
            <div style="position:relative; width:100%; aspect-ratio:16/9; overflow:hidden; border-radius:12px;">
                <iframe
                        src="{{ $embedUrl }}"
                        title="Embedded media"
                        loading="lazy"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen
                        referrerpolicy="strict-origin-when-cross-origin"
                        style="position:absolute; inset:0; width:100%; height:100%; border:0;"
                ></iframe>
            </div>
        @endif

        @if ($caption !== '')
            <figcaption
                    style="margin-top:.5rem; font-size:.875rem; color:rgba(107,114,128,.9);">{{ $caption }}</figcaption>
        @endif
    </figure>
@endif
