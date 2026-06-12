@props([
    'variant' => 'single',
    'language' => null,
    'copyable' => false,
    'copyState' => 'idle',
    'expandable' => false,
    'collapsedLines' => 9,
    'light' => false,
    'showMoreLabel' => 'Show more',
    'showLessLabel' => 'Show less',
])

@php
    $resolvedVariant = in_array($variant, ['inline', 'single', 'multi'], true) ? $variant : 'single';
    $resolvedCopyState = $copyState === 'copied' ? 'copied' : 'idle';
    $snippetId = 'ui-code-snippet-'.Str::uuid();
    $codeId = $snippetId.'-code';
    $feedbackId = $snippetId.'-feedback';
    $canExpand = $resolvedVariant === 'multi' && $expandable;
    $lines = max(2, (int) $collapsedLines);
@endphp

@if ($resolvedVariant === 'inline')
    @if ($copyable)
        <x-ui.tooltip
            :text="$resolvedCopyState === 'copied' ? 'Copied to clipboard' : 'Copy to clipboard'"
            placement="auto"
            size="single"
        >
            <button
                type="button"
                {{ $attributes->class(['ui-code-snippet-inline', 'ui-code-snippet-inline-copyable']) }}
                data-ui-component="code-snippet"
                data-ui-code-snippet
                data-ui-code-snippet-variant="inline"
                data-ui-code-copy-state="{{ $resolvedCopyState }}"
                data-ui-code-copy-button
            ><code data-ui-code-copy-source>{{ $slot }}</code><span id="{{ $feedbackId }}" class="sr-only" data-ui-code-copy-feedback>{{ $resolvedCopyState === 'copied' ? 'Copied to clipboard' : 'Copy to clipboard' }}</span></button>
        </x-ui.tooltip>
    @else
        <code
            {{ $attributes->class('ui-code-snippet-inline') }}
            data-ui-component="code-snippet"
            data-ui-code-snippet
            data-ui-code-snippet-variant="inline"
        >{{ $slot }}</code>
    @endif
@else
<div
    {{ $attributes->class([
        'ui-code-snippet-shell',
        'ui-code-snippet-shell-single' => $resolvedVariant === 'single',
        'ui-code-snippet-shell-multi' => $resolvedVariant === 'multi',
        'ui-code-snippet-shell-light' => $light,
        'ui-code-snippet-shell-expandable' => $canExpand,
    ]) }}
    data-ui-component="code-snippet"
    data-ui-code-snippet
    data-ui-code-snippet-variant="{{ $resolvedVariant }}"
    data-ui-code-copy-state="{{ $resolvedCopyState }}"
    @if($canExpand) data-ui-code-snippet-expandable data-ui-code-snippet-expanded="false" @endif
    style="--ui-code-snippet-collapsed-lines: {{ $lines }};"
>
    @if ($language)
        <div class="ui-code-snippet-header">
            <span>{{ $language }}</span>
        </div>
    @endif
    @if ($copyable)
        <div class="ui-code-snippet-copy-control">
            <x-ui.icon-button
                type="button"
                icon="heroicon-o-clipboard-document"
                label="Copy to clipboard"
                tooltip="{{ $resolvedCopyState === 'copied' ? 'Copied to clipboard' : 'Copy to clipboard' }}"
                tooltip-placement="auto"
                size="sm"
                semantic="ghost"
                data-ui-code-copy-button
                data-ui-code-copy-state="{{ $resolvedCopyState }}"
            />
        </div>
    @endif
    <pre id="{{ $codeId }}" class="ui-code-snippet" data-ui-code-snippet-code><code data-ui-code-copy-source>{{ $slot }}</code></pre>
    @if ($copyable)
        <span id="{{ $feedbackId }}" class="sr-only" data-ui-code-copy-feedback aria-live="polite">{{ $resolvedCopyState === 'copied' ? 'Copied to clipboard' : 'Copy to clipboard' }}</span>
    @endif
    @if ($canExpand)
        <div class="ui-code-snippet-footer">
            <button
                type="button"
                class="ui-action ui-action-ghost ui-code-snippet-toggle"
                aria-expanded="false"
                aria-controls="{{ $codeId }}"
                data-ui-code-show-more
                data-ui-code-show-more-label="{{ $showMoreLabel }}"
                data-ui-code-show-less-label="{{ $showLessLabel }}"
            >{{ $showMoreLabel }}</button>
        </div>
    @endif
</div>
@endif
