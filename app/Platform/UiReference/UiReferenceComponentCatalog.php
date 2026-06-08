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
            fn (array $component): bool => in_array($component['disposition'], ['Implement T1 Page', 'Queued Gap', 'Represent As T2 Pattern', 'Not Applicable Yet'], true)
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
            $this->component('accordion', 'Accordion', 'Navigation and disclosure', 'Implement T1 Page', 'Disclosure for optional content groups.', ['default', 'expanded', 'collapsed', 'disabled', 'focus'], ['Use for local disclosure. Do not use as primary navigation.']),
            $this->component('ai-label', 'AI label', 'Low-applicability gates', 'Not Applicable Yet', 'AI-specific explainability marker.', ['queued'], ['Trigger only when an AI-assisted feature exists. Do not build speculative AI chrome.']),
            $this->component('breadcrumb', 'Breadcrumb', 'Navigation and disclosure', 'Implement T1 Page', 'Location trail for information architecture.', ['default', 'current page', 'middle overflow', 'truncated'], ['Use for location. Do not use for task progress.']),
            $this->component('button', 'Button', 'Actions', 'Implement T1 Page', 'Primary, secondary, low-emphasis, and destructive actions.', ['standard', 'soft', 'ghost', 'outline', 'danger', 'disabled', 'loading', 'focus'], ['One primary action per region.', 'Use x-ui.button.']),
            $this->component('checkbox', 'Checkbox', 'Selection controls', 'Implement T1 Page', 'Independent yes/no choices and multi-select groups.', ['unchecked', 'checked', 'indeterminate queued', 'focus', 'disabled', 'read-only', 'error', 'warning'], ['Use for multiple or independent selections.', 'Do not use for one required choice.']),
            $this->component('code-snippet', 'Code snippet', 'Low-applicability gates', 'Queued Gap', 'Developer-facing code display.', ['single-line queued', 'multi-line queued'], ['Trigger only when docs or integration flows need copyable code examples.']),
            $this->component('contained-list', 'Contained list', 'Data display', 'Queued Gap', 'Compact list inside constrained panels.', ['default queued', 'actionable queued'], ['Use structured list or data-list item until a constrained-list consumer appears.']),
            $this->component('content-switcher', 'Content switcher', 'Navigation and disclosure', 'Queued Gap', 'Compact peer-view switcher.', ['default queued', 'icon queued'], ['Use tabs for content panels until a switcher-specific need appears.']),
            $this->component('data-table', 'Data table', 'Data display', 'Implement T1 Page', 'Tabular data with column alignment, sorting, filtering, and row actions.', ['basic', 'selectable', 'sortable', 'loading', 'empty', 'row actions'], ['Use for many rows or sortable/filterable data.', 'T2 table pages compose this owner.']),
            $this->component('date-picker', 'Date picker', 'Inputs', 'Implement T1 Page', 'Native date and date-time input family, with range picker queued.', ['date', 'date-time', 'range queued', 'error', 'warning', 'disabled', 'read-only'], ['Use native controls for simple date entry.']),
            $this->component('dropdown', 'Dropdown', 'Inputs', 'Implement T1 Page', 'Known-option dropdown and menu-like selection boundary.', ['default', 'disabled', 'error', 'warning', 'searchable handoff'], ['Use select for short lists and searchable select for long known lists.']),
            $this->component('file-uploader', 'File uploader', 'Inputs', 'Implement T1 Page', 'Single attachment input with drag-drop uploader queued.', ['button upload', 'disabled', 'error', 'bulk drag-drop queued'], ['Use button upload for one-off attachments.']),
            $this->component('form', 'Form', 'Form structure', 'Represent As T2 Pattern', 'Form sections, groups, validation, and action bars.', ['section', 'inline row', 'summary', 'actions'], ['T1 field pages own primitives. T2 Form Patterns owns compositions.'], '/platform/ui-reference/patterns/forms'),
            $this->component('inline-loading', 'Inline loading', 'Feedback and loading', 'Implement T1 Page', 'Small local pending state for same-page actions.', ['spinner with text', 'button loading', 'polite status'], ['Use for short local operations.']),
            $this->component('link', 'Link', 'Utilities', 'Implement T1 Page', 'Text link treatment for navigation and trusted inline actions.', ['default', 'hover', 'focus', 'visited not styled', 'disabled queued'], ['Use for navigation, not command buttons.']),
            $this->component('list', 'List', 'Data display', 'Queued Gap', 'Plain ordered/unordered list guidance.', ['ordered', 'unordered', 'nested boundary'], ['Use for text content only; use structured list for comparable rows.']),
            $this->component('loading', 'Loading', 'Feedback and loading', 'Implement T1 Page', 'Spinner and skeleton loading family.', ['spinner', 'skeleton', 'full-page queued', 'inline'], ['Use skeleton when final shape is known.']),
            $this->component('menu', 'Menu', 'Actions', 'Implement T1 Page', 'Disclosure list of contextual actions.', ['enabled', 'hover', 'focus', 'selected/current', 'danger', 'disabled', 'divider', 'submenu boundary'], ['Use x-ui.menu-item and dropdown-action-menu.']),
            $this->component('menu-buttons', 'Menu buttons', 'Actions', 'Implement T1 Page', 'Button-triggered menus and overflow triggers.', ['text trigger', 'icon-only trigger', 'split/combo queued'], ['Use for grouped secondary actions.']),
            $this->component('modal', 'Modal', 'Overlays', 'Implement T1 Page', 'Blocking dialog for decisions and confirmations.', ['passive', 'transactional', 'danger', 'acknowledgment queued', 'progress queued'], ['Use x-ui.modal for blocking decisions.']),
            $this->component('multiselect', 'Multiselect', 'Inputs', 'Queued Gap', 'Multiple known-option selection control.', ['queued', 'tagged values queued', 'filtering queued'], ['Use checkbox groups for small visible sets until a dedicated multiselect consumer exists.', 'Do not substitute radio or native select when multiple values are required.']),
            $this->component('notification', 'Notification', 'Feedback and loading', 'Implement T1 Page', 'Grouped notification family for inline alerts, toasts, banners, actionable feedback, and persisted handoff.', ['inline', 'toast', 'page banner', 'actionable', 'persisted handoff'], ['Keep notification family grouped.']),
            $this->component('number-input', 'Number input', 'Inputs', 'Implement T1 Page', 'Numeric input with increment/decrement controls.', ['default', 'fluid', 'min/max/step', 'error icon', 'warning icon', 'disabled', 'read-only', 'focus'], ['Use for small relative numeric adjustments. Use text input or slider for wide ranges.']),
            $this->component('pagination', 'Pagination', 'Data display', 'Implement T1 Page', 'Full pagination and compact pagination navigation.', ['full', 'compact nav', 'page size', 'overflow', 'disabled prev/next', 'small', 'medium', 'large'], ['Place below related content. Match table density where possible.']),
            $this->component('popover', 'Popover', 'Navigation and disclosure', 'Queued Gap', 'Floating interactive content container.', ['interactive queued', 'placement queued'], ['Use modal/drawer/toggletip until a popover-specific consumer exists.']),
            $this->component('progress-bar', 'Progress bar', 'Feedback and loading', 'Queued Gap', 'Linear completion meter.', ['determinate queued', 'indeterminate queued'], ['Trigger when long-running workflows need measurable progress.']),
            $this->component('progress-indicator', 'Progress indicator', 'Feedback and loading', 'Queued Gap', 'Step-by-step workflow progress.', ['horizontal queued', 'vertical queued'], ['Use instead of tabs for linear task progress.']),
            $this->component('radio-button', 'Radio button', 'Selection controls', 'Implement T1 Page', 'Mutually exclusive single-selection groups.', ['vertical', 'horizontal', 'selected', 'unselected', 'focus', 'disabled', 'read-only', 'error', 'warning'], ['Use for one choice from a visible set. Use checkbox for multi-select.']),
            $this->component('search', 'Search', 'Inputs', 'Implement T1 Page', 'Keyword search input for page, table, or component scope.', ['page search', 'table search', 'component search', 'clear action', 'loading queued'], ['Search handles free-entry keywords; filters handle known dimensions.']),
            $this->component('select', 'Select', 'Inputs', 'Implement T1 Page', 'Native select for short known option lists.', ['default', 'focus', 'disabled', 'read-only', 'error', 'warning'], ['Use searchable select for long known lists.']),
            $this->component('slider', 'Slider', 'Inputs', 'Queued Gap', 'Range selection for large continuous or relative numeric values.', ['single value queued', 'range queued'], ['Trigger when number input would require too many clicks.']),
            $this->component('structured-list', 'Structured list', 'Data display', 'Implement T1 Page', 'Scannable row comparison and selectable rich options.', ['default', 'selectable', 'condensed', 'hang alignment', 'flush alignment', 'selected', 'focus', 'disabled', 'skeleton'], ['Use data table for sorting/filtering or multiple row selection.']),
            $this->component('tabs', 'Tabs', 'Navigation and disclosure', 'Implement T1 Page', 'Line, contained, and vertical peer content panels.', ['line', 'contained', 'vertical', 'icon-leading', 'icon-only', 'overflow', 'selected', 'focus', 'disabled'], ['Do not use tabs for progress or comparison tasks.']),
            $this->component('tag', 'Tag', 'Feedback and loading', 'Implement T1 Page', 'Tag/badge labeling family.', ['base', 'outline', 'semantic', 'removable queued'], ['Use x-ui.badge for current tag/status display.']),
            $this->component('text-input', 'Text input', 'Inputs', 'Implement T1 Page', 'Single-line free-entry text field.', ['default', 'fluid', 'helper', 'focus', 'error', 'warning', 'disabled', 'read-only'], ['Use native type attributes before custom controls.']),
            $this->component('tile', 'Tile', 'Data display', 'Implement T1 Page', 'Compact static, clickable, selectable, and expandable blocks.', ['base', 'clickable', 'selectable', 'expandable', 'disabled queued'], ['Use cards for richer composed content.']),
            $this->component('toggle', 'Toggle', 'Selection controls', 'Implement T1 Page', 'Immediate on/off setting.', ['off', 'on', 'focus', 'disabled', 'read-only queued'], ['Use only when the state is understandable without another submit action.']),
            $this->component('toggletip', 'Toggletip', 'Overlays', 'Implement T1 Page', 'Focusable explanatory disclosure.', ['closed', 'open', 'focus', 'dismissible'], ['Use for interactive explanatory content.']),
            $this->component('tooltip', 'Tooltip', 'Overlays', 'Implement T1 Page', 'Short non-interactive hover/focus help.', ['hover', 'focus', 'definition'], ['Do not put interactive content in a tooltip.']),
            $this->component('tree-view', 'Tree view', 'Data display', 'Queued Gap', 'Hierarchical navigation or data browsing.', ['collapsed queued', 'expanded queued', 'selected queued'], ['Trigger only when hierarchical content needs in-page browsing.']),
            $this->component('ui-shell', 'UI shell', 'Shell', 'Represent As T2 Pattern', 'Application shell family covering header, left navigation, right panel disposition, account menu, notification handoff, and global actions.', ['header', 'left panel', 'right panel queued', 'desktop', 'mobile', 'account menu', 'notification handoff'], ['T2 layout/navigation pages own shell composition.', 'Header, left panel, and right panel remain Login-specific subsections of the UI shell family.'], '/platform/ui-reference/patterns/navigation', ['ui-shell-header', 'ui-shell-left-panel', 'ui-shell-right-panel']),
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
        $docPath = '02-standards/ui/components/tier-1/'.$slug.'.md';
        $priority = $this->priorityFor($slug);
        $status = match ($disposition) {
            'Implement T1 Page' => 'Implemented - pending manual review',
            'Represent As T2 Pattern' => 'App-specific exception',
            'Queued Gap' => 'Deferred',
            'Not Applicable Yet' => 'Do not implement',
            default => 'Partial',
        };
        $owner = $ownerRoute ?? '/platform/ui-reference/components/'.$slug;

        return [
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
            'use_when' => $guidance,
            'do_not_use_when' => $this->avoidanceFor($slug, $disposition),
            'variants' => $this->variantsFor($states),
            'states' => $states,
            'anatomy' => $this->anatomyFor($slug),
            'behavior' => $this->behaviorFor($slug, $disposition),
            'accessibility' => $this->accessibilityFor($slug, $disposition),
            'content_guidance' => $this->contentGuidanceFor($slug),
            'developer_api' => $this->developerApiFor($slug, $owner),
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
        if ($disposition === 'Represent As T2 Pattern') {
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
                'tag' => 'x-ui.badge',
                'menu' => 'x-ui.menu-item / x-ui.patterns.dropdown-action-menu',
                default => 'Catalog owner route documents the approved markup or queued implementation contract.',
            },
            'tokens' => 'Use Foundation Element tokens for color, spacing, typography, iconography, motion, and theme behavior.',
            'example' => '<!-- Use the documented owner route and canonical component contract for implementation. -->',
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
            $elements[] = ['label' => '2x Grid', 'href' => '/platform/ui-reference/elements/grid'];
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
