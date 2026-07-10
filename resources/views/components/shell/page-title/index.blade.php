{{-- ==========================================================================
    File: resources/views/components/shell/page-title/index.blade.php
    Purpose: UI shell page title.

    Notes:
    - Renders optional breadcrumbs, optional page title, optional page subtitle,
      optional page actions, and optional supporting title content.
    - Breadcrumbs may be supplied as an items array or through the breadcrumbs
      named slot.
    - Breadcrumbs rendered here are page-title navigation links, not in-page
      tab panels.
    - Keep this component structural. Page-specific actions should be supplied
      through the actions slot.
    ========================================================================== --}}

@props([
    'title' => null,
    'subtitle' => null,
    'headingTag' => 'h1',
    'items' => [],
    'breadcrumbLabel' => 'Breadcrumb',
])

@php
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

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
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedHeadingTag = in_array($headingTag, $allowedHeadingTags, true)
        ? $headingTag
        : 'h1';

    $resolvedBreadcrumbLabel = filled($breadcrumbLabel)
        ? $breadcrumbLabel
        : 'Breadcrumb';

    /*
    |--------------------------------------------------------------------------
    | Normalize Breadcrumb Items
    |--------------------------------------------------------------------------
    */

    $breadcrumbItems = collect($items)->map(function ($item) {
        return [
            'label' => data_get($item, 'label'),
            'href' => data_get($item, 'href'),
            'current' => data_get($item, 'current'),
            'wireNavigate' => (bool) data_get($item, 'wireNavigate', false),
        ];
    })->filter(fn ($item) => filled($item['label']))->values();

    /*
    |--------------------------------------------------------------------------
    | Resolve Render State
    |--------------------------------------------------------------------------
    */

    $hasBreadcrumbSlot = isset($breadcrumbs)
        && trim((string) $breadcrumbs) !== '';

    $hasBreadcrumbs = $hasBreadcrumbSlot || $breadcrumbItems->isNotEmpty();
    $hasTitle = filled($title);
    $hasSubtitle = filled($subtitle);
    $hasActions = isset($actions) && trim((string) $actions) !== '';
    $hasContent = trim((string) $slot) !== '';
    $hasText = $hasTitle || $hasSubtitle;
@endphp

<div
    {{ $attributes->class('ui-shell-page-title')->merge([
        'data-ui-component' => 'shell-page-title',
        'data-ui-shell-page-title' => true,
        'data-ui-shell-page-title-heading-tag' => $resolvedHeadingTag,
        'data-ui-shell-page-title-breadcrumbs' => $hasBreadcrumbs ? 'true' : 'false',
        'data-ui-shell-page-title-breadcrumb-source' => $hasBreadcrumbs ? ($hasBreadcrumbSlot ? 'slot' : 'items') : 'none',
        'data-ui-shell-page-title-breadcrumb-count' => $breadcrumbItems->count(),
        'data-ui-shell-page-title-title' => $hasTitle ? 'true' : 'false',
        'data-ui-shell-page-title-subtitle' => $hasSubtitle ? 'true' : 'false',
        'data-ui-shell-page-title-actions' => $hasActions ? 'true' : 'false',
        'data-ui-shell-page-title-content' => $hasContent ? 'true' : 'false',
    ]) }}
>
    @if ($hasBreadcrumbs)
        {{-- ------------------------------------------------------------------
            Breadcrumbs
            ------------------------------------------------------------------
            Breadcrumbs may be caller-rendered through the breadcrumbs slot or
            generated from the items array.
            ------------------------------------------------------------------ --}}

        <nav
            class="ui-shell-page-title__breadcrumbs"
            aria-label="{{ $resolvedBreadcrumbLabel }}"
            data-ui-shell-page-title-breadcrumbs-region
        >
            @if ($hasBreadcrumbSlot)
                {{ $breadcrumbs }}
            @else
                <ol class="ui-shell-page-title__breadcrumb-list">
                    @foreach ($breadcrumbItems as $item)
                        @php
                            $label = $item['label'];
                            $href = $item['href'];
                            $current = is_null($item['current'])
                                ? $loop->last
                                : (bool) $item['current'];
                        @endphp

                        <li
                            class="ui-shell-page-title__breadcrumb-item"
                            data-ui-shell-page-title-breadcrumb-item
                            @if ($current) data-ui-shell-page-title-breadcrumb-current="true" @endif
                        >
                            @if ($href && ! $current)
                                <a
                                    href="{{ $href }}"
                                    class="ui-shell-page-title__breadcrumb-link"
                                    @if ($item['wireNavigate']) wire:navigate @endif
                                    data-ui-shell-page-title-breadcrumb-link
                                >
                                    @if ($label instanceof HtmlString)
                                        {!! $label !!}
                                    @else
                                        {{ $label }}
                                    @endif
                                </a>
                            @else
                                <span
                                    class="ui-shell-page-title__breadcrumb-current"
                                    @if ($current) aria-current="page" @endif
                                    data-ui-shell-page-title-breadcrumb-current-label
                                >
                                    @if ($label instanceof HtmlString)
                                        {!! $label !!}
                                    @else
                                        {{ $label }}
                                    @endif
                                </span>
                            @endif
                        </li>
                    @endforeach
                </ol>
            @endif
        </nav>
    @endif

    @if ($hasText || $hasActions)
        <div
            class="ui-shell-page-title__row"
            data-ui-shell-page-title-row
        >
            @if ($hasText)
                <div
                    class="ui-shell-page-title__text"
                    data-ui-shell-page-title-text
                >
                    @if ($hasTitle)
                        {{-- --------------------------------------------------
                            Title
                            -------------------------------------------------- --}}

                        <{{ $resolvedHeadingTag }} class="ui-shell-page-title__title">
                            @if ($title instanceof HtmlString)
                                {!! $title !!}
                            @else
                                {{ $title }}
                            @endif
                        </{{ $resolvedHeadingTag }}>
                    @endif

                    @if ($hasSubtitle)
                        {{-- --------------------------------------------------
                            Subtitle
                            -------------------------------------------------- --}}

                        <p class="ui-shell-page-title__subtitle">
                            @if ($subtitle instanceof HtmlString)
                                {!! $subtitle !!}
                            @else
                                {{ $subtitle }}
                            @endif
                        </p>
                    @endif
                </div>
            @endif

            @if ($hasActions)
                <div
                    class="ui-shell-page-title__actions"
                    data-ui-shell-page-title-actions-region
                >
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif

    @if ($hasContent)
        {{-- ------------------------------------------------------------------
            Extra content
            ------------------------------------------------------------------
            Page-specific actions or supporting title content can be supplied
            through the default slot.
            ------------------------------------------------------------------ --}}

        <div class="ui-shell-page-title__content">
            {{ $slot }}
        </div>
    @endif
</div>
