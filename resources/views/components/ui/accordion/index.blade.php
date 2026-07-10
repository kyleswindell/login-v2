{{-- ==========================================================================
    File: resources/views/components/ui/accordion/index.blade.php
    Purpose: Accordion component.

    Notes:
    - Emits the installed .ui-accordion selector contract.
    - Aligns Blade anatomy with Carbon Accordion structure:
      li > button heading > wrapper > content.
    - Supports item-array rendering with single or multiple open mode.
    - Supports slot-based content when caller owns item markup.
    - Supports contained, flush, compact, icon-start, and scrollable variants.
    - Uses x-ui.icon for the chevron.
    - Accordion open/close behavior is handled by installed accordion JavaScript.
    - Accordion styles are handled by resources/css/components/accordion.css.
    ========================================================================== --}}

@props ([
    "items" => [],
    "id" => null,
    "variant" => "default",
    "alignment" => "default",
    "isFlush" => null,
    "iconAlignment" => "end",
    "align" => null,
    "size" => "default",
    "mode" => "multiple",
    "scrollable" => false,
    "panelMaxHeight" => "16rem",
    "disabled" => false,
    "ordered" => false,
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedVariants = [
        'default',
        'contained',
    ];

    $allowedAlignments = [
        'default',
        'flush',
    ];

    $allowedIconAlignments = [
        'end',
        'start',
    ];

    $allowedSizes = [
        'default',
        'compact',
    ];

    $allowedModes = [
        'multiple',
        'single',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Public Values
    |--------------------------------------------------------------------------
    */

    $resolvedId = $id ?? $attributes->get('id') ?? 'ui-accordion-'.Str::uuid();

    $resolvedVariant = in_array($variant, $allowedVariants, true)
        ? $variant
        : 'default';

    $requestedIconAlignment = $align ?? $iconAlignment;

    $resolvedIconAlignment = in_array($requestedIconAlignment, $allowedIconAlignments, true)
        ? $requestedIconAlignment
        : 'end';

    /*
    |--------------------------------------------------------------------------
    | Flush Handling
    |--------------------------------------------------------------------------
    |
    | Carbon's flush treatment does not apply with start-aligned chevrons.
    |
    */

    $requestedAlignment = ! is_null($isFlush)
        ? (filter_var($isFlush, FILTER_VALIDATE_BOOLEAN) ? 'flush' : 'default')
        : (in_array($alignment, $allowedAlignments, true) ? $alignment : 'default');

    $resolvedAlignment = $resolvedIconAlignment === 'start' && $requestedAlignment === 'flush'
        ? 'default'
        : $requestedAlignment;

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'default';

    $resolvedMode = in_array($mode, $allowedModes, true)
        ? $mode
        : 'multiple';

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isScrollable = filter_var($scrollable, FILTER_VALIDATE_BOOLEAN);
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isOrdered = filter_var($ordered, FILTER_VALIDATE_BOOLEAN);

    $listTag = $isOrdered ? 'ol' : 'ul';

    /*
    |--------------------------------------------------------------------------
    | Scroll Style Handling
    |--------------------------------------------------------------------------
    */

    $resolvedPanelMaxHeight = is_string($panelMaxHeight) && preg_match('/^[0-9.]+(px|rem|em|vh|vw|%)$/', $panelMaxHeight) === 1
        ? $panelMaxHeight
        : '16rem';

    $existingStyle = trim((string) $attributes->get('style'));

    $scrollStyle = $isScrollable
        ? '--ui-accordion-panel-max-height: '.$resolvedPanelMaxHeight.';'
        : null;

    $resolvedStyle = trim(collect([
        $existingStyle,
        $scrollStyle,
    ])->filter()->implode(' '));

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-accordion',
        'ui-accordion-contained' => $resolvedVariant === 'contained',
        'ui-accordion-flush' => $resolvedAlignment === 'flush',
        'ui-accordion--flush' => $resolvedAlignment === 'flush',
        'ui-accordion-icon-start' => $resolvedIconAlignment === 'start',
        'ui-accordion--start' => $resolvedIconAlignment === 'start',
        'ui-accordion--end' => $resolvedIconAlignment === 'end',
        'ui-accordion-compact' => $resolvedSize === 'compact',
        'ui-accordion-scrollable' => $isScrollable,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    */

    $accordionAttributes = $attributes->except([
        'id',
        'style',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Slot Detection
    |--------------------------------------------------------------------------
    */

    $hasSlotContent = trim($slot->toHtml()) !== '';

    /*
    |--------------------------------------------------------------------------
    | Single Open Tracking
    |--------------------------------------------------------------------------
    */

    $openItemAlreadyRendered = false;
@endphp

<{{ $listTag }}
    id="{{ $resolvedId }}"
    {{
        $accordionAttributes
            ->class($classes)
            ->merge([
                "data-ui-component" => "accordion",
                "data-ui-accordion" => $resolvedId,
                "data-ui-accordion-mode" => $resolvedMode,
                "data-ui-accordion-variant" => $resolvedVariant,
                "data-ui-accordion-alignment" => $resolvedAlignment,
                "data-ui-accordion-icon-alignment" => $resolvedIconAlignment,
                "data-ui-accordion-size" => $resolvedSize,
                "data-ui-accordion-disabled" => $isDisabled ? "true" : "false",
                "data-ui-accordion-ordered" => $isOrdered ? "true" : "false",
                "data-ui-accordion-scrollable" => $isScrollable ? "true" : "false",
            ])
    }}
    @if ($resolvedStyle !== "") style="{{ $resolvedStyle }}" @endif
>
    {{-- ----------------------------------------------------------------------
        Accordion items
        ---------------------------------------------------------------------- --}}

    @foreach ($items as $index => $item)
        @php
            /*
            |--------------------------------------------------------------------------
            | Item Normalization
            |--------------------------------------------------------------------------
            */

            $itemData = is_array($item)
                ? $item
                : [
                    'title' => $item,
                    'body' => '',
                ];

            $itemId = data_get($itemData, 'id', $resolvedId.'-item-'.$index);
            $panelId = data_get($itemData, 'panelId', data_get($itemData, 'panel_id', $itemId.'-panel'));
            $triggerId = data_get($itemData, 'triggerId', data_get($itemData, 'trigger_id', $itemId.'-trigger'));

            $itemTitle = data_get($itemData, 'title', 'Accordion item');
            $itemMeta = data_get($itemData, 'meta');
            $itemBody = data_get($itemData, 'body', data_get($itemData, 'content', ''));

            $itemAriaLabel = data_get($itemData, 'ariaLabel', data_get($itemData, 'aria-label'));

            $itemOpenRequested = filter_var(data_get($itemData, 'open', false), FILTER_VALIDATE_BOOLEAN);

            $isOpen = $itemOpenRequested
                && ($resolvedMode === 'multiple' || ! $openItemAlreadyRendered);

            if ($isOpen) {
                $openItemAlreadyRendered = true;
            }

            $isItemDisabled = $isDisabled
                || filter_var(data_get($itemData, 'disabled', false), FILTER_VALIDATE_BOOLEAN);
        @endphp

        <li
            @class ([
                "ui-accordion-item",
                "ui-accordion__item",
                "ui-accordion-item-active" => $isOpen,
                "ui-accordion__item--active" => $isOpen,
                "ui-accordion-item-disabled" => $isItemDisabled,
                "ui-accordion__item--disabled" => $isItemDisabled
            ])
            data-ui-accordion-item
            data-ui-accordion-item-index="{{ $index }}"
            data-ui-accordion-item-open="{{ $isOpen ? 'true' : 'false' }}"
            data-ui-accordion-item-disabled="{{ $isItemDisabled ? 'true' : 'false' }}"
        >
            <button
                id="{{ $triggerId }}"
                type="button"
                class="ui-accordion-heading ui-accordion__heading ui-accordion-trigger"
                aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                aria-controls="{{ $panelId }}"
                @if (filled($itemAriaLabel)) aria-label="{{ $itemAriaLabel }}" @endif
                data-ui-accordion-trigger
                data-ui-accordion-trigger-disabled="{{ $isItemDisabled ? 'true' : 'false' }}"
                @disabled ($isItemDisabled)
            >
                <x-ui.icon
                    name="chevron--right"
                    class="ui-accordion-arrow ui-accordion__arrow ui-accordion-icon"
                    aria-hidden="true"
                />

                <span class="ui-accordion-label">
                    <span class="ui-accordion-title">
                        @if ($itemTitle instanceof HtmlString)
                            {!! $itemTitle !!}
                        @else
                            {{ $itemTitle }}
                        @endif
                    </span>

                    @if (filled($itemMeta))
                        <span class="ui-accordion-meta">
                            @if ($itemMeta instanceof HtmlString)
                                {!! $itemMeta !!}
                            @else
                                {{ $itemMeta }}
                            @endif
                        </span>
                    @endif
                </span>
            </button>

            <div
                id="{{ $panelId }}"
                class="ui-accordion-wrapper ui-accordion__wrapper ui-accordion-panel"
                role="region"
                aria-labelledby="{{ $triggerId }}"
                data-ui-accordion-panel
                data-ui-accordion-panel-open="{{ $isOpen ? 'true' : 'false' }}"
                data-ui-accordion-animating="false"
                @if (!$isOpen) hidden @endif
            >
                <div
                    class="ui-accordion-content ui-accordion__content ui-accordion-body"
                >
                    @if ($itemBody instanceof HtmlString)
                        {!! $itemBody !!}
                    @elseif (filled($itemBody))
                        <p>{{ $itemBody }}</p>
                    @endif
                </div>
            </div>
        </li>
    @endforeach

    {{-- ----------------------------------------------------------------------
        Slot items
        ---------------------------------------------------------------------- --}}

    @if ($hasSlotContent)
        {{ $slot }}
    @endif
</{{ $listTag }}>
