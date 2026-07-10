{{-- ==========================================================================
    File: resources/views/components/patterns/tag-group/index.blade.php
    Purpose: Tag Group pattern wrapper.

    Notes:
    - Pattern wrapper for grouping x-ui.tag instances.
    - Does not register as a Component API contract.
    - Use for read-only, dismissible, selectable, or operational tag groups.
    - Horizontal wrapping is the default for easier scanning.
    - Groups of six or fewer tags should generally remain on one row.
    - If selectable tags wrap beyond roughly five lines, use a different
      control such as multi-select or filterable-multi-select.
    - Individual selectable tags remain tabbable; this pattern does not use
      roving tabindex.
    - Tag styles are owned by x-ui.tag.
    ========================================================================== --}}

@props([
    'items' => [],
    'label' => null,
    'labelledby' => null,
    'selectionMode' => null,
    'orientation' => 'horizontal',
    'wrap' => true,
    'compact' => false,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedSelectionModes = [
        'single',
        'multiple',
    ];

    $allowedOrientations = [
        'horizontal',
        'vertical',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedSelectionMode = in_array($selectionMode, $allowedSelectionModes, true)
        ? $selectionMode
        : null;

    $resolvedOrientation = in_array($orientation, $allowedOrientations, true)
        ? $orientation
        : 'horizontal';

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $allowsWrap = filter_var($wrap, FILTER_VALIDATE_BOOLEAN);
    $isCompact = filter_var($compact, FILTER_VALIDATE_BOOLEAN);

    $hasAccessibleGroupName = filled($label) || filled($labelledby);
    $usesGroupRole = $hasAccessibleGroupName || filled($resolvedSelectionMode);

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    |
    | Pattern classes are intentionally separate from x-ui.tag classes.
    | x-ui.tag owns individual tag shape, color, size, and interaction styling.
    |
    */

    $classes = [
        'ui-tag-group',
        'ui-tag-group--'.$resolvedOrientation,
        'ui-tag-group--wrap' => $allowsWrap,
        'ui-tag-group--nowrap' => ! $allowsWrap,
        'ui-tag-group--compact' => $isCompact,
        'ui-tag-group--selectable' => filled($resolvedSelectionMode),
        'ui-tag-group--selection-'.$resolvedSelectionMode => filled($resolvedSelectionMode),
    ];

    /*
    |--------------------------------------------------------------------------
    | Slot Detection
    |--------------------------------------------------------------------------
    */

    $hasSlotContent = trim($slot->toHtml()) !== '';

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    */

    $groupAttributes = $attributes->except([
        'role',
        'aria-label',
        'aria-labelledby',
    ]);
@endphp

<div
    {{ $groupAttributes->class($classes)->merge([
        'role' => $usesGroupRole ? 'group' : null,
        'aria-label' => filled($label) ? $label : null,
        'aria-labelledby' => blank($label) && filled($labelledby) ? $labelledby : null,
        'data-ui-pattern' => 'tag-group',
        'data-ui-tag-group' => true,
        'data-ui-tag-group-orientation' => $resolvedOrientation,
        'data-ui-tag-group-wrap' => $allowsWrap ? 'true' : 'false',
        'data-ui-tag-group-selection-mode' => $resolvedSelectionMode,
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Array-driven Tags
        ----------------------------------------------------------------------
        Use items for simple groups. Use slot mode when tags need custom
        attributes, event hooks, or surrounding markup.
        ---------------------------------------------------------------------- --}}

    @foreach ($items as $index => $item)
        @php
            $itemData = is_array($item)
                ? $item
                : [
                    'text' => $item,
                ];

            $itemVariant = data_get($itemData, 'variant');

            if (blank($itemVariant) && filled($resolvedSelectionMode)) {
                $itemVariant = 'selectable';
            }

            $itemVariant = $itemVariant ?: 'read-only';
        @endphp

        <x-ui.tag
            :id="data_get($itemData, 'id')"
            :variant="$itemVariant"
            :type="data_get($itemData, 'type')"
            :tone="data_get($itemData, 'tone')"
            :size="data_get($itemData, 'size', 'md')"
            :text="data_get($itemData, 'text', data_get($itemData, 'label'))"
            :icon="data_get($itemData, 'icon')"
            :disabled="data_get($itemData, 'disabled', false)"
            :selected="data_get($itemData, 'selected')"
            :default-selected="data_get($itemData, 'defaultSelected', data_get($itemData, 'default_selected', false))"
            :dismiss-label="data_get($itemData, 'dismissLabel', data_get($itemData, 'dismiss_label'))"
            :dismiss-tooltip-label="data_get($itemData, 'dismissTooltipLabel', data_get($itemData, 'dismiss_tooltip_label'))"
            :dismiss-tooltip-alignment="data_get($itemData, 'dismissTooltipAlignment', data_get($itemData, 'dismiss_tooltip_alignment', 'bottom'))"
            :tag-title="data_get($itemData, 'tagTitle', data_get($itemData, 'tag_title'))"
            :title="data_get($itemData, 'title')"
            :truncate="data_get($itemData, 'truncate')"
            :dir="data_get($itemData, 'dir', 'ltr')"
            :disclosure-target="data_get($itemData, 'disclosureTarget', data_get($itemData, 'disclosure_target'))"
            :expanded="data_get($itemData, 'expanded', false)"
            :decorator="data_get($itemData, 'decorator')"
            data-ui-tag-group-item
            data-ui-tag-group-item-index="{{ $index }}"
        />
    @endforeach

    {{-- ----------------------------------------------------------------------
        Slotted Tags
        ----------------------------------------------------------------------
        Slot mode is preferred when callers need complete control over each
        x-ui.tag instance.
        ---------------------------------------------------------------------- --}}

    @if ($hasSlotContent)
        {{ $slot }}
    @endif
</div>