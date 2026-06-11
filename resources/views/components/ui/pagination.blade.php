@props([
    'currentPage' => 1,
    'lastPage' => 1,
    'total' => null,
    'perPage' => null,
    'baseUrl' => '#',
    'variant' => 'full',
    'density' => 'standard',
    'pageSizeOptions' => [],
])

@php
    $current = max(1, (int) $currentPage);
    $last = max(1, (int) $lastPage);
    $variant = in_array($variant, ['full', 'compact'], true) ? $variant : 'full';
    $hrefFor = fn (int $page): string => $baseUrl === '#' ? '#' : $baseUrl.(str_contains($baseUrl, '?') ? '&' : '?').'page='.$page;
@endphp

<nav
    class="flex flex-wrap items-center justify-between gap-3"
    aria-label="Pagination"
    data-ui-component="pagination"
    data-ui-pagination-variant="{{ $variant }}"
    data-ui-pagination-density="{{ $density }}"
>
    <p class="text-sm" style="color: var(--ui-text-secondary);">
        Page <span class="font-semibold" style="color: var(--ui-text-primary);">{{ $current }}</span> of {{ $last }}
        @if ($total !== null)
            <span class="ml-2">({{ $total }} records)</span>
        @endif
    </p>

    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ $hrefFor(max(1, $current - 1)) }}" @class(['ui-pagination-control', 'is-disabled' => $current <= 1]) @if($current <= 1) aria-disabled="true" @endif>
            Previous
        </a>

        @if ($variant === 'full')
            @foreach (range(1, min($last, 5)) as $page)
                <a
                    href="{{ $hrefFor($page) }}"
                    @class(['ui-pagination-control', 'is-active' => $page === $current])
                    @if($page === $current) aria-current="page" @endif
                >
                    {{ $page }}
                </a>
            @endforeach
        @endif

        <a href="{{ $hrefFor(min($last, $current + 1)) }}" @class(['ui-pagination-control', 'is-disabled' => $current >= $last]) @if($current >= $last) aria-disabled="true" @endif>
            Next
        </a>
    </div>

    @if (! empty($pageSizeOptions))
        <label class="flex items-center gap-2 text-sm" style="color: var(--ui-text-secondary);">
            <span>Rows</span>
            <select class="ui-select ui-select-compact w-auto" data-ui-pagination-page-size>
                @foreach ($pageSizeOptions as $option)
                    <option value="{{ $option }}" @selected((int) $option === (int) $perPage)>{{ $option }}</option>
                @endforeach
            </select>
        </label>
    @endif
</nav>
