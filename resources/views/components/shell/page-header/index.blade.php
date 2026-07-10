{{-- ==========================================================================
    File: resources/views/components/shell/page-header/index.blade.php
    Purpose: UI shell page header composition.

    Notes:
    - Composes x-shell.page-title and x-shell.page-tabs into the actual page
      content header used by shell views.
    - Reserves the page-tabs rail when requested so page content starts
      consistently across shell pages.
    - Does not render an empty nav landmark when tabs are absent.
    - Page title remains responsible for breadcrumbs, title, subtitle, and
      title-region actions.
    - Page tabs remains responsible only for route-style page navigation.
    ========================================================================== --}}

@props([
    'title' => null,
    'subtitle' => null,
    'headingTag' => 'h1',
    'breadcrumbItems' => [],
    'breadcrumbLabel' => 'Breadcrumb',
    'tabItems' => [],
    'tabLabel' => 'Page sections',
    'reserveTabs' => true,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Resolve Render State
    |--------------------------------------------------------------------------
    */

    $hasBreadcrumbSlot = isset($breadcrumbs)
        && trim((string) $breadcrumbs) !== '';

    $hasTabsSlot = isset($tabs)
        && trim((string) $tabs) !== '';

    $hasActionsSlot = isset($actions)
        && trim((string) $actions) !== '';

    $hasTitleSlot = trim((string) $slot) !== '';

    $normalizedBreadcrumbItems = is_iterable($breadcrumbItems)
        ? collect($breadcrumbItems)->values()
        : collect();

    $normalizedTabItems = is_iterable($tabItems)
        ? collect($tabItems)->values()
        : collect();

    $hasPageTitle = filled($title)
        || filled($subtitle)
        || $hasBreadcrumbSlot
        || $normalizedBreadcrumbItems->isNotEmpty()
        || $hasActionsSlot
        || $hasTitleSlot;

    $hasTabs = $hasTabsSlot || $normalizedTabItems->isNotEmpty();
    $reservesTabs = filter_var($reserveTabs, FILTER_VALIDATE_BOOLEAN);
@endphp

<header
    {{ $attributes->class('ui-shell-page-header')->merge([
        'data-ui-component' => 'shell-page-header',
        'data-ui-shell-page-header' => true,
        'data-ui-shell-page-header-title-region' => $hasPageTitle ? 'true' : 'false',
        'data-ui-shell-page-header-tabs' => $hasTabs ? 'true' : 'false',
        'data-ui-shell-page-header-reserve-tabs' => $reservesTabs ? 'true' : 'false',
        'data-ui-shell-page-header-actions' => $hasActionsSlot ? 'true' : 'false',
    ]) }}
>
    @if ($hasPageTitle)
        <div
            class="ui-shell-page-header__title-region"
            data-ui-shell-page-header-page-title
        >
            <x-shell.page-title
                :title="$title"
                :subtitle="$subtitle"
                :heading-tag="$headingTag"
                :items="$normalizedBreadcrumbItems->all()"
                :breadcrumb-label="$breadcrumbLabel"
            >
                @if ($hasBreadcrumbSlot)
                    <x-slot:breadcrumbs>
                        {{ $breadcrumbs }}
                    </x-slot:breadcrumbs>
                @endif

                @if ($hasActionsSlot)
                    <x-slot:actions>
                        {{ $actions }}
                    </x-slot:actions>
                @endif

                {{ $slot }}
            </x-shell.page-title>
        </div>
    @endif

    <div
        class="ui-shell-page-header__tabs-region"
        data-ui-shell-page-header-tabs-region
        data-ui-shell-page-header-tabs-region-visible="{{ $hasTabs ? 'true' : 'false' }}"
    >
        @if ($hasTabs)
            @if ($hasTabsSlot)
                <x-shell.page-tabs
                    :label="$tabLabel"
                    data-ui-shell-page-header-page-tabs
                >
                    {{ $tabs }}
                </x-shell.page-tabs>
            @else
                <x-shell.page-tabs
                    :items="$normalizedTabItems->all()"
                    :label="$tabLabel"
                    data-ui-shell-page-header-page-tabs
                />
            @endif
        @elseif ($reservesTabs)
            <div
                class="ui-shell-page-header__tabs-spacer"
                aria-hidden="true"
                data-ui-shell-page-header-tabs-spacer
            ></div>
        @endif
    </div>
</header>
