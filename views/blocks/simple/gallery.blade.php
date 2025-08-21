@php
    $raw = $data['images'] ?? [];

    $items = collect($raw)->map(function ($it) {
        if (is_string($it)) {
            $url = page_media_url($it);
            return $url ? ['url'=>$url, 'thumb'=>$url, 'alt'=>'', 'caption'=>null] : null;
        }
        $url   = page_media_url($it['url']  ?? $it['src'] ?? null);
        $thumb = page_media_url($it['thumb'] ?? ($it['url'] ?? $it['src'] ?? null));
        return $url ? [
            'url'     => $url,
            'thumb'   => $thumb ?: $url,
            'alt'     => $it['alt'] ?? '',
            'caption' => $it['caption'] ?? null,
        ] : null;
    })->filter()->values();

    $count = $items->count();
@endphp

@if ($count > 0)
    <div
        x-data="{
            i: 0,
            items: @js($items),
            total: {{ $count }},
            curr(){ return this.items[this.i] },
            go(n){ this.i = (n + this.total) % this.total; this.ensureThumbVisible(false) },
            prev(){ this.go(this.i - 1) },
            next(){ this.go(this.i + 1) },
            startX: 0, dx: 0,
            onTouchStart(e){ this.startX = e.touches[0].clientX; this.dx = 0 },
            onTouchMove(e){ this.dx = e.touches[0].clientX - this.startX },
            onTouchEnd(){ if (this.dx > 50) this.prev(); else if (this.dx < -50) this.next(); this.dx = 0 },
            ensureThumbVisible(init = false){
                this.$nextTick(() => {
                    const strip = this.$refs.thumbs;
                    if (!strip) return;
                    const btn = strip.querySelector(`[data-idx='${this.i}']`);
                    if (!btn) return;

                    const left = btn.offsetLeft - (strip.clientWidth - btn.offsetWidth) / 2;
                    const target = Math.max(0, left);
                    strip.scrollTo({ left: target, behavior: init ? 'auto' : 'smooth' });
                });
            },
        }"
        @keydown.window.arrow-left.prevent="prev()"
        @keydown.window.arrow-right.prevent="next()"
        wire:ignore
    >
        <div
            style="position: relative; overflow: hidden; border-radius: 12px;"
            @touchstart="onTouchStart($event)"
            @touchmove="onTouchMove($event)"
            @touchend="onTouchEnd()"
        >
            <img
                :src="curr().url"
                :alt="curr().alt"
                loading="lazy"
                decoding="async"
                style="display:block; width:100%; height:auto; user-select:none;"
                draggable="false"
            >

            @if ($count > 1)
                <div
                    style="position:absolute; inset:0; display:flex; align-items:center; justify-content:space-between; padding:0 6px; z-index:10;">
                    <x-filament::icon-button icon="heroicon-m-chevron-left" color="gray" size="lg" circular label="<="
                                             x-on:click="prev()"/>
                    <x-filament::icon-button icon="heroicon-m-chevron-right" color="gray" size="lg" circular label="=>"
                                             x-on:click="next()"/>
                </div>
            @endif
        </div>

        <div style="text-align:center; margin-top:8px;">
            <p x-text="curr().caption || curr().alt || ''"></p>
        </div>

        @if ($count > 1)
            <div
                x-ref="thumbs"
                style="
                    --thumb-size: clamp(40px, 9vw, 64px);
                    display:flex;
                    gap:8px;
                    margin-top:10px;
                    padding:6px 2px;
                    overflow-x:auto;
                    overflow-y:hidden;
                    -webkit-overflow-scrolling:touch;
                    overscroll-behavior: contain;
                    scroll-snap-type:x mandatory;
                    scrollbar-gutter: stable both-edges;
                "
            >
                <template x-for="(item, idx) in items" :key="idx">
                    <button
                        type="button"
                        x-on:click="go(idx)"
                        :aria-label="`${idx + 1}`"
                        :aria-current="i === idx"
                        :data-idx="idx"
                        style="
                            flex:0 0 auto;
                            border:0; padding:0; background:transparent; cursor:pointer;
                            scroll-snap-align:start;
                        "
                    >
                        <img
                            :src="item.thumb || item.url"
                            :alt="item.alt"
                            loading="lazy"
                            style="
                                width: var(--thumb-size);
                                height: var(--thumb-size);
                                object-fit: cover;
                                margin-inline: 3px;
                                display:block; border-radius:8px; opacity:.6;
                            "
                            :style="i === idx ? { opacity: '1', outline: '2px solid currentColor', outlineOffset: '2px' } : {}"
                        >
                    </button>
                </template>
            </div>
        @endif
    </div>
@endif
