@props([
'variant' => 'read-only',
'type' => 'gray',
'size' => 'md',
'text' => null,
'icon' => null,
'disabled' => false,
'selected' => false,
'defaultSelected' => false,
'dismissLabel' => null,
'dismissTooltipAlignment' => 'center',
'tagTitle' => null,
'title' => null,
'truncate' => null,
'dir' => 'ltr',
'disclosureTarget' => null,
])

@php
$variantMap = [
'readonly' => 'read-only',
'read-only' => 'read-only',
'dismissible' => 'dismissible',
'selectable' => 'selectable',
'operational' => 'operational',
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

$sizeMap = ['sm' => 'sm', 'md' => 'md', 'lg' => 'lg'];
$truncateMap = ['start' => 'start', 'middle' => 'middle', 'end' => 'end'];

$resolvedVariant = $variantMap[$variant] ?? 'read-only';
$resolvedType = $typeMap[$type] ?? 'gray';
$resolvedSize = $sizeMap[$size] ?? 'md';
$resolvedTruncate = $truncateMap[$truncate] ?? null;
$isSelected = filter_var($selected, FILTER_VALIDATE_BOOLEAN) || filter_var($defaultSelected, FILTER_VALIDATE_BOOLEAN);
$isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
$label = trim((string) ($text ?? $slot));
$titleText = $tagTitle ?? $title ?? $label;
$labelDirection = in_array($dir, ['ltr', 'rtl', 'auto'], true) ? $dir : 'ltr';
$closeLabel = $dismissLabel ?? 'Remove '.$label;
$disclosureId = $disclosureTarget ? ltrim((string) $disclosureTarget, '#') : null;
$labelLength = mb_strlen($label);
$middleSplit = max(4, (int) floor($labelLength * 0.62));
$middleStart = $resolvedTruncate === 'middle' ? mb_substr($label, 0, $middleSplit) : null;
$middleEnd = $resolvedTruncate === 'middle' ? mb_substr($label, $middleSplit) : null;

$classes = [
'ui-tag',
'ui-tag-'.$resolvedVariant,
'ui-tag-type-'.$resolvedType,
'ui-tag-'.$resolvedSize,
'ui-tag-has-icon' => filled($icon),
'ui-tag-selected' => $resolvedVariant === 'selectable' && $isSelected,
'ui-tag-disabled' => $isDisabled,
'ui-tag-truncate-'.$resolvedTruncate => filled($resolvedTruncate),
];
@endphp

@php
$labelMarkup = function () use ($resolvedTruncate, $label, $middleStart, $middleEnd, $titleText, $labelDirection) {
$titleAttribute = e($titleText);
$directionAttribute = e($labelDirection);

if ($resolvedTruncate === 'middle') {
return '<span class="ui-tag-label ui-tag-label-middle" title="'.$titleAttribute.'" dir="'.$directionAttribute.'"><span class="ui-tag-label-start">'.e($middleStart).'</span><span class="ui-tag-label-end">'.e($middleEnd).'</span></span>';
}

return '<span class="ui-tag-label" title="'.$titleAttribute.'" dir="'.$directionAttribute.'">'.e($label).'</span>';
};
@endphp

@if ($resolvedVariant === 'selectable')
<button
    type="button"
    {{ $attributes->class($classes) }}
    data-ui-component="tag"
    data-ui-tag
    data-ui-tag-variant="{{ $resolvedVariant }}"
    data-ui-tag-type="{{ $resolvedType }}"
    data-ui-tag-size="{{ $resolvedSize }}"
    data-ui-tag-selected="{{ $isSelected ? 'true' : 'false' }}"
    aria-pressed="{{ $isSelected ? 'true' : 'false' }}"
    @disabled($isDisabled)>
    @if ($isDisabled) aria-disabled="true" @endif
    @if ($icon)
    <x-dynamic-component :component="$icon" class="ui-tag-icon ui-tag-icon-decorative" aria-hidden="true" />
    @endif
    {!! $labelMarkup() !!}
</button>
@elseif ($resolvedVariant === 'operational')
<button
    type="button"
    {{ $attributes->class($classes) }}
    data-ui-component="tag"
    data-ui-tag
    data-ui-tag-operational
    data-ui-tag-variant="{{ $resolvedVariant }}"
    data-ui-tag-type="{{ $resolvedType }}"
    data-ui-tag-size="{{ $resolvedSize }}"
    @if ($disclosureId)
    data-ui-tag-disclosure-target="{{ $disclosureId }}"
    aria-controls="{{ $disclosureId }}"
    aria-expanded="false"
    @endif
    aria-expanded="false"
    @disabled($isDisabled)>
    @if ($isDisabled) aria-disabled="true" @endif
    @if ($icon)
    <x-dynamic-component :component="$icon" class="ui-tag-icon ui-tag-icon-decorative" aria-hidden="true" />
    @endif
    {!! $labelMarkup() !!}
</button>
@else
<span
    {{ $attributes->class($classes) }}
    data-ui-component="tag"
    data-ui-tag
    data-ui-tag-variant="{{ $resolvedVariant }}"
    data-ui-tag-type="{{ $resolvedType }}"
    data-ui-tag-size="{{ $resolvedSize }}"
    @if ($isDisabled) aria-disabled="true" @endif>
    @if ($icon)
    <x-dynamic-component :component="$icon" class="ui-tag-icon ui-tag-icon-decorative" aria-hidden="true" />
    @endif
    {!! $labelMarkup() !!}
    @if ($resolvedVariant === 'dismissible')
    <button
        type="button"
        class="ui-tag-close"
        aria-label="{{ $closeLabel }}"
        title="{{ $closeLabel }}"
        data-ui-tag-dismiss
        data-ui-tooltip-alignment="{{ $dismissTooltipAlignment }}"
        @disabled($isDisabled)>
        <x-heroicon-o-x-mark class="ui-tag-close-icon" aria-hidden="true" />
    </button>
    @endif
</span>
@endif