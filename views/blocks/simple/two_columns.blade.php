@php
    $ratio = (string) ($data['ratio'] ?? '6-6');
    [$l, $r] = array_pad(array_map('intval', explode('-', $ratio)), 2, 6);
    $l = max(1, $l);
    $r = max(1, $r);
@endphp

<div class="tc-two-cols" style="--lfr: {{ $l }}fr; --rfr: {{ $r }}fr;">
    <div>{!! $data['left'] ?? '' !!}</div>
    <div>{!! $data['right'] ?? '' !!}</div>
</div>

@once
    <style>
        .tc-two-cols {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        @media (min-width: 768px) {
            .tc-two-cols {
                grid-template-columns: var(--lfr) var(--rfr);
            }
        }
    </style>
@endonce
