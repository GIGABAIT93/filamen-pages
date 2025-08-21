@php
    $label  = $data['label'] ?? '';
    $url    = $data['url'] ?? '#';
    $style  = $data['style'] ?? 'primary';
    $newTab = !empty($data['new_tab']);
    $color = match($style) {
        'secondary','link' => 'gray',
        'danger' => 'danger',
        'success' => 'success',
        'warning' => 'warning',
        'info' => 'info',
        default => 'primary',
    };
    $outlined = $style === 'link';
@endphp

@if($label !== '')
    <x-filament::button
        :href="$url"
        tag="a"
        :target="$newTab ? '_blank' : null"
        :rel="$newTab ? 'noopener' : null"
        :color="$color"
        :outlined="$outlined"
        class="my-4"
    >
        {{ $label }}
    </x-filament::button>
@endif
