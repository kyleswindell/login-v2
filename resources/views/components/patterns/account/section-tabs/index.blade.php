{{-- ==========================================================================
    File: resources/views/components/patterns/account/section-tabs/index.blade.php
    Purpose: Account local section tabs pattern.

    Notes:
    - Owns repeated account-page local tab-panel composition.
    - Composes x-ui.tabs for in-page tab panels.
    - Does not own route/page navigation; that remains x-shell.page-tabs through
      the app layout page tabs.
    - Suppresses the tablist when only one panel is supplied by default.
    - Defaults to Carbon-style vertical contained tabs for account sections.
    ========================================================================== --}}

@props ([
    "id" => null,
    "label" => "Account sections",
    "panels" => [],
    "variant" => "contained",
    "orientation" => "vertical",
    "activation" => "automatic",
    "size" => "md",
    "height" => null,
    "selectedIndex" => null,
    "defaultSelectedIndex" => 0,
    "gridAware" => false,
    "scrollable" => false,
    "showSingleTab" => false,
])

@php
    /*
     *--------------------------------------------------------------------------
     * Resolve panels
     *--------------------------------------------------------------------------
     */

    $resolvedId = filled($id)
        ? $id
        : "account-section-tabs-".\Illuminate\Support\Str::uuid();

    $panelItems = collect(is_iterable($panels) ? $panels : [])
        ->filter(fn ($panel) => is_array($panel))
        ->values();

    $panelCount = $panelItems->count();

    /*
     *--------------------------------------------------------------------------
     * Resolve tab values
     *--------------------------------------------------------------------------
     */

    $allowedVariants = ["line", "contained"];
    $allowedOrientations = ["horizontal", "vertical"];
    $allowedActivations = ["automatic", "manual"];
    $allowedSizes = ["sm", "md", "lg"];

    $resolvedOrientation = in_array($orientation, $allowedOrientations, true)
        ? $orientation
        : "vertical";

    $resolvedVariant = in_array($variant, $allowedVariants, true)
        ? $variant
        : "contained";

    if ($resolvedOrientation === "vertical") {
        $resolvedVariant = "contained";
    }

    $resolvedActivation = in_array($activation, $allowedActivations, true)
        ? $activation
        : "automatic";

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : "md";

    $usesScrollable = filter_var($scrollable, FILTER_VALIDATE_BOOLEAN);

    $usesGridAware = filter_var($gridAware, FILTER_VALIDATE_BOOLEAN)
        && $resolvedVariant === "contained"
        && $resolvedOrientation === "horizontal";

    $rendersSingleTab = filter_var($showSingleTab, FILTER_VALIDATE_BOOLEAN);

    /*
     *--------------------------------------------------------------------------
     * Selected index
     *--------------------------------------------------------------------------
     */

    $requestedSelectedIndex = is_numeric($selectedIndex)
        ? (int) $selectedIndex
        : null;

    if (is_null($requestedSelectedIndex)) {
        $selectedPanelIndex = $panelItems->search(
            fn ($panel) => filter_var(data_get($panel, "selected", false), FILTER_VALIDATE_BOOLEAN)
        );

        $requestedSelectedIndex = $selectedPanelIndex === false
            ? (int) $defaultSelectedIndex
            : (int) $selectedPanelIndex;
    }

    $resolvedSelectedIndex = $panelCount > 0
        ? max(0, min($requestedSelectedIndex, $panelCount - 1))
        : 0;

    /*
     *--------------------------------------------------------------------------
     * Panel renderer
     *--------------------------------------------------------------------------
     */

    $renderPanel = function (array $panel): \Illuminate\Support\HtmlString {
        if (array_key_exists("panel", $panel)) {
            $content = data_get($panel, "panel");

            if ($content instanceof \Illuminate\Support\HtmlString) {
                return $content;
            }

            if (is_object($content) && method_exists($content, "toHtml")) {
                return new \Illuminate\Support\HtmlString($content->toHtml());
            }

            return new \Illuminate\Support\HtmlString((string) $content);
        }

        $view = data_get($panel, "view");
        $data = data_get($panel, "data", []);

        if (is_string($view) && $view !== "") {
            return new \Illuminate\Support\HtmlString(
                view($view, is_array($data) ? $data : [])->render()
            );
        }

        return new \Illuminate\Support\HtmlString("");
    };

    /*
     *--------------------------------------------------------------------------
     * Build x-ui.tabs array
     *--------------------------------------------------------------------------
     */

    $tabs = $panelItems
        ->map(function (array $panel, int $index) use ($resolvedId, $resolvedSelectedIndex, $renderPanel) {
            $label = (string) data_get($panel, "label", "Section ".($index + 1));
            $key = (string) data_get($panel, "key", \Illuminate\Support\Str::slug($label) ?: "section-".$index);

            return [
                "id" => data_get($panel, "id", "{$resolvedId}-{$key}-tab"),
                "panel_id" => data_get(
                    $panel,
                    "panel_id",
                    data_get($panel, "panelId", "{$resolvedId}-{$key}-panel")
                ),
                "label" => $label,
                "panel_title" => data_get($panel, "panel_title", data_get($panel, "panelTitle")),
                "selected" => $index === $resolvedSelectedIndex,
                "disabled" => filter_var(data_get($panel, "disabled", false), FILTER_VALIDATE_BOOLEAN),
                "icon" => data_get($panel, "icon"),
                "icon_only" => data_get($panel, "icon_only", data_get($panel, "iconOnly", false)),
                "secondary" => data_get($panel, "secondary", data_get($panel, "secondaryLabel")),
                "panel" => $renderPanel($panel),
            ];
        })
        ->all();

    $selectedPanel = $panelItems->get($resolvedSelectedIndex);
    $selectedPanelHtml = is_array($selectedPanel)
        ? $renderPanel($selectedPanel)
        : new \Illuminate\Support\HtmlString("");

    /*
     *--------------------------------------------------------------------------
     * CSS class contract
     *--------------------------------------------------------------------------
     */

    $classes = [
        "ui-account-section-tabs",
        "ui-account-section-tabs--single" => $panelCount <= 1 && ! $rendersSingleTab,
        "ui-account-section-tabs--tabbed" => $panelCount > 1 || $rendersSingleTab,
        "ui-account-section-tabs--vertical" => $resolvedOrientation === "vertical",
    ];
@endphp

<section
    {{
        $attributes->class($classes)->merge([
            "data-ui-pattern" => "account.section-tabs",
            "data-account-section-tabs" => "true",
            "data-account-section-tabs-count" => (string) $panelCount,
            "data-account-section-tabs-orientation" => $resolvedOrientation,
        ])
    }}
>
    @if ($panelCount > 1 || ($panelCount === 1 && $rendersSingleTab))
        <x-ui.tabs
            :id="$resolvedId"
            :label="$label"
            :tabs="$tabs"
            :orientation="$resolvedOrientation"
            :variant="$resolvedVariant"
            :activation="$resolvedActivation"
            :size="$resolvedSize"
            :height="$height"
            :grid-aware="$usesGridAware"
            :scrollable="$usesScrollable"
        />
    @elseif ($panelCount === 1)
        {!! $selectedPanelHtml->toHtml() !!}
    @endif
</section>
