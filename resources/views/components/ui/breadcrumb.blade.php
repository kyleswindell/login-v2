@props([
    'items' => [],
    'size' => 'md',
    'includeCurrent' => false,
    'current' => null,
    'ariaLabel' => 'Breadcrumb',
    'maxVisible' => null,
    'overflow' => false,
    'menuOpen' => false,
])

@php
    $resolvedSize = in_array($size, ['sm', 'md'], true) ? $size : 'md';
    $normalizedItems = collect($items)->map(function ($item) {
        return [
            'label' => $item['label'] ?? '',
            'href' => $item['href'] ?? '#',
            'current' => (bool) ($item['current'] ?? false),
        ];
    })->filter(fn ($item) => filled($item['label']))->values();

    if (filled($current)) {
        $currentItem = is_array($current)
            ? [
                'label' => $current['label'] ?? '',
                'href' => $current['href'] ?? null,
                'current' => true,
            ]
            : [
                'label' => (string) $current,
                'href' => null,
                'current' => true,
            ];

        if (filled($currentItem['label'])) {
            $normalizedItems = $normalizedItems->reject(fn ($item) => $item['current'])->values()->push($currentItem);
            $includeCurrent = true;
        }
    }

    if (! $includeCurrent) {
        $normalizedItems = $normalizedItems->reject(fn ($item) => $item['current'])->values();
    }

    $hiddenItems = collect();
    $visibleItems = $normalizedItems;

    $truncateAfter = is_numeric($maxVisible) && (int) $maxVisible > 0
        ? (int) $maxVisible
        : ($includeCurrent ? 5 : 4);

    if ($overflow && $normalizedItems->count() > $truncateAfter) {
        $headCount = 2;
        $tailCount = $includeCurrent ? 3 : 2;
        $head = $normalizedItems->take($headCount);
        $tail = $normalizedItems->slice(-$tailCount)->values();
        $hiddenItems = $normalizedItems->slice($headCount, max(0, $normalizedItems->count() - $headCount - $tailCount))->values();
        $visibleItems = $head->concat($tail)->values();
    }
@endphp

<nav
    {{ $attributes->class([
        'ui-breadcrumb',
        'ui-breadcrumb-sm' => $resolvedSize === 'sm',
        'ui-breadcrumb-trailing' => ! $includeCurrent,
    ]) }}
    aria-label="{{ $ariaLabel }}"
    data-ui-component="breadcrumb"
    data-ui-breadcrumb-size="{{ $resolvedSize }}"
    data-ui-breadcrumb-current-included="{{ $includeCurrent ? 'true' : 'false' }}"
    data-ui-breadcrumb-visible-items="{{ $visibleItems->count() }}"
    data-ui-breadcrumb-truncate-after="{{ $truncateAfter }}"
    @if ($overflow) data-ui-breadcrumb-overflow="true" @endif
>
    <ol class="ui-breadcrumb-list">
        @foreach ($visibleItems as $index => $item)
            @if ($index === 2 && $hiddenItems->isNotEmpty())
                <li class="ui-breadcrumb-item ui-breadcrumb-overflow" data-ui-breadcrumb-overflow-item>
                    <button
                        type="button"
                        class="ui-breadcrumb-overflow-trigger"
                        aria-haspopup="menu"
                        aria-expanded="{{ $menuOpen ? 'true' : 'false' }}"
                        aria-label="Show hidden breadcrumb links"
                        data-ui-breadcrumb-overflow-trigger
                        data-ui-menu-trigger
                    >
                        <span aria-hidden="true">...</span>
                    </button>
                    <div class="ui-menu ui-menu-sm ui-menu-align-bottom-start" role="menu" @if (! $menuOpen) hidden @endif data-ui-menu>
                        @foreach ($hiddenItems as $hiddenItem)
                            <a href="{{ $hiddenItem['href'] }}" class="ui-menu-item" role="menuitem">{{ $hiddenItem['label'] }}</a>
                        @endforeach
                    </div>
                </li>
            @endif

            <li class="ui-breadcrumb-item">
                @if ($item['current'])
                    <span class="ui-breadcrumb-current" aria-current="page">{{ $item['label'] }}</span>
                @else
                    <a href="{{ $item['href'] }}" class="ui-breadcrumb-link">{{ $item['label'] }}</a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
