@php
    $html = (string) ($data['html'] ?? '');
@endphp
@if ($html !== '')
    <div class="fi-fo-markdown-editor fi-prose">
        {!! str($html)->markdown()->sanitizeHtml() !!}
    </div>
@endif
