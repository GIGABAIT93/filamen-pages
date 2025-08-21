@php
    $html = (string) ($data['html'] ?? '');
@endphp

@if ($html !== '')
    <div class="fi-fo-rich-editor-content fi-prose">
        {!! str($html)->sanitizeHtml() !!}
    </div>
@endif
