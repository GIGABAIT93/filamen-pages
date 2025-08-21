<x-filament-panels::page>
    <x-filament::section>
        @foreach($blocks as $block)
            @php
                $data = data_get($block, 'data', []);
                $useSection = (bool) data_get($data, 'global.use_section', false);
                $useCompact = (bool) data_get($data, 'global.use_compact', false);
            @endphp
            @if($useSection)
                <x-filament::section style="margin-top: 10px;" :compact="$useCompact">
                    @includeIf('pages::blocks.simple.' . data_get($block, 'type'), [
                        'data' => $data,
                    ])
                </x-filament::section>
            @else
                <div style="margin-top: 20px;">
                    @includeIf('pages::blocks.simple.' . data_get($block, 'type'), [
                        'data' => $data,
                    ])
                </div>
            @endif

        @endforeach
    </x-filament::section>
</x-filament-panels::page>
