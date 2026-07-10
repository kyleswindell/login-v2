{{-- ==========================================================================
    File: resources/views/components/ui/pagination-nav/overflow.blade.php
    Purpose: UI pagination navigation overflow selector.

    Source: Converted from the Carbon PaginationNav PaginationOverflow helper.

    Notes:
    - Renders an overflow select when more than one hidden page exists.
    - Renders a normal page item when exactly one hidden page exists.
    - Provides a default overflow icon through x-ui.icon.
    ========================================================================== --}}

@props([
    'fromIndex' => null,
    'count' => null,
    'disableOverflow' => false,
    'itemLabel' => 'Page',
    'activeLabel' => 'Active',
])

@php
    /*
    |--------------------------------------------------------------------------
    | Normalize Values
    |--------------------------------------------------------------------------
    */

    $fromIndex = is_numeric($fromIndex) ? max((int) $fromIndex, 0) : 0;
    $count = is_numeric($count) ? max((int) $count, 0) : 0;

    $hasDisabledOverflow = filter_var($disableOverflow, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | Slot Detection
    |--------------------------------------------------------------------------
    */

    $hasIconSlot = isset($icon) && trim($icon->toHtml()) !== '';
@endphp

@if ($hasDisabledOverflow && $count > 1)
    <li
        class="ui-pagination-nav__list-item"
        data-ui-pagination-nav-list-item
        data-ui-pagination-nav-overflow-item
    >
        <div
            class="ui-pagination-nav__select"
            data-ui-pagination-nav-overflow-wrapper
        >
            <select
                class="ui-pagination-nav__page ui-pagination-nav__page--select"
                aria-label="Select {{ $itemLabel }} number"
                disabled
                data-ui-pagination-nav-overflow
                data-ui-pagination-nav-overflow-disabled="true"
                data-ui-pagination-nav-overflow-from-index="{{ $fromIndex }}"
                data-ui-pagination-nav-overflow-count="{{ $count }}"
            ></select>

            <div class="ui-pagination-nav__select-icon-wrapper">
                <span class="ui-pagination-nav__select-icon">
                    @if ($hasIconSlot)
                        {{ $icon }}
                    @else
                        <x-ui.icon name="overflow-menu--horizontal" aria-hidden="true" />
                    @endif
                </span>
            </div>
        </div>
    </li>
@elseif ($count > 1)
    <li
        class="ui-pagination-nav__list-item"
        data-ui-pagination-nav-list-item
        data-ui-pagination-nav-overflow-item
    >
        <div
            class="ui-pagination-nav__select"
            data-ui-pagination-nav-overflow-wrapper
        >
            <select
                class="ui-pagination-nav__page ui-pagination-nav__page--select"
                aria-label="Select {{ $itemLabel }} number"
                data-ui-pagination-nav-overflow
                data-ui-pagination-nav-overflow-disabled="false"
                data-ui-pagination-nav-overflow-from-index="{{ $fromIndex }}"
                data-ui-pagination-nav-overflow-count="{{ $count }}"
            >
                <option value="" hidden></option>

                @for ($i = 0; $i < $count; $i++)
                    <option
                        value="{{ $fromIndex + $i }}"
                        data-page="{{ $fromIndex + $i + 1 }}"
                    >
                        {{ $fromIndex + $i + 1 }}
                    </option>
                @endfor
            </select>

            <div class="ui-pagination-nav__select-icon-wrapper">
                <span class="ui-pagination-nav__select-icon">
                    @if ($hasIconSlot)
                        {{ $icon }}
                    @else
                        <x-ui.icon name="overflow-menu--horizontal" aria-hidden="true" />
                    @endif
                </span>
            </div>
        </div>
    </li>
@elseif ($count === 1)
    <x-ui.pagination-nav.item
        :page="$fromIndex + 1"
        :page-index="$fromIndex"
        :item-label="$itemLabel"
        :active-label="$activeLabel"
    />
@endif