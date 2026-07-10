{{-- ==========================================================================
    File: resources/views/components/shell/content/index.blade.php
    Purpose: UI shell content container.

    Source: Converted from the UI shell Content React component.

    Notes:
    - Renders the base UI shell content container.
    - Defaults to a main element so skip-to-content can target the primary page
      content landmark.
    - Supports a constrained custom tag name through the tag prop.
    - Optionally composes a shell page header and page tabs before the content
      body.
    - Renders page body content inside ui-shell-content__body so shell spacing,
      header, tabs, breadcrumbs, and body composition remain consistent.
    - Does not own app grid behavior directly. Grid-enabled app layouts may
      render a ui-css-grid wrapper inside the default slot.
    ========================================================================== --}}

@props ([
    "tag" => "main",
    "pageTitle" => null,
    "pageSubtitle" => null,
    "headingTag" => "h1",
    "breadcrumbs" => [],
    "tabItems" => [],
    "tabsLabel" => null,
    "reservePageTabs" => true,
])

@php
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedTags = [
        'main',
        'div',
        'section',
        'article',
    ];

    $allowedHeadingTags = [
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Root Element
    |--------------------------------------------------------------------------
    */

    $resolvedTag = is_string($tag) && in_array($tag, $allowedTags, true)
        ? $tag
        : 'main';

    /*
    |--------------------------------------------------------------------------
    | Resolve Heading Element
    |--------------------------------------------------------------------------
    */

    $resolvedHeadingTag = is_string($headingTag) && in_array($headingTag, $allowedHeadingTags, true)
        ? $headingTag
        : 'h1';

    /*
    |--------------------------------------------------------------------------
    | Resolve Page Tabs State
    |--------------------------------------------------------------------------
    */

    $hasPageTabsSlot = isset($pageTabs)
        && trim((string) $pageTabs) !== '';

    $hasTabItems = collect($tabItems)->filter()->isNotEmpty();

    $hasPageTabs = $hasPageTabsSlot || $hasTabItems;

    $pageTabsSource = $hasPageTabs
        ? ($hasPageTabsSlot ? 'slot' : 'items')
        : 'none';

    $pageTitleText = $pageTitle instanceof HtmlString
        ? trim(strip_tags((string) $pageTitle))
        : trim((string) $pageTitle);

    $resolvedTabsLabel = $tabsLabel
        ?? (filled($pageTitleText) ? "{$pageTitleText} sections" : 'Page sections');

    /*
    |--------------------------------------------------------------------------
    | Resolve Page Header State
    |--------------------------------------------------------------------------
    */

    $hasPageHeaderSlot = isset($pageHeader)
        && trim((string) $pageHeader) !== '';

    $hasHeaderBreadcrumbsSlot = isset($headerBreadcrumbs)
        && trim((string) $headerBreadcrumbs) !== '';

    $hasPageActionsSlot = isset($pageActions)
        && trim((string) $pageActions) !== '';

    $hasBreadcrumbItems = collect($breadcrumbs)->filter()->isNotEmpty();

    $hasPageHeader = $hasPageHeaderSlot
        || filled($pageTitle)
        || filled($pageSubtitle)
        || $hasHeaderBreadcrumbsSlot
        || $hasBreadcrumbItems
        || $hasPageActionsSlot
        || $hasPageTabs;

    $pageHeaderSource = $hasPageHeader
        ? ($hasPageHeaderSlot ? 'slot' : 'props')
        : 'none';

    $reservesPageTabs = filter_var($reservePageTabs, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | Resolve Body State
    |--------------------------------------------------------------------------
    */

    $hasBodyContent = trim((string) $slot) !== '';

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-shell-content',
        'ui-shell-content--with-page-header' => $hasPageHeader,
        'ui-shell-content--with-page-tabs' => $hasPageTabs,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | tag is owned by the component and should not render as a raw attribute.
    |
    */

    $contentAttributes = $attributes->except([
        'tag',
    ]);
@endphp

<{{ $resolvedTag }}
    {{
        $contentAttributes
            ->class($classes)
            ->merge([
                "data-ui-component" => "shell-content",
                "data-ui-shell-content" => true,
                "data-ui-shell-content-tag" => $resolvedTag,
                "data-ui-shell-content-page-header" => $hasPageHeader
                    ? "true"
                    : "false",
                "data-ui-shell-content-page-header-source" => $pageHeaderSource,
                "data-ui-shell-content-page-tabs" => $hasPageTabs ? "true" : "false",
                "data-ui-shell-content-page-tabs-source" => $pageTabsSource,
                "data-ui-shell-content-reserve-page-tabs" => $reservesPageTabs ? "true" : "false",
                "data-ui-shell-content-body" => $hasBodyContent ? "true" : "false",
            ])
    }}
>
    @if ($hasPageHeaderSlot)
        {{-- ------------------------------------------------------------------
            Custom page header
            ------------------------------------------------------------------ --}}
        {{ $pageHeader }}
    @elseif ($hasPageHeader)
        {{-- ------------------------------------------------------------------
            Composed page header
            ------------------------------------------------------------------ --}}
        <x-shell.page-header
            :title="$pageTitle"
            :subtitle="$pageSubtitle"
            :heading-tag="$resolvedHeadingTag"
            :breadcrumb-items="$breadcrumbs"
            :tab-items="$tabItems"
            :tab-label="$resolvedTabsLabel"
            :reserve-tabs="$reservesPageTabs"
        >
            @if ($hasHeaderBreadcrumbsSlot)
                <x-slot:breadcrumbs>
                    {{ $headerBreadcrumbs }}
                </x-slot:breadcrumbs>
            @endif

            @if ($hasPageTabsSlot)
                <x-slot:tabs>
                    {{ $pageTabs }}
                </x-slot:tabs>
            @endif

            @if ($hasPageActionsSlot)
                <x-slot:actions>
                    {{ $pageActions }}
                </x-slot:actions>
            @endif
        </x-shell.page-header>
    @endif

    @if ($hasPageHeaderSlot && $hasPageTabsSlot)
        {{-- ------------------------------------------------------------------
            Custom page tabs
            ------------------------------------------------------------------ --}}
        {{ $pageTabs }}
    @elseif ($hasPageHeaderSlot && $hasPageTabs)
        {{-- ------------------------------------------------------------------
            Composed page tabs
            ------------------------------------------------------------------ --}}
        <x-shell.page-tabs :items="$tabItems" :label="$resolvedTabsLabel" />
    @endif

    {{-- ----------------------------------------------------------------------
        Content body
        ----------------------------------------------------------------------
        Main page content is rendered inside the body wrapper so shell spacing
        and page-header/page-tabs composition remain consistent.

        When x-app-layout grid is enabled, the default slot may contain the
        app-owned ui-css-grid wrapper. Direct children of that grid wrapper
        should be ui-css-grid-column elements.
        ---------------------------------------------------------------------- --}}
    <div class="ui-shell-content__body" data-ui-shell-content-body-region>
        {{ $slot }}
    </div>
</{{ $resolvedTag }}>
