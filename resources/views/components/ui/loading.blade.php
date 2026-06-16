@props([
    'id' => null,
    'active' => true,
    'size' => 'lg',
    'placement' => 'component',
    'label' => null,
    'overlay' => null,
    'disableRelatedActions' => false,
    'ariaLabel' => null,
    'ariaLive' => 'polite',
])

@php
    $size = in_array($size, ['sm', 'lg'], true) ? $size : 'lg';
    $placement = in_array($placement, ['inline', 'component', 'section', 'modal', 'side-panel', 'tile', 'page'], true)
        ? $placement
        : 'component';
    $ariaLive = in_array($ariaLive, ['off', 'polite', 'assertive'], true) ? $ariaLive : 'polite';
    $usesOverlay = $overlay;

    if ($usesOverlay === null) {
        $usesOverlay = $size === 'lg' && in_array($placement, ['component', 'section', 'modal', 'side-panel', 'tile', 'page'], true);
    }

    $attributeAriaLabel = $attributes->get('aria-label');
    $componentAttributes = $attributes->except(['aria-label']);
    $accessibleLabel = $ariaLabel ?? $attributeAriaLabel ?? $label ?? 'Loading';
@endphp

@if ($active)
    <div
        @if($id) id="{{ $id }}" @endif
        {{ $componentAttributes->class([
            'ui-loading',
            'ui-loading--'.$size,
            'ui-loading--placement-'.$placement,
            'ui-loading--overlay' => $usesOverlay,
        ]) }}
        role="status"
        aria-live="{{ $ariaLive }}"
        aria-label="{{ $accessibleLabel }}"
        aria-busy="true"
        data-ui-component="loading"
        data-ui-loading
        data-ui-loading-active="true"
        data-ui-loading-size="{{ $size }}"
        data-ui-loading-placement="{{ $placement }}"
        data-ui-loading-overlay="{{ $usesOverlay ? 'true' : 'false' }}"
        @if($disableRelatedActions) data-ui-loading-disable-related-actions="true" @endif
    >
        <span class="ui-loading__indicator" aria-hidden="true">
            <span class="ui-loading__spinner"></span>
        </span>

        @if ($label)
            <span class="ui-loading__label">{{ $label }}</span>
        @endif
    </div>
@endif
