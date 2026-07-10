{{-- ==========================================================================
    File: resources/views/components/ui/data-table/container.blade.php
    Purpose: Data Table outer container, title, and description wrapper.

    Notes:
    - Owns the data-table region surface and optional header copy.
    - Does not render table rows or cells directly.
    - Uses the installed ui-data-table-container class contract.
    ========================================================================== --}}

@props([
    'title' => null,
    'description' => null,
    'titleId' => null,
    'descriptionId' => null,
    'stickyHeader' => false,
    'useStaticWidth' => false,
    'aiEnabled' => false,
])

<section
    {{ $attributes->class([
        'ui-data-table-container',
        'ui-data-table--max-width' => $stickyHeader,
        'ui-data-table-container--static' => $useStaticWidth,
        'ui-data-table-container--ai-enabled' => $aiEnabled,
    ]) }}
    data-ui-component="data-table"
>
    @if ($title || $description)
        <div class="ui-data-table-header">
            <div class="ui-data-table-header__content">
                @if ($title)
                    <h3
                        id="{{ $titleId }}"
                        class="ui-data-table-header__title ui-data-table-header-title"
                    >
                        {{ $title }}
                    </h3>
                @endif

                @if ($description)
                    <p
                        id="{{ $descriptionId }}"
                        class="ui-data-table-header__description ui-data-table-header-description"
                    >
                        {{ $description }}
                    </p>
                @endif
            </div>
        </div>
    @endif

    {{ $slot }}
</section>
