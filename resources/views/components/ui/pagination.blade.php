@props([
    'id' => null,
    'label' => 'Pagination',
    'variant' => 'pagination',
    'size' => null,
    'density' => null,
    'alignment' => 'right',
    'currentPage' => 1,
    'lastPage' => 1,
    'totalPages' => null,
    'totalItems' => null,
    'total' => null,
    'perPage' => null,
    'pageSize' => null,
    'pageSizeOptions' => [],
    'baseUrl' => '#',
    'pageName' => 'page',
    'pageSizeName' => 'per_page',
    'showItemsPerPage' => true,
    'showItemRange' => true,
    'showPageSelector' => true,
    'loop' => false,
    'disabled' => false,
    'responsive' => true,
    'interactive' => false,
    'smallBreakpoint' => false,
    'window' => 1,
])

@php
    $paginationId = $id ?? 'pagination-'.str()->random(8);
    $current = max(1, (int) $currentPage);
    $last = max(1, (int) ($totalPages ?? $lastPage));
    $current = min($current, $last);
    $pageSize = (int) ($pageSize ?? $perPage ?? 25);
    $total = $totalItems ?? $total;
    $total = $total === null ? null : max(0, (int) $total);
    $from = $total === null || $total === 0 ? null : (($current - 1) * $pageSize) + 1;
    $to = $total === null || $total === 0 ? null : min($total, $current * $pageSize);

    $resolvedVariant = match ($variant) {
        'pagination', 'bar' => 'pagination',
        'pagination-nav', 'nav', 'full', 'compact' => 'pagination-nav',
        default => 'pagination',
    };
    $compatVariant = in_array($variant, ['full', 'compact'], true) ? $variant : null;
    $resolvedSize = in_array($size, ['sm', 'md', 'lg'], true)
        ? $size
        : (($density === 'compact') ? 'sm' : 'md');
    $resolvedAlignment = in_array($alignment, ['left', 'right'], true) ? $alignment : 'right';
    $pageWindow = max(1, min(3, (int) $window));
    $isDisabled = (bool) $disabled;
    $isInteractive = (bool) $interactive;
    $isSmallBreakpoint = (bool) $smallBreakpoint;
    $hasPrevious = $loop ? $last > 1 : $current > 1;
    $hasNext = $loop ? $last > 1 : $current < $last;
    $previousPage = $current <= 1 ? ($loop ? $last : 1) : $current - 1;
    $nextPage = $current >= $last ? ($loop ? 1 : $last) : $current + 1;

    $optionValues = collect($pageSizeOptions)->map(function ($option) {
        if (is_array($option)) {
            return [
                'value' => data_get($option, 'value', data_get($option, 'label')),
                'label' => (string) data_get($option, 'label', data_get($option, 'value')),
            ];
        }

        return ['value' => $option, 'label' => (string) $option];
    })->filter(fn ($option) => filled($option['value']))->values();

    $hrefFor = function (int $page, array $extra = []) use ($baseUrl, $pageName): string {
        if ($baseUrl === '#') {
            return '#';
        }

        $separator = str_contains($baseUrl, '?') ? '&' : '?';
        $params = http_build_query(array_merge([$pageName => $page], $extra));

        return $baseUrl.$separator.$params;
    };

    $pageItems = [];

    if ($last <= 7) {
        $pageItems = collect(range(1, $last))->map(fn (int $page) => ['type' => 'page', 'page' => $page])->all();
    } else {
        $visible = collect([1, $last]);

        for ($page = max(2, $current - $pageWindow); $page <= min($last - 1, $current + $pageWindow); $page++) {
            $visible->push($page);
        }

        $visible = $visible->unique()->sort()->values();
        $previous = null;

        foreach ($visible as $page) {
            if ($previous !== null && $page > $previous + 1) {
                $pageItems[] = ['type' => 'overflow', 'start' => $previous + 1, 'end' => $page - 1];
            }

            $pageItems[] = ['type' => 'page', 'page' => $page];
            $previous = $page;
        }
    }
@endphp

<nav
    id="{{ $paginationId }}"
    aria-label="{{ $label }}"
    data-ui-component="pagination"
    data-ui-pagination
    data-ui-pagination-variant="{{ $resolvedVariant }}"
    @if($compatVariant) data-ui-pagination-compat-variant="{{ $compatVariant }}" @endif
    data-ui-pagination-size="{{ $resolvedSize }}"
    data-ui-pagination-alignment="{{ $resolvedAlignment }}"
    data-ui-pagination-current="{{ $current }}"
    data-ui-pagination-total-pages="{{ $last }}"
    data-ui-pagination-page-size-value="{{ $pageSize }}"
    @if($total !== null) data-ui-pagination-total-items="{{ $total }}" @endif
    data-ui-pagination-window="{{ $pageWindow }}"
    @if($isInteractive) data-ui-pagination-interactive="true" @endif
    @if($loop) data-ui-pagination-loop="true" @endif
    @if($isDisabled) data-ui-pagination-disabled="true" @endif
    @if($responsive) data-ui-pagination-responsive="true" @endif
    @if($isSmallBreakpoint) data-ui-pagination-small-breakpoint="true" @endif
    {{ $attributes->class([
        'ui-pagination',
        'ui-pagination-'.$resolvedVariant,
        'ui-pagination-'.$resolvedSize,
        'ui-pagination-align-'.$resolvedAlignment,
        'ui-pagination-disabled' => $isDisabled,
        'ui-pagination-responsive' => $responsive,
        'ui-pagination-small-breakpoint' => $isSmallBreakpoint,
    ]) }}
>
    @if ($resolvedVariant === 'pagination')
        <div class="ui-pagination-bar" data-ui-pagination-bar>
            @if ($showItemsPerPage && $optionValues->isNotEmpty())
                <form class="ui-pagination-page-size" method="GET" action="{{ $baseUrl === '#' ? '#' : $baseUrl }}" data-ui-pagination-page-size-form>
                    <label class="ui-pagination-label" for="{{ $paginationId }}-page-size">Items per page:</label>
                    <select
                        id="{{ $paginationId }}-page-size"
                        class="ui-pagination-select ui-pagination-select-page-size"
                        name="{{ $pageSizeName }}"
                        @disabled($isDisabled)
                        data-ui-pagination-page-size
                    >
                        @foreach ($optionValues as $option)
                            <option value="{{ $option['value'] }}" @selected((string) $option['value'] === (string) $pageSize)>{{ $option['label'] }}</option>
                        @endforeach
                    </select>
                </form>
            @endif

            @if ($showItemRange)
                <p class="ui-pagination-range" data-ui-pagination-range>
                    @if ($total === null)
                        Page {{ $current }} of {{ $last }}
                    @elseif ($total === 0)
                        0 items
                    @else
                        {{ $from }}-{{ $to }} of {{ $total }} items
                    @endif
                </p>
            @endif

            @if ($showPageSelector)
                <label class="ui-pagination-label ui-pagination-page-selector" for="{{ $paginationId }}-page-select">
                    <span class="sr-only">Current page</span>
                    <select
                        id="{{ $paginationId }}-page-select"
                        class="ui-pagination-select ui-pagination-select-page-select"
                        name="{{ $pageName }}"
                        @disabled($isDisabled)
                        data-ui-pagination-page-select
                    >
                        @foreach (range(1, $last) as $page)
                            <option value="{{ $page }}" @selected($page === $current)>{{ $page }}</option>
                        @endforeach
                    </select>
                    <span>of {{ $last }} {{ str('page')->plural($last) }}</span>
                </label>
            @endif

            <div class="ui-pagination-controls" data-ui-pagination-controls>
                <a
                    href="{{ $hrefFor($previousPage) }}"
                    aria-label="Previous page"
                    @class(['ui-pagination-control', 'ui-pagination-control-icon', 'is-disabled' => $isDisabled || ! $hasPrevious])
                    @if($isDisabled || ! $hasPrevious) aria-disabled="true" tabindex="-1" @endif
                    data-ui-pagination-prev
                >
                    <x-heroicon-o-chevron-left class="ui-pagination-icon" aria-hidden="true" />
                </a>
                <a
                    href="{{ $hrefFor($nextPage) }}"
                    aria-label="Next page"
                    @class(['ui-pagination-control', 'ui-pagination-control-icon', 'is-disabled' => $isDisabled || ! $hasNext])
                    @if($isDisabled || ! $hasNext) aria-disabled="true" tabindex="-1" @endif
                    data-ui-pagination-next
                >
                    <x-heroicon-o-chevron-right class="ui-pagination-icon" aria-hidden="true" />
                </a>
            </div>
        </div>
    @else
        <div class="ui-pagination-nav-shell" data-ui-pagination-nav>
            <a
                href="{{ $hrefFor($previousPage) }}"
                aria-label="Previous page"
                @class(['ui-pagination-control', 'ui-pagination-control-icon', 'is-disabled' => $isDisabled || ! $hasPrevious])
                @if($isDisabled || ! $hasPrevious) aria-disabled="true" tabindex="-1" @endif
                data-ui-pagination-prev
            >
                <x-heroicon-o-chevron-left class="ui-pagination-icon" aria-hidden="true" />
            </a>

            <ol class="ui-pagination-list" aria-label="Pages">
                @foreach ($pageItems as $item)
                    @if ($item['type'] === 'page')
                        @php $page = $item['page']; @endphp
                        <li
                            @class([
                                'ui-pagination-item',
                                'ui-pagination-item-page',
                                'ui-pagination-item-current' => $page === $current,
                                'ui-pagination-item-edge' => $page === 1 || $page === $last,
                                'ui-pagination-item-neighbor' => $page !== $current && $page !== 1 && $page !== $last,
                            ])
                        >
                            <a
                                href="{{ $hrefFor($page) }}"
                                aria-label="Page {{ $page }}"
                                @if($page === $current) aria-current="page" @endif
                                @class(['ui-pagination-page', 'is-current' => $page === $current, 'is-disabled' => $isDisabled])
                                @if($isDisabled) aria-disabled="true" tabindex="-1" @endif
                                data-ui-pagination-page="{{ $page }}"
                            >
                                {{ $page }}
                            </a>
                        </li>
                    @else
                        @php
                            $overflowPages = range($item['start'], $item['end']);
                            $overflowId = $paginationId.'-overflow-'.$item['start'].'-'.$item['end'];
                        @endphp
                        <li class="ui-pagination-item ui-pagination-item-overflow">
                            <div class="ui-pagination-overflow" data-ui-pagination-overflow>
                                <button
                                    type="button"
                                    class="ui-pagination-page ui-pagination-overflow-trigger"
                                    aria-label="Show hidden pages {{ $item['start'] }} through {{ $item['end'] }}"
                                    aria-haspopup="menu"
                                    aria-expanded="false"
                                    aria-controls="{{ $overflowId }}"
                                    data-ui-pagination-overflow-trigger
                                >
                                    <span aria-hidden="true">...</span>
                                </button>
                                <div id="{{ $overflowId }}" class="ui-pagination-overflow-menu" role="menu" data-ui-pagination-overflow-menu hidden>
                                    @foreach ($overflowPages as $page)
                                        <a
                                            href="{{ $hrefFor($page) }}"
                                            class="ui-pagination-overflow-item"
                                            role="menuitem"
                                            data-ui-pagination-overflow-page="{{ $page }}"
                                        >
                                            Page {{ $page }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ol>

            <a
                href="{{ $hrefFor($nextPage) }}"
                aria-label="Next page"
                @class(['ui-pagination-control', 'ui-pagination-control-icon', 'is-disabled' => $isDisabled || ! $hasNext])
                @if($isDisabled || ! $hasNext) aria-disabled="true" tabindex="-1" @endif
                data-ui-pagination-next
            >
                <x-heroicon-o-chevron-right class="ui-pagination-icon" aria-hidden="true" />
            </a>
        </div>
    @endif
</nav>
