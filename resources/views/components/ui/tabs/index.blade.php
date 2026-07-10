{{-- ==========================================================================
    File: resources/views/components/ui/tabs/index.blade.php
    Purpose: Array-driven Tabs component.

    Notes:
    - Emits the installed .ui-tabs selector contract.
    - Renders a tablist, tab buttons, and associated tab panels from an array API.
    - Supports line and contained variants, horizontal and vertical orientation,
      automatic/manual activation markers, scrollable treatment, grid-aware
      treatment, full-width treatment, disabled tabs, icon tabs, secondary
      labels, and dismissible tab markers.
    - This Blade component does not expose the full Carbon composable
      Tabs/TabList/Tab/TabPanel family. It owns one array-driven surface.
    - Unlike Carbon React, this component uses .ui-tabs as the whole tabs shell,
      not only the tablist wrapper.
    - Tab selection and keyboard behavior should be handled by installed tabs
      JavaScript when dynamic behavior is needed.
    ========================================================================== --}}

@props ([
    "id" => null,
    "label" => "Tabs",
    "tabs" => [],
    "variant" => "line",
    "contained" => null,
    "orientation" => "horizontal",
    "activation" => "automatic",
    "scrollable" => false,
    "gridAware" => false,
    "fullWidth" => false,
    "selectedIndex" => null,
    "defaultSelectedIndex" => 0,
    "dismissible" => false,
    "dismissable" => null,
    "size" => null,
    "height" => null,
])

@php
    use Illuminate\Support\HtmlString;
    use Illuminate\Support\Str;

    /*
     *--------------------------------------------------------------------------
     * Supported public values
     *--------------------------------------------------------------------------
     */

    $allowedVariants = [
        "line",
        "contained",
    ];

    $allowedOrientations = [
        "horizontal",
        "vertical",
    ];

    $allowedActivations = [
        "automatic",
        "manual",
    ];

    $allowedSizes = [
        "sm",
        "md",
        "lg",
    ];

    /*
     *--------------------------------------------------------------------------
     * Resolve values
     *--------------------------------------------------------------------------
     */

    $resolvedVariant = ! is_null($contained)
        ? (filter_var($contained, FILTER_VALIDATE_BOOLEAN) ? "contained" : "line")
        : (in_array($variant, $allowedVariants, true) ? $variant : "line");

    $resolvedOrientation = in_array($orientation, $allowedOrientations, true)
        ? $orientation
        : "horizontal";

    $resolvedActivation = in_array($activation, $allowedActivations, true)
        ? $activation
        : "automatic";

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : null;

    $idBase = $id ?? $attributes->get("id") ?? "ui-tabs-".Str::uuid();

    /*
     *--------------------------------------------------------------------------
     * Render state
     *--------------------------------------------------------------------------
     */

    $isScrollable = filter_var($scrollable, FILTER_VALIDATE_BOOLEAN);

    $isGridAware = filter_var($gridAware, FILTER_VALIDATE_BOOLEAN)
        && $resolvedVariant === "contained";

    $isFullWidth = filter_var($fullWidth, FILTER_VALIDATE_BOOLEAN)
        && $resolvedVariant === "contained";

    $isGloballyDismissible = ! is_null($dismissable)
        ? filter_var($dismissable, FILTER_VALIDATE_BOOLEAN)
        : filter_var($dismissible, FILTER_VALIDATE_BOOLEAN);

    /*
     *--------------------------------------------------------------------------
     * Height style handling
     *--------------------------------------------------------------------------
     */

    $resolvedHeight = is_string($height) && preg_match('/^[0-9.]+(px|rem|em|vh|vw|%)$/', $height) === 1
        ? $height
        : null;

    $existingStyle = trim((string) $attributes->get("style"));

    $heightStyle = $resolvedOrientation === "vertical" && filled($resolvedHeight)
        ? "height: ".$resolvedHeight.";"
        : null;

    $resolvedStyle = trim(collect([
        $existingStyle,
        $heightStyle,
    ])->filter()->implode(" "));

    /*
     *--------------------------------------------------------------------------
     * Normalize tabs
     *--------------------------------------------------------------------------
     */

    $normalizedTabs = collect($tabs)
        ->map(function ($tab, int $index) use ($idBase, $isGloballyDismissible) {
            $tabData = is_array($tab)
                ? $tab
                : [
                    "label" => $tab,
                    "panel" => null,
                ];

            $label = data_get($tabData, "label", "Tab ".($index + 1));

            $dismissible = array_key_exists("dismissible", $tabData)
                ? filter_var(data_get($tabData, "dismissible"), FILTER_VALIDATE_BOOLEAN)
                : filter_var(data_get($tabData, "dismissable", $isGloballyDismissible), FILTER_VALIDATE_BOOLEAN);

            return [
                "id" => data_get($tabData, "id", $idBase."-tab-".$index),
                "panel_id" => data_get($tabData, "panel_id", data_get($tabData, "panelId", $idBase."-panel-".$index)),
                "label" => $label,
                "panel_title" => data_get($tabData, "panel_title", data_get($tabData, "panelTitle", null)),
                "panel" => data_get($tabData, "panel", data_get($tabData, "content", "")),
                "selected" => filter_var(data_get($tabData, "selected", false), FILTER_VALIDATE_BOOLEAN),
                "disabled" => filter_var(data_get($tabData, "disabled", false), FILTER_VALIDATE_BOOLEAN),
                "icon" => data_get($tabData, "icon"),
                "icon_only" => filter_var(data_get($tabData, "icon_only", data_get($tabData, "iconOnly", false)), FILTER_VALIDATE_BOOLEAN),
                "secondary" => data_get($tabData, "secondary", data_get($tabData, "secondaryLabel")),
                "dismissible" => $dismissible,
                "dismiss_label" => data_get($tabData, "dismiss_label", data_get($tabData, "dismissLabel", "Dismiss ".$label." tab")),
            ];
        })
        ->values();

    /*
     *--------------------------------------------------------------------------
     * Resolve selected tab
     *--------------------------------------------------------------------------
     */

    if ($normalizedTabs->isNotEmpty()) {
        if (is_numeric($selectedIndex)) {
            $selectedIndex = max(0, min((int) $selectedIndex, $normalizedTabs->count() - 1));
        } else {
            $selectedSearchResult = $normalizedTabs->search(fn ($tab) => $tab["selected"]);

            $selectedIndex = $selectedSearchResult === false
                ? (is_numeric($defaultSelectedIndex) ? (int) $defaultSelectedIndex : 0)
                : (int) $selectedSearchResult;

            $selectedIndex = max(0, min($selectedIndex, $normalizedTabs->count() - 1));
        }

        if (filter_var(data_get($normalizedTabs->get($selectedIndex), "disabled", false), FILTER_VALIDATE_BOOLEAN)) {
            $firstEnabledIndex = $normalizedTabs->search(fn ($tab) => ! $tab["disabled"]);
            $selectedIndex = $firstEnabledIndex === false ? 0 : (int) $firstEnabledIndex;
        }
    } else {
        $selectedIndex = 0;
    }

    /*
     *--------------------------------------------------------------------------
     * CSS class contract
     *--------------------------------------------------------------------------
     */

    $classes = [
        "ui-tabs",
        "ui-tabs-contained" => $resolvedVariant === "contained",
        "ui-tabs-vertical" => $resolvedOrientation === "vertical",
        "ui-tabs-scrollable" => $isScrollable,
        "ui-tabs-grid-aware" => $isGridAware,
        "ui-tabs-full-width" => $isFullWidth,
        "ui-tabs-dismissible" => $isGloballyDismissible,
        "ui-layout--size-".$resolvedSize => filled($resolvedSize),
    ];

    /*
     *--------------------------------------------------------------------------
     * Attribute handling
     *--------------------------------------------------------------------------
     */

    $tabsAttributes = $attributes->except([
        "id",
        "style",
    ]);

    /*
     *--------------------------------------------------------------------------
     * Trusted content helper
     *--------------------------------------------------------------------------
     */

    $renderTrustedContent = function ($content): string {
        if ($content instanceof HtmlString) {
            return $content->toHtml();
        }

        if (is_object($content) && method_exists($content, "toHtml")) {
            return $content->toHtml();
        }

        return e((string) $content);
    };
@endphp

<div
    id="{{ $idBase }}"
    {{
        $tabsAttributes->class($classes)->merge([
            "data-ui-component" => "tabs",
            "data-ui-tabs" => "true",
            "data-ui-tabs-variant" => $resolvedVariant,
            "data-ui-tabs-orientation" => $resolvedOrientation,
            "data-ui-tabs-activation" => $resolvedActivation,
            "data-ui-tabs-selected-index" => $selectedIndex,
            "data-ui-tabs-scrollable" => $isScrollable ? "true" : "false",
            "data-ui-tabs-grid-aware" => $isGridAware ? "true" : "false",
            "data-ui-tabs-full-width" => $isFullWidth ? "true" : "false",
            "data-ui-tabs-dismissible" => $isGloballyDismissible ? "true" : "false",
            "data-ui-tabs-size" => $resolvedSize,
        ])
    }}
    @if ($resolvedStyle !== "") style="{{ $resolvedStyle }}" @endif
>
    {{-- ----------------------------------------------------------------------
        Tab list
        ---------------------------------------------------------------------- --}}

    <div
        class="ui-tabs-list"
        role="tablist"
        aria-label="{{ $label }}"
        aria-orientation="{{ $resolvedOrientation }}"
        data-ui-tabs-list
    >
        @foreach ($normalizedTabs as $index => $tab)
            @php
                $selected = (int) $index === (int) $selectedIndex;
                $disabled = filter_var($tab["disabled"], FILTER_VALIDATE_BOOLEAN);
                $tabHasIcon = filled($tab["icon"]);
            @endphp

            <button
                id="{{ $tab['id'] }}"
                type="button"
                @class ([
                    "ui-tabs-tab",
                    "ui-tabs__nav-item",
                    "ui-tabs__nav-link",
                    "ui-tabs-tab-selected" => $selected,
                    "ui-tabs__nav-item--selected" => $selected,
                    "ui-tabs-tab-disabled" => $disabled,
                    "ui-tabs__nav-item--disabled" => $disabled,
                    "ui-tabs-tab-icon-only" => $tab["icon_only"],
                    "ui-tabs-tab-dismissible" => $tab["dismissible"]
                ])
                role="tab"
                aria-selected="{{ $selected ? 'true' : 'false' }}"
                aria-controls="{{ $tab['panel_id'] }}"
                tabindex="{{ $selected ? '0' : '-1' }}"
                aria-disabled="{{ $disabled ? 'true' : 'false' }}"
                @disabled ($disabled)
                data-ui-tabs-tab
                data-ui-tabs-tab-index="{{ $index }}"
                data-ui-tabs-tab-selected="{{ $selected ? 'true' : 'false' }}"
                data-ui-tabs-tab-disabled="{{ $disabled ? 'true' : 'false' }}"
                @if ($tab["dismissible"]) data-ui-tabs-dismissible="true" @endif
            >
                @if ($tabHasIcon)
                    <span class="ui-tabs-tab-icon" aria-hidden="true">
                        @if ($tab["icon"] instanceof HtmlString)
                            {!! $tab["icon"] !!}
                        @else
                            <x-ui.icon :name="$tab['icon']" />
                        @endif
                    </span>
                @endif

                @if (!$tab["icon_only"])
                    <span class="ui-tabs-tab-label ui-tabs__nav-item-label">
                        {!!
                            $renderTrustedContent(
                                $tab["label"],
                            )
                        !!}
                    </span>
                @else
                    <span class="ui-visually-hidden sr-only">
                        {{ $tab["label"] }}
                    </span>
                @endif

                @if (filled($tab["secondary"]))
                    <span
                        class="ui-tabs-tab-secondary ui-tabs__nav-item-secondary-label"
                    >
                        {!!
                            $renderTrustedContent(
                                $tab["secondary"],
                            )
                        !!}
                    </span>
                @endif

                @if ($tab["dismissible"])
                    <span
                        class="ui-tabs-tab-dismiss"
                        aria-hidden="true"
                        title="{{ $tab['dismiss_label'] }}"
                        data-ui-tabs-dismiss
                        data-ui-tabs-dismiss-label="{{ $tab['dismiss_label'] }}"
                    >
                        <x-ui.icon name="close" aria-hidden="true" />
                    </span>
                @endif
            </button>
        @endforeach
    </div>

    {{-- ----------------------------------------------------------------------
        Tab panels
        ---------------------------------------------------------------------- --}}

    <div class="ui-tabs-panels" data-ui-tabs-panels>
        @foreach ($normalizedTabs as $index => $tab)
            @php
                $selected = (int) $index === (int) $selectedIndex;
            @endphp

            <div
                id="{{ $tab['panel_id'] }}"
                @class ([
                    "ui-tabs-panel",
                    "ui-tab-content",
                    "ui-tabs-panel-selected" => $selected
                ])
                role="tabpanel"
                aria-labelledby="{{ $tab['id'] }}"
                aria-hidden="{{ $selected ? 'false' : 'true' }}"
                data-ui-tabs-panel
                data-ui-tabs-panel-index="{{ $index }}"
                data-ui-tabs-panel-selected="{{ $selected ? 'true' : 'false' }}"
                @if (!$selected) hidden @endif
            >
                @if (filled($tab["panel_title"]))
                    <h4 class="ui-tabs-panel-title">
                        {!!
                            $renderTrustedContent(
                                $tab["panel_title"],
                            )
                        !!}
                    </h4>
                @endif

                @if ($tab["panel"] instanceof HtmlString ||
                    (is_object($tab["panel"]) &&
                        method_exists($tab["panel"], "toHtml")))
                    {!!
                        $renderTrustedContent(
                            $tab["panel"],
                        )
                    !!}
                @elseif (filled($tab["panel"]))
                    <p>{{ $tab["panel"] }}</p>
                @endif
            </div>
        @endforeach
    </div>
</div>
