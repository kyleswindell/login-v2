@props([
    'text' => null,
    'placement' => 'auto',
    'align' => 'center',
    'size' => 'auto',
    'kind' => 'default',
    'id' => null,
    'open' => false,
])

@php
    $allowedPlacements = ['auto', 'top', 'right', 'bottom', 'left'];
    $allowedAlignments = ['start', 'center', 'end'];
    $allowedSizes = ['auto', 'single', 'multi', 'definition'];
    $allowedKinds = ['default', 'definition'];

    $resolvedPlacement = in_array($placement, $allowedPlacements, true) ? $placement : 'auto';
    $resolvedAlign = in_array($align, $allowedAlignments, true) ? $align : 'center';
    $resolvedKind = in_array($kind, $allowedKinds, true) ? $kind : 'default';
    $resolvedSize = in_array($size, $allowedSizes, true) ? $size : 'auto';
    $tooltipText = trim((string) $text);
    $tooltipId = $id ?? 'ui-tooltip-'.Str::uuid();

    if ($resolvedSize === 'auto') {
        $resolvedSize = $resolvedKind === 'definition' || mb_strlen($tooltipText) > 48 ? 'multi' : 'single';
    }

    if ($resolvedKind === 'definition') {
        $resolvedSize = 'definition';
    }
@endphp

<span
    {{ $attributes->class('ui-tooltip') }}
    data-ui-component="tooltip"
    data-ui-tooltip
    data-ui-tooltip-kind="{{ $resolvedKind }}"
    data-ui-tooltip-placement="{{ $resolvedPlacement }}"
    data-ui-tooltip-resolved-placement="{{ $resolvedPlacement === 'auto' ? 'top' : $resolvedPlacement }}"
    data-ui-tooltip-align="{{ $resolvedAlign }}"
    data-ui-tooltip-size="{{ $resolvedSize }}"
    data-ui-tooltip-state="{{ $open ? 'open' : 'closed' }}"
>
    <span class="ui-tooltip-trigger" data-ui-tooltip-trigger aria-describedby="{{ $tooltipId }}">{{ $slot }}</span>
    <span
        id="{{ $tooltipId }}"
        role="tooltip"
        class="ui-tooltip-content"
        aria-hidden="{{ $open ? 'false' : 'true' }}"
        data-ui-tooltip-content
        data-ui-tooltip-id="{{ $tooltipId }}"
        data-ui-tooltip-state="{{ $open ? 'open' : 'closed' }}"
        @if (! $open) hidden @endif
    >
        {{ $tooltipText }}
        <span class="ui-tooltip-caret" aria-hidden="true" data-ui-tooltip-caret></span>
    </span>
</span>
