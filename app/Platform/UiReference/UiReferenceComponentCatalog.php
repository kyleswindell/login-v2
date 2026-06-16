<?php

namespace App\Platform\UiReference;

use Illuminate\Support\Collection;

class UiReferenceComponentCatalog
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        return $this->components();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function primaryPages(): array
    {
        return array_values(array_filter(
            $this->components(),
            fn (array $component): bool => in_array($component['disposition'], ['Implement Component Page', 'Queued Gap', 'Represent As Pattern', 'Not Applicable Yet'], true)
        ));
    }

    /**
     * @return array<string, array<int, array<string, mixed>>>
     */
    public function grouped(): array
    {
        return Collection::make($this->primaryPages())
            ->groupBy('group')
            ->map(fn (Collection $items): array => $items->values()->all())
            ->all();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function find(string $slug): ?array
    {
        foreach ($this->components() as $component) {
            if ($component['slug'] === $slug || in_array($slug, $component['aliases'], true)) {
                return $component;
            }
        }

        return null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function components(): array
    {
        return [
            $this->component('accordion', 'Accordion', 'Navigation and disclosure', 'Implement Component Page', 'Disclosure for optional content groups.', ['default', 'expanded', 'collapsed', 'disabled', 'focus'], ['Use for local disclosure. Do not use as primary navigation.']),
            $this->component('ai-label', 'AI label', 'Low-applicability gates', 'Not Applicable Yet', 'AI-specific explainability marker.', ['queued'], ['Trigger only when an AI-assisted feature exists. Do not build speculative AI chrome.']),
            $this->component('breadcrumb', 'Breadcrumb', 'Navigation and disclosure', 'Implement Component Page', 'Location trail for information architecture.', ['default', 'current page', 'middle overflow', 'truncated'], ['Use for location. Do not use for task progress.']),
            $this->component('button', 'Button', 'Actions', 'Implement Component Page', 'Primary, secondary, low-emphasis, and destructive actions.', ['standard', 'soft', 'ghost', 'outline', 'danger', 'disabled', 'loading', 'focus'], ['One primary action per region.', 'Use x-ui.button.']),
            $this->component('checkbox', 'Checkbox', 'Selection controls', 'Implement Component Page', 'Independent yes/no choices and multi-select groups.', ['unchecked', 'checked', 'indeterminate queued', 'focus', 'disabled', 'read-only', 'error', 'warning'], ['Use for multiple or independent selections.', 'Do not use for one required choice.']),
            $this->component('code-snippet', 'Code snippet', 'Low-applicability gates', 'Implement Component Page', 'Developer-facing code display.', ['single-line', 'multi-line', 'copy ready', 'copied', 'highlighted tokens'], ['Use for exact implementation syntax in docs and reference pages.']),
            $this->component('contained-list', 'Contained list', 'Data display', 'Implemented Pending Review', 'Compact bounded row list for page regions, panels, sidebars, and disclosed contexts.', ['on-page', 'disclosed', 'single-line rows', 'dynamic rows', 'linked rows', 'row actions', 'search/filter composition', 'sticky header', 'loading', 'empty', 'disabled'], ['Use when a bounded row group is clearer than a full table.']),
            $this->component('content-switcher', 'Content switcher', 'Navigation and disclosure', 'Implement Component Page', 'Compact peer-view switcher.', ['default', 'icon', 'selected', 'disabled', 'focus'], ['Use for compact peer views where tabs would be too visually heavy.']),
            $this->component('data-table', 'Data table', 'Data display', 'Implemented Pending Review', 'Tabular data with column alignment, sorting, filtering, row actions, state handling, and pagination composition.', ['basic', 'sortable', 'row sizes', 'toolbar', 'loading', 'empty', 'error', 'row actions', 'responsive overflow', 'selection gated'], ['Use for many rows or sortable/filterable data.', 'Pattern table pages compose this owner.']),
            $this->component('date-picker', 'Date picker', 'Inputs', 'Implemented Pending Review', 'Date, date-time, range calendar, and time picker proofs for date and scheduling entry.', ['date', 'date-time', 'date range calendar', 'time picker', 'small', 'medium', 'large', 'fluid', 'error', 'warning', 'disabled', 'read-only', 'loading'], ['Use date picker for date entry and range selection when users need calendar context. Use Forms Patterns for submission and workflow validation.']),
            $this->component('dropdown', 'Dropdown', 'Inputs', 'Implement Component Page', 'Custom single-select listbox for known-option field, filter, or sorting controls.', ['closed', 'open', 'selected', 'focus', 'disabled', 'read-only', 'error', 'warning', 'long menu'], ['Use for custom single selection. Use Select for native form/mobile selection.']),
            $this->component('file-uploader', 'File uploader', 'Inputs', 'Implement Component Page', 'Single attachment input with drag-drop uploader queued.', ['button upload', 'disabled', 'error', 'bulk drag-drop queued'], ['Use button upload for one-off attachments.']),
            $this->component('form', 'Form', 'Form structure', 'Represent As Pattern', 'Form sections, groups, validation, and action bars.', ['section', 'inline row', 'summary', 'actions'], ['Component field pages own primitives. Form Patterns own compositions.'], '/platform/ui-reference/patterns/forms'),
            $this->component('inline-loading', 'Inline loading', 'Feedback and loading', 'Implement Component Page', 'Small local pending state for same-page actions.', ['spinner with text', 'button loading', 'polite status'], ['Use for short local operations.']),
            $this->component('link', 'Link', 'Utilities', 'Implement Component Page', 'Text link treatment for navigation and trusted reference destinations.', ['default', 'hover', 'focus', 'active', 'visited policy', 'current', 'unavailable'], ['Use for navigation, not command buttons.']),
            $this->component('list', 'List', 'Data display', 'Implement Component Page', 'Plain ordered/unordered list guidance.', ['ordered', 'unordered', 'nested boundary', 'content-only'], ['Use for prose content only; use structured list for comparable rows.']),
            $this->component('loading', 'Loading', 'Feedback and loading', 'Implemented Pending Review', 'Large blocking and small inline loading indicators for unknown-duration pending work.', ['large', 'small', 'overlay', 'page', 'component', 'section', 'modal', 'side-panel', 'tile', 'inline', 'active', 'inactive'], ['Use skeleton when final shape is known. Use inline loading for action-level completion handoff.']),
            $this->component('menu', 'Menu', 'Actions', 'Implement Component Page', 'Disclosure list of contextual actions.', ['enabled', 'hover', 'focus', 'selected/current', 'danger', 'disabled', 'divider', 'submenu boundary'], ['Use x-ui.menu-item and dropdown-action-menu.']),
            $this->component('menu-buttons', 'Menu buttons', 'Actions', 'Implement Component Page', 'Button-triggered menus and overflow triggers.', ['text trigger', 'icon-only trigger', 'split/combo queued'], ['Use for grouped secondary actions.']),
            $this->component('modal', 'Modal', 'Overlays', 'Implement Component Page', 'Blocking dialog for decisions and confirmations.', ['passive', 'transactional', 'danger', 'acknowledgment queued', 'progress queued'], ['Use x-ui.modal for blocking decisions.']),
            $this->component('multiselect', 'Multiselect', 'Inputs', 'Implement Component Page', 'Multiple known-option selection control.', ['selected values', 'filterable', 'clearable', 'select all', 'disabled', 'read-only', 'error', 'warning', 'loading'], ['Use when users must choose multiple values from a known option set.', 'Use checkbox groups for small visible sets.']),
            $this->component('notification', 'Notification', 'Feedback and loading', 'Implement Component Page', 'Grouped notification family for inline alerts, toasts, banners, actionable feedback, and persisted handoff.', ['inline', 'toast', 'page banner', 'actionable', 'persisted handoff'], ['Keep notification family grouped.']),
            $this->component('number-input', 'Number input', 'Inputs', 'Implement Component Page', 'Numeric input with increment/decrement controls.', ['default', 'fluid', 'min/max/step', 'error icon', 'warning icon', 'disabled', 'read-only', 'focus'], ['Use for small relative numeric adjustments. Use text input or slider for wide ranges.']),
            $this->component('pagination', 'Pagination', 'Data display', 'Implemented Pending Review', 'Pagination bar and page navigation for segmented record sets.', ['pagination bar', 'pagination nav', 'items per page', 'page selector', 'overflow menu', 'looping', 'disabled prev/next', 'small', 'medium', 'large'], ['Place below related content. Match table density where possible.']),
            $this->component('popover', 'Popover', 'Navigation and disclosure', 'Implement Component Page', 'Floating interactive content container.', ['closed', 'open', 'focus-visible', 'disabled', 'placement', 'alignment', 'size'], ['Use when short interactive contextual content belongs near its trigger.']),
            $this->component('progress-bar', 'Progress bar', 'Feedback and loading', 'Implement Component Page', 'Linear completion meter.', ['determinate', 'indeterminate', 'success', 'error', 'loading'], ['Use when long-running workflows need measurable progress.']),
            $this->component('progress-indicator', 'Progress indicator', 'Feedback and loading', 'Implement Component Page', 'Step-by-step workflow progress.', ['horizontal', 'vertical', 'current', 'complete', 'error', 'upcoming'], ['Use instead of tabs for linear task progress.']),
            $this->component('radio-button', 'Radio button', 'Selection controls', 'Implement Component Page', 'Mutually exclusive single-selection groups.', ['vertical', 'horizontal', 'selected', 'unselected', 'focus', 'disabled', 'read-only', 'error', 'warning'], ['Use for one choice from a visible set. Use checkbox for multi-select.']),
            $this->component('search', 'Search', 'Inputs', 'Implemented Pending Review', 'Keyword search input for page, table, or component scope.', ['page search', 'table search', 'component search', 'clear action', 'small', 'medium', 'large', 'fluid', 'loading', 'disabled', 'read-only'], ['Search handles free-entry keywords; filters and result rendering belong to owning Patterns.']),
            $this->component('select', 'Select', 'Inputs', 'Implemented Pending Review', 'Native single-value form select for short known option lists.', ['default', 'inline', 'fluid', 'small', 'medium', 'large', 'error', 'warning', 'disabled', 'read-only', 'loading', 'grouped options'], ['Use Dropdown for custom filtering/sorting controls, Multiselect for multiple values, and Radio button for very small visible sets.']),
            $this->component('slider', 'Slider', 'Inputs', 'Implement Component Page', 'Range selection for large continuous or relative numeric values.', ['single value', 'range', 'value input', 'disabled', 'read-only', 'warning'], ['Use when relative position is more useful than exact entry alone.']),
            $this->component('structured-list', 'Structured list', 'Data display', 'Implemented Pending Review', 'Native table-backed row comparison with optional single-selection rows.', ['default', 'selectable', 'condensed', 'hang alignment', 'flush alignment', 'background', 'selected', 'focus', 'disabled', 'empty', 'skeleton'], ['Use Data table for sorting/filtering, pagination, expansion, or multiple row selection.']),
            $this->component('tabs', 'Tabs', 'Navigation and disclosure', 'Implement Component Page', 'Line, contained, and vertical peer content panels.', ['line', 'contained', 'vertical', 'icon-leading', 'icon-only', 'overflow', 'selected', 'focus', 'disabled'], ['Do not use tabs for progress or comparison tasks.']),
            $this->component('tag', 'Tag', 'Feedback and loading', 'Implemented Pending Review', 'Compact metadata, filter, selectable, and operational overflow labels.', ['read-only', 'dismissible', 'selectable', 'operational', 'small', 'medium', 'large', 'color tokens', 'overflow tooltip', 'skeleton'], ['Use x-ui.tag for compact labels and filter tokens. Use Notification for explanatory feedback and Button/Menu for commands.']),
            $this->component('text-input', 'Text input', 'Inputs', 'Implemented Pending Review', 'Text, password, and text area field family for free-form entry.', ['text input', 'password input', 'text area', 'default', 'fluid', 'small', 'medium', 'large', 'error', 'warning', 'disabled', 'read-only', 'skeleton'], ['Use for free-form values. Use selection controls when values must come from known options.']),
            $this->component('tile', 'Tile', 'Data display', 'Implemented Pending Review', 'Compact static, clickable, selectable, and expandable blocks.', ['static/base', 'clickable', 'selectable single', 'selectable multiple', 'expandable', 'disabled interactive', 'media deferred', 'AI gated'], ['Use cards for richer composed content.']),
            $this->component('toggle', 'Toggle', 'Selection controls', 'Implement Component Page', 'Immediate on/off setting.', ['off', 'on', 'focus', 'disabled', 'read-only queued'], ['Use only when the state is understandable without another submit action.']),
            $this->component('toggletip', 'Toggletip', 'Overlays', 'Implement Component Page', 'Focusable explanatory disclosure.', ['closed', 'open', 'focus', 'dismissible'], ['Use for interactive explanatory content.']),
            $this->component('tooltip', 'Tooltip', 'Overlays', 'Implement Component Page', 'Short non-interactive hover/focus help.', ['hover', 'focus', 'definition'], ['Do not put interactive content in a tooltip.']),
            $this->component('tree-view', 'Tree view', 'Data display', 'Implement Component Page', 'Hierarchical navigation or data browsing.', ['collapsed', 'expanded', 'selected', 'active', 'disabled', 'branch', 'leaf'], ['Use when hierarchical content needs in-page browsing.']),
            $this->component('ui-shell', 'UI shell', 'Shell', 'Represent As Pattern', 'Application shell family covering header, left navigation, right panel disposition, account menu, notification handoff, and global actions.', ['header', 'left panel', 'right panel queued', 'desktop', 'mobile', 'account menu', 'notification handoff'], ['Pattern layout/navigation pages own shell composition.', 'Header, left panel, and right panel remain Login-specific subsections of the UI shell family.'], '/platform/ui-reference/patterns/navigation', ['ui-shell-header', 'ui-shell-left-panel', 'ui-shell-right-panel']),
        ];
    }

    /**
     * @param array<int, string> $states
     * @param array<int, string> $guidance
     *
     * @return array<string, mixed>
     */
    private function component(
        string $slug,
        string $label,
        string $group,
        string $disposition,
        string $summary,
        array $states,
        array $guidance,
        ?string $ownerRoute = null,
        array $aliases = [],
    ): array {
        $docPath = '02-standards/ui/components/'.$slug.'.md';
        $priority = $this->priorityFor($slug);
        $status = match ($disposition) {
            'Implement Component Page' => 'Implemented - pending manual review',
            'Represent As Pattern' => 'App-specific exception',
            'Queued Gap' => 'Deferred',
            'Not Applicable Yet' => 'Do not implement',
            default => 'Partial',
        };
        $owner = $ownerRoute ?? '/platform/ui-reference/components/'.$slug;

        $component = [
            'slug' => $slug,
            'label' => $label,
            'group' => $group,
            'category' => $group,
            'priority' => $priority,
            'priority_label' => match ($priority) {
                'A' => 'Tier A - Baseline app development',
                'B' => 'Tier B - Common reusable component',
                default => 'Tier C - Contextual or deferred',
            },
            'status' => $status,
            'disposition' => $disposition,
            'summary' => $summary,
            'purpose' => $summary,
            'current_decision' => $this->currentDecisionFor($slug, $disposition),
            'carbon_parity_note' => $this->parityNoteFor($slug, $disposition),
            'feature_flag_note' => $this->featureFlagNoteFor($slug),
            'use_when' => $guidance,
            'do_not_use_when' => $this->avoidanceFor($slug, $disposition),
            'variants' => $this->variantsFor($states),
            'states' => $states,
            'anatomy' => $this->anatomyFor($slug),
            'behavior' => $this->behaviorFor($slug, $disposition),
            'accessibility' => $this->accessibilityFor($slug, $disposition),
            'content_guidance' => $this->contentGuidanceFor($slug),
            'developer_api' => $this->developerApiFor($slug, $owner),
            'live_examples' => $this->liveExamplesFor($slug, $label, $disposition, $states),
            'related' => $this->relatedFor($slug, $group),
            'foundation_elements' => $this->foundationElementsFor($slug),
            'queued_gaps' => $this->queuedGapsFor($slug, $disposition, $guidance),
            'guidance' => $guidance,
            'owner_route' => $owner,
            'source_owner' => $owner,
            'doc_path' => $docPath,
            'doc_route' => '/platform/docs?path='.rawurlencode($docPath),
            'route_name' => 'platform.ui-reference.components.show',
            'aliases' => $aliases,
        ];

        if ($slug === 'accordion') {
            $component = array_replace($component, [
                'purpose' => 'Use accordion to reveal optional supporting content within the current page context.',
                'current_decision' => 'Accordion is the app-owned disclosure primitive for secondary local detail. It supports multiple panels by default, optional single-open behavior, compact density, flush alignment, consistent icon alignment, contained surfaces, and capped scrollable panels.',
                'carbon_parity_note' => 'Use this route as the implementation owner for local disclosure. If a feature needs navigation, comparison, or required task steps, use the related component or Pattern owner instead.',
                'use_when' => [
                    'Secondary details help the task but are not required to continue.',
                    'Grouped help, advanced settings, or review notes would otherwise add visual noise.',
                    'A local section needs optional explanation while the main workflow stays visible.',
                ],
                'do_not_use_when' => [
                    'Users must read the content before continuing, including required instructions or validation errors.',
                    'The UI is primary navigation, wizard steps, or a progress indicator.',
                    'Users need to compare all sections at once; use tabs, a structured list, or visible page sections.',
                ],
                'states' => ['collapsed', 'expanded', 'hover', 'focus-visible', 'pressed', 'disabled', 'not applicable: read-only', 'not applicable: loading', 'not applicable: validation', 'not applicable: empty'],
                'variants' => ['contained/contextual', 'compact', 'flush alignment', 'icon alignment: start', 'icon alignment: end', 'single-open', 'scrollable panel'],
                'anatomy' => [
                    'Group: wraps related accordion items.',
                    'Item: one trigger and one associated panel.',
                    'Heading: preserves local document structure.',
                    'Trigger: native button that owns expanded state.',
                    'Title: short sentence-case label.',
                    'Chevron: decorative state indicator using end alignment by default.',
                    'Start icon alignment: rare whole-accordion option for tree-like disclosure.',
                    'Panel: collapsible content region.',
                    'Body: optional supporting text or controls.',
                    'Metadata: optional helper text under the title.',
                ],
                'behavior' => [
                    'Click, tap, Enter, and Space toggle the focused trigger.',
                    'Focus stays on the trigger after expansion or collapse.',
                    'Multiple panels can stay open by default; use `mode="single"` when only one section should remain open.',
                    'Disabled items use native disabled button behavior and cannot expand.',
                    'Panels wrap inside the available width and must not create horizontal overflow.',
                    'Flush alignment starts title and chevron at the rule line and adds horizontal padding only for hover and focus states.',
                    'Icon placement is consistent per accordion instance and should not alternate within the same page.',
                    'Open and close motion uses measured panel height and respects reduced-motion preferences.',
                ],
                'accessibility' => [
                    'Use a semantic button for every trigger.',
                    'Keep `aria-expanded`, `aria-controls`, and panel `id` values in sync.',
                    'Show a visible focus state on every trigger.',
                    'Hide decorative chevrons from assistive technology.',
                    'Keep required instructions, errors, and primary task steps visible outside collapsed panels.',
                ],
                'content_guidance' => [
                    'Write trigger labels in sentence case.',
                    'Name the disclosed content directly, such as Review history or Advanced settings.',
                    'Avoid vague labels such as More, Details, or Information.',
                    'Keep body copy short. Move long workflows to a page section, modal, or Pattern-owned flow.',
                    'Do not make collapsed content the only explanation for disabled or destructive actions.',
                ],
                'developer_api' => [
                    'owner_route' => $owner,
                    'blade' => 'x-ui.accordion',
                    'js_controller' => 'initAccordions exported from resources/js/ui-controls.js',
                    'data_attributes' => 'data-ui-accordion, data-ui-accordion-trigger, data-ui-accordion-panel',
                    'props' => 'variant: default|contained; alignment: default|flush; iconAlignment: end|start; size: default|compact; mode: multiple|single; scrollable: bool; panelMaxHeight: CSS length',
                    'tokens' => 'Uses Foundation Color, Spacing, Typography, Motion, and Theme tokens through ui-accordion classes.',
                    'example' => '<x-ui.accordion :items="$items" />',
                    'source_files' => 'resources/views/components/ui/accordion.blade.php; resources/js/ui-controls/accordions.js; resources/css/app.css',
                ],
                'live_examples' => $this->accordionLiveExamples(),
                'related' => [
                    ['label' => 'Tabs', 'href' => '/platform/ui-reference/components/tabs'],
                    ['label' => 'Structured list', 'href' => '/platform/ui-reference/components/structured-list'],
                    ['label' => 'Modal', 'href' => '/platform/ui-reference/components/modal'],
                    ['label' => 'Popover', 'href' => '/platform/ui-reference/components/popover'],
                    ['label' => 'Toggletip', 'href' => '/platform/ui-reference/components/toggletip'],
                    ['label' => 'Tooltip', 'href' => '/platform/ui-reference/components/tooltip'],
                    ['label' => 'Help/documentation pattern', 'href' => '/platform/ui-reference/patterns/data-content'],
                    ['label' => 'Forms/settings patterns', 'href' => '/platform/ui-reference/patterns/forms'],
                ],
            ]);
        }

        if ($slug !== 'accordion') {
            $depth = (new UiReferenceComponentDepthCatalog())->for($slug);

            if ($depth !== null) {
                $component = array_replace($component, $depth);
            }
        }

        return $component;
    }

    private function currentDecisionFor(string $slug, string $disposition): string
    {
        if ($disposition === 'Represent As Pattern') {
            return 'Composition ownership belongs to the linked Pattern page; this catalog entry preserves disposition and discoverability.';
        }

        if (in_array($disposition, ['Queued Gap', 'Not Applicable Yet'], true)) {
            return 'Do not build speculative UI until the documented trigger condition exists.';
        }

        return 'Component page is scaffolded for family-depth implementation and must consume approved Foundation Elements.';
    }

    private function parityNoteFor(string $slug, string $disposition): string
    {
        if ($disposition === 'Not Applicable Yet') {
            return 'Mapped for completeness; not currently part of Login App product behavior.';
        }

        return 'Login App owns the visual and implementation contract; external systems are used only as completeness benchmarks.';
    }

    private function featureFlagNoteFor(string $slug): ?string
    {
        return in_array($slug, ['menu-buttons', 'modal', 'notification', 'structured-list', 'tile', 'toggle', 'tree-view'], true)
            ? 'If external feature-flagged behavior is later evaluated, document whether Login App follows that behavior or an app-specific variant.'
            : null;
    }

    private function priorityFor(string $slug): string
    {
        return match ($slug) {
            'button', 'link', 'text-input', 'select', 'checkbox', 'radio-button', 'toggle', 'form', 'tag', 'notification', 'loading', 'inline-loading', 'tooltip', 'modal', 'data-table', 'pagination', 'search', 'ui-shell', 'breadcrumb' => 'A',
            'accordion', 'code-snippet', 'contained-list', 'content-switcher', 'dropdown', 'file-uploader', 'list', 'menu', 'menu-buttons', 'multiselect', 'number-input', 'progress-bar', 'progress-indicator', 'tabs', 'tile', 'toggletip' => 'B',
            default => 'C',
        };
    }

    /**
     * @param array<int, string> $states
     *
     * @return array<int, string>
     */
    private function variantsFor(array $states): array
    {
        return array_values(array_slice($states, 0, min(count($states), 6)));
    }

    /**
     * @return array<int, string>
     */
    private function avoidanceFor(string $slug, string $disposition): array
    {
        if ($disposition === 'Represent As Pattern') {
            return ['Do not duplicate this as a local primitive. Use the linked Pattern owner for composition behavior.'];
        }

        if (in_array($disposition, ['Queued Gap', 'Not Applicable Yet'], true)) {
            return ['Do not build speculative UI for this component until the trigger condition is met.'];
        }

        return match ($slug) {
            'button' => ['Do not use buttons for navigation that should be a link.', 'Do not create local button colors or sizes.'],
            'link' => ['Do not use `href="#"` for commands. Use a button for state-changing actions.'],
            'checkbox' => ['Do not use checkboxes for mutually exclusive choices. Use radio buttons.'],
            'radio-button' => ['Do not use radio buttons for independent or multi-select choices.'],
            'modal' => ['Do not use modals for long repeated workflows or non-blocking contextual detail.'],
            'data-table' => ['Do not use data tables as a spreadsheet replacement or for simple content lists.'],
            default => ['Do not create one-off markup, colors, spacing, or behavior outside this component contract.'],
        };
    }

    /**
     * @return array<int, string>
     */
    private function anatomyFor(string $slug): array
    {
        return match ($slug) {
            'button', 'menu-buttons' => ['container', 'label', 'optional icon', 'loading indicator'],
            'text-input', 'select', 'dropdown', 'number-input', 'date-picker', 'file-uploader', 'search', 'slider', 'multiselect' => ['label', 'control', 'helper text', 'validation message', 'optional status icon'],
            'checkbox', 'radio-button', 'toggle', 'content-switcher' => ['group label', 'option control', 'option label', 'helper or validation message'],
            'notification' => ['status icon', 'title', 'message', 'action', 'dismiss control'],
            'modal' => ['backdrop', 'dialog container', 'header', 'body', 'footer actions', 'close control'],
            'data-table' => ['caption/title', 'toolbar', 'header row', 'body rows', 'row actions', 'pagination'],
            'ui-shell' => ['header', 'left panel', 'main content', 'account menu', 'utility actions'],
            default => ['container', 'label or title', 'content', 'state indicator', 'optional action'],
        };
    }

    /**
     * @return array<int, string>
     */
    private function behaviorFor(string $slug, string $disposition): array
    {
        if (in_array($disposition, ['Queued Gap', 'Not Applicable Yet'], true)) {
            return ['Behavior remains gated until a product consumer creates a concrete implementation need.'];
        }

        return match ($slug) {
            'modal' => ['Move focus into the dialog when opened.', 'Trap focus while open.', 'Return focus to the invoking control on close.'],
            'menu', 'menu-buttons' => ['Open from an accessible trigger.', 'Close on selection, Escape, outside click, or focus loss according to the app contract.'],
            'data-table' => ['Keep sort, filter, row action, loading, empty, and pagination behavior predictable.'],
            'tabs' => ['Selected tab controls one nearby panel. Do not use tabs for progress steps.'],
            default => ['Support documented click, keyboard, focus, disabled, loading, responsive, and validation behavior where applicable.'],
        };
    }

    /**
     * @return array<int, string>
     */
    private function accessibilityFor(string $slug, string $disposition): array
    {
        if (in_array($disposition, ['Queued Gap', 'Not Applicable Yet'], true)) {
            return ['Do not mark complete until keyboard, focus, screen reader, and contrast behavior is defined.'];
        }

        return match ($slug) {
            'button', 'menu-buttons' => ['Icon-only controls require an accessible label and visible tooltip.', 'Focus-visible state is required.'],
            'tooltip' => ['Tooltip content is non-interactive and must be available on focus, not only hover.'],
            'notification', 'tag' => ['Do not rely on color alone; include text and icon/semantic treatment where meaningful.'],
            'modal' => ['Use dialog semantics, focus trap, Escape behavior, and return focus.'],
            default => ['Provide visible focus, keyboard access, readable contrast, semantic naming, and non-color-only meaning where applicable.'],
        };
    }

    /**
     * @return array<int, string>
     */
    private function contentGuidanceFor(string $slug): array
    {
        return match ($slug) {
            'button' => ['Use concise verb-led labels that describe the action outcome.'],
            'notification' => ['Use a short title, clear message, and actionable recovery copy for errors.'],
            'text-input', 'select', 'dropdown', 'number-input' => ['Labels are required unless a documented accessibility exception exists.', 'Placeholder text is not a replacement for labels.'],
            default => ['Use sentence case, clear labels, and copy that describes the component outcome or state.'],
        };
    }

    /**
     * @return array<string, string>
     */
    private function developerApiFor(string $slug, string $owner): array
    {
        return [
            'owner_route' => $owner,
            'blade' => match ($slug) {
                'button' => 'x-ui.button',
                'modal' => 'x-ui.modal',
                'tag' => 'x-ui.tag',
                'menu' => 'x-ui.menu-item / x-ui.patterns.dropdown-action-menu',
            default => 'Catalog owner route documents the approved markup or queued implementation contract.',
            },
            'tokens' => 'Use Foundation Element tokens for color, spacing, typography, iconography, motion, and theme behavior.',
            'example' => 'Component-specific API pending correction.',
        ];
    }

    /**
     * @param array<int, string> $states
     *
     * @return array<int, array<string, mixed>>
     */
    private function liveExamplesFor(string $slug, string $label, string $disposition, array $states): array
    {
        if (in_array($disposition, ['Queued Gap', 'Not Applicable Yet'], true)) {
            return [[
                'id' => 'trigger-condition',
                'title' => 'Trigger condition',
                'description' => 'This component remains visible in the catalog, but the app does not render speculative component chrome until a product need exists.',
                'view' => null,
                'variants' => [
                    ['label' => 'Deferred', 'status' => 'Deferred', 'notes' => 'No app-approved variant until implementation is queued.'],
                ],
            ]];
        }

        return [[
            'id' => 'component-correction-pending',
            'title' => 'Component-specific correction pending',
            'description' => $label.' will receive production examples during its approved component correction pass.',
            'view' => null,
            'variants' => array_map(
                fn (string $state): array => ['label' => $state, 'status' => 'Pending component correction', 'notes' => 'Listed as catalog coverage; not yet a finished variant example.'],
                array_slice($states, 0, min(count($states), 4))
            ),
        ]];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function accordionLiveExamples(): array
    {
        return [
            [
                'id' => 'basic-accordion',
                'title' => 'Basic accordion',
                'description' => 'Minimum viable disclosure with one open panel and one collapsed panel.',
                'view' => 'platform.ui-reference.components.examples.accordion-basic',
                'context_notes' => [
                    'Use this as the baseline when optional supporting detail belongs close to the related section.',
                    'The trigger remains a button and owns the expanded/collapsed state.',
                ],
                'variants' => [
                    ['label' => 'Compact', 'status' => 'Implemented', 'view' => 'platform.ui-reference.components.examples.accordion-variant-compact', 'notes' => 'Use for dense secondary disclosure inside constrained settings or utility panels.'],
                    ['label' => 'Start icon alignment', 'status' => 'Implemented', 'view' => 'platform.ui-reference.components.examples.accordion-variant-icon-start', 'notes' => 'Rare whole-accordion option for tree-like disclosure; default end alignment remains preferred.'],
                ],
            ],
            [
                'id' => 'multiple-independent-sections',
                'title' => 'Multiple independent sections',
                'description' => 'Independent groups allow more than one optional section to stay open.',
                'view' => 'platform.ui-reference.components.examples.accordion-multiple',
                'context_notes' => [
                    'Use independent sections when users may need to compare nearby optional content.',
                    'Use the single-open variant when the workflow should keep only one related section open at a time.',
                ],
                'variants' => [
                    ['label' => 'Single-open', 'status' => 'Implemented', 'view' => 'platform.ui-reference.components.examples.accordion-variant-single-open', 'notes' => 'Use when only one related support section should stay open to reduce scan noise.'],
                ],
            ],
            [
                'id' => 'long-content-accordion',
                'title' => 'Long content accordion',
                'description' => 'Wrapped body content demonstrates overflow and readable spacing behavior.',
                'view' => 'platform.ui-reference.components.examples.accordion-long-content',
                'context_notes' => [
                    'Panel content wraps inside the available width.',
                    'Long workflows should move to a full page or pattern-owned surface.',
                ],
                'variants' => [
                    ['label' => 'Scrollable panel', 'status' => 'Implemented', 'view' => 'platform.ui-reference.components.examples.accordion-variant-scrollable', 'notes' => 'Use with a capped panel height when optional reference content is long but must stay in context.'],
                ],
            ],
            [
                'id' => 'accordion-inside-card',
                'title' => 'Accordion inside card or panel',
                'description' => 'A contextual accordion used inside a bounded surface without redefining card spacing.',
                'view' => 'platform.ui-reference.components.examples.accordion-card',
                'context_notes' => [
                    'Parent layouts own external spacing; Accordion owns only internal item spacing.',
                    'Nested surfaces must keep layer and border tokens readable in light and dark themes.',
                ],
                'variants' => [
                    ['label' => 'Contained contextual', 'status' => 'Implemented', 'view' => 'platform.ui-reference.components.examples.accordion-variant-contained', 'notes' => 'Allowed when the parent card or panel owns the surrounding context.'],
                    ['label' => 'Flush alignment', 'status' => 'Implemented', 'view' => 'platform.ui-reference.components.examples.accordion-variant-flush', 'notes' => 'Use in smaller spaces such as side panels or sidebars when title and chevron should align to surrounding rule lines.'],
                ],
            ],
            [
                'id' => 'form-assistance-accordion',
                'title' => 'Form assistance accordion',
                'description' => 'Optional guidance for form settings that should not replace visible labels or validation.',
                'view' => 'platform.ui-reference.components.examples.accordion-form-assistance',
                'context_notes' => [
                    'Use only for secondary explanations. Labels, helper text, and errors remain visible outside the Accordion.',
                    'Do not hide required instructions or validation recovery steps here.',
                ],
                'variants' => [
                    ['label' => 'Compact assistance disclosure', 'status' => 'Implemented', 'view' => 'platform.ui-reference.components.examples.accordion-variant-compact', 'notes' => 'Allowed for optional form explanation only; visible labels and validation remain outside the Accordion.'],
                ],
            ],
        ];
    }

    /**
     * @return array<int, array{label: string, href: string}>
     */
    private function relatedFor(string $slug, string $group): array
    {
        $links = [
            ['label' => 'Components overview', 'href' => '/platform/ui-reference/components'],
            ['label' => 'Patterns', 'href' => '/platform/ui-reference/patterns/forms'],
        ];

        if ($group === 'Actions') {
            $links[] = ['label' => 'Navigation patterns', 'href' => '/platform/ui-reference/patterns/navigation'];
        }

        if (in_array($group, ['Inputs', 'Selection controls', 'Form structure'], true)) {
            $links[] = ['label' => 'Form patterns', 'href' => '/platform/ui-reference/patterns/forms'];
        }

        if ($group === 'Data display') {
            $links[] = ['label' => 'Table patterns', 'href' => '/platform/ui-reference/patterns/tables'];
        }

        return $links;
    }

    /**
     * @return array<int, array{label: string, href: string}>
     */
    private function foundationElementsFor(string $slug): array
    {
        $elements = [
            ['label' => 'Color', 'href' => '/platform/ui-reference/elements/color'],
            ['label' => 'Spacing', 'href' => '/platform/ui-reference/elements/spacing'],
            ['label' => 'Typography', 'href' => '/platform/ui-reference/elements/typography'],
            ['label' => 'Themes', 'href' => '/platform/ui-reference/elements/themes'],
        ];

        if (in_array($slug, ['button', 'menu', 'menu-buttons', 'notification', 'tooltip', 'toggletip', 'search', 'ui-shell'], true)) {
            $elements[] = ['label' => 'Icons', 'href' => '/platform/ui-reference/elements/icons'];
        }

        if (in_array($slug, ['modal', 'notification', 'loading', 'inline-loading', 'progress-bar', 'progress-indicator', 'accordion', 'tabs', 'ui-shell'], true)) {
            $elements[] = ['label' => 'Motion', 'href' => '/platform/ui-reference/elements/motion'];
        }

        if (in_array($slug, ['data-table', 'structured-list', 'tile', 'ui-shell'], true)) {
            $elements[] = ['label' => '2x Grid', 'href' => '/platform/ui-reference/elements/2x-grid'];
        }

        return $elements;
    }

    /**
     * @param array<int, string> $guidance
     *
     * @return array<int, string>
     */
    private function queuedGapsFor(string $slug, string $disposition, array $guidance): array
    {
        if (in_array($disposition, ['Queued Gap', 'Not Applicable Yet'], true)) {
            return $guidance;
        }

        return match ($slug) {
            'ui-shell' => ['Right panel remains queued until a persistent right-side context is required.'],
            'checkbox' => ['Indeterminate state requires a supported parent/child selection consumer before production use.'],
            default => [],
        };
    }
}
