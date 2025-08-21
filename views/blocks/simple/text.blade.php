@php
    $content = $data['content'] ?? '';
@endphp

@if($content !== '')
    <p>{{ $content }}</p>
@endif
