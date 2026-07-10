{{-- ==========================================================================
    File: resources/views/components/ui/breadcrumb/index.blade.php
    Purpose: Breadcrumb navigation component.

    Notes:
    - Emits the installed .ui-breadcrumb selector contract.
    - Supports item-array driven breadcrumbs, current-page inclusion, explicit
      current item, small and medium sizes, optional trailing slash suppression,
      and overflow menu behavior.
    - Breadcrumb owns navigation hierarchy only; page title, section heading,
      and routing state are owned by the consuming layout or Pattern.
    - Overflow menu behavior should be handled by installed menu JavaScript.
    - Breadcrumb styles are handled by resources/css/components/breadcrumb.css.
    ========================================================================== --}}

@props([
    'items' => [],
    'size' => 'md',
    'includeCurrent' => false,
    'current' => null,
    'ariaLabel' => 'Breadcrumb',
    'maxVisible' => null,
    'overflow' => false,
    'menuOpen' => false,
    'noTrailingSlash' => false,
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
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'md';

    $shouldIncludeCurrent = filter_var($includeCurrent, FILTER_VALIDATE_BOOLEAN);
    $usesOverflow = filter_var($overflow, FILTER_VALIDATE_BOOLEAN);
    $isMenuOpen = filter_var($menuOpen, FILTER_VALIDATE_BOOLEAN);
    $hasNoTrailingSlash = filter_var($noTrailingSlash, FILTER_VALIDATE_BOOLEAN);

    $attributeAriaLabel = $attributes->get('aria-label');
    $resolvedAriaLabel = $attributeAriaLabel ?? $ariaLabel ?? 'Breadcrumb';

    $overflowMenuId = 'ui-breadcrumb-overflow-menu-'.str()->random(8);

    /*
    |--------------------------------------------------------------------------
    | Normalize Items
    |--------------------------------------------------------------------------
    |
    | Items accept array/object values with label, href, and current keys.
    | Empty labels are removed because each breadcrumb item needs usable text.
    |
    */

    $normalizedItems = collect($items)->map(function ($item) {
        $label = (string) data_get($item, 'label', '');
        $href = data_get($item, 'href', '#');

        return [
            'label' => $label,
            'href' => filled($href) ? (string) $href : '#',
            'current' => filter_var(data_get($item, 'current', false), FILTER_VALIDATE_BOOLEAN),
        ];
    })->filter(fn ($item) => filled($item['label']))->values();

    /*
    |--------------------------------------------------------------------------
    | Resolve Current Item
    |--------------------------------------------------------------------------
    */

    if (filled($current)) {
        $currentItem = is_array($current) || is_object($current)
            ? [
                'label' => (string) data_get($current, 'label', ''),
                'href' => data_get($current, 'href'),
                'current' => true,
            ]
            : [
                'label' => (string) $current,
                'href' => null,
                'current' => true,
            ];

        if (filled($currentItem['label'])) {
            $normalizedItems = $normalizedItems
                ->reject(fn ($item) => $item['current'])
                ->values()
                ->push($currentItem);

            $shouldIncludeCurrent = true;
        }
    }

    if (! $shouldIncludeCurrent) {
        $normalizedItems = $normalizedItems
            ->reject(fn ($item) => $item['current'])
            ->values();
    }

    /*
    |--------------------------------------------------------------------------
    | Resolve Overflow
    |--------------------------------------------------------------------------
    */

    $hiddenItems = collect();
    $visibleItems = $normalizedItems;
    $compactOverflowItems = collect();

    $truncateAfter = is_numeric($maxVisible) && (int) $maxVisible > 0
        ? (int) $maxVisible
        : ($shouldIncludeCurrent ? 5 : 4);

    if ($usesOverflow && $normalizedItems->count() > $truncateAfter) {
        $headCount = 2;
        $tailCount = $shouldIncludeCurrent ? 3 : 2;

        $head = $normalizedItems->take($headCount);
        $tail = $normalizedItems->slice(-$tailCount)->values();

        $hiddenItems = $normalizedItems
            ->slice($headCount, max(0, $normalizedItems->count() - $headCount - $tailCount))
            ->values();

        $visibleItems = $head->concat($tail)->values();
    }

    if ($usesOverflow && $normalizedItems->count() > 1) {
        $compactOverflowItems = $normalizedItems
            ->slice(0, -1)
            ->filter(fn ($item) => ! $item['current'])
            ->values();
    }

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    |
    | These classes must match resources/css/components/breadcrumb.css.
    |
    */

    $classes = [
        'ui-breadcrumb',
        'ui-breadcrumb-sm' => $resolvedSize === 'sm',
        'ui-breadcrumb-md' => $resolvedSize === 'md',
        'ui-breadcrumb-no-trailing-slash' => $hasNoTrailingSlash,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | aria-label is resolved by the component so ariaLabel and caller aria-label
    | share one predictable output.
    |
    */

    $navAttributes = $attributes->except([
        'aria-label',
    ]);
@endphp

<nav
    {{ $navAttributes->class($classes) }}
    aria-label="{{ $resolvedAriaLabel }}"
    data-ui-component="breadcrumb"
    data-ui-breadcrumb
    data-ui-breadcrumb-size="{{ $resolvedSize }}"
    data-ui-breadcrumb-current-included="{{ $shouldIncludeCurrent ? 'true' : 'false' }}"
    data-ui-breadcrumb-visible-items="{{ $visibleItems->count() }}"
    data-ui-breadcrumb-truncate-after="{{ $truncateAfter }}"
    @if ($usesOverflow) data-ui-breadcrumb-overflow="true" @endif
    @if ($hasNoTrailingSlash) data-ui-breadcrumb-no-trailing-slash="true" @endif
>
    <ol class="ui-breadcrumb-list">
        @foreach ($visibleItems as $index => $item)
            @if ($index === 2 && $hiddenItems->isNotEmpty())
                <li
                    class="ui-breadcrumb-item ui-breadcrumb-overflow"
                    data-ui-breadcrumb-overflow-item
                >
                    {{-- ------------------------------------------------------
                        Overflow trigger
                        ------------------------------------------------------
                        JavaScript owns menu disclosure, placement, keyboard
                        behavior, and outside-click dismissal.
                        ------------------------------------------------------ --}}

                    <button
                        type="button"
                        class="ui-breadcrumb-overflow-trigger"
                        aria-haspopup="menu"
                        aria-expanded="{{ $isMenuOpen ? 'true' : 'false' }}"
                        aria-controls="{{ $overflowMenuId }}"
                        aria-label="Show hidden breadcrumb links"
                        data-ui-breadcrumb-overflow-trigger
                        data-ui-menu-trigger
                    >
                        <x-ui.icon
                            name="overflow-menu--horizontal"
                            class="ui-breadcrumb-overflow-icon"
                            aria-hidden="true"
                            focusable="false"
                        />
                    </button>

                    {{-- ------------------------------------------------------
                        Overflow menu
                        ------------------------------------------------------
                        Desktop overflow contains the truncated middle items.
                        Compact overflow can expose the collapsed breadcrumb
                        trail before the current item.
                        ------------------------------------------------------ --}}

                    <div
                        id="{{ $overflowMenuId }}"
                        class="ui-menu ui-menu-sm ui-menu-align-bottom-start ui-breadcrumb-overflow-menu"
                        role="menu"
                        data-ui-menu
                        data-ui-menu-panel
                        data-ui-breadcrumb-overflow-menu
                        data-ui-menu-placement="bottom-start"
                        data-ui-menu-size="sm"
                        data-ui-breadcrumb-overflow-menu-state="{{ $isMenuOpen ? 'open' : 'closed' }}"
                        @if (! $isMenuOpen) hidden @endif
                    >
                        @foreach ($hiddenItems as $hiddenItem)
                            <x-ui.menu-item
                                href="{{ $hiddenItem['href'] }}"
                                size="sm"
                                class="ui-breadcrumb-overflow-desktop-item"
                            >
                                {{ $hiddenItem['label'] }}
                            </x-ui.menu-item>
                        @endforeach

                        @foreach ($compactOverflowItems as $compactItem)
                            <x-ui.menu-item
                                href="{{ $compactItem['href'] }}"
                                size="sm"
                                class="ui-breadcrumb-overflow-compact-item"
                            >
                                {{ $compactItem['label'] }}
                            </x-ui.menu-item>
                        @endforeach
                    </div>
                </li>
            @endif

            <li class="ui-breadcrumb-item">
                @if ($item['current'])
                    <span class="ui-breadcrumb-current" aria-current="page">
                        {{ $item['label'] }}
                    </span>
                @else
                    <a href="{{ $item['href'] }}" class="ui-breadcrumb-link">
                        {{ $item['label'] }}
                    </a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>