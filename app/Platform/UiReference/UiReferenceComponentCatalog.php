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
            if ($component['slug'] === $slug) {
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
            $this->component('ui-shell-header', 'UI shell header', 'Shell', 'Represent As T2 Pattern', 'Application header, account menu, notifications, and global actions.', ['desktop', 'mobile', 'account menu', 'notification handoff'], ['T2 layout/navigation pages own shell composition.'], '/platform/ui-reference/patterns/navigation'),
            $this->component('ui-shell-left-panel', 'UI shell left panel', 'Shell', 'Represent As T2 Pattern', 'Primary sidebar and section navigation shell.', ['expanded', 'collapsed queued', 'active route'], ['T2 navigation/layout pages own shell composition.'], '/platform/ui-reference/patterns/navigation'),
            $this->component('ui-shell-right-panel', 'UI shell right panel', 'Shell', 'Queued Gap', 'Right-side supplemental shell panel.', ['queued'], ['Trigger when app shell needs persistent right-side context beyond drawers.']),
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
    ): array {
        return [
            'slug' => $slug,
            'label' => $label,
            'group' => $group,
            'disposition' => $disposition,
            'summary' => $summary,
            'states' => $states,
            'guidance' => $guidance,
            'owner_route' => $ownerRoute ?? '/platform/ui-reference/components/'.$slug,
            'route_name' => 'platform.ui-reference.components.show',
        ];
    }
}
