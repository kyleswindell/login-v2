{{-- ==========================================================================
    File: resources/views/components/patterns/account/panel/index.blade.php
    Purpose: Account panel pattern.

    Notes:
    - Owns repeated account tab-panel section anatomy.
    - Provides a consistent heading, description, optional actions, and body
      spacing for account page panels.
    - Designed for content rendered inside x-ui.tabs panels.
    - Does not own tabs, route navigation, modals, persistence, validation, or
      field-level APIs.
    ========================================================================== --}}

@props ([
    "title" => null,
    "description" => null,
    "titleId" => null,
    "compact" => false,
    "bordered" => true,
])

@php
    /*
     *--------------------------------------------------------------------------
     * Panel state
     *--------------------------------------------------------------------------
     */

    $resolvedTitleId = filled($titleId)
        ? $titleId
        : "account-panel-title-".\Illuminate\Support\Str::uuid();

    $isCompact = filter_var($compact, FILTER_VALIDATE_BOOLEAN);
    $isBordered = filter_var($bordered, FILTER_VALIDATE_BOOLEAN);

    $hasActions = isset($actions) && trim($actions->toHtml()) !== "";
    $hasDescription = filled($description);

    /*
     *--------------------------------------------------------------------------
     * CSS class contract
     *--------------------------------------------------------------------------
     */

    $rootClasses = [
        "ui-account-panel",
        "ui-account-panel--compact" => $isCompact,
        "ui-account-panel--bordered" => $isBordered,
    ];

    $headerClasses = [
        "ui-account-panel__header",
    ];

    $bodyClasses = [
        "ui-account-panel__body",
    ];

    $actionClasses = [
        "ui-account-panel__actions",
    ];
@endphp

<section
    {{
        $attributes->class($rootClasses)->merge([
            "aria-labelledby" => $resolvedTitleId,
            "data-ui-pattern" => "account.panel",
            "data-account-panel" => "true",
        ])
    }}
>
    <header @class ($headerClasses)>
        <div class="ui-account-panel__heading">
            <h2 id="{{ $resolvedTitleId }}" class="ui-card-title">
                {{ $title }}
            </h2>

            @if ($hasDescription)
                <p class="ui-card-copy ui-account-panel__description">
                    @if ($description instanceof \Illuminate\Support\HtmlString)
                        {!! $description->toHtml() !!}
                    @else
                        {{ $description }}
                    @endif
                </p>
            @endif
        </div>

        @if ($hasActions)
            <div @class ($actionClasses)>{{ $actions }}</div>
        @endif
    </header>

    <div @class ($bodyClasses)>{{ $slot }}</div>
</section>
