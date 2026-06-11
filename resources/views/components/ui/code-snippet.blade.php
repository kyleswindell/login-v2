@props([
    'variant' => 'single',
    'language' => null,
    'copyable' => false,
    'copyState' => 'idle',
])

@php
    $resolvedVariant = in_array($variant, ['single', 'multi'], true) ? $variant : 'single';
@endphp

<div
    {{ $attributes->class(['ui-code-snippet-shell', 'ui-code-snippet-shell-multi' => $resolvedVariant === 'multi']) }}
    data-ui-component="code-snippet"
    data-ui-code-snippet-variant="{{ $resolvedVariant }}"
>
    @if ($language || $copyable)
        <div class="ui-code-snippet-header">
            @if ($language)
                <span>{{ $language }}</span>
            @endif
            @if ($copyable)
                <button type="button" class="ui-code-snippet-copy" data-ui-code-copy-state="{{ $copyState }}">
                    {{ $copyState === 'copied' ? 'Copied' : 'Copy' }}
                </button>
            @endif
        </div>
    @endif
    <pre class="ui-code-snippet"><code>{{ $slot }}</code></pre>
</div>
