@php
    $style = $data['style'] ?? 'solid';
    $label = $data['label'] ?? null;

    $borderStyle = in_array($style, ['dashed','dotted'], true) ? $style : 'solid';
@endphp

@if ($label)
    <x-filament::section :heading="$label" />
@else
    <hr
        role="separator"
        style="
            margin: 1rem 0;
            border: 0;
            border-top-width: 2px;
            border-top-style: {{ $borderStyle }};
            border-top-color: currentColor;
            opacity: .2;
        "
    >
@endif
