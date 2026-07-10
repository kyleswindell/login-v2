{{-- ==========================================================================
    File: resources/views/components/ui/pagination-nav/index.blade.php
    Purpose: UI pagination navigation component.

    Source: Converted from the Carbon PaginationNav React component.

    Notes:
    - Renders the pagination nav container and list.
    - Uses zero-based page state internally, matching the source component.
    - Renders previous/next direction buttons, visible page items, and overflow
      select controls.
    - Provides default pagination icons through x-ui.icon.
    - Client-side page changes should be handled by installed pagination JS.
    ========================================================================== --}}

@props([
    'totalItems' => 0,
    'page' => 0,
    'itemsShown' => 10,
    'size' => 'lg',
    'loop' => false,
    'disableOverflow' => false,
    'previousLabel' => 'Previous',
    'nextLabel' => 'Next',
    'itemLabel' => 'Page',
    'activeLabel' => 'Active',
    'ofLabel' => 'of',
    'tooltipAlignment' => 'center',
    'tooltipPosition' => 'bottom',
])

@php
    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedSizes = [
        'sm',
        'md',
        'lg',
    ];

    $allowedTooltipAlignments = [
        'start',
        'center',
        'end',
    ];

    $allowedTooltipPositions = [
        'top',
        'right',
        'bottom',
        'left',
    ];

    /*
    |--------------------------------------------------------------------------
    | Normalize Values
    |--------------------------------------------------------------------------
    */

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'lg';

    $resolvedTooltipAlignment = in_array($tooltipAlignment, $allowedTooltipAlignments, true)
        ? $tooltipAlignment
        : 'center';

    $resolvedTooltipPosition = in_array($tooltipPosition, $allowedTooltipPositions, true)
        ? $tooltipPosition
        : 'bottom';

    $totalItems = is_numeric($totalItems) ? max((int) $totalItems, 0) : 0;
    $currentPage = is_numeric($page) ? (int) $page : 0;
    $itemsShown = is_numeric($itemsShown) ? max((int) $itemsShown, 0) : 10;

    $currentPage = max(0, min($currentPage, max($totalItems - 1, 0)));

    $usesLoop = filter_var($loop, FILTER_VALIDATE_BOOLEAN);
    $hasDisabledOverflow = filter_var($disableOverflow, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | Size Behavior
    |--------------------------------------------------------------------------
    |
    | Carbon adjusts this responsively in React. Blade renders the initial
    | server-side state. Any responsive recalculation belongs in pagination JS.
    |
    */

    $numberOfPages = match ($resolvedSize) {
        'md' => $itemsShown === 4 ? $itemsShown : 5,
        'sm' => min(max($itemsShown, 4), 7),
        default => 4,
    };

    $itemsDisplayedOnPage = max($itemsShown >= 4 ? $itemsShown : $numberOfPages, 4);

    /*
    |--------------------------------------------------------------------------
    | Cut Calculation
    |--------------------------------------------------------------------------
    */

    $calculateCuts = static function (
        int $page,
        int $totalItems,
        int $itemsDisplayedOnPage,
        ?int $splitPoint = null
    ): array {
        if ($itemsDisplayedOnPage >= $totalItems) {
            return ['front' => 0, 'back' => 0];
        }

        $split = $splitPoint ?? (int) ceil($itemsDisplayedOnPage / 2) - 1;

        $frontHidden = $page + 1 - $split;
        $backHidden = $totalItems - $page - ($itemsDisplayedOnPage - $split) + 1;

        if ($frontHidden <= 1) {
            $backHidden -= $frontHidden <= 0 ? abs($frontHidden) + 1 : 0;
            $frontHidden = 0;
        }

        if ($backHidden <= 1) {
            $frontHidden -= $backHidden <= 0 ? abs($backHidden) + 1 : 0;
            $backHidden = 0;
        }

        return [
            'front' => max(0, $frontHidden),
            'back' => max(0, $backHidden),
        ];
    };

    $cuts = $calculateCuts($currentPage, $totalItems, $itemsDisplayedOnPage);

    $backwardButtonDisabled = $totalItems <= 1 || (! $usesLoop && $currentPage === 0);
    $forwardButtonDisabled = $totalItems <= 1 || (! $usesLoop && $currentPage >= $totalItems - 1);

    $startOffset = $itemsDisplayedOnPage <= 4 && $currentPage > 1 ? 0 : 1;

    $shouldRenderFirstItem = $totalItems > 0
        && ($itemsDisplayedOnPage >= 5 || ($itemsDisplayedOnPage <= 4 && $currentPage <= 1));

    $middleStart = $startOffset + $cuts['front'];
    $middleEndExclusive = max($middleStart, $totalItems - (1 + $cuts['back']));

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-pagination-nav',
        'ui-layout--size-'.$resolvedSize,
    ];
@endphp

<nav
    {{ $attributes->class($classes)->merge([
        'data-ui-component' => 'pagination-nav',
        'data-ui-pagination-nav' => true,
        'data-ui-pagination-nav-page' => $currentPage,
        'data-ui-pagination-nav-total-items' => $totalItems,
        'data-ui-pagination-nav-items-shown' => $itemsShown,
        'data-ui-pagination-nav-size' => $resolvedSize,
        'data-ui-pagination-nav-loop' => $usesLoop ? 'true' : 'false',
        'data-ui-pagination-nav-disable-overflow' => $hasDisabledOverflow ? 'true' : 'false',
    ]) }}
>
    <ul class="ui-pagination-nav__list" data-ui-pagination-nav-list>
        <x-ui.pagination-nav.direction-button
            direction="backward"
            :label="$previousLabel"
            :disabled="$backwardButtonDisabled"
            :tooltip-alignment="$resolvedTooltipAlignment"
            :tooltip-position="$resolvedTooltipPosition"
            data-ui-pagination-nav-previous
        >
            @isset($previousIcon)
                {{ $previousIcon }}
            @else
                <x-ui.icon name="caret--left" aria-hidden="true" />
            @endisset
        </x-ui.pagination-nav.direction-button>

        @if ($shouldRenderFirstItem)
            <x-ui.pagination-nav.item
                :page="1"
                :page-index="0"
                :active="$currentPage === 0"
                :item-label="$itemLabel"
                :active-label="$activeLabel"
            />
        @endif

        <x-ui.pagination-nav.overflow
            :from-index="$startOffset"
            :count="$cuts['front']"
            :disable-overflow="$hasDisabledOverflow"
            :item-label="$itemLabel"
            :active-label="$activeLabel"
        >
            @isset($overflowIcon)
                <x-slot:icon>
                    {{ $overflowIcon }}
                </x-slot:icon>
            @endisset
        </x-ui.pagination-nav.overflow>

        @for ($item = $middleStart; $item < $middleEndExclusive; $item++)
            <x-ui.pagination-nav.item
                :page="$item + 1"
                :page-index="$item"
                :active="$currentPage === $item"
                :item-label="$itemLabel"
                :active-label="$activeLabel"
            />
        @endfor

        <x-ui.pagination-nav.overflow
            :from-index="$totalItems - $cuts['back'] - 1"
            :count="$cuts['back']"
            :disable-overflow="$hasDisabledOverflow"
            :item-label="$itemLabel"
            :active-label="$activeLabel"
        >
            @isset($overflowIcon)
                <x-slot:icon>
                    {{ $overflowIcon }}
                </x-slot:icon>
            @endisset
        </x-ui.pagination-nav.overflow>

        @if ($totalItems > 1)
            <x-ui.pagination-nav.item
                :page="$totalItems"
                :page-index="$totalItems - 1"
                :active="$currentPage === $totalItems - 1"
                :item-label="$itemLabel"
                :active-label="$activeLabel"
            />
        @endif

        <x-ui.pagination-nav.direction-button
            direction="forward"
            :label="$nextLabel"
            :disabled="$forwardButtonDisabled"
            :tooltip-alignment="$resolvedTooltipAlignment"
            :tooltip-position="$resolvedTooltipPosition"
            data-ui-pagination-nav-next
        >
            @isset($nextIcon)
                {{ $nextIcon }}
            @else
                <x-ui.icon name="caret--right" aria-hidden="true" />
            @endisset
        </x-ui.pagination-nav.direction-button>
    </ul>

    <div
        aria-live="polite"
        aria-atomic="true"
        class="ui-pagination-nav__accessibility-label"
        data-ui-pagination-nav-accessibility-label
    >
        {{ $itemLabel }} {{ $currentPage + 1 }} {{ $ofLabel }} {{ $totalItems }}
    </div>
</nav>