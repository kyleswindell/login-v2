@props([
    'tone' => 'neutral',
    'color' => null,
    'variant' => 'read-only',
    'size' => 'md',
    'icon' => null,
    'label' => null,
    'removable' => false,
    'removeLabel' => null,
    'selectable' => false,
    'selected' => false,
    'operational' => false,
    'disabled' => false,
    'skeleton' => false,
    'title' => null,
    'truncate' => null,
])

@php
    $colorMap = [
        'neutral' => 'gray',
        'gray' => 'gray',
        'cool-gray' => 'cool-gray',
        'cool_gray' => 'cool-gray',
        'warm-gray' => 'warm-gray',
        'warm_gray' => 'warm-gray',
        'red' => 'red',
        'error' => 'red',
        'danger' => 'red',
        'magenta' => 'magenta',
        'purple' => 'purple',
        'blue' => 'blue',
        'info' => 'blue',
        'notice' => 'blue',
        'cyan' => 'cyan',
        'teal' => 'teal',
        'green' => 'green',
        'success' => 'green',
        'warning' => 'warm-gray',
        'high-contrast' => 'high-contrast',
        'inverse' => 'high-contrast',
        'outline' => 'outline',
    ];

    $variantMap = [
        'readonly' => 'read-only',
        'read-only' => 'read-only',
        'dismissible' => 'dismissible',
        'selectable' => 'selectable',
        'operational' => 'operational',
    ];

    $sizeMap = ['sm' => 'sm', 'md' => 'md', 'lg' => 'lg'];
    $truncateMap = ['start' => 'start', 'middle' => 'middle', 'end' => 'end'];

    $isRemovableRequested = filter_var($removable, FILTER_VALIDATE_BOOLEAN);
    $isSelectableRequested = filter_var($selectable, FILTER_VALIDATE_BOOLEAN);
    $isOperationalRequested = filter_var($operational, FILTER_VALIDATE_BOOLEAN);
    $isSelected = filter_var($selected, FILTER_VALIDATE_BOOLEAN);
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isSkeleton = filter_var($skeleton, FILTER_VALIDATE_BOOLEAN);

    $requestedVariant = $variant;
    if ($isRemovableRequested) {
        $requestedVariant = 'dismissible';
    } elseif ($isSelectableRequested) {
        $requestedVariant = 'selectable';
    } elseif ($isOperationalRequested) {
        $requestedVariant = 'operational';
    }

    $resolvedVariant = $variantMap[$requestedVariant] ?? 'read-only';
    $resolvedColor = $colorMap[$color ?? $tone] ?? 'gray';
    $resolvedSize = $sizeMap[$size] ?? 'md';
    $resolvedTruncate = $truncateMap[$truncate] ?? null;
    $tagLabel = trim((string) ($label ?? $slot));
    $titleText = $title ?? ($resolvedTruncate ? $tagLabel : null);
    $closeLabel = $removeLabel ?? 'Remove '.$tagLabel;

    $classes = [
        'ui-tag',
        'ui-tag-'.$resolvedVariant,
        'ui-tag-color-'.$resolvedColor,
        'ui-tag-'.$resolvedSize,
        'ui-tag-selected' => $resolvedVariant === 'selectable' && $isSelected,
        'ui-tag-disabled' => $isDisabled,
        'ui-tag-skeleton' => $isSkeleton,
        'ui-tag-truncate-'.$resolvedTruncate => filled($resolvedTruncate),
    ];
@endphp

@if ($isSkeleton)
    <span
        {{ $attributes->class($classes) }}
        data-ui-component="tag"
        data-ui-tag-variant="{{ $resolvedVariant }}"
        data-ui-tag-tone="{{ $resolvedColor }}"
        data-ui-tag-color="{{ $resolvedColor }}"
        data-ui-tag-size="{{ $resolvedSize }}"
        aria-hidden="true"
    >
        <span class="ui-tag-label">{{ $tagLabel ?: 'Loading tag' }}</span>
    </span>
@elseif ($resolvedVariant === 'selectable')
    <button
        type="button"
        {{ $attributes->class($classes) }}
        data-ui-component="tag"
        data-ui-tag-variant="{{ $resolvedVariant }}"
        data-ui-tag-tone="{{ $resolvedColor }}"
        data-ui-tag-color="{{ $resolvedColor }}"
        data-ui-tag-size="{{ $resolvedSize }}"
        data-ui-tag-selected="{{ $isSelected ? 'true' : 'false' }}"
        aria-pressed="{{ $isSelected ? 'true' : 'false' }}"
        @if ($titleText) title="{{ $titleText }}" @endif
        @disabled($isDisabled)
    >
        @if ($icon)
            <x-dynamic-component :component="$icon" class="ui-tag-icon ui-tag-icon-decorative" aria-hidden="true" />
        @endif
        <span class="ui-tag-label">{{ $tagLabel }}</span>
    </button>
@elseif ($resolvedVariant === 'operational')
    <button
        type="button"
        {{ $attributes->class($classes) }}
        data-ui-component="tag"
        data-ui-tag-variant="{{ $resolvedVariant }}"
        data-ui-tag-tone="{{ $resolvedColor }}"
        data-ui-tag-color="{{ $resolvedColor }}"
        data-ui-tag-size="{{ $resolvedSize }}"
        aria-haspopup="dialog"
        aria-expanded="false"
        @if ($titleText) title="{{ $titleText }}" @endif
        @disabled($isDisabled)
    >
        @if ($icon)
            <x-dynamic-component :component="$icon" class="ui-tag-icon ui-tag-icon-decorative" aria-hidden="true" />
        @endif
        <span class="ui-tag-label">{{ $tagLabel }}</span>
        <x-heroicon-o-chevron-down class="ui-tag-action-icon" aria-hidden="true" />
    </button>
@else
    <span
        {{ $attributes->class($classes) }}
        data-ui-component="tag"
        data-ui-tag-variant="{{ $resolvedVariant }}"
        data-ui-tag-tone="{{ $resolvedColor }}"
        data-ui-tag-color="{{ $resolvedColor }}"
        data-ui-tag-size="{{ $resolvedSize }}"
        @if ($titleText) title="{{ $titleText }}" @endif
        @if ($isDisabled) aria-disabled="true" @endif
    >
        @if ($icon)
            <x-dynamic-component :component="$icon" class="ui-tag-icon ui-tag-icon-decorative" aria-hidden="true" />
        @endif
        <span class="ui-tag-label">{{ $tagLabel }}</span>
        @if ($resolvedVariant === 'dismissible')
            <button type="button" class="ui-tag-close" aria-label="{{ $closeLabel }}" @disabled($isDisabled)>
                <x-heroicon-o-x-mark class="ui-tag-close-icon" aria-hidden="true" />
            </button>
        @endif
    </span>
@endif
