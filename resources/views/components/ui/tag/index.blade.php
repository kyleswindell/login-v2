{{--
|--------------------------------------------------------------------------
| File: resources/views/components/ui/tag/index.blade.php
| Purpose: Render the app-owned Tag component family.
|--------------------------------------------------------------------------
|
| Tag supports compact read-only, dismissible, selectable, and operational
| labels for metadata, status, filtering, and compact disclosure triggers.
|
| Public API is declared in:
| resources/views/components/ui/tag/contract.php
|
--}}

@props([
    'id' => null,
    'variant' => 'read-only',
    'type' => null,
    'tone' => null,
    'size' => 'md',
    'text' => null,
    'label' => null,
    'icon' => null,
    'disabled' => false,
    'selected' => null,
    'defaultSelected' => false,
    'dismissLabel' => null,
    'dismissTooltipLabel' => null,
    'dismissTooltipAlignment' => 'bottom',
    'tagTitle' => null,
    'title' => null,
    'truncate' => null,
    'dir' => 'ltr',
    'disclosureTarget' => null,
    'expanded' => false,
    'decorator' => null,
    'slug' => null,
])

@php
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Canonical API Maps
    |--------------------------------------------------------------------------
    */

    $variantMap = [
        'readonly' => 'read-only',
        'read-only' => 'read-only',
        'filter' => 'dismissible',
        'dismissible' => 'dismissible',
        'selectable' => 'selectable',
        'operational' => 'operational',
    ];

    $toneMap = [
        'gray' => 'gray',
        'neutral' => 'gray',
        'blue' => 'blue',
        'info' => 'blue',
        'notice' => 'blue',
        'green' => 'green',
        'success' => 'green',
        'red' => 'red',
        'danger' => 'red',
        'error' => 'red',
        'purple' => 'purple',
        'warning' => 'purple',
        'yellow' => 'purple',
    ];

    $typeMap = [
        'gray' => 'gray',
        'cool-gray' => 'cool-gray',
        'cool_gray' => 'cool-gray',
        'warm-gray' => 'warm-gray',
        'warm_gray' => 'warm-gray',
        'red' => 'red',
        'magenta' => 'magenta',
        'purple' => 'purple',
        'blue' => 'blue',
        'cyan' => 'cyan',
        'teal' => 'teal',
        'green' => 'green',
        'high-contrast' => 'high-contrast',
        'outline' => 'outline',
    ];

    $typeLabelMap = [
        'gray' => 'Gray',
        'cool-gray' => 'Cool gray',
        'warm-gray' => 'Warm gray',
        'red' => 'Red',
        'magenta' => 'Magenta',
        'purple' => 'Purple',
        'blue' => 'Blue',
        'cyan' => 'Cyan',
        'teal' => 'Teal',
        'green' => 'Green',
        'high-contrast' => 'High contrast',
        'outline' => 'Outline',
    ];

    $sizeMap = [
        'sm' => 'sm',
        'md' => 'md',
        'lg' => 'lg',
    ];

    $truncateMap = [
        'start' => 'start',
        'middle' => 'middle',
        'end' => 'end',
    ];

    $directionMap = [
        'ltr' => 'ltr',
        'rtl' => 'rtl',
        'auto' => 'auto',
    ];

    $dismissTooltipAlignmentMap = [
        'top' => 'top',
        'bottom' => 'bottom',
        'left' => 'left',
        'right' => 'right',
        'top-start' => 'top-start',
        'top-end' => 'top-end',
        'bottom-start' => 'bottom-start',
        'bottom-end' => 'bottom-end',
        'left-start' => 'left-start',
        'left-end' => 'left-end',
        'right-start' => 'right-start',
        'right-end' => 'right-end',
        'start' => 'bottom-start',
        'center' => 'bottom',
        'end' => 'bottom-end',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $requestedVariant = is_string($variant)
        ? strtolower(str_replace('_', '-', trim($variant)))
        : 'read-only';

    $requestedTone = is_string($tone)
        ? strtolower(str_replace('_', '-', trim($tone)))
        : null;

    $requestedType = $type ?? (! is_null($requestedTone) ? ($toneMap[$requestedTone] ?? $requestedTone) : null);

    $requestedType = is_string($requestedType)
        ? strtolower(str_replace('_', '-', trim($requestedType)))
        : null;

    $requestedSize = is_string($size)
        ? strtolower(trim($size))
        : 'md';

    $requestedTruncate = is_string($truncate)
        ? strtolower(trim($truncate))
        : null;

    $requestedDirection = is_string($dir)
        ? strtolower(trim($dir))
        : 'ltr';

    $requestedDismissTooltipAlignment = is_string($dismissTooltipAlignment)
        ? strtolower(str_replace('_', '-', trim($dismissTooltipAlignment)))
        : 'bottom';

    $resolvedId = $id ?? $attributes->get('id');
    $resolvedVariant = $variantMap[$requestedVariant] ?? 'read-only';
    $resolvedType = ! is_null($requestedType) ? ($typeMap[$requestedType] ?? 'gray') : 'gray';
    $resolvedSize = $sizeMap[$requestedSize] ?? 'md';
    $resolvedTruncate = $truncateMap[$requestedTruncate] ?? null;
    $labelDirection = $directionMap[$requestedDirection] ?? 'ltr';
    $resolvedDismissTooltipAlignment = $dismissTooltipAlignmentMap[$requestedDismissTooltipAlignment] ?? 'bottom';

    $disclosureId = filled($disclosureTarget)
        ? ltrim((string) $disclosureTarget, '#')
        : null;

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);

    $isSelected = ! is_null($selected)
        ? filter_var($selected, FILTER_VALIDATE_BOOLEAN)
        : filter_var($defaultSelected, FILTER_VALIDATE_BOOLEAN);

    $isExpanded = filter_var($expanded, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | Label Handling
    |--------------------------------------------------------------------------
    */

    $slotText = trim(strip_tags($slot->toHtml()));

    $resolvedLabel = trim((string) ($text ?? $label ?? $slotText));
    $resolvedLabel = $resolvedLabel !== '' ? $resolvedLabel : ($typeLabelMap[$resolvedType] ?? '');

    $titleText = $tagTitle ?? $title ?? $resolvedLabel;

    $closeLabel = $dismissTooltipLabel
        ?? $dismissLabel
        ?? 'Remove '.($resolvedLabel !== '' ? $resolvedLabel : 'tag');

    /*
    |--------------------------------------------------------------------------
    | Decorator Handling
    |--------------------------------------------------------------------------
    |
    | `slug` is retained as a deprecated compatibility alias for `decorator`.
    |
    */

    $resolvedDecorator = $decorator ?? $slug;
    $hasDecorator = isset($resolvedDecorator) && filled($resolvedDecorator);
    $rendersDecorator = $hasDecorator && in_array($resolvedVariant, ['read-only', 'dismissible'], true);

    $renderTrustedContent = function ($content): string {
        if ($content instanceof HtmlString) {
            return $content->toHtml();
        }

        if (is_object($content) && method_exists($content, 'toHtml')) {
            return $content->toHtml();
        }

        return e((string) $content);
    };

    /*
    |--------------------------------------------------------------------------
    | Truncation Helpers
    |--------------------------------------------------------------------------
    */

    $labelLength = mb_strlen($resolvedLabel);
    $middleSplit = max(4, (int) floor($labelLength * 0.62));

    $middleStart = $resolvedTruncate === 'middle'
        ? mb_substr($resolvedLabel, 0, $middleSplit)
        : null;

    $middleEnd = $resolvedTruncate === 'middle'
        ? mb_substr($resolvedLabel, $middleSplit)
        : null;

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-tag',
        'ui-tag-'.$resolvedVariant,
        'ui-tag-type-'.$resolvedType,
        'ui-tag-'.$resolvedSize,
        'ui-tag-has-icon' => filled($icon),
        'ui-tag-has-decorator' => $rendersDecorator,
        'ui-tag-selected' => $resolvedVariant === 'selectable' && $isSelected,
        'ui-tag-disabled' => $isDisabled,
        'ui-tag-truncate-'.$resolvedTruncate => filled($resolvedTruncate),
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    */

    $tagAttributes = $attributes->except([
        'id',
    ]);
@endphp

@php
    /*
    |--------------------------------------------------------------------------
    | Label Markup
    |--------------------------------------------------------------------------
    */

    $labelMarkup = function () use ($resolvedTruncate, $resolvedLabel, $middleStart, $middleEnd, $titleText, $labelDirection) {
        $titleAttribute = e($titleText);
        $directionAttribute = e($labelDirection);

        if ($resolvedTruncate === 'middle') {
            return '<span class="ui-tag-label ui-tag-label-middle" title="'.$titleAttribute.'" dir="'.$directionAttribute.'"><span class="ui-tag-label-start">'.e($middleStart).'</span><span class="ui-tag-label-end">'.e($middleEnd).'</span></span>';
        }

        return '<span class="ui-tag-label" title="'.$titleAttribute.'" dir="'.$directionAttribute.'">'.e($resolvedLabel).'</span>';
    };
@endphp

@if ($resolvedVariant === 'selectable')
    <button
        type="button"
        @if (filled($resolvedId)) id="{{ $resolvedId }}" @endif
        {{ $tagAttributes->class($classes)->merge([
            'data-ui-component' => 'tag',
            'data-ui-tag' => true,
            'data-ui-tag-variant' => $resolvedVariant,
            'data-ui-tag-type' => $resolvedType,
            'data-ui-tag-size' => $resolvedSize,
            'data-ui-tag-selected' => $isSelected ? 'true' : 'false',
            'data-ui-tag-disabled' => $isDisabled ? 'true' : 'false',
        ]) }}
        aria-pressed="{{ $isSelected ? 'true' : 'false' }}"
        @disabled($isDisabled)
        @if ($isDisabled) aria-disabled="true" @endif
    >
        @if (filled($icon))
            <x-ui.icon :name="$icon" class="ui-tag-icon ui-tag-icon-decorative" aria-hidden="true" />
        @endif

        {!! $labelMarkup() !!}
    </button>
@elseif ($resolvedVariant === 'operational')
    <button
        type="button"
        @if (filled($resolvedId)) id="{{ $resolvedId }}" @endif
        {{ $tagAttributes->class($classes)->merge([
            'data-ui-component' => 'tag',
            'data-ui-tag' => true,
            'data-ui-tag-operational' => true,
            'data-ui-tag-variant' => $resolvedVariant,
            'data-ui-tag-type' => $resolvedType,
            'data-ui-tag-size' => $resolvedSize,
            'data-ui-tag-disabled' => $isDisabled ? 'true' : 'false',
            'data-ui-tag-expanded' => $isExpanded ? 'true' : 'false',
            'data-ui-tag-disclosure-target' => $disclosureId,
        ]) }}
        @if (filled($disclosureId)) aria-controls="{{ $disclosureId }}" @endif
        aria-expanded="{{ $isExpanded ? 'true' : 'false' }}"
        @disabled($isDisabled)
        @if ($isDisabled) aria-disabled="true" @endif
    >
        @if (filled($icon))
            <x-ui.icon :name="$icon" class="ui-tag-icon ui-tag-icon-decorative" aria-hidden="true" />
        @endif

        {!! $labelMarkup() !!}
    </button>
@else
    <span
        @if (filled($resolvedId)) id="{{ $resolvedId }}" @endif
        {{ $tagAttributes->class($classes)->merge([
            'data-ui-component' => 'tag',
            'data-ui-tag' => true,
            'data-ui-tag-variant' => $resolvedVariant,
            'data-ui-tag-type' => $resolvedType,
            'data-ui-tag-size' => $resolvedSize,
            'data-ui-tag-disabled' => $isDisabled ? 'true' : 'false',
            'data-ui-tag-dismissible' => $resolvedVariant === 'dismissible' ? 'true' : null,
            'data-ui-tag-decorator' => $rendersDecorator ? 'true' : 'false',
            'data-ui-tag-decorator-source' => filled($slug) ? 'slug' : ($rendersDecorator ? 'decorator' : null),
        ]) }}
        @if ($isDisabled) aria-disabled="true" @endif
    >
        @if (filled($icon))
            <x-ui.icon :name="$icon" class="ui-tag-icon ui-tag-icon-decorative" aria-hidden="true" />
        @endif

        {!! $labelMarkup() !!}

        @if ($rendersDecorator)
            <span class="ui-tag-decorator">
                {!! $renderTrustedContent($resolvedDecorator) !!}
            </span>
        @endif

        @if ($resolvedVariant === 'dismissible')
            <button
                type="button"
                class="ui-tag-close"
                aria-label="{{ $closeLabel }}"
                title="{{ $closeLabel }}"
                data-ui-tag-dismiss
                data-ui-tooltip-alignment="{{ $resolvedDismissTooltipAlignment }}"
                @disabled($isDisabled)
            >
                <x-ui.icon name="close" class="ui-tag-close-icon" aria-hidden="true" />
            </button>
        @endif
    </span>
@endif