{{-- ==========================================================================
    File: resources/views/components/ui/pagination-nav/root.blade.php
    Purpose: UI pagination navigation root.

    Source: Converted from the Carbon PaginationNav React component.
    Notes:
    - Renders the pagination nav container and list.
    - Uses zero-based page state internally, matching the source component.
    - Renders previous/next direction buttons, visible page items, and overflow
      select controls.
    - Icon artwork is not defined here; provide previousIcon, nextIcon, and
      overflowIcon slots when needed.
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
])

@php
    /*
    |--------------------------------------------------------------------------
    | Normalize values
    |--------------------------------------------------------------------------
    */

    $totalItems = max((int) $totalItems, 0);
    $currentPage = max(0, min((int) $page, max($totalItems - 1, 0)));
    $itemsShown = (int) $itemsShown;

    /*
    |--------------------------------------------------------------------------
    | Size behavior
    |--------------------------------------------------------------------------
    |
    | Carbon adjusts this responsively in React. Blade renders the initial
    | server-side state. Any responsive recalculation belongs in pagination JS.
    |
    */

    $numberOfPages = match ($size) {
        'md' => $itemsShown === 4 ? $itemsShown : 5,
        'sm' => min(max($itemsShown, 4), 7),
        default => 4,
    };

    $itemsDisplayedOnPage = max($itemsShown >= 4 ? $itemsShown : $numberOfPages, 4);

    /*
    |--------------------------------------------------------------------------
    | Cut calculation
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

    $backwardButtonDisabled = ! (bool) $loop && $currentPage === 0;
    $forwardButtonDisabled = ! (bool) $loop && $currentPage === $totalItems - 1;

    $startOffset = $itemsDisplayedOnPage <= 4 && $currentPage > 1 ? 0 : 1;

    $shouldRenderFirstItem = $totalItems > 0
        && ($itemsDisplayedOnPage >= 5 || ($itemsDisplayedOnPage <= 4 && $currentPage <= 1));

    $middleStart = $startOffset + $cuts['front'];
    $middleEndExclusive = $totalItems - (1 + $cuts['back']);

    $classes = [
        'ui-pagination-nav',
        "ui-layout--size-{$size}" => filled($size),
    ];
@endphp

<nav
    {{ $attributes->class($classes)->merge([
        'data-ui-pagination-nav' => true,
        'data-ui-pagination-nav-page' => $currentPage,
        'data-ui-pagination-nav-total-items' => $totalItems,
        'data-ui-pagination-nav-items-shown' => $itemsShown,
        'data-ui-pagination-nav-loop' => $loop ? 'true' : 'false',
        'data-ui-pagination-nav-disable-overflow' => $disableOverflow ? 'true' : 'false',
    ]) }}
>
    <ul class="ui-pagination-nav__list">
        <x-ui.pagination-nav.direction-button
            direction="backward"
            :label="$previousLabel"
            :disabled="$backwardButtonDisabled"
            data-ui-pagination-nav-previous
        >
            @isset($previousIcon)
                {{ $previousIcon }}
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
            :disable-overflow="$disableOverflow"
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
            :disable-overflow="$disableOverflow"
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
            data-ui-pagination-nav-next
        >
            @isset($nextIcon)
                {{ $nextIcon }}
            @endisset
        </x-ui.pagination-nav.direction-button>
    </ul>

    <div
        aria-live="polite"
        aria-atomic="true"
        class="ui-pagination-nav__accessibility-label"
    >
        {{ $itemLabel }} {{ $currentPage + 1 }} {{ $ofLabel }} {{ $totalItems }}
    </div>
</nav>