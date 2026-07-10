{{-- ==========================================================================
    File: resources/views/components/ui/contained-list/index.blade.php
    Purpose: Contained List component.

    Notes:
    - Emits the installed .ui-contained-list selector contract.
    - Renders an optional header, optional header action, list body, items,
      loading state, empty state, or custom slot rows.
    - Uses x-ui.contained-list-item for array-driven rows.
    - Uses x-ui.icon-button for the header action.
    ========================================================================== --}}

@props([
    'title' => null,
    'ariaLabel' => null,
    'labelledBy' => null,
    'description' => null,
    'items' => [],
    'variant' => 'on-page',
    'size' => 'md',
    'titleIcon' => null,
    'headerActionLabel' => null,
    'headerActionIcon' => 'search',
    'headerActionHref' => null,
    'headerActionTooltip' => null,
    'insetDividers' => false,
    'stickyHeader' => false,
    'loading' => false,
    'emptyTitle' => 'No items',
    'emptyDescription' => null,
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
        'on-page',
        'disclosed',
        'elevated',
    ];

    $allowedSizes = [
        'sm',
        'md',
        'lg',
        'xl',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedId = $attributes->get('id') ?: 'ui-contained-list-'.Str::uuid();

    $resolvedVariant = in_array($variant, $allowedVariants, true)
        ? $variant
        : 'on-page';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'md';

    $titleId = $resolvedId.'-title';

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $hasHeaderAction = filled($headerActionLabel);
    $hasHeader = filled($title) || filled($description) || $hasHeaderAction;

    $hasInsetDividers = filter_var($insetDividers, FILTER_VALIDATE_BOOLEAN);
    $hasStickyHeader = filter_var($stickyHeader, FILTER_VALIDATE_BOOLEAN);
    $isLoading = filter_var($loading, FILTER_VALIDATE_BOOLEAN);

    $normalizedItems = collect($items)->values();
    $hasItems = $normalizedItems->isNotEmpty();
    $hasSlotItems = trim($slot->toHtml()) !== '';

    /*
    |--------------------------------------------------------------------------
    | Accessible Naming
    |--------------------------------------------------------------------------
    */

    $resolvedAriaLabel = filled($ariaLabel) && blank($title) && blank($labelledBy)
        ? $ariaLabel
        : null;

    $resolvedLabelledBy = filled($labelledBy)
        ? $labelledBy
        : (filled($title) ? $titleId : null);

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $rootClasses = [
        'ui-contained-list',
        'ui-contained-list--'.$resolvedVariant,
        'ui-contained-list--'.$resolvedSize,
        'ui-layout--size-'.$resolvedSize,
        'ui-contained-list-inset-dividers' => $hasInsetDividers,
        'ui-contained-list--loading' => $isLoading,
        'ui-contained-list--empty' => ! $isLoading && ! $hasItems && ! $hasSlotItems,
    ];
@endphp

<section
    {{ $attributes->class($rootClasses)->merge([
        'id' => $resolvedId,
        'data-ui-component' => 'contained-list',
        'data-ui-contained-list' => true,
        'data-ui-contained-list-variant' => $resolvedVariant,
        'data-ui-contained-list-size' => $resolvedSize,
        'data-ui-contained-list-inset-dividers' => $hasInsetDividers ? 'true' : 'false',
        'data-ui-contained-list-sticky-header' => $hasStickyHeader ? 'true' : 'false',
        'data-ui-contained-list-loading' => $isLoading ? 'true' : 'false',
        'data-ui-contained-list-item-count' => $normalizedItems->count(),
        'aria-label' => $resolvedAriaLabel,
        'aria-labelledby' => $resolvedLabelledBy,
        'aria-busy' => $isLoading ? 'true' : null,
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Header
        ---------------------------------------------------------------------- --}}

    @if ($hasHeader)
        <header @class(['ui-contained-list-header', 'ui-contained-list-header-sticky' => $hasStickyHeader])>
            <span class="ui-contained-list-header-content">
                @if (filled($title))
                    <h3 id="{{ $titleId }}" class="ui-contained-list-title">
                        @if ($titleIcon)
                            <x-ui.icon
                                :name="$titleIcon"
                                class="ui-contained-list-title-icon"
                                aria-hidden="true"
                            />
                        @endif

                        <span>
                            @if ($title instanceof HtmlString)
                                {!! $title !!}
                            @else
                                {{ $title }}
                            @endif
                        </span>
                    </h3>
                @endif

                @if (filled($description))
                    <p class="ui-contained-list-description">
                        @if ($description instanceof HtmlString)
                            {!! $description !!}
                        @else
                            {{ $description }}
                        @endif
                    </p>
                @endif
            </span>

            @if ($hasHeaderAction)
                <span class="ui-contained-list-header-actions">
                    <x-ui.icon-button
                        :href="$headerActionHref"
                        :icon="$headerActionIcon"
                        :label="$headerActionLabel"
                        :tooltip="$headerActionTooltip ?? $headerActionLabel"
                        tooltip-placement="auto"
                        size="sm"
                        semantic="ghost"
                    />
                </span>
            @endif
        </header>
    @endif

    {{-- ----------------------------------------------------------------------
        Body
        ---------------------------------------------------------------------- --}}

    <ul
        class="ui-contained-list-body"
        data-ui-contained-list-body
        role="list"
        @if (filled($resolvedLabelledBy)) aria-labelledby="{{ $resolvedLabelledBy }}" @endif
    >
        @if ($isLoading)
            <li class="ui-contained-list-state" data-ui-contained-list-loading>
                Loading list items
            </li>
        @elseif ($hasItems)
            @foreach ($normalizedItems as $item)
                <x-ui.contained-list-item
                    :title="data_get($item, 'title')"
                    :description="data_get($item, 'description')"
                    :meta="data_get($item, 'meta')"
                    :href="data_get($item, 'href')"
                    :icon="data_get($item, 'icon')"
                    :status="data_get($item, 'status')"
                    :action-items="data_get($item, 'actions', [])"
                    :selected="filter_var(data_get($item, 'selected', false), FILTER_VALIDATE_BOOLEAN)"
                    :current="filter_var(data_get($item, 'current', false), FILTER_VALIDATE_BOOLEAN)"
                    :disabled="filter_var(data_get($item, 'disabled', false), FILTER_VALIDATE_BOOLEAN)"
                />
            @endforeach
        @elseif ($hasSlotItems)
            {{ $slot }}
        @else
            <li class="ui-contained-list-state" data-ui-contained-list-empty>
                <p class="ui-contained-list-state-title">{{ $emptyTitle }}</p>

                @if (filled($emptyDescription))
                    <p class="ui-contained-list-state-description">
                        @if ($emptyDescription instanceof HtmlString)
                            {!! $emptyDescription !!}
                        @else
                            {{ $emptyDescription }}
                        @endif
                    </p>
                @endif
            </li>
        @endif
    </ul>
</section>