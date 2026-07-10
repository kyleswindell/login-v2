{{-- ==========================================================================
    File: resources/views/components/ui/tile/index.blade.php
    Purpose: Tile component for static, clickable, selectable, and expandable surfaces.

    Notes:
    - Emits the installed .ui-tile selector contract.
    - Normalizes Carbon Tile, ClickableTile, SelectableTile, and ExpandableTile
      concepts into one Blade variant API.
    - Content anatomy is rendered by resources/views/components/ui/partials/tile-content.blade.php.
    - Supports static, clickable, selectable, and expandable variants.
    - Expand/collapse and selection behavior are handled by installed Tile JavaScript.
    ========================================================================== --}}

@props([
    'title' => null,
    'description' => null,
    'href' => null,
    'variant' => 'static',
    'selected' => false,
    'current' => false,
    'expanded' => false,
    'disabled' => false,
    'density' => 'standard',
    'type' => 'button',
    'name' => null,
    'value' => null,
    'selectionMode' => 'single',
    'icon' => null,
    'meta' => null,
    'loading' => false,
    'interactive' => false,
    'expandButtonLabel' => 'Toggle tile details',
])

@php
    use Illuminate\Support\Str;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedVariants = [
        'static',
        'clickable',
        'selectable',
        'expandable',
    ];

    $allowedDensities = [
        'standard',
        'compact',
    ];

    $allowedSelectionModes = [
        'single',
        'multiple',
    ];

    $allowedButtonTypes = [
        'button',
        'submit',
        'reset',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $requestedVariant = $variant === 'base' ? 'static' : $variant;

    $resolvedVariant = in_array($requestedVariant, $allowedVariants, true)
        ? $requestedVariant
        : 'static';

    $resolvedDensity = in_array($density, $allowedDensities, true)
        ? $density
        : 'standard';

    $resolvedSelectionMode = in_array($selectionMode, $allowedSelectionModes, true)
        ? $selectionMode
        : 'single';

    $resolvedButtonType = in_array($type, $allowedButtonTypes, true)
        ? $type
        : 'button';

    $inputType = $resolvedSelectionMode === 'multiple' ? 'checkbox' : 'radio';

    $resolvedId = $attributes->get('id') ?: 'ui-tile-'.Str::uuid();
    $expandedPanelId = $resolvedId.'-expanded';

    /*
    |--------------------------------------------------------------------------
    | Slot Detection
    |--------------------------------------------------------------------------
    */

    $slotContent = trim($slot->toHtml());
    $usesSlotAsTitle = blank($title) && $slotContent !== '';
    $hasBody = filled($title) && $slotContent !== '';

    $detailsSlot = $details ?? null;
    $hasDetailsSlot = isset($detailsSlot) && trim($detailsSlot->toHtml()) !== '';

    $actionsSlot = $actions ?? null;
    $hasActionsSlot = isset($actionsSlot) && trim($actionsSlot->toHtml()) !== '';

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isCurrent = filter_var($current, FILTER_VALIDATE_BOOLEAN);
    $isSelected = filter_var($selected, FILTER_VALIDATE_BOOLEAN) || $isCurrent;
    $isExpanded = filter_var($expanded, FILTER_VALIDATE_BOOLEAN);
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isLoading = filter_var($loading, FILTER_VALIDATE_BOOLEAN);
    $isInteractive = in_array($resolvedVariant, ['clickable', 'selectable', 'expandable'], true);
    $isExpandableInteractive = $resolvedVariant === 'expandable'
        && filter_var($interactive, FILTER_VALIDATE_BOOLEAN);

    $isEmpty = blank($title)
        && blank($description)
        && blank($meta)
        && blank($icon)
        && ! $hasBody
        && ! $usesSlotAsTitle;

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $rootClasses = [
        'ui-tile',
        'ui-tile--'.$resolvedVariant,
        'ui-tile--density-'.$resolvedDensity,
        'ui-tile--expandable-interactive' => $isExpandableInteractive,
        'ui-tile--selected' => $isSelected,
        'ui-tile--current' => $isCurrent,
        'ui-tile--expanded' => $resolvedVariant === 'expandable' && $isExpanded,
        'ui-tile--collapsed' => $resolvedVariant === 'expandable' && ! $isExpanded,
        'ui-tile--disabled' => $isDisabled,
        'ui-tile--loading' => $isLoading,
        'ui-tile--empty' => $isEmpty,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Contract
    |--------------------------------------------------------------------------
    */

    $tileAttributes = $attributes
        ->except(['id'])
        ->class($rootClasses)
        ->merge([
            'id' => $resolvedId,
            'data-ui-component' => 'tile',
            'data-ui-tile' => true,
            'data-ui-tile-variant' => $resolvedVariant,
            'data-ui-tile-density' => $resolvedDensity,
            'data-ui-tile-selection-mode' => $resolvedVariant === 'selectable' ? $resolvedSelectionMode : null,
            'data-ui-selected' => $isSelected ? 'true' : 'false',
            'data-ui-current' => $isCurrent ? 'true' : 'false',
            'data-ui-expanded' => $resolvedVariant === 'expandable' ? ($isExpanded ? 'true' : 'false') : null,
            'data-ui-tile-expanded' => $resolvedVariant === 'expandable' ? ($isExpanded ? 'true' : 'false') : null,
            'data-ui-tile-interactive' => $isExpandableInteractive ? 'true' : 'false',
            'data-ui-disabled' => $isDisabled ? 'true' : 'false',
            'data-ui-loading' => $isLoading ? 'true' : 'false',
        ]);
@endphp

@if ($resolvedVariant === 'clickable' && filled($href) && ! $isDisabled)
    <a
        href="{{ $href }}"
        {{ $tileAttributes }}
        @if ($isCurrent) aria-current="page" @endif
        @if ($isLoading) aria-busy="true" @endif
    >
        @include('components.ui.partials.tile-content', [
            'title' => $title,
            'description' => $description,
            'meta' => $meta,
            'icon' => $icon,
            'slot' => $slot,
            'usesSlotAsTitle' => $usesSlotAsTitle,
            'hasBody' => $hasBody,
        ])

        <span class="ui-tile__action-icon" aria-hidden="true">
            <x-ui.icon name="arrow--right" />
        </span>
    </a>
@elseif ($resolvedVariant === 'clickable')
    <button
        type="{{ $resolvedButtonType }}"
        {{ $tileAttributes }}
        @disabled($isDisabled)
        @if ($isLoading) aria-busy="true" @endif
    >
        @include('components.ui.partials.tile-content', [
            'title' => $title,
            'description' => $description,
            'meta' => $meta,
            'icon' => $icon,
            'slot' => $slot,
            'usesSlotAsTitle' => $usesSlotAsTitle,
            'hasBody' => $hasBody,
        ])

        <span class="ui-tile__action-icon" aria-hidden="true">
            <x-ui.icon name="arrow--right" />
        </span>
    </button>
@elseif ($resolvedVariant === 'selectable')
    <label
        {{ $tileAttributes->merge([
            'data-ui-tile-selectable' => true,
            'role' => $resolvedSelectionMode === 'multiple' ? 'checkbox' : 'radio',
            'aria-checked' => $isSelected ? 'true' : 'false',
            'aria-disabled' => $isDisabled ? 'true' : null,
            'tabindex' => $isDisabled ? '-1' : '0',
        ]) }}
    >
        <input
            class="ui-tile__input"
            type="{{ $inputType }}"
            @if (filled($name)) name="{{ $name }}" @endif
            @if (filled($value)) value="{{ $value }}" @endif
            @checked($isSelected)
            @disabled($isDisabled)
            tabindex="-1"
            data-ui-tile-input
        >

        <span class="ui-tile__selection-icon" aria-hidden="true"></span>

        @include('components.ui.partials.tile-content', [
            'title' => $title,
            'description' => $description,
            'meta' => $meta,
            'icon' => $icon,
            'slot' => $slot,
            'usesSlotAsTitle' => $usesSlotAsTitle,
            'hasBody' => $hasBody,
        ])
    </label>
@elseif ($resolvedVariant === 'expandable')
    <div
        {{ $tileAttributes->merge([
            'data-ui-tile-expandable' => true,
            'aria-disabled' => $isDisabled ? 'true' : null,
            'aria-busy' => $isLoading ? 'true' : null,
        ]) }}
    >
        @if ($isExpandableInteractive)
            <div class="ui-tile__interactive-content">
                @include('components.ui.partials.tile-content', [
                    'title' => $title,
                    'description' => $description,
                    'meta' => $meta,
                    'icon' => $icon,
                    'slot' => $slot,
                    'usesSlotAsTitle' => $usesSlotAsTitle,
                    'hasBody' => $hasBody,
                ])

                @if ($hasActionsSlot)
                    <div class="ui-tile__actions">
                        {{ $actionsSlot }}
                    </div>
                @endif
            </div>

            <button
                type="button"
                class="ui-tile__expand-button"
                aria-label="{{ $expandButtonLabel }}"
                aria-expanded="{{ $isExpanded ? 'true' : 'false' }}"
                @if ($hasDetailsSlot) aria-controls="{{ $expandedPanelId }}" @endif
                data-ui-tile-expand-trigger
                @disabled($isDisabled)
            >
                <x-ui.icon name="chevron--down" aria-hidden="true" />
            </button>
        @else
            <button
                type="button"
                class="ui-tile__expand-trigger"
                aria-expanded="{{ $isExpanded ? 'true' : 'false' }}"
                @if ($hasDetailsSlot) aria-controls="{{ $expandedPanelId }}" @endif
                data-ui-tile-expand-trigger
                @disabled($isDisabled)
            >
                @include('components.ui.partials.tile-content', [
                    'title' => $title,
                    'description' => $description,
                    'meta' => $meta,
                    'icon' => $icon,
                    'slot' => $slot,
                    'usesSlotAsTitle' => $usesSlotAsTitle,
                    'hasBody' => $hasBody,
                ])

                <span class="ui-tile__action-icon" aria-hidden="true">
                    <x-ui.icon name="chevron--down" />
                </span>
            </button>
        @endif

        @if ($hasDetailsSlot)
            <div
                id="{{ $expandedPanelId }}"
                class="ui-tile__expanded"
                data-ui-tile-expanded-panel
                @if (! $isExpanded) hidden @endif
            >
                {{ $detailsSlot }}
            </div>
        @endif
    </div>
@else
    <div
        {{ $tileAttributes->merge([
            'aria-busy' => $isLoading ? 'true' : null,
        ]) }}
    >
        @include('components.ui.partials.tile-content', [
            'title' => $title,
            'description' => $description,
            'meta' => $meta,
            'icon' => $icon,
            'slot' => $slot,
            'usesSlotAsTitle' => $usesSlotAsTitle,
            'hasBody' => $hasBody,
        ])

        @if ($hasActionsSlot)
            <div class="ui-tile__actions">
                {{ $actionsSlot }}
            </div>
        @endif
    </div>
@endif