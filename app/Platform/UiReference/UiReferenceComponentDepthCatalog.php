<?php

namespace App\Platform\UiReference;

class UiReferenceComponentDepthCatalog
{
    /**
     * @return array<string, mixed>|null
     */
    public function for(string $slug): ?array
    {
        return match ($slug) {
            'button' => $this->buttonComponent(),
            'link' => $this->linkComponent(),
            'menu' => $this->menuComponent(),
            'menu-buttons' => $this->menuButtonsComponent(),

            'text-input' => $this->inputs('text-input', 'Text input', 'Single-line free-entry text fields capture short user-provided values.', 'text', ['Login form field', 'Settings form field', 'Validation field', 'Read-only field', 'Disabled field']),
            'textarea' => $this->inputs('textarea', 'Textarea', 'Textarea captures longer user-entered copy with visible multiline affordance.', 'textarea', ['Settings form field', 'Validation field', 'Read-only field', 'Disabled field']),
            'select' => $this->selectComponent(),
            'dropdown' => $this->dropdownComponent(),
            'number-input' => $this->inputs('number-input', 'Number input', 'Number input captures bounded numeric values with optional step controls.', 'number', ['Min/max/step', 'Increment/decrement', 'Error/warning icon', 'Disabled/read-only', 'Compact/fluid']),
            'date-picker' => $this->datePickerComponent(),
            'file-uploader' => $this->inputs('file-uploader', 'File uploader', 'File uploader collects one or more user-selected files through an accessible input.', 'file', ['Button upload', 'File validation', 'Disabled', 'Drag-drop deferred']),
            'search' => $this->searchComponent(),
            'multiselect' => $this->multiselectComponent(),
            'slider' => $this->sliderComponent(),

            'checkbox' => $this->checkboxComponent(),
            'radio-button' => $this->radioButtonComponent(),
            'toggle' => $this->selection('toggle', 'Toggle', 'Toggle controls immediate on/off settings.', 'toggle', [
                ['Immediate setting', 'A setting changes as soon as the toggle is changed.'],
                ['Disabled setting', 'A setting is unavailable because of permissions or dependency.'],
                ['Setting with helper text', 'Optional context explains what the setting changes.'],
            ]),
            'content-switcher' => $this->contentSwitcherComponent(),

            'notification' => $this->feedback('notification', 'Notification', 'Notifications communicate state changes, errors, and system messages.', 'alert', ['Form validation error', 'Record saved', 'API failure', 'Background job completed', 'Maintenance notice']),
            'tag' => $this->tagComponent(),
            'inline-loading' => $this->feedback('inline-loading', 'Inline loading', 'Inline loading shows short local progress without blocking the page.', 'inline-loading', ['Button/action pending', 'Local save pending', 'Polite status']),
            'loading' => $this->feedback('loading', 'Loading', 'Loading uses spinners and skeletons to keep pending content understandable.', 'loading', ['Spinner', 'Skeleton text/card/table', 'Page-region loading']),
            'progress-bar' => $this->feedback('progress-bar', 'Progress bar', 'Progress bar shows measurable completion for a long-running task.', 'progress', ['Determinate progress', 'Indeterminate deferred', 'Success/error completion']),
            'progress-indicator' => $this->feedback('progress-indicator', 'Progress indicator', 'Progress indicator shows a user position in a linear step flow.', 'steps', ['Step flow', 'Current/completed/error step', 'Vertical/horizontal']),
            'ai-label' => $this->doNotImplement('ai-label', 'AI label', 'AI label is not implemented until an approved AI-assisted feature exists.'),

            'modal' => $this->overlay('modal', 'Modal', 'Modal interrupts the current page for a required decision or contained task.', 'modal', ['Confirmation dialog', 'Form modal', 'Read-only detail', 'Destructive action', 'Wizard deferred']),
            'tooltip' => $this->tooltipComponent(),
            'toggletip' => $this->overlay('toggletip', 'Toggletip', 'Toggletip provides focusable, dismissible contextual help.', 'toggletip', ['Contextual help', 'Dismissible rich help', 'Form assistance']),
            'popover' => $this->popoverComponent(),

            'data-table' => $this->dataDisplay('data-table', 'Data table', 'Data table organizes comparable records into aligned columns.', 'table', ['Basic sortable table', 'Filterable table', 'Row actions', 'Loading', 'Empty', 'Responsive overflow']),
            'pagination' => $this->dataDisplay('pagination', 'Pagination', 'Pagination moves through segmented record sets.', 'pagination', ['Full pagination', 'Compact pagination', 'Page-size selector', 'Disabled prev/next', 'Overflow']),
            'structured-list' => $this->structuredListComponent(),
            'list' => $this->listComponent(),
            'code-snippet' => $this->codeSnippetComponent(),
            'tile' => $this->dataDisplay('tile', 'Tile', 'Tile presents compact selectable, clickable, or static content blocks.', 'tile', ['Static tile', 'Clickable tile', 'Selectable tile', 'Expandable tile', 'Disabled deferred']),
            'contained-list' => $this->containedListComponent(),
            'tree-view' => $this->treeViewComponent(),

            'breadcrumb' => $this->breadcrumbComponent(),
            'tabs' => $this->tabsComponent(),
            'ui-shell' => $this->navigation('ui-shell', 'UI shell', 'UI shell frames the global app experience.', 'shell', ['Header baseline', 'Left panel', 'Account menu', 'Notification/action area', 'Mobile/collapsed behavior', 'Right panel deferred']),
            default => null,
        };
    }

    /**
     * @return array<string, mixed>
     */
    private function buttonComponent(): array
    {
        return array_replace($this->correctedImplemented('button', 'Button', 'Buttons choose, confirm, or reveal a user command with explicit action hierarchy.', [
            $this->exampleFromSample('Form submission action', 'Primary submit, secondary save, and low-emphasis cancel stay grouped at the end of a form.', ['type' => 'buttons', 'items' => [
                ['label' => 'Save changes', 'semantic' => 'primary'],
                ['label' => 'Save draft', 'semantic' => 'neutral'],
                ['label' => 'Cancel', 'variant' => 'ghost'],
            ]], [
                $this->sampleVariant('Primary', ['type' => 'buttons', 'items' => [['label' => 'Save changes', 'semantic' => 'primary']]]),
                $this->sampleVariant('Secondary neutral', ['type' => 'buttons', 'items' => [['label' => 'Save draft', 'semantic' => 'neutral']]]),
                $this->sampleVariant('Loading submit', ['type' => 'buttons', 'items' => [['label' => 'Saving', 'semantic' => 'primary', 'loading' => true]]]),
                $this->sampleVariant('Disabled submit', ['type' => 'buttons', 'items' => [['label' => 'Save changes', 'semantic' => 'primary', 'disabled' => true]]]),
            ]),
            $this->exampleFromSample('Page header actions', 'A page header gets one primary action and supporting outline or ghost actions.', ['type' => 'buttons', 'items' => [
                ['label' => 'Create workspace', 'semantic' => 'primary'],
                ['label' => 'Export', 'variant' => 'outline'],
                ['label' => 'View docs', 'variant' => 'ghost'],
            ]], [
                $this->sampleVariant('Outline', ['type' => 'buttons', 'items' => [['label' => 'Export', 'variant' => 'outline']]]),
                $this->sampleVariant('Ghost', ['type' => 'buttons', 'items' => [['label' => 'View docs', 'variant' => 'ghost']]]),
                $this->sampleVariant('Focus-visible', ['type' => 'buttons', 'items' => [['label' => 'Create workspace', 'semantic' => 'primary', 'state' => 'focus']]]),
                $this->sampleVariant('Pressed', ['type' => 'buttons', 'items' => [['label' => 'Create workspace', 'semantic' => 'primary', 'state' => 'active']]]),
            ]),
            $this->exampleFromSample('Modal footer actions', 'Confirmation flows keep the confirmation and cancellation choices visible together.', ['type' => 'buttons', 'items' => [
                ['label' => 'Confirm', 'semantic' => 'primary'],
                ['label' => 'Cancel', 'variant' => 'ghost'],
            ]], [
                $this->sampleVariant('Primary confirmation', ['type' => 'buttons', 'items' => [['label' => 'Confirm', 'semantic' => 'primary']]]),
                $this->sampleVariant('Danger confirmation', ['type' => 'buttons', 'items' => [['label' => 'Delete workspace', 'semantic' => 'danger'], ['label' => 'Cancel', 'variant' => 'ghost']]]),
            ]),
            $this->exampleFromSample('Table row actions', 'Dense rows use small outline or ghost actions; icon-only controls keep a 44px target.', ['type' => 'buttons', 'items' => [
                ['label' => 'Open', 'variant' => 'outline', 'size' => 'sm'],
                ['label' => 'Edit', 'variant' => 'ghost', 'size' => 'sm'],
            ]], [
                $this->sampleVariant('Small buttons', ['type' => 'buttons', 'items' => [['label' => 'Open', 'variant' => 'outline', 'size' => 'sm'], ['label' => 'Edit', 'variant' => 'ghost', 'size' => 'sm']]]),
                $this->sampleVariant('Icon-only default', ['type' => 'icon-button', 'items' => [['label' => 'Refresh row', 'icon' => 'arrow-path']]]),
                $this->sampleVariant('Icon-only hover', ['type' => 'icon-button', 'items' => [['label' => 'Refresh row hover', 'icon' => 'arrow-path', 'state' => 'hover']]]),
                $this->sampleVariant('Icon-only focus', ['type' => 'icon-button', 'items' => [['label' => 'Refresh row focus', 'icon' => 'arrow-path', 'state' => 'focus']]]),
                $this->sampleVariant('Icon-only disabled', ['type' => 'icon-button', 'items' => [['label' => 'Refresh row disabled', 'icon' => 'arrow-path', 'disabled' => true]]]),
            ]),
            $this->exampleFromSample('Destructive confirmation', 'Danger buttons are reserved for destructive commands and stay paired with an escape path.', ['type' => 'buttons', 'items' => [
                ['label' => 'Delete tenant', 'semantic' => 'danger'],
                ['label' => 'Cancel', 'variant' => 'ghost'],
            ]], [
                $this->sampleVariant('Danger', ['type' => 'buttons', 'items' => [['label' => 'Delete tenant', 'semantic' => 'danger']]]),
                $this->sampleVariant('Danger hover', ['type' => 'buttons', 'items' => [['label' => 'Delete tenant', 'semantic' => 'danger', 'state' => 'hover']]]),
                $this->sampleVariant('Danger outline', ['type' => 'buttons', 'items' => [['label' => 'Remove access', 'semantic' => 'danger', 'variant' => 'outline']]]),
            ]),
        ], ['button element', 'label text', 'optional icon', 'spinner/loading indicator', 'disabled state', 'focus ring'], [
            'Use when a user needs to submit, confirm, cancel, reveal, or trigger a command.',
            'Use one primary button per region and group lower-emphasis actions nearby.',
            'Use icon-only buttons only when the icon is recognizable and has an accessible name.',
        ], [
            'Do not use buttons for navigation to unrelated content; use links instead.',
            'Do not use support colors for decoration or non-semantic emphasis.',
            'Do not create local button margins; parent layouts own external spacing.',
        ], [
            'Default',
            'Hover',
            'Focus-visible',
            'Active/pressed',
            'Disabled',
            'Loading',
            'Danger',
            'Icon-only',
            'Icon-only loading',
            'Icon-only danger prohibited',
        ], [
            'Click or tap activates the command once unless loading or disabled.',
            'Enter and Space activate native button controls.',
            'Loading buttons keep the label visible and expose `aria-busy`.',
            'Icon-only buttons keep at least a 44px target and require an accessible label.',
        ], [
            'Use verb-led labels such as Save changes, Create workspace, or Delete tenant.',
            'Avoid vague labels such as Go, Submit, More, or OK when a specific verb is possible.',
            'Danger labels name the destructive outcome directly.',
        ], [
            'Buttons are native `button` elements unless a link destination is required.',
            'Disabled buttons use the disabled attribute and are not focusable.',
            'Icon-only controls need an accessible label and visible focus.',
            'Meaning must not rely on color alone; pair danger with explicit copy.',
        ]), [
            'status' => 'Implemented - pending manual review',
            'current_decision' => 'Button uses an expanded matrix-style reference layout because variants, sizes, groups, icons, content behavior, and token/state roles are too broad for the simple tab-plus-variants scaffold.',
            'live_examples_layout' => 'flexible-matrix',
            'live_examples_view' => 'platform.ui-reference.components.live-examples.button',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function linkComponent(): array
    {
        return array_replace($this->correctedImplemented('link', 'Link', 'Links move users to related locations, page sections, protocol destinations, or trusted reference content.', [
            $this->exampleFromSample('Inline content link', 'A link embedded in body copy without taking over action hierarchy.', ['type' => 'links', 'items' => [
                ['label' => 'billing policy section', 'href' => '#link-destination-proof', 'variant' => 'inline'],
            ]], [
                $this->sampleVariant('Inline text', ['type' => 'links', 'items' => [['label' => 'billing policy section', 'href' => '#link-destination-proof', 'variant' => 'inline']]]),
                $this->sampleVariant('Inline icon suppressed', ['type' => 'links', 'items' => [['label' => 'policy notes', 'href' => '#link-destination-proof', 'variant' => 'inline', 'icon' => 'heroicon-o-arrow-top-right-on-square']]]),
            ]),
            $this->exampleFromSample('Standalone internal link', 'A route link after supporting copy, optionally with a trailing icon.', ['type' => 'links', 'items' => [
                ['label' => 'Compare Button rules', 'href' => '/platform/ui-reference/components/button', 'icon' => 'heroicon-o-arrow-right', 'icon_position' => 'end'],
            ]], [
                $this->sampleVariant('Icon trailing', ['type' => 'links', 'items' => [['label' => 'Compare Button rules', 'href' => '/platform/ui-reference/components/button', 'icon' => 'heroicon-o-arrow-right', 'icon_position' => 'end']]]),
                $this->sampleVariant('Same-page anchor', ['type' => 'links', 'items' => [['label' => 'Jump to destination proof', 'href' => '#link-destination-proof', 'icon' => 'heroicon-o-arrow-down']]]),
            ]),
            $this->exampleFromSample('External/help link', 'Reference handoff with a clear external cue and secure new-tab behavior.', ['type' => 'links', 'items' => [
                ['label' => 'Open Carbon Link guidance', 'href' => 'https://carbondesignsystem.com/components/link/usage/', 'external' => true, 'new_tab' => true, 'icon' => 'heroicon-o-arrow-top-right-on-square'],
            ]], [
                $this->sampleVariant('Email link', ['type' => 'links', 'items' => [['label' => 'Email support', 'href' => 'mailto:support@example.com', 'icon' => 'heroicon-o-envelope']]]),
                $this->sampleVariant('Phone link', ['type' => 'links', 'items' => [['label' => 'Call support', 'href' => 'tel:+15555551212', 'icon' => 'heroicon-o-phone']]]),
                $this->sampleVariant('Download link', ['type' => 'links', 'items' => [['label' => 'Download reference', 'href' => '/platform/ui-reference', 'download' => 'ui-reference.html', 'icon' => 'heroicon-o-arrow-down-tray']]]),
            ]),
            $this->exampleFromSample('Navigation link', 'A lightweight current-route link where Button would imply a command.', ['type' => 'links', 'items' => [
                ['label' => 'Link component', 'href' => '/platform/ui-reference/components/link', 'current' => 'page'],
                ['label' => 'Billing unavailable', 'href' => '/platform/billing', 'unavailable' => true],
            ]], [
                $this->sampleVariant('Current page', ['type' => 'links', 'items' => [['label' => 'Link component', 'href' => '/platform/ui-reference/components/link', 'current' => 'page']]]),
                $this->sampleVariant('Unavailable treatment', ['type' => 'links', 'items' => [['label' => 'Billing unavailable', 'href' => '/platform/billing', 'unavailable' => true]]]),
                $this->sampleVariant('Visited policy', ['type' => 'links', 'items' => [['label' => 'Previously viewed runbook', 'href' => '#link-destination-proof', 'visited' => true]]]),
            ]),
            $this->exampleFromSample('Size scale', 'Small, medium, and large links map to Link-owned typography roles.', ['type' => 'links', 'items' => [
                ['label' => 'Small helper link', 'href' => '#link-destination-proof', 'size' => 'sm'],
                ['label' => 'Medium body link', 'href' => '#link-destination-proof', 'size' => 'md'],
                ['label' => 'Large resource link', 'href' => '#link-destination-proof', 'size' => 'lg'],
            ]], [
                $this->sampleVariant('Small', ['type' => 'links', 'items' => [['label' => 'Small helper link', 'href' => '#link-destination-proof', 'size' => 'sm']]]),
                $this->sampleVariant('Medium', ['type' => 'links', 'items' => [['label' => 'Medium body link', 'href' => '#link-destination-proof', 'size' => 'md']]]),
                $this->sampleVariant('Large', ['type' => 'links', 'items' => [['label' => 'Large resource link', 'href' => '#link-destination-proof', 'size' => 'lg']]]),
            ]),
        ], ['native anchor element', 'destination-specific link text', 'optional standalone trailing icon', 'visited policy marker', 'visible focus ring'], [
            'Use when users need to navigate to another route, same-page section, trusted resource, email address, or phone number.',
            'Use inline links only inside prose, and standalone links only outside sentence flow.',
        ], [
            'Do not use Link for save, submit, delete, confirm, cancel, toggle, filtering, sorting, selection, or menu-trigger commands.',
            'Do not use inline links with icons, fake href values, image-only links, or the same generic label for different destinations.',
        ], [
            'Enabled / unvisited',
            'Hover',
            'Focus',
            'Active',
            'Visited policy',
            'Current page',
            'Unavailable / disabled',
            'Inline',
            'Standalone',
            'Small',
            'Medium',
            'Large',
        ], [
            'Interactive links render native anchors with valid internal, external, hash, mailto, tel, or download destinations.',
            'Unavailable links render non-interactive text and do not keep an active href.',
            'External new-tab links include secure rel behavior.',
            'Inline links suppress icons and remain underlined by default.',
            'Standalone links may use a trailing currentColor icon when it clarifies the destination.',
        ], [
            'Use destination-specific text such as Open account settings or Download tax form.',
            'Avoid vague labels such as Click here, More, Learn more, or Read more unless nearby context is programmatically associated.',
            'Use sentence case and keep link text concise enough to scan.',
        ], [
            'Links are keyboard reachable with Tab and activated with Enter.',
            'Every link has meaningful visible text or a meaningful accessible name.',
            'Focus state is visible and token-backed.',
            'External, email, phone, and download destinations are clear from text or icon.',
            'Disabled or unavailable links are not focusable or actionable.',
        ]), [
            'live_examples_view' => 'platform.ui-reference.components.live-examples.link',
            'live_examples_layout' => 'flexible-matrix',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function dropdownComponent(): array
    {
        return array_replace($this->correctedImplemented('dropdown', 'Dropdown', 'Dropdown chooses one value from a known option list through a custom listbox when native Select or an action Menu is not the right boundary.', [
            $this->exampleFromSample('Basic known-option dropdown', 'Single-select Dropdown shows a visible label, placeholder, selected value, and open or closed menu state.', ['type' => 'field', 'items' => [
                ['label' => 'Status', 'type' => 'dropdown', 'name' => 'status', 'value_key' => 'active', 'open' => true],
            ]], [
                $this->sampleVariant('Closed', ['type' => 'field', 'items' => [['label' => 'Status', 'type' => 'dropdown', 'name' => 'status_closed']]]),
                $this->sampleVariant('Open', ['type' => 'field', 'items' => [['label' => 'Status', 'type' => 'dropdown', 'name' => 'status_open', 'value_key' => 'active', 'open' => true]]]),
                $this->sampleVariant('Selected', ['type' => 'field', 'items' => [['label' => 'Status', 'type' => 'dropdown', 'name' => 'status_selected', 'value_key' => 'enabled']]]),
            ]),
            $this->exampleFromSample('Long known-option handoff', 'Long option lists use capped menu height, scrolling affordance, one-line option labels, and title text for overflow labels.', ['type' => 'field', 'items' => [
                ['label' => 'Reference area', 'type' => 'dropdown', 'name' => 'reference_area', 'value_key' => 'enabled', 'menu_max_height' => '11rem', 'open' => true],
            ]], [
                $this->sampleVariant('Capped menu', ['type' => 'field', 'items' => [['label' => 'Capped menu', 'type' => 'dropdown', 'name' => 'capped_menu', 'menu_max_height' => '11rem', 'open' => true]]]),
                $this->sampleVariant('Auto placement', ['type' => 'field', 'items' => [['label' => 'Auto placement', 'type' => 'dropdown', 'name' => 'auto_placement', 'placement' => 'auto']]]),
            ]),
            $this->exampleFromSample('Validation selection', 'Validation examples prove helper, required, error, and warning states without relying on color alone.', ['type' => 'field', 'items' => [
                ['label' => 'Workspace type', 'type' => 'dropdown', 'name' => 'workspace_type', 'state' => 'error', 'required' => true],
                ['label' => 'Owner role', 'type' => 'dropdown', 'name' => 'owner_role', 'state' => 'warning', 'value_key' => 'pending'],
            ]], [
                $this->sampleVariant('Error', ['type' => 'field', 'items' => [['label' => 'Error dropdown', 'type' => 'dropdown', 'name' => 'error_dropdown', 'state' => 'error']]]),
                $this->sampleVariant('Warning', ['type' => 'field', 'items' => [['label' => 'Warning dropdown', 'type' => 'dropdown', 'name' => 'warning_dropdown', 'state' => 'warning']]]),
            ]),
            $this->exampleFromSample('Disabled and read-only dropdown', 'Disabled cannot open; read-only keeps a fixed value visible and suppresses menu opening.', ['type' => 'field', 'items' => [
                ['label' => 'Billing plan', 'type' => 'dropdown', 'name' => 'billing_plan', 'state' => 'disabled', 'value_key' => 'enabled'],
                ['label' => 'System role', 'type' => 'dropdown', 'name' => 'system_role', 'state' => 'readonly', 'value_key' => 'paused'],
            ]], [
                $this->sampleVariant('Disabled', ['type' => 'field', 'items' => [['label' => 'Disabled dropdown', 'type' => 'dropdown', 'name' => 'disabled_dropdown', 'state' => 'disabled']]]),
                $this->sampleVariant('Read-only', ['type' => 'field', 'items' => [['label' => 'Read-only dropdown', 'type' => 'dropdown', 'name' => 'readonly_dropdown', 'state' => 'readonly', 'value_key' => 'enabled']]]),
            ]),
            $this->exampleFromSample('Size comparison', 'Small, medium, and large sizes keep trigger and option row heights aligned.', ['type' => 'field', 'items' => [
                ['label' => 'Small', 'type' => 'dropdown', 'name' => 'dropdown_sm', 'size' => 'sm', 'value_key' => 'enabled'],
                ['label' => 'Medium', 'type' => 'dropdown', 'name' => 'dropdown_md', 'size' => 'md', 'value_key' => 'pending'],
                ['label' => 'Large', 'type' => 'dropdown', 'name' => 'dropdown_lg', 'size' => 'lg', 'value_key' => 'disabled'],
            ]], [
                $this->sampleVariant('Small', ['type' => 'field', 'items' => [['label' => 'Small dropdown', 'type' => 'dropdown', 'name' => 'small_dropdown', 'size' => 'sm']]]),
                $this->sampleVariant('Medium', ['type' => 'field', 'items' => [['label' => 'Medium dropdown', 'type' => 'dropdown', 'name' => 'medium_dropdown', 'size' => 'md']]]),
                $this->sampleVariant('Large', ['type' => 'field', 'items' => [['label' => 'Large dropdown', 'type' => 'dropdown', 'name' => 'large_dropdown', 'size' => 'lg']]]),
            ]),
        ], ['visible label', 'button-like field trigger', 'selected value or placeholder', 'chevron icon', 'listbox menu', 'option rows', 'hidden submitted value', 'helper or validation text'], [
            'Use when users need one value from a predefined list and a custom listbox is more appropriate than native Select.',
            'Use for page filters, sorting controls, modals, side panels, or component controls where the option list is known before interaction.',
        ], [
            'Do not use Dropdown for action menus, overflow commands, destructive options, multiple selections, searchable/custom typed values, or two-option choices.',
            'Do not use Dropdown when native Select satisfies a mostly form-based or mobile-first workflow.',
        ], [
            'Closed',
            'Open',
            'Hover',
            'Focus',
            'Active option',
            'Selected',
            'Invalid',
            'Warning',
            'Disabled',
            'Read-only',
            'Small',
            'Medium',
            'Large',
            'Long menu',
        ], [
            'Trigger click, Enter, Space, or Arrow keys open the menu unless disabled or read-only.',
            'Options are selected through click, Enter, or Space and update the visible value plus hidden submitted value.',
            'Escape, outside click, Tab, or selecting an option closes the menu.',
            'Open and closed states keep matching width; menu placement may resolve up or down to avoid clipping.',
            'Multiselect, filterable multiselect, and combo box behavior belong to separate or deferred owners.',
        ], [
            'Labels are visible, concise, and sentence case.',
            'Options are short text-only labels, preferably three words or fewer.',
            'Long option text truncates visually and exposes the full label through `title`.',
            'Error copy explains recovery; warning copy explains consequence.',
        ], [
            'Trigger exposes a listbox relationship with accessible label and `aria-expanded` state.',
            'Options expose `role="option"` and selected state.',
            'Helper, error, and warning copy are associated with the trigger.',
            'Focus remains visible on trigger and options.',
            'Disabled dropdowns are not interactive; read-only dropdowns stay readable and do not open.',
        ]), [
            'live_examples_view' => 'platform.ui-reference.components.live-examples.dropdown',
            'live_examples_layout' => 'flexible-matrix',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function selectComponent(): array
    {
        return array_replace($this->correctedImplemented('select', 'Select', 'Select collects one submitted form value from a native browser option list.', [
            $this->exampleFromSample('Short native selection', 'Native select renders a visible label, helper text, prompt option, and one scalar selected value.', ['type' => 'field', 'items' => [
                ['type' => 'select', 'label' => 'Status', 'placeholder' => 'Choose status', 'required' => true, 'value_key' => null],
                ['type' => 'select', 'label' => 'Billing cycle', 'value_key' => 'annual'],
            ]], [
                $this->sampleVariant('Prompt option', ['type' => 'field', 'items' => [['type' => 'select', 'label' => 'Status', 'placeholder' => 'Choose status', 'required' => true, 'value_key' => null]]]),
                $this->sampleVariant('Selected value', ['type' => 'field', 'items' => [['type' => 'select', 'label' => 'Billing cycle', 'value_key' => 'annual']]]),
            ]),
            $this->exampleFromSample('Styles and sizes', 'Default select supports small, medium, and large heights; inline and fluid styles stay native.', ['type' => 'field', 'items' => [
                ['type' => 'select', 'label' => 'Small', 'size' => 'sm'],
                ['type' => 'select', 'label' => 'Medium', 'size' => 'md'],
                ['type' => 'select', 'label' => 'Large', 'size' => 'lg'],
            ]], [
                $this->sampleVariant('Small', ['type' => 'field', 'items' => [['type' => 'select', 'label' => 'Small', 'size' => 'sm']]]),
                $this->sampleVariant('Medium', ['type' => 'field', 'items' => [['type' => 'select', 'label' => 'Medium', 'size' => 'md']]]),
                $this->sampleVariant('Large', ['type' => 'field', 'items' => [['type' => 'select', 'label' => 'Large', 'size' => 'lg']]]),
                $this->sampleVariant('Inline', ['type' => 'field', 'items' => [['type' => 'select', 'label' => 'Sort order', 'variant' => 'inline']]]),
                $this->sampleVariant('Fluid', ['type' => 'field', 'items' => [['type' => 'select', 'label' => 'Billing cycle', 'style' => 'fluid']]]),
            ]),
            $this->exampleFromSample('Validation selection', 'Error and warning states replace helper text and keep message IDs associated through aria-describedby.', ['type' => 'field', 'items' => [
                ['type' => 'select', 'label' => 'Account type', 'state' => 'error', 'required' => true],
                ['type' => 'select', 'label' => 'Billing cycle', 'state' => 'warning'],
            ]], [
                $this->sampleVariant('Error', ['type' => 'field', 'items' => [['type' => 'select', 'label' => 'Account type', 'state' => 'error', 'required' => true]]]),
                $this->sampleVariant('Warning', ['type' => 'field', 'items' => [['type' => 'select', 'label' => 'Billing cycle', 'state' => 'warning']]]),
            ]),
            $this->exampleFromSample('Disabled, read-only, and loading', 'Disabled and loading selects are unavailable; read-only renders a value summary rather than an enabled select.', ['type' => 'field', 'items' => [
                ['type' => 'select', 'label' => 'Disabled plan', 'state' => 'disabled'],
                ['type' => 'select', 'label' => 'Read-only plan', 'state' => 'readonly'],
                ['type' => 'select', 'label' => 'Loading plans', 'state' => 'loading'],
            ]], [
                $this->sampleVariant('Disabled', ['type' => 'field', 'items' => [['type' => 'select', 'label' => 'Disabled plan', 'state' => 'disabled']]]),
                $this->sampleVariant('Read-only summary', ['type' => 'field', 'items' => [['type' => 'select', 'label' => 'Read-only plan', 'state' => 'readonly']]]),
                $this->sampleVariant('Loading', ['type' => 'field', 'items' => [['type' => 'select', 'label' => 'Loading plans', 'state' => 'loading']]]),
            ]),
            $this->exampleFromSample('Grouped options', 'Native optgroups may be used when grouping improves scanning and the list remains short.', ['type' => 'field', 'items' => [
                ['type' => 'select', 'label' => 'Workspace state', 'grouped' => true, 'value_key' => 'pending'],
            ]], [
                $this->sampleVariant('Optgroup', ['type' => 'field', 'items' => [['type' => 'select', 'label' => 'Workspace state', 'grouped' => true, 'value_key' => 'pending']]]),
            ]),
        ], ['visible label', 'native select field', 'prompt option', 'selected option', 'helper or validation text', 'status icon', 'read-only summary'], [
            'Use when the user chooses one option that will be submitted as part of a form.',
            'Use for three or more short known options when radio buttons would take too much space.',
        ], [
            'Do not use Select for actions, filtering, sorting, navigation, searchable lists, or multiple selections.',
            'Do not replace native select behavior with custom dropdown chrome when the browser control satisfies the workflow.',
        ], [
            'Enabled',
            'Selected',
            'Hover',
            'Focus',
            'Open',
            'Error',
            'Warning',
            'Disabled',
            'Read-only',
            'Skeleton/loading',
            'Small',
            'Medium',
            'Large',
            'Inline',
            'Fluid',
            'Grouped options',
        ], [
            'Native browser select owns opening, closing, option highlighting, and keyboard behavior.',
            'Read-only state renders a non-interactive value summary with a hidden submitted value.',
            'Loading state disables the select, marks the wrapper busy, and exposes status copy.',
        ], [
            'Labels use one to three concise words where practical.',
            'Option labels are sentence case, parallel, and usually three words or fewer.',
            'Error messages say what the user must correct before saving.',
        ], [
            'Visible labels are associated to the native select by for/id.',
            'Helper, error, warning, and loading copy are associated through aria-describedby.',
            'Error states expose aria-invalid and warnings do not.',
        ]), [
            'live_examples_view' => 'platform.ui-reference.components.live-examples.select',
            'live_examples_layout' => 'flexible-matrix',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function breadcrumbComponent(): array
    {
        $baseTrail = [
            ['label' => 'Platform', 'href' => '#'],
            ['label' => 'Operations', 'href' => '#'],
            ['label' => 'Security settings', 'href' => '#'],
            ['label' => 'Domain rules', 'href' => '#'],
        ];
        $overflowTrail = [
            ['label' => 'Platform', 'href' => '#'],
            ['label' => 'Operations', 'href' => '#'],
            ['label' => 'Tenant admin', 'href' => '#'],
            ['label' => 'Security settings', 'href' => '#'],
            ['label' => 'Domain rules', 'href' => '#'],
        ];
        $currentPage = ['label' => 'Current page'];

        return $this->correctedImplemented('breadcrumb', 'Breadcrumb', 'Breadcrumbs show a user where the current view sits in the app information architecture.', [
            $this->exampleFromSample('Small size', 'Small breadcrumbs pair with page headers and condensed breakpoints.', ['type' => 'breadcrumb', 'items' => $baseTrail, 'size' => 'sm', 'include_current' => false], [
                $this->sampleVariant('Truncated menu', ['type' => 'breadcrumb', 'items' => $overflowTrail, 'size' => 'sm', 'overflow' => true, 'include_current' => false]),
                $this->sampleVariant('Current page listed', ['type' => 'breadcrumb', 'items' => $baseTrail, 'size' => 'sm', 'current' => $currentPage]),
                $this->sampleVariant('Truncated menu with current page listed', ['type' => 'breadcrumb', 'items' => $overflowTrail, 'size' => 'sm', 'overflow' => true, 'current' => $currentPage]),
            ], ['Default trails stop at the previous page unless the current page is unclear without the breadcrumb.']),
            $this->exampleFromSample('Medium size', 'Medium breadcrumbs are the default when there is no page header or when the breadcrumb carries more orientation weight.', ['type' => 'breadcrumb', 'items' => $baseTrail, 'size' => 'md', 'include_current' => false], [
                $this->sampleVariant('Truncated menu', ['type' => 'breadcrumb', 'items' => $overflowTrail, 'size' => 'md', 'overflow' => true, 'include_current' => false]),
                $this->sampleVariant('Current page listed', ['type' => 'breadcrumb', 'items' => $baseTrail, 'size' => 'md', 'current' => $currentPage]),
                $this->sampleVariant('Truncated menu with current page listed', ['type' => 'breadcrumb', 'items' => $overflowTrail, 'size' => 'md', 'overflow' => true, 'current' => $currentPage]),
            ], ['Breadcrumbs never wrap. If the trail is too long, collapse the middle links into the overflow menu.']),
        ], ['navigation landmark', 'ordered list', 'page link', 'separator', 'overflow trigger', 'overflow menu', 'optional current page text'], [
            'Use when users need orientation inside a nested information architecture.',
            'Use small breadcrumbs in page headers and medium breadcrumbs at the top of pages without a title.',
            'Use middle overflow when the first link and last two page links cannot fit on one line.',
        ], [
            'Do not use breadcrumbs for task progress or wizard steps.',
            'Do not wrap breadcrumbs onto a second line.',
            'Do not make the current page an interactive link when it is listed.',
        ], [
            'Default',
            'Hover',
            'Focus-visible',
            'Overflow menu open',
            'Current page listed',
            'Truncated',
            'Disabled not applicable',
        ], [
            'Default trails start at the highest useful parent and stop at the previous page.',
            'When the current page is listed, it is the last item and is plain text with `aria-current`.',
            'Overflow uses the installed default threshold unless `maxVisible` is reviewed for a specific layout.',
            'At larger widths, overflow keeps the first parent breadcrumb as long as possible and exposes hidden middle links in a menu.',
            'At small widths, overflow compresses to the overflow trigger followed by the final visible breadcrumb.',
            'The overflow trigger opens a menu and closes on Escape or outside click.',
        ], [
            'Keep each page link short and entity-specific.',
            'Move from the highest parent toward the current location.',
            'List the current page only when the page title is absent or the location is unclear.',
        ], [
            'Use a `nav` landmark with `aria-label="Breadcrumb"`.',
            'Use an ordered list so the hierarchy is conveyed structurally.',
            'The overflow trigger needs `aria-haspopup="menu"` and synchronized `aria-expanded`.',
            'The current page, when listed, uses `aria-current="page"` and is not a link.',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function tabsComponent(): array
    {
        $baseTabs = [
            ['label' => 'Overview', 'selected' => true, 'panel_title' => 'Overview panel', 'panel' => 'Summary content is available immediately.'],
            ['label' => 'Activity', 'panel_title' => 'Activity panel', 'panel' => 'Recent events and audit activity render in this panel.'],
            ['label' => 'Settings', 'panel_title' => 'Settings panel', 'panel' => 'Configuration controls stay grouped inside the selected tab panel.'],
            ['label' => 'Disabled', 'disabled' => true, 'panel' => 'Disabled tabs are not interactive.'],
        ];
        $iconTabs = [
            ['label' => 'Overview', 'icon' => '◷', 'selected' => true, 'panel' => 'Icon tabs keep icons to the right of the label.'],
            ['label' => 'Members', 'icon' => '◎', 'panel' => 'Members panel content is unique to this tab.'],
            ['label' => 'Settings', 'icon' => '⚙', 'panel' => 'Settings panel content is unique to this tab.'],
        ];
        $dismissibleTabs = [
            ['label' => 'Result A', 'selected' => true, 'dismissible' => true, 'panel' => 'User-created result A can be dismissed.'],
            ['label' => 'Result B', 'dismissible' => true, 'panel' => 'User-created result B can be dismissed.'],
            ['label' => 'Result C', 'dismissible' => true, 'icon' => '◎', 'panel' => 'Dismissible tabs may use icons only when all tabs do.'],
        ];

        return $this->correctedImplemented('tabs', 'Tabs', 'Tabs switch between peer panels while keeping the user in the same task context.', [
            $this->exampleFromSample('Line tabs', 'Flexible tabs for peer sections in a page, modal, or component surface.', ['type' => 'tabs', 'items' => $baseTabs, 'variant' => 'line'], [
                $this->sampleVariant('Scrollable line tabs', ['type' => 'tabs', 'items' => array_merge($baseTabs, [
                    ['label' => 'Billing', 'panel' => 'Billing content.'],
                    ['label' => 'Access', 'panel' => 'Access content.'],
                    ['label' => 'History', 'panel' => 'History content.'],
                ]), 'variant' => 'line', 'scrollable' => true]),
                $this->sampleVariant('Overflow/scroll', ['type' => 'tabs', 'items' => array_merge($baseTabs, [
                    ['label' => 'Billing', 'panel' => 'Billing content.'],
                    ['label' => 'Access', 'panel' => 'Access content.'],
                    ['label' => 'History', 'panel' => 'History content.'],
                ]), 'variant' => 'line', 'scrollable' => true]),
                $this->sampleVariant('Tabs with icons', ['type' => 'tabs', 'items' => $iconTabs, 'variant' => 'line']),
                $this->sampleVariant('Icon-leading', ['type' => 'tabs', 'items' => $iconTabs, 'variant' => 'line'], 'Implemented', 'Rendered as the app icon tab treatment; icons remain pinned to the right side of the label.'),
                $this->sampleVariant('Icon-only tabs', ['type' => 'tabs', 'items' => [
                    ['label' => 'Overview', 'icon' => '◷', 'icon_only' => true, 'selected' => true, 'panel' => 'Icon-only tabs require tooltips or accessible labels.'],
                    ['label' => 'Members', 'icon' => '◎', 'icon_only' => true, 'panel' => 'Members panel.'],
                    ['label' => 'Settings', 'icon' => '⚙', 'icon_only' => true, 'panel' => 'Settings panel.'],
                ], 'variant' => 'line']),
                $this->sampleVariant('Dismissible tabs', ['type' => 'tabs', 'items' => $dismissibleTabs, 'variant' => 'line']),
            ]),
            $this->exampleFromSample('Contained tabs', 'Emphasized tabs attached to a panel for defined sub-page content areas.', ['type' => 'tabs', 'items' => $baseTabs, 'variant' => 'contained'], [
                $this->sampleVariant('Secondary labels', ['type' => 'tabs', 'items' => [
                    ['label' => 'Queued', 'secondary' => '12 items', 'selected' => true, 'panel' => 'Secondary labels are limited to contained tabs.'],
                    ['label' => 'Reviewing', 'secondary' => '4 items', 'panel' => 'Reviewing panel.'],
                    ['label' => 'Passed', 'secondary' => '29 items', 'panel' => 'Passed panel.'],
                ], 'variant' => 'contained', 'grid_aware' => true]),
                $this->sampleVariant('Scrollable contained tabs', ['type' => 'tabs', 'items' => array_merge($baseTabs, [
                    ['label' => 'Billing', 'panel' => 'Billing content.'],
                    ['label' => 'Access', 'panel' => 'Access content.'],
                    ['label' => 'History', 'panel' => 'History content.'],
                ]), 'variant' => 'contained', 'scrollable' => true]),
                $this->sampleVariant('Dismissible tabs with icons', ['type' => 'tabs', 'items' => $dismissibleTabs, 'variant' => 'contained']),
            ]),
            $this->exampleFromSample('Vertical tabs', 'Vertical tabs support quick scanning from top to bottom without replacing navigation.', ['type' => 'tabs', 'items' => $baseTabs, 'variant' => 'line', 'orientation' => 'vertical'], [
                $this->sampleVariant('Vertical grid-aware', ['type' => 'tabs', 'items' => $baseTabs, 'variant' => 'line', 'orientation' => 'vertical', 'grid_aware' => true]),
                $this->sampleVariant('Manual activation', ['type' => 'tabs', 'items' => $baseTabs, 'variant' => 'line', 'orientation' => 'vertical', 'activation' => 'manual']),
                $this->sampleVariant('Small breakpoint handoff', ['type' => 'tabs', 'items' => $baseTabs, 'variant' => 'contained', 'scrollable' => true]),
            ], ['Vertical tabs are not primary navigation. At small breakpoints, use scrolling contained tabs instead of stacking horizontal tabs.']),
        ], ['tablist', 'tab', 'selected indicator', 'optional right-pinned icon', 'optional secondary label', 'dismiss control', 'tabpanel'], [
            'Use tabs for peer content panels in the same context.',
            'Use line tabs for flexible page or component sections.',
            'Use contained tabs when the selected panel should read as a defined surface.',
            'Use vertical tabs for quick scanning where the panel height remains stable.',
        ], [
            'Do not use tabs as primary navigation.',
            'Do not use tabs for progress, comparison, or required linear steps.',
            'Do not wrap horizontal tabs onto multiple lines; use horizontal scroll.',
        ], [
            'Selected',
            'Unselected',
            'Hover',
            'Focus-visible',
            'Disabled',
            'Scrollable',
            'Dismissible',
        ], [
            'One tab is selected by default, usually the first available tab.',
            'Selecting a tab deselects the previously selected tab and updates the panel.',
            'Automatic tablists select when arrow focus moves; manual tablists wait for Enter or Space.',
            'Horizontal tabs scroll instead of wrapping; vertical tabs keep tablist and panel on the same layer.',
        ], [
            'Use short labels that describe the panel content.',
            'Do not mix icon tabs with non-icon tabs in the same list when icons are used for structure.',
            'Use dismissible tabs only for user-created or user-curated content.',
        ], [
            'Use `role="tablist"`, `role="tab"`, and `role="tabpanel"` with matching IDs.',
            'Arrow keys move focus through enabled tabs; Enter and Space activate manual tabs.',
            'Disabled tabs are removed from interaction and are not subject to contrast requirements.',
            'Icon-only tabs need accessible names and a tooltip pattern when used in production.',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function menuComponent(): array
    {
        $items = [
            ['label' => 'Open details', 'shortcut' => 'Enter'],
            ['label' => 'Duplicate', 'shortcut' => 'Ctrl+D'],
            ['label' => 'Move to', 'children' => [
                ['label' => 'Active workspaces'],
                ['label' => 'Archived workspaces'],
            ]],
            ['divider' => true],
            ['label' => 'Delete', 'danger' => true, 'state' => 'danger-hover'],
        ];

        return $this->correctedImplemented('menu', 'Menu', 'Menus present contextual actions behind a trigger without crowding the page.', [
            $this->exampleFromSample('Contextual action menu', 'A closed trigger opens object-level actions in a predictable order, and the proof menu shows the action surface without replacing it with a menu-button example.', ['type' => 'menu', 'items' => $items, 'trigger_label' => 'Workspace actions', 'size' => 'md', 'align' => 'bottom-start', 'proof_panel' => true], [
                $this->sampleVariant('Enabled item', ['type' => 'menu', 'items' => [['label' => 'Open details']], 'trigger_label' => 'Enabled state', 'proof_panel' => true]),
                $this->sampleVariant('Hover item', ['type' => 'menu', 'items' => [['label' => 'Open details', 'state' => 'hover']], 'trigger_label' => 'Hover state', 'proof_panel' => true]),
                $this->sampleVariant('Focus item', ['type' => 'menu', 'items' => [['label' => 'Open details', 'state' => 'focus']], 'trigger_label' => 'Focus state', 'proof_panel' => true]),
                $this->sampleVariant('Focus and hover', ['type' => 'menu', 'items' => [['label' => 'Open details', 'state' => 'focus-hover']], 'trigger_label' => 'Focus + hover', 'proof_panel' => true]),
                $this->sampleVariant('Danger item', ['type' => 'menu', 'items' => [['label' => 'Delete workspace', 'danger' => true]], 'trigger_label' => 'Danger item', 'proof_panel' => true]),
                $this->sampleVariant('Danger hover', ['type' => 'menu', 'items' => [['label' => 'Delete workspace', 'danger' => true, 'state' => 'danger-hover']], 'trigger_label' => 'Danger state', 'proof_panel' => true]),
                $this->sampleVariant('Danger hover and focus', ['type' => 'menu', 'items' => [['label' => 'Delete workspace', 'danger' => true, 'state' => 'danger-focus-hover']], 'trigger_label' => 'Danger focus state', 'proof_panel' => true]),
                $this->sampleVariant('Disabled item', ['type' => 'menu', 'items' => [['label' => 'Export report', 'disabled' => true]], 'trigger_label' => 'Disabled state', 'proof_panel' => true]),
            ], [
                'The base trigger is closed by default and becomes interactive through `initMenus`.',
                'The visible proof panel represents the menu surface itself, not the Menu buttons component.',
                'State variants use static proof panels so review text stays visible.',
            ]),
            $this->exampleFromSample('Row action menu', 'Table rows use icon-only overflow triggers and keep menus short.', ['type' => 'menu', 'items' => [
                ['label' => 'View record'],
                ['label' => 'Edit record'],
                ['label' => 'Export record'],
                ['divider' => true],
                ['label' => 'Disable record', 'danger' => true],
            ], 'trigger_label' => 'Open actions for Workspace alpha', 'trigger_kind' => 'icon', 'size' => 'sm', 'proof_panel' => true], [
                $this->sampleVariant('Icon-only trigger', ['type' => 'menu', 'items' => [['label' => 'View record']], 'trigger_label' => 'Open actions for Workspace beta', 'trigger_kind' => 'icon']),
                $this->sampleVariant('Divided groups', ['type' => 'menu', 'items' => [['label' => 'View record'], ['divider' => true], ['label' => 'Export record']], 'trigger_label' => 'Divided groups', 'proof_panel' => true]),
                $this->sampleVariant('Extra small', ['type' => 'menu', 'items' => [['label' => 'Copy']], 'trigger_label' => 'XS menu', 'size' => 'xs', 'proof_panel' => true]),
                $this->sampleVariant('Small', ['type' => 'menu', 'items' => [['label' => 'Copy']], 'trigger_label' => 'SM menu', 'size' => 'sm', 'proof_panel' => true]),
                $this->sampleVariant('Medium', ['type' => 'menu', 'items' => [['label' => 'Copy']], 'trigger_label' => 'MD menu', 'size' => 'md', 'proof_panel' => true]),
                $this->sampleVariant('Large', ['type' => 'menu', 'items' => [['label' => 'Copy']], 'trigger_label' => 'LG menu', 'size' => 'lg', 'proof_panel' => true]),
            ], [
                'Icon-only row triggers need object-specific accessible labels.',
                'Visible size variants prove item height without leaving overlays open.',
            ]),
            $this->exampleFromSample('Grouped and selected menu', 'Dividers, selected rows, shortcuts, selected indicators, title tooltips, and submenu indicators keep larger menus scannable.', ['type' => 'menu', 'items' => [
                ['label' => 'List view', 'selected' => true, 'selection_type' => 'single'],
                ['label' => 'Card view', 'selection_type' => 'single'],
                ['label' => 'Preview details'],
                ['divider' => true],
                ['label' => 'Sort by', 'children' => [
                    ['label' => 'Created date'],
                    ['label' => 'Workspace owner'],
                    ['label' => 'Review status'],
                ]],
                ['label' => 'Refresh', 'shortcut' => 'R'],
            ], 'trigger_label' => 'View options', 'proof_panel' => true], [
                $this->sampleVariant('Dividers', ['type' => 'menu', 'items' => [['label' => 'Open'], ['label' => 'Duplicate'], ['divider' => true], ['label' => 'Archive'], ['label' => 'Delete workspace', 'danger' => true]], 'trigger_label' => 'Grouped menu', 'proof_panel' => true]),
                $this->sampleVariant('Multi-section grouping', ['type' => 'menu', 'items' => [['label' => 'Open'], ['label' => 'Duplicate'], ['divider' => true], ['label' => 'Export'], ['label' => 'Share'], ['divider' => true], ['label' => 'Delete workspace', 'danger' => true]], 'trigger_label' => 'Sectioned menu', 'proof_panel' => true]),
                $this->sampleVariant('Keyboard shortcut', ['type' => 'menu', 'items' => [['label' => 'Refresh', 'shortcut' => 'R']], 'trigger_label' => 'Shortcut menu', 'proof_panel' => true]),
                $this->sampleVariant('Submenu actions', ['type' => 'menu', 'items' => [['label' => 'Move to', 'children' => [['label' => 'Active workspaces'], ['label' => 'Archived workspaces'], ['label' => 'Review queue']]]], 'trigger_label' => 'Submenu menu', 'proof_panel' => true]),
                $this->sampleVariant('Single-select', ['type' => 'menu', 'items' => [['label' => 'List view', 'selected' => true, 'selection_type' => 'single'], ['label' => 'Card view', 'selection_type' => 'single'], ['label' => 'Preview details']], 'trigger_label' => 'Single select', 'proof_panel' => true]),
                $this->sampleVariant('Multi-select', ['type' => 'menu', 'items' => [['label' => 'Owner access', 'selected' => true, 'selection_type' => 'multiple'], ['label' => 'Billing access', 'selected' => true, 'selection_type' => 'multiple'], ['label' => 'Audit access', 'selection_type' => 'multiple']], 'trigger_label' => 'Multi select', 'proof_panel' => true]),
                $this->sampleVariant('Truncated label with title', ['type' => 'menu', 'items' => [['label' => 'Open the complete workspace audit evidence package', 'title' => 'Open the complete workspace audit evidence package']], 'trigger_label' => 'Truncated label', 'proof_panel' => true]),
            ], [
                'Selected menu items use menuitemradio or menuitemcheckbox roles only for compact command settings.',
                'Selected and unselected rows reserve the same indicator column so labels stay aligned.',
                'Submenus are working one-level action groups; deeper nesting remains prohibited.',
            ]),
            $this->exampleFromSample('Alignment and RTL', 'Open menus align to the available space and mirror in RTL contexts.', ['type' => 'menu', 'items' => [['label' => 'Open'], ['label' => 'Export']], 'trigger_label' => 'Aligned menu', 'align' => 'bottom-end', 'proof_panel' => true], [
                $this->sampleVariant('Bottom start', ['type' => 'menu', 'items' => [['label' => 'Open']], 'trigger_label' => 'Bottom start', 'align' => 'bottom-start', 'proof_panel' => true]),
                $this->sampleVariant('Bottom end', ['type' => 'menu', 'items' => [['label' => 'Open']], 'trigger_label' => 'Bottom end', 'align' => 'bottom-end', 'proof_panel' => true]),
                $this->sampleVariant('Top start', ['type' => 'menu', 'items' => [['label' => 'Open']], 'trigger_label' => 'Top start', 'align' => 'top-start', 'proof_panel' => true]),
                $this->sampleVariant('Top end', ['type' => 'menu', 'items' => [['label' => 'Open']], 'trigger_label' => 'Top end', 'align' => 'top-end', 'proof_panel' => true]),
                $this->sampleVariant('RTL mirrored', ['type' => 'menu', 'items' => [['label' => 'Open'], ['label' => 'Move to', 'children' => [['label' => 'Review queue'], ['label' => 'Archive']]], ['label' => 'Shortcut action', 'shortcut' => 'Ctrl+K']], 'trigger_label' => 'RTL menu', 'rtl' => true, 'proof_panel' => true]),
            ], [
                'Placement is exposed as a component data hook for visual and behavior review.',
                'RTL proof mirrors the trigger, menu panel, submenu indicator, submenu placement, and shortcut direction inside the same component contract.',
            ]),
        ], ['trigger', 'menu container', 'action item', 'divider', 'submenu indicator', 'keyboard shortcut', 'selected item', 'danger item'], [
            'Use when several contextual actions belong behind a trigger.',
            'Use menu buttons for small grouped action sets and row overflow actions.',
            'Use dividers to group related actions and separate destructive commands.',
        ], [
            'Do not hide primary actions that should be visible.',
            'Do not put more than five items in menu-button menus or more than twelve items in overflow/context menus.',
            'Do not add multiple nested submenu levels.',
        ], [
            'Enabled',
            'Hover',
            'Focus',
            'Focus and hover',
            'Selected',
            'Danger hover',
            'Danger hover and focus',
            'Disabled',
        ], [
            'Clicking the trigger opens the menu and focuses the first item.',
            'Up and Down arrows move between items; Enter activates an item; Escape closes and returns focus.',
            'Clicking outside closes the menu.',
            'Submenus are one-level boundaries only unless a later workflow justifies deeper nesting.',
        ], [
            'Use short, precise action labels.',
            'Order actions by expected use and group related actions with dividers.',
            'When a term repeats across more than two actions, move the shared term to the submenu label.',
            'Use browser title text for rare truncated menu labels.',
        ], [
            'The trigger must expose `aria-haspopup="menu"` and synchronized `aria-expanded`.',
            'Menu items use `role="menuitem"` and visible focus.',
            'Disabled items remain visible only when the action may become available later.',
            'Permission-impossible actions should be hidden instead of disabled.',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function menuButtonsComponent(): array
    {
        return array_replace($this->correctedImplemented('menu-buttons', 'Menu buttons', 'Menu buttons expose grouped secondary actions from a button trigger.', [
            $this->exampleFromSample('Menu button', 'A labeled trigger opens actions with the same relative importance.', ['type' => 'menu-button', 'items' => [
                ['label' => 'Create', 'kind' => 'menu-button', 'type' => 'primary'],
            ]], []),
            $this->exampleFromSample('Combo button', 'A visible primary action stays available while related alternate actions live in the menu.', ['type' => 'menu-button', 'items' => [
                ['label' => 'Save', 'kind' => 'combo-button'],
            ]], []),
            $this->exampleFromSample('Overflow menu', 'An icon-only trigger exposes additional row, card, or toolbar actions in constrained space.', ['type' => 'menu-button', 'items' => [
                ['label' => 'Workspace actions', 'kind' => 'overflow-menu'],
            ]], []),
        ], ['trigger button', 'primary action button for combo', 'icon trigger for overflow or combo', 'menu surface', 'menu item', 'danger menu item', 'disabled trigger'], [
            'Use a menu button when all actions in the menu list share the same level of importance.',
            'Use a combo button when screen real estate is limited and one action has clear primary importance.',
            'Use an overflow menu when additional row, card, or toolbar options are available in constrained space.',
        ], [
            'Do not use Menu buttons for value selection; use Dropdown, Select, or Multiselect.',
            'Do not hide the only safe escape path or the only primary action in a menu.',
            'Do not put forms, search fields, checkboxes, radio groups, or rich controls inside a menu.',
        ], [
            'Default',
            'Hover',
            'Focus-visible',
            'Open',
            'Disabled',
            'Loading trigger',
            'Danger menu item',
            'Keyboard item focus',
        ], [
            'Click or tap opens the menu trigger and keeps helper/reference page text visible while closed.',
            'Menu button and overflow menu examples start closed unless a section explicitly demonstrates open state.',
            'Combo button separates the primary action from the menu trigger and preserves focus order.',
            'Trigger size and menu item size stay aligned across extra small, small, medium, and large.',
        ], [
            'Use short sentence-case trigger labels that describe the shared action or object.',
            'Use a shared verb on the trigger when menu items are distinct objects for that verb.',
            'Overflow accessible labels must name the object or region, such as Workspace actions.',
            'Danger item labels must name the destructive outcome directly.',
        ], [
            'Every trigger is a native button with an accessible name.',
            'Menu triggers expose `aria-haspopup`, `aria-expanded`, and `aria-controls` through the Menu API.',
            'Icon-only overflow triggers require an accessible label and visible focus.',
            'Escape closes an open menu and returns focus to the trigger.',
        ]), [
            'status' => 'Implemented - pending manual review',
            'current_decision' => 'Menu buttons use a matrix-style reference layout so Menu button, Combo button, Overflow menu, sizing, width, state, keyboard, and content boundaries remain reviewable.',
            'live_examples_layout' => 'flexible-matrix',
            'live_examples_view' => 'platform.ui-reference.components.live-examples.menu-buttons',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function codeSnippetComponent(): array
    {
        return array_replace($this->correctedImplemented('code-snippet', 'Code snippet', 'Code snippets present implementation examples with app-approved code typography, syntax token colors, copy controls, and optional multi-line expansion.', [
            $this->exampleFromSample('Single-line code', 'Short API calls stay on one line and may include a copy action.', ['type' => 'code', 'variant' => 'single', 'language' => 'Blade', 'copyable' => true, 'items' => [], 'code' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.button</span> <span class="ui-code-token-property">semantic</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"primary"</span><span class="ui-code-token-punctuation">&gt;</span>Save<span class="ui-code-token-punctuation">&lt;/</span><span class="ui-code-token-keyword">x-ui.button</span><span class="ui-code-token-punctuation">&gt;</span>'], [
                $this->sampleVariant('Copy ready', ['type' => 'code', 'variant' => 'single', 'language' => 'Blade', 'copyable' => true, 'items' => [], 'code' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.button</span><span class="ui-code-token-punctuation"> /&gt;</span>']),
                $this->sampleVariant('Copied state', ['type' => 'code', 'variant' => 'single', 'language' => 'Blade', 'copyable' => true, 'copy_state' => 'copied', 'items' => [], 'code' => '<span class="ui-code-token-keyword">Copied</span>']),
            ]),
            $this->exampleFromSample('Multi-line code', 'Longer examples preserve line breaks and scan as implementation snippets.', ['type' => 'code', 'variant' => 'multi', 'language' => 'Blade', 'copyable' => true, 'items' => [], 'code' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.menu</span><br>    <span class="ui-code-token-property">:items</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$items"</span><br>    <span class="ui-code-token-property">trigger-label</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Actions"</span><br><span class="ui-code-token-punctuation">/&gt;</span>'], [
                $this->sampleVariant('Without copy', ['type' => 'code', 'variant' => 'multi', 'language' => 'Blade', 'items' => [], 'code' => '<span class="ui-code-token-keyword">Route</span>::<span class="ui-code-token-property">get</span>(<span class="ui-code-token-string">"/platform"</span>);']),
                $this->sampleVariant('With copy', ['type' => 'code', 'variant' => 'multi', 'language' => 'PHP', 'copyable' => true, 'items' => [], 'code' => '<span class="ui-code-token-keyword">return</span> <span class="ui-code-token-string">"copied"</span><span class="ui-code-token-punctuation">;</span>']),
            ]),
            $this->exampleFromSample('Highlighted syntax tokens', 'Highlighted token roles use the Typography and Color code-token system.', ['type' => 'code', 'variant' => 'multi', 'language' => 'HTML', 'items' => [], 'code' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">p</span> <span class="ui-code-token-property">class</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"ui-type-mono"</span><span class="ui-code-token-punctuation">&gt;</span>code snippet<span class="ui-code-token-punctuation">&lt;/</span><span class="ui-code-token-keyword">p</span><span class="ui-code-token-punctuation">&gt;</span>'], [
                $this->sampleVariant('Keyword token', ['type' => 'code', 'variant' => 'single', 'language' => 'Token', 'items' => [], 'code' => '<span class="ui-code-token-keyword">keyword</span>']),
                $this->sampleVariant('Property token', ['type' => 'code', 'variant' => 'single', 'language' => 'Token', 'items' => [], 'code' => '<span class="ui-code-token-property">property</span>']),
                $this->sampleVariant('String token', ['type' => 'code', 'variant' => 'single', 'language' => 'Token', 'items' => [], 'code' => '<span class="ui-code-token-string">"string"</span>']),
            ]),
        ], ['snippet shell', 'optional header', 'language label', 'preformatted code', 'syntax token spans', 'optional copy button'], [
            'Use when a developer needs to read or reuse exact implementation syntax.',
            'Use highlighted tokens for code samples on docs and reference pages.',
            'Use copy controls only where copying is genuinely useful.',
        ], [
            'Do not use code snippets for ordinary prose or labels.',
            'Do not hard-code syntax colors; use `ui-code-token-*` classes.',
            'Do not show speculative API calls as complete examples.',
        ], [
            'Single-line',
            'Multi-line',
            'Highlighted',
            'Copy ready',
            'Copied',
            'Overflow',
        ], [
            'Snippets preserve whitespace and line breaks.',
            'Copy buttons are optional and must update visible state when implemented.',
            'Long examples scroll horizontally instead of wrapping into misleading syntax.',
            'Multi-line snippets may expose a show-more ghost button when the layout needs a collapsed view.',
        ], [
            'Keep examples short and tied to the current component API.',
            'Use highlighted tokens only for syntax roles such as keyword, property, string, and punctuation.',
            'Do not use colored code text as decoration outside code contexts.',
        ], [
            'Use semantic `pre` and `code` structure.',
            'Copy controls must be keyboard reachable and announce copied state when implemented.',
            'Token colors must meet contrast in light and dark themes.',
        ]), [
            'status' => 'Implemented - pending manual review',
            'current_decision' => 'Code snippet owns inline, single-line, multi-line, copy tooltip/status, syntax token, horizontal overflow, light modifier, and show-more proof through the installed x-ui.code-snippet API.',
            'live_examples_layout' => 'flexible-matrix',
            'live_examples_view' => 'platform.ui-reference.components.live-examples.code-snippet',
        ]);
    }

    /**
     * @param array<int, array{0: string, 1: string, 2: string, 3: array<int, array<string, mixed>>, 4: array<int, array<string, mixed>>}> $examples
     * @param array<int, string> $anatomy
     *
     * @return array<string, mixed>
     */
    private function actions(string $slug, string $label, string $purpose, array $examples, array $anatomy): array
    {
        return $this->implemented($slug, $label, $purpose, $examples, $anatomy, [
            'Use when a user needs to start, confirm, navigate to, or reveal a clearly labeled action.',
            'Use approved action hierarchy so each region has one obvious primary action.',
        ], [
            'Do not use action controls as decoration or status indicators.',
            'Do not introduce local colors, margins, or unapproved icon-only controls.',
        ], [
            'Default, hover, focus-visible, active/pressed, disabled, and loading where applicable.',
            'Danger state is reserved for destructive actions with clear labels.',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function tooltipComponent(): array
    {
        return array_replace($this->correctedImplemented('tooltip', 'Tooltip', 'Tooltip provides short non-interactive help on hover or focus.', [
            $this->exampleFromSample('Icon-only button tooltip', 'Icon-only controls expose concise one- or two-word help on hover and focus.', ['type' => 'tooltip', 'items' => [
                ['title' => 'Refresh data', 'placement' => 'top'],
            ]], []),
            $this->exampleFromSample('Definition tooltip', 'Definition terms use dotted underline treatment and concise sentence-copy help.', ['type' => 'tooltip', 'items' => [
                ['title' => 'A workspace groups users, roles, and settings for one account.', 'placement' => 'top'],
            ]], []),
            $this->exampleFromSample('Placement and alignment', 'Top, right, bottom, left, start, center, and end placements are demonstrated with the installed component.', ['type' => 'tooltip', 'items' => [
                ['title' => 'Placement example', 'placement' => 'auto'],
            ]], []),
        ], ['UI trigger', 'caret tip', 'tooltip container', 'definition trigger', 'non-interactive text'], [
            'Use for short optional help on hover and focus.',
            'Use for icon-only controls that need a concise visible description.',
            'Use for definition terms with short glossary copy.',
        ], [
            'Do not put essential task instructions in a tooltip.',
            'Do not place links, buttons, form controls, or interactive content in a tooltip.',
            'Do not use Tooltip where Toggletip, Popover, helper text, or Modal is the correct surface.',
        ], [
            'Closed',
            'Open on hover',
            'Open on focus',
            'Escape dismissal',
            'Definition hover/focus',
        ], [
            'Hovering or focusing the trigger opens the tooltip.',
            'The tooltip remains associated with the trigger through `aria-describedby`.',
            'Escape closes the tooltip without moving focus.',
            'Auto placement keeps the tooltip in view where supported; mobile auto placement resolves below the trigger.',
        ], [
            'Icon-only tooltip copy should be concise, usually one or two words.',
            'Definition tooltip copy should be sentence case and punctuated.',
            'Tooltip copy is optional help, not required instructions.',
        ], [
            'Tooltip content is non-focusable and non-interactive.',
            'Triggers remain keyboard reachable and visibly focused.',
            'The caret and container point to the trigger without obscuring essential nearby content.',
            'Reduced motion disables tooltip transitions.',
        ]), [
            'status' => 'Implemented - pending manual review',
            'current_decision' => 'Tooltip now uses a component-owned overlay surface with caret, sizing, placement, alignment, accessible description, and hover/focus/Escape behavior.',
            'live_examples_layout' => 'flexible-matrix',
            'live_examples_view' => 'platform.ui-reference.components.live-examples.tooltip',
        ]);
    }

    /**
     * @param array<int, string> $scenarios
     *
     * @return array<string, mixed>
     */
    private function inputs(string $slug, string $label, string $purpose, string $type, array $scenarios): array
    {
        $examples = array_map(fn (string $scenario): array => [
            $scenario,
            $scenario.' demonstrates label, helper, validation, disabled, or read-only behavior using app field classes.',
            'field',
            [['label' => $scenario, 'type' => $type, 'value' => $this->fieldValue($type), 'state' => $this->fieldState($scenario)]],
            [
                $this->variant('Helper text', 'field', [['label' => 'Field with helper text', 'type' => $type, 'value' => $this->fieldValue($type)]]),
                $this->variant('Focus-visible', 'field', [['label' => 'Focused field', 'type' => $type, 'value' => $this->fieldValue($type), 'state' => 'focus']]),
                $this->variant('Disabled', 'field', [['label' => 'Disabled field', 'type' => $type, 'value' => $this->fieldValue($type), 'state' => 'disabled']]),
                $this->variant('Read-only', 'field', [['label' => 'Read-only field', 'type' => $type, 'value' => $this->fieldValue($type), 'state' => 'readonly']]),
                $this->variant('Validation', 'field', [['label' => 'Validation field', 'type' => $type, 'value' => $this->fieldValue($type), 'state' => 'error']]),
            ],
        ], $scenarios);

        return $this->implemented($slug, $label, $purpose, $examples, ['label', 'control', 'helper text', 'validation message', 'status icon', 'disabled/read-only treatment'], [
            'Use when users need to enter or choose app data directly.',
            'Use labels, helper text, validation, and token-backed field states consistently.',
        ], [
            'Do not rely on placeholder text as the only label.',
            'Do not use custom field chrome when the native control satisfies the workflow.',
        ], [
            'Default, hover-capable, focus-visible, disabled, read-only, helper, error, warning, and loading where applicable.',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function datePickerComponent(): array
    {
        return array_replace($this->correctedImplemented('date-picker', 'Date picker', 'Date picker uses native date and date-time controls for simple date entry while deferring custom calendar and range-picker behavior.', [
            $this->exampleFromSample('Native date entry', 'Native single-date entry with visible label, helper copy, browser picker behavior, and optional min/max constraints.', ['type' => 'date-picker', 'items' => [
                ['name' => 'start_date', 'label' => 'Start date', 'value' => '2026-06-08', 'helper' => 'Use the first date this setting should apply.', 'date_format' => 'yyyy-mm-dd'],
            ]], [
                $this->sampleVariant('Required date', ['type' => 'date-picker', 'items' => [
                    ['name' => 'review_due', 'label' => 'Review due date', 'value' => '2026-06-15', 'helper' => 'Required dates must also be validated on the server.', 'required' => true],
                ]]),
                $this->sampleVariant('Bounded date', ['type' => 'date-picker', 'items' => [
                    ['name' => 'policy_start', 'label' => 'Policy start date', 'value' => '2026-06-08', 'min' => '2026-01-01', 'max' => '2026-12-31', 'helper' => 'Allowed dates run from January 1 through December 31, 2026.'],
                ]]),
            ], [
                'The browser popup is native browser behavior; the app owns the field shell, label, helper, and validation treatment.',
            ]),
            $this->exampleFromSample('Date-time entry', 'Native date-time entry for simple scheduling where the surrounding pattern explains the relevant time zone.', ['type' => 'date-picker', 'items' => [
                ['name' => 'scheduled_at', 'label' => 'Scheduled activation', 'value' => '2026-06-08T09:30', 'date_type' => 'datetime-local', 'helper' => 'Times use the workspace time zone.'],
            ]], [
                $this->sampleVariant('Minute step', ['type' => 'date-picker', 'items' => [
                    ['name' => 'maintenance_start', 'label' => 'Maintenance start', 'value' => '2026-06-08T09:30', 'date_type' => 'datetime-local', 'step' => '60', 'helper' => 'Minute precision is allowed for this scheduling workflow.'],
                ]]),
                $this->sampleVariant('Warning state', ['type' => 'date-picker', 'items' => [
                    ['name' => 'late_window', 'label' => 'Late maintenance window', 'value' => '2026-06-08T23:30', 'date_type' => 'datetime-local', 'state' => 'warning', 'warning' => 'This time is outside the recommended maintenance window.'],
                ]]),
            ]),
            $this->exampleFromSample('Styles and sizes', 'Small, medium, large, and fluid field treatments use the same native input behavior.', ['type' => 'date-picker', 'items' => [
                ['name' => 'date_sm', 'label' => 'Small', 'value' => '2026-06-08', 'size' => 'sm'],
                ['name' => 'date_md', 'label' => 'Medium', 'value' => '2026-06-08', 'size' => 'md'],
                ['name' => 'date_lg', 'label' => 'Large', 'value' => '2026-06-08', 'size' => 'lg'],
            ]], [
                $this->sampleVariant('Small', ['type' => 'date-picker', 'items' => [['name' => 'date_sm', 'label' => 'Small', 'value' => '2026-06-08', 'size' => 'sm']]]),
                $this->sampleVariant('Medium', ['type' => 'date-picker', 'items' => [['name' => 'date_md', 'label' => 'Medium', 'value' => '2026-06-08', 'size' => 'md']]]),
                $this->sampleVariant('Large', ['type' => 'date-picker', 'items' => [['name' => 'date_lg', 'label' => 'Large', 'value' => '2026-06-08', 'size' => 'lg']]]),
                $this->sampleVariant('Fluid', ['type' => 'date-picker', 'items' => [['name' => 'date_fluid', 'label' => 'Fluid date', 'value' => '2026-06-08', 'style' => 'fluid']]]),
            ]),
            $this->exampleFromSample('Validation states', 'Required date entry with blocking error copy, warning copy, and non-color-only status treatment.', ['type' => 'date-picker', 'items' => [
                ['name' => 'expires_on', 'label' => 'Expiration date', 'value' => '', 'state' => 'error', 'error' => 'Choose an expiration date before saving.', 'required' => true],
            ]], [
                $this->sampleVariant('Error', ['type' => 'date-picker', 'items' => [
                    ['name' => 'cutover_date', 'label' => 'Cutover date', 'value' => '', 'state' => 'error', 'error' => 'Choose a cutover date before continuing.'],
                ]]),
                $this->sampleVariant('Warning', ['type' => 'date-picker', 'items' => [
                    ['name' => 'review_date', 'label' => 'Review date', 'value' => '2026-12-24', 'state' => 'warning', 'warning' => 'Review dates near holidays need owner confirmation.'],
                ]]),
            ]),
            $this->exampleFromSample('Disabled, read-only, and loading', 'Unavailable, fixed, and pending date values stay visible without offering an editable date picker.', ['type' => 'date-picker', 'items' => [
                ['name' => 'created_on', 'label' => 'Created on', 'value' => '2026-06-08', 'state' => 'readonly', 'helper' => 'Created date is system-managed.'],
                ['name' => 'locked_until', 'label' => 'Locked until', 'value' => '2026-06-30', 'state' => 'disabled', 'helper' => 'This date is controlled by tenant policy.'],
            ]], [
                $this->sampleVariant('Read-only', ['type' => 'date-picker', 'items' => [
                    ['name' => 'audit_date', 'label' => 'Audit date', 'value' => '2026-06-08', 'state' => 'readonly', 'helper' => 'Audit dates are generated by the system.'],
                ]]),
                $this->sampleVariant('Disabled', ['type' => 'date-picker', 'items' => [
                    ['name' => 'policy_unlock', 'label' => 'Policy unlock date', 'value' => '2026-07-01', 'state' => 'disabled', 'helper' => 'Policy unlock date is not editable in this state.'],
                ]]),
                $this->sampleVariant('Loading', ['type' => 'date-picker', 'items' => [
                    ['name' => 'available_date', 'label' => 'Available date', 'state' => 'loading'],
                ]]),
            ]),
            $this->exampleFromSample('Range and calendar boundaries', 'Range relationships are pattern-owned today; custom calendar range picker behavior remains gated.', ['type' => 'deferred', 'items' => [
                ['label' => 'Use two x-ui.date-picker fields or the Date range filter Pattern until a custom calendar range API is approved.'],
                ['label' => 'Trigger only when unavailable-date rules, calendar panels, range previews, and keyboard range selection are fully specified.'],
            ]], [
                $this->sampleVariant('Pattern-owned range', ['type' => 'deferred', 'items' => [
                    ['label' => 'Date range filtering belongs to the Forms/Tables Pattern until a range-picker Component is approved.'],
                ]], 'Deferred', 'Do not fake a custom range calendar on the Component page.'),
            ]),
        ], ['label', 'native date/date-time input', 'helper text', 'validation message', 'status icon', 'min/max/step constraints', 'disabled/read-only treatment'], [
            'Use native date or date-time entry for simple field-level date capture.',
            'Use visible helper copy when constraints, time zone, or business rules affect the date.',
            'Use server-side validation as the source of truth for required, minimum, maximum, and business-rule validation.',
        ], [
            'Do not build custom calendar chrome for simple date entry.',
            'Do not use Date picker for date ranges, unavailable-date rules, or scheduling workflows without a Pattern owner.',
            'Do not rely on placeholder text or native browser UI as the only instruction.',
        ], [
            'Default',
            'Hover-capable',
            'Focus-visible',
            'Required',
            'Disabled',
            'Read-only',
            'Error',
            'Warning',
            'Date-time',
            'Range deferred',
        ], [
            'The input uses native date or datetime-local browser behavior; the app owns label, helper, validation, status, and layout treatment.',
            'Disabled fields are not editable or focusable; read-only fields expose fixed values without allowing edits.',
            'Minimum, maximum, and step constraints must be paired with server validation and user-visible helper or error copy when they affect the task.',
            'Custom range selection, masked input, unavailable dates, and calendar panels remain gated until a dedicated API is approved.',
        ], [
            'Write labels in sentence case and name the date being captured, such as Start date or Expiration date.',
            'Explain time zone ownership when using date-time fields.',
            'Error copy must describe recovery, not only restate that a date is invalid.',
            'Do not hide required date constraints inside placeholder text or native picker behavior.',
        ], [
            'Every field needs a visible label associated with the native input.',
            'Use `aria-invalid` and visible error text for blocking validation.',
            'Helper, warning, and error copy must be referenced by `aria-describedby` where present.',
            'Do not rely on color alone for error or warning states; include visible text and status icon treatment.',
            'Native browser picker behavior varies by platform, so the server validation contract must remain authoritative.',
        ]), [
            'live_examples_view' => 'platform.ui-reference.components.live-examples.date-picker',
            'live_examples_layout' => 'flexible-matrix',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function contentSwitcherComponent(): array
    {
        return $this->correctedImplemented('content-switcher', 'Content switcher', 'Content switcher switches compact peer views without implying primary navigation, form selection, or task progress.', [
            $this->exampleFromSample('Peer view switcher', 'Use when a compact surface needs two or three related views in the same workflow region.', [
                'type' => 'content-switcher',
                'label' => 'Workspace view',
                'items' => [
                    ['id' => 'content-switcher-summary', 'label' => 'Summary', 'value' => 'summary', 'selected' => true, 'panel_title' => 'Summary view', 'panel' => 'Key workspace metrics remain visible without navigating away.'],
                    ['id' => 'content-switcher-activity', 'label' => 'Activity', 'value' => 'activity', 'panel_title' => 'Activity view', 'panel' => 'Recent changes and comments appear in the same region.'],
                    ['id' => 'content-switcher-settings', 'label' => 'Settings', 'value' => 'settings', 'panel_title' => 'Settings view', 'panel' => 'Configuration details stay local to this compact surface.'],
                ],
            ], [
                $this->sampleVariant('Default', [
                    'type' => 'content-switcher',
                    'label' => 'View mode',
                    'items' => [
                        ['label' => 'Summary', 'value' => 'summary', 'selected' => true],
                        ['label' => 'Activity', 'value' => 'activity'],
                    ],
                ]),
                $this->sampleVariant('Compact', [
                    'type' => 'content-switcher',
                    'label' => 'Density',
                    'size' => 'sm',
                    'items' => [
                        ['label' => 'Daily', 'value' => 'daily', 'selected' => true],
                        ['label' => 'Weekly', 'value' => 'weekly'],
                    ],
                ]),
            ]),
            $this->exampleFromSample('Icon view switcher', 'Icons may reinforce short labels when the available space is constrained.', [
                'type' => 'content-switcher',
                'label' => 'Display mode',
                'items' => [
                    ['label' => 'List', 'value' => 'list', 'icon' => 'heroicon-o-list-bullet', 'selected' => true, 'panel_title' => 'List display', 'panel' => 'Rows stay dense and scannable.'],
                    ['label' => 'Grid', 'value' => 'grid', 'icon' => 'heroicon-o-squares-2x2', 'panel_title' => 'Grid display', 'panel' => 'Tiles emphasize visual grouping.'],
                    ['label' => 'Map', 'value' => 'map', 'icon' => 'heroicon-o-map', 'disabled' => true, 'panel_title' => 'Map display', 'panel' => 'Unavailable options are disabled only when they can become available.'],
                ],
            ], [
                $this->sampleVariant('Icon labels', [
                    'type' => 'content-switcher',
                    'label' => 'Display mode',
                    'items' => [
                        ['label' => 'List', 'value' => 'list', 'icon' => 'heroicon-o-list-bullet', 'selected' => true],
                        ['label' => 'Grid', 'value' => 'grid', 'icon' => 'heroicon-o-squares-2x2'],
                    ],
                ]),
                $this->sampleVariant('Disabled option', [
                    'type' => 'content-switcher',
                    'label' => 'Display mode',
                    'items' => [
                        ['label' => 'List', 'value' => 'list', 'selected' => true],
                        ['label' => 'Map', 'value' => 'map', 'disabled' => true],
                    ],
                ]),
            ]),
            $this->exampleFromSample('Toolbar mode switcher', 'Use without panels only when the switched region is owned by a nearby parent component or pattern.', [
                'type' => 'content-switcher',
                'label' => 'Toolbar mode',
                'show_panels' => false,
                'size' => 'sm',
                'items' => [
                    ['label' => 'Open', 'value' => 'open', 'selected' => true],
                    ['label' => 'Closed', 'value' => 'closed'],
                    ['label' => 'All', 'value' => 'all'],
                ],
            ], [
                $this->sampleVariant('No panel mode', [
                    'type' => 'content-switcher',
                    'label' => 'Filter mode',
                    'show_panels' => false,
                    'size' => 'sm',
                    'items' => [
                        ['label' => 'Open', 'value' => 'open', 'selected' => true],
                        ['label' => 'All', 'value' => 'all'],
                    ],
                ]),
            ]),
        ], ['container', 'tablist', 'switcher option', 'selected option', 'optional icon', 'optional panel region'], [
            'Use for compact peer view switching inside a page, card, toolbar, or panel.',
            'Use when two or three equal views need less visual weight than Tabs.',
            'Use labels that describe the displayed view, not actions.',
        ], [
            'Do not use for command actions; use Button or Menu buttons.',
            'Do not use for form value submission; use Radio button, Select, Checkbox, or Toggle.',
            'Do not use for route/location navigation; use Navigation, Breadcrumb, or Tabs when panel semantics are needed.',
            'Do not use for progress; use Progress indicator.',
        ], [
            'Default',
            'Hover',
            'Focus-visible',
            'Selected',
            'Disabled',
            'Compact',
            'Icon with label',
        ], [
            'Uses tablist/tab/tabpanel semantics because options switch visible peer content.',
            'Arrow keys, Home, and End move between enabled options and update the selected panel.',
            'Enter and Space select the focused option.',
            'Disabled options remain visible only when availability can change.',
            'Horizontal overflow scrolls instead of wrapping.',
        ], [
            'Use short nouns such as Summary, Activity, Open, or Closed.',
            'Avoid action verbs that make options read like command buttons.',
            'Keep option count to two or three unless a stronger component standard approves more.',
        ], [
            'Provide an accessible group label through the component label prop.',
            'Keep `aria-selected`, `aria-controls`, and panel IDs synchronized.',
            'Do not rely on color alone; selected state also uses semantic attributes.',
            'Disabled options must not receive focus or change panels.',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function searchComponent(): array
    {
        return array_replace($this->correctedImplemented('search', 'Search', 'Search captures free-entry keywords for page, table, or component scope without owning result panels or structured filters.', [
            $this->exampleFromSample('Page search', 'Page-scoped keyword entry with accessible label, placeholder, helper copy, and clear action.', ['type' => 'field', 'items' => [
                ['type' => 'search', 'name' => 'search_page_users', 'label' => 'Search users', 'placeholder' => 'Search by name or email', 'helper' => 'Search applies to the current page region.'],
            ]], [
                $this->sampleVariant('Default page query', ['type' => 'field', 'items' => [['type' => 'search', 'label' => 'Search users', 'placeholder' => 'Search by name or email']]]),
                $this->sampleVariant('Clear action', ['type' => 'field', 'items' => [['type' => 'search', 'label' => 'Search workspaces', 'value' => 'tenant']]]),
            ]),
            $this->exampleFromSample('Table search', 'Compact search can be composed into a table toolbar while the table pattern owns result count and filtering.', ['type' => 'field', 'items' => [
                ['type' => 'search', 'name' => 'search_table_audit', 'label' => 'Search table', 'placeholder' => 'Search audit events', 'scope' => 'table', 'size' => 'sm', 'active' => true, 'results_region' => 'search-table-results'],
            ]], [
                $this->sampleVariant('Small table search', ['type' => 'field', 'items' => [['type' => 'search', 'label' => 'Search table', 'scope' => 'table', 'size' => 'sm']]]),
                $this->sampleVariant('Active search gate', ['type' => 'deferred', 'items' => [['label' => 'Active search requires debounce, status, and Pattern-owned result handling.']]], 'Gated', 'Do not render active result panels from the component alone.'),
            ]),
            $this->exampleFromSample('Component search', 'A fluid search field can fill a bounded component or panel region.', ['type' => 'field', 'items' => [
                ['type' => 'search', 'name' => 'search_component_roles', 'label' => 'Search roles', 'placeholder' => 'Search roles', 'scope' => 'component', 'variant' => 'fluid'],
            ]], [
                $this->sampleVariant('Fluid search', ['type' => 'field', 'items' => [['type' => 'search', 'label' => 'Search roles', 'variant' => 'fluid']]]),
                $this->sampleVariant('Component scope', ['type' => 'field', 'items' => [['type' => 'search', 'label' => 'Search roles', 'scope' => 'component']]]),
            ]),
            $this->exampleFromSample('Sizes and states', 'Small, medium, large, loading, disabled, and read-only states use the app field token contract.', ['type' => 'field', 'items' => [
                ['type' => 'search', 'name' => 'search_size_sm', 'label' => 'Small search', 'size' => 'sm'],
                ['type' => 'search', 'name' => 'search_size_md', 'label' => 'Medium search', 'size' => 'md'],
                ['type' => 'search', 'name' => 'search_size_lg', 'label' => 'Large search', 'size' => 'lg'],
            ]], [
                $this->sampleVariant('Small', ['type' => 'field', 'items' => [['type' => 'search', 'label' => 'Small search', 'size' => 'sm']]]),
                $this->sampleVariant('Medium', ['type' => 'field', 'items' => [['type' => 'search', 'label' => 'Medium search', 'size' => 'md']]]),
                $this->sampleVariant('Large', ['type' => 'field', 'items' => [['type' => 'search', 'label' => 'Large search', 'size' => 'lg']]]),
                $this->sampleVariant('Loading search', ['type' => 'field', 'items' => [['type' => 'search', 'label' => 'Loading search', 'state' => 'loading']]]),
                $this->sampleVariant('Disabled', ['type' => 'field', 'items' => [['type' => 'search', 'label' => 'Disabled search', 'state' => 'disabled']]]),
                $this->sampleVariant('Read-only', ['type' => 'field', 'items' => [['type' => 'search', 'label' => 'Read-only search', 'state' => 'readonly']]]),
            ]),
            $this->exampleFromSample('Validation search and no-results handoff', 'Field-level validation is distinct from no-results messaging, which belongs to the result region.', ['type' => 'field', 'items' => [
                ['type' => 'search', 'name' => 'search_invalid', 'label' => 'Search audit events', 'value' => '?', 'state' => 'error'],
                ['type' => 'search', 'name' => 'search_warning', 'label' => 'Search invoices', 'value' => 'all', 'state' => 'warning'],
            ]], [
                $this->sampleVariant('Validation search', ['type' => 'field', 'items' => [['type' => 'search', 'label' => 'Search audit events', 'state' => 'error']]]),
                $this->sampleVariant('No-results handoff', ['type' => 'deferred', 'items' => [['label' => 'Result region owns no-results guidance, not the field.']]], 'Pattern-owned', 'No-results is rendered by the result Pattern.'),
            ]),
        ], ['search field', 'search icon', 'query text', 'placeholder', 'clear button', 'label', 'helper or validation message', 'loading status'], [
            'Use when users need free-keyword search for page, table, or component content.',
            'Use placeholder text for a short hint, not as the accessible label.',
            'Use Search with Patterns for result rendering, no-results states, and table filtering.',
        ], [
            'Do not use Search for ordinary text input, known-option selection, action menus, or structured filters.',
            'Do not render suggestions, typeahead, recent searches, global shell search, or AI-assisted search without a Pattern or feature owner.',
            'Do not create local clear-button scripts or raw search input chrome in feature views.',
        ], [
            'Enabled',
            'Focus',
            'Filled',
            'Clear available',
            'Loading',
            'Disabled',
            'Read-only',
            'Error',
            'Warning',
            'Small',
            'Medium',
            'Large',
            'Fluid',
        ], [
            'The clear button appears only when a query exists and clears on click or Escape.',
            'Enter submits through the owning form when submit behavior is enabled.',
            'Active search can dispatch debounced change events, but result panels and empty states remain Pattern-owned.',
        ], [
            'Labels name the search scope, such as Search users, Search table, or Search audit events.',
            'Placeholders are short hints such as Search by name or email.',
            'No-results copy belongs to the result region and should include a next step.',
        ], [
            'Search input uses native input[type=search] semantics with an accessible label.',
            'The clear button is keyboard reachable and has an accessible name.',
            'Escape clears the query when a clearable value exists.',
            'Loading state identifies the related results region when asynchronous results update.',
        ]), [
            'live_examples_view' => 'platform.ui-reference.components.live-examples.search',
            'live_examples_layout' => 'flexible-matrix',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function structuredListComponent(): array
    {
        return array_replace($this->correctedImplemented('structured-list', 'Structured list', 'Structured list compares rich rows where a full data table would be excessive.', [
            $this->exampleFromSample('Default structured list', 'Read-only native table structure for simple grouped comparison.', ['type' => 'structured-list', 'items' => [[
                'columns' => [
                    ['key' => 'workspace', 'label' => 'Workspace'],
                    ['key' => 'role', 'label' => 'Role'],
                    ['key' => 'status', 'label' => 'Status'],
                ],
                'rows' => [
                    ['id' => 'acme', 'cells' => ['workspace' => 'Acme production', 'role' => 'Owner', 'status' => 'Active']],
                    ['id' => 'northwind', 'cells' => ['workspace' => 'Northwind staging', 'role' => 'Editor', 'status' => 'Pending review']],
                ],
            ]]], [
                $this->sampleVariant('Hang alignment', ['type' => 'structured-list', 'items' => [['alignment' => 'hang']]]),
                $this->sampleVariant('Background modifier', ['type' => 'structured-list', 'items' => [['background' => true]]]),
            ]),
            $this->exampleFromSample('Density and alignment', 'Condensed rows and flush alignment support dense read-only metadata comparisons.', ['type' => 'structured-list', 'items' => [[
                'size' => 'condensed',
                'alignment' => 'flush',
            ]]], [
                $this->sampleVariant('Condensed list', ['type' => 'structured-list', 'items' => [['size' => 'condensed']]]),
                $this->sampleVariant('Flush alignment', ['type' => 'structured-list', 'items' => [['alignment' => 'flush']]]),
            ]),
            $this->exampleFromSample('Selectable structured list', 'Selectable structured list uses visible left radio controls and scalar single-selection behavior.', ['type' => 'structured-list', 'items' => [[
                'variant' => 'selectable',
                'value' => 'growth',
                'name' => 'plan',
            ]]], [
                $this->sampleVariant('Radio-style selectable rows', ['type' => 'structured-list', 'items' => [['variant' => 'selectable', 'value' => 'growth']]]),
                $this->sampleVariant('Disabled row', ['type' => 'structured-list', 'items' => [['variant' => 'selectable', 'disabled_row' => true]]]),
            ]),
            $this->exampleFromSample('Empty and skeleton states', 'Empty and skeleton states preserve the structured-list contract without pretending final data is loaded.', ['type' => 'structured-list', 'items' => [[
                'empty' => true,
            ]]], [
                $this->sampleVariant('Empty state', ['type' => 'structured-list', 'items' => [['empty' => true]]]),
                $this->sampleVariant('Skeleton state', ['type' => 'structured-list', 'items' => [['skeleton' => true]]]),
            ]),
            $this->exampleFromSample('Structured list vs related APIs', 'Sorting, filtering, pagination, nested rows, row expansion, and multi-selection move the workflow to Data table or another owning API.', ['type' => 'deferred', 'items' => [
                ['label' => 'Use Data table for sorting, filtering, pagination, row expansion, or multiple row selection.'],
                ['label' => 'Use Contained list for compact lists inside cards, sidebars, panels, or modals.'],
            ]], [
                $this->sampleVariant('Data table boundary', ['type' => 'deferred', 'items' => [['label' => 'Data table owns advanced row behavior.']]], 'Pattern-owned', 'Do not add table behavior to Structured list.'),
            ]),
        ], ['native table', 'caption', 'column headers', 'row headers', 'cells', 'dividers', 'radio selection control', 'empty state', 'skeleton rows'], [
            'Use when users need simple row/column comparison.',
            'Use selectable structured list only for one scalar row choice.',
            'Use Data table when rows need sorting, filtering, pagination, nesting, expansion, or multi-selection.',
        ], [
            'Do not use Structured list for complex datasets, row action menus, bulk actions, or multiple row selection.',
            'Do not use flush alignment with selectable lists.',
            'Do not use background modifier with flush alignment.',
        ], [
            'Default',
            'Selectable',
            'Condensed',
            'Hang alignment',
            'Flush alignment',
            'Background modifier',
            'Selected',
            'Focus',
            'Disabled',
            'Empty',
            'Skeleton',
        ], [
            'Default structured lists are read-only and have no interactive row behavior.',
            'Selectable lists use visible left radio controls and full-row click behavior.',
            'ArrowUp and ArrowDown move focus between selectable rows; Space selects the focused row.',
        ], [
            'Column headers use short sentence-case labels.',
            'Row text stays simple and scannable.',
            'No-results or empty copy belongs inside the structured-list empty state when no rows are available.',
        ], [
            'Native table semantics preserve header and row relationships.',
            'Selectable rows expose native radio controls for single-selection semantics.',
            'Disabled selectable rows use disabled radio controls and disabled visual treatment.',
        ]), [
            'live_examples_view' => 'platform.ui-reference.components.live-examples.structured-list',
            'live_examples_layout' => 'flexible-matrix',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function multiselectComponent(): array
    {
        return $this->correctedImplemented('multiselect', 'Multiselect', 'Multiselect chooses multiple known options through the installed multi-value field API.', [
            $this->exampleFromSample('Filterable multiselect', 'Searchable known-option selection with selected values shown in the trigger.', ['type' => 'multiselect', 'items' => [[
                'name' => 'workspace_roles',
                'label' => 'Workspace roles',
                'value' => ['owner', 'admin'],
                'filterable' => true,
                'clearable' => true,
                'select_all' => true,
                'open' => true,
            ]]], [
                $this->sampleVariant('Selected values', ['type' => 'multiselect', 'items' => [[
                    'name' => 'selected_roles',
                    'label' => 'Selected roles',
                    'value' => ['owner', 'admin'],
                    'open' => true,
                ]]]),
                $this->sampleVariant('Filterable', ['type' => 'multiselect', 'items' => [[
                    'name' => 'filtered_roles',
                    'label' => 'Filtered roles',
                    'value' => ['owner'],
                    'filterable' => true,
                    'open' => true,
                ]]]),
            ]),
            $this->exampleFromSample('Validation multiselect', 'Blocking validation belongs to the field while all selectable options remain visible.', ['type' => 'multiselect', 'items' => [[
                'name' => 'required_roles',
                'label' => 'Required roles',
                'value' => [],
                'error' => 'Choose at least one role before saving.',
                'open' => true,
            ]]], [
                $this->sampleVariant('Error', ['type' => 'multiselect', 'items' => [[
                    'name' => 'role_error',
                    'label' => 'Role selection',
                    'error' => 'Choose at least one role before saving.',
                    'open' => true,
                ]]]),
                $this->sampleVariant('Warning', ['type' => 'multiselect', 'items' => [[
                    'name' => 'role_warning',
                    'label' => 'Elevated roles',
                    'value' => ['owner'],
                    'warning' => 'Owner roles require audit review.',
                    'open' => true,
                ]]]),
            ]),
            $this->exampleFromSample('Disabled and loading multiselect', 'Unavailable and loading option states stay explicit without replacing the label.', ['type' => 'multiselect', 'items' => [
                ['name' => 'disabled_roles', 'label' => 'Disabled roles', 'value' => ['owner'], 'disabled' => true],
                ['name' => 'loading_roles', 'label' => 'Loading roles', 'loading' => true, 'open' => true],
            ]], [
                $this->sampleVariant('Disabled', ['type' => 'multiselect', 'items' => [[
                    'name' => 'disabled_roles_variant',
                    'label' => 'Disabled roles',
                    'value' => ['owner'],
                    'disabled' => true,
                ]]]),
                $this->sampleVariant('Loading', ['type' => 'multiselect', 'items' => [[
                    'name' => 'loading_roles_variant',
                    'label' => 'Loading roles',
                    'loading' => true,
                    'open' => true,
                ]]]),
            ]),
        ], ['label', 'trigger', 'selected value tags', 'filter input', 'option list', 'clear/select-all controls', 'helper or validation text'], [
            'Use when users must choose multiple values from a known option set.',
            'Use filtering when the option set is too long to scan quickly.',
            'Use clear or select-all actions only when they save real effort.',
        ], [
            'Do not use Multiselect for one visible choice; use radio or select instead.',
            'Do not hide small option sets that would be clearer as checkboxes.',
            'Do not use async option loading until that behavior is explicitly specified.',
        ], [
            'Default',
            'Open',
            'Selected values',
            'Filterable',
            'Clearable',
            'Select all',
            'Disabled',
            'Read-only',
            'Error',
            'Warning',
            'Loading',
            'Empty',
        ], [
            'Clicking the trigger opens or closes the option panel.',
            'Selected options update hidden inputs and the visible selected-value tags.',
            'Filter input hides nonmatching visible options without changing selected values.',
            'Clear and select-all controls update every enabled option.',
        ], [
            'Use short noun labels for options.',
            'Keep selected-value labels short enough to wrap cleanly inside the trigger.',
            'Error copy must describe the recovery action.',
        ], [
            'The trigger exposes listbox semantics and selected options expose `aria-selected`.',
            'Every instance needs a visible label.',
            'Validation states need visible text and `aria-invalid` where blocking.',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function popoverComponent(): array
    {
        return $this->correctedImplemented('popover', 'Popover', 'Popover shows short interactive contextual content from a visible trigger.', [
            $this->exampleFromSample('No tip', 'No-tip popovers are used when the trigger already has a visually defined down state.', ['type' => 'popover', 'items' => [[
                'label' => 'Workspace details',
                'title' => 'Workspace details',
                'body' => 'This popover opens from a full trigger button and does not render a visual tip.',
                'tip' => 'none',
                'trigger_kind' => 'button',
            ]]], [
                $this->sampleVariant('Text trigger', ['type' => 'popover', 'items' => [[
                    'label' => 'Review status',
                    'body' => 'Text triggers are allowed when the trigger needs visible context.',
                    'tip' => 'none',
                    'trigger_kind' => 'button',
                ]]]),
                $this->sampleVariant('Ghost trigger', ['type' => 'popover', 'items' => [[
                    'label' => 'Policy notes',
                    'body' => 'Ghost triggers can open no-tip popovers when the surrounding control state is already clear.',
                    'tip' => 'none',
                    'trigger_kind' => 'ghost',
                ]]]),
            ]),
            $this->exampleFromSample('Caret tip', 'Caret-tip popovers visually associate the floating panel with the trigger.', ['type' => 'popover', 'items' => [[
                'label' => 'Review help',
                'title' => 'Review help',
                'body' => 'The caret tip points from the panel back toward the trigger.',
                'tip' => 'caret',
                'trigger_kind' => 'icon',
            ]]], [
                $this->sampleVariant('Top placement', ['type' => 'popover', 'items' => [[
                    'label' => 'Top popover',
                    'body' => 'The panel opens above the trigger.',
                    'tip' => 'caret',
                    'placement' => 'top',
                ]]]),
                $this->sampleVariant('End aligned', ['type' => 'popover', 'items' => [[
                    'label' => 'End aligned',
                    'body' => 'The caret remains associated with the trigger when the panel aligns to the end edge.',
                    'tip' => 'caret',
                    'align' => 'end',
                ]]]),
            ]),
            $this->exampleFromSample('Tab tip', 'Tab-tip popovers use a flat tab connector when a broader trigger edge needs visual association.', ['type' => 'popover', 'items' => [[
                'label' => 'Account summary',
                'title' => 'Account summary',
                'body' => 'The tab tip creates a broader connector between the panel and trigger.',
                'tip' => 'tab',
                'trigger_kind' => 'button',
            ]]], [
                $this->sampleVariant('Center aligned', ['type' => 'popover', 'items' => [[
                    'label' => 'Center tab',
                    'body' => 'Tab tips can be centered when the trigger is wider than an icon.',
                    'tip' => 'tab',
                    'align' => 'center',
                    'trigger_kind' => 'button',
                ]]]),
                $this->sampleVariant('Large tab panel', ['type' => 'popover', 'items' => [[
                    'label' => 'Large tab',
                    'body' => 'Large popovers still keep content concise and local to the trigger.',
                    'tip' => 'tab',
                    'size' => 'lg',
                    'trigger_kind' => 'button',
                ]]]),
            ]),
            $this->exampleFromSample('Placement options', 'Placement examples show top, right, bottom, and left without using locked-open panels.', ['type' => 'popover', 'items' => [
                ['label' => 'Top', 'body' => 'Top placement opens above the trigger.', 'placement' => 'top'],
                ['label' => 'Right', 'body' => 'Right placement opens beside the trigger.', 'placement' => 'right'],
                ['label' => 'Bottom', 'body' => 'Bottom placement is the default.', 'placement' => 'bottom'],
                ['label' => 'Left', 'body' => 'Left placement opens before the trigger.', 'placement' => 'left'],
            ]], [
                $this->sampleVariant('Start alignment', ['type' => 'popover', 'items' => [[
                    'label' => 'Start aligned',
                    'body' => 'The panel start edge aligns with the trigger.',
                    'align' => 'start',
                    'trigger_kind' => 'button',
                ]]]),
                $this->sampleVariant('Center alignment', ['type' => 'popover', 'items' => [[
                    'label' => 'Center aligned',
                    'body' => 'The panel centers on the trigger.',
                    'align' => 'center',
                    'trigger_kind' => 'button',
                ]]]),
                $this->sampleVariant('End alignment', ['type' => 'popover', 'items' => [[
                    'label' => 'End aligned',
                    'body' => 'The panel end edge aligns with the trigger.',
                    'align' => 'end',
                    'trigger_kind' => 'button',
                ]]]),
            ]),
            $this->exampleFromSample('Overflow content', 'When content must scroll, only the body scrolls while header and footer remain fixed.', ['type' => 'popover', 'items' => [[
                'label' => 'Activity notes',
                'title' => 'Activity notes',
                'body' => 'Recent sync activity, permission changes, review comments, billing updates, notification deliveries, audit records, and retry details stay inside a vertically scrolling body region. Horizontal overflow is not allowed.',
                'footer' => 'Footer actions remain fixed while the body scrolls.',
                'size' => 'lg',
                'trigger_kind' => 'button',
            ]]], [
                $this->sampleVariant('Hover trigger', ['type' => 'popover', 'items' => [[
                    'label' => 'Hover details',
                    'body' => 'Hover-triggered popovers remain available for disclosure-pattern uses that explicitly allow hover.',
                    'interaction' => 'hover',
                    'trigger_kind' => 'ghost',
                ]]]),
                $this->sampleVariant('Focus trigger', ['type' => 'popover', 'items' => [[
                    'label' => 'Focus details',
                    'body' => 'Focus-triggered popovers open from keyboard focus and close when focus leaves the component.',
                    'interaction' => 'focus',
                    'trigger_kind' => 'ghost',
                ]]]),
                $this->sampleVariant('Disabled trigger', ['type' => 'popover', 'items' => [[
                    'label' => 'Policy unavailable',
                    'body' => 'Disabled triggers do not open.',
                    'disabled' => true,
                ]]]),
            ]),
        ], ['trigger button', 'panel', 'tip connector', 'scrollable body region', 'close control', 'placement/alignment marker'], [
            'Use when short interactive contextual content belongs near its trigger.',
            'Use for help that needs a close control or small links/actions.',
        ], [
            'Do not use Popover for blocking decisions; use Modal.',
            'Do not use Popover for non-interactive hover-only text; use Tooltip.',
            'Do not put long workflows or required page content inside a popover.',
        ], [
            'Closed',
            'Open',
            'No tip',
            'Caret tip',
            'Tab tip',
            'Focus-visible',
            'Disabled',
            'Placement',
            'Alignment',
            'Small',
            'Medium',
            'Large',
            'Overflow content',
        ], [
            'Trigger click opens or closes the panel.',
            'Approved trigger modes include click, hover, and focus when the disclosure pattern allows them.',
            'Escape or the close control closes the panel and returns focus.',
            'Outside click closes an open panel.',
            'When overflow is needed, only the body scrolls; header and footer remain fixed.',
        ], [
            'Use concise trigger labels.',
            'Keep panel copy short and task-adjacent.',
            'Do not repeat visible page content inside the panel.',
        ], [
            'The trigger uses `aria-haspopup="dialog"`, `aria-expanded`, and `aria-controls`.',
            'The panel has a programmatic label.',
            'Close controls require an accessible name.',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function sliderComponent(): array
    {
        return $this->correctedImplemented('slider', 'Slider', 'Slider adjusts a numeric value or range when relative position is more useful than exact entry alone.', [
            $this->exampleFromSample('Single-value slider', 'A native range input with visible label, value output, and optional numeric entry.', ['type' => 'slider', 'items' => [[
                'name' => 'retention_days',
                'label' => 'Retention days',
                'value' => 30,
                'min' => 0,
                'max' => 90,
                'show_input' => true,
            ]]], [
                $this->sampleVariant('With value input', ['type' => 'slider', 'items' => [[
                    'name' => 'review_window',
                    'label' => 'Review window',
                    'value' => 14,
                    'min' => 0,
                    'max' => 30,
                    'show_input' => true,
                ]]]),
                $this->sampleVariant('Disabled', ['type' => 'slider', 'items' => [[
                    'name' => 'disabled_slider',
                    'label' => 'Locked retention',
                    'value' => 30,
                    'disabled' => true,
                ]]]),
            ]),
            $this->exampleFromSample('Range slider', 'A paired range slider for relative lower and upper bounds.', ['type' => 'range-slider', 'items' => [[
                'name_min' => 'min_score',
                'name_max' => 'max_score',
                'label' => 'Score range',
                'value_min' => 20,
                'value_max' => 80,
                'show_inputs' => true,
            ]]], [
                $this->sampleVariant('With paired inputs', ['type' => 'range-slider', 'items' => [[
                    'name_min' => 'min_threshold',
                    'name_max' => 'max_threshold',
                    'label' => 'Threshold range',
                    'value_min' => 10,
                    'value_max' => 70,
                    'show_inputs' => true,
                ]]]),
            ]),
            $this->exampleFromSample('Validation slider', 'Slider validation appears as visible field feedback and does not rely on color alone.', ['type' => 'slider', 'items' => [[
                'name' => 'quota_limit',
                'label' => 'Quota limit',
                'value' => 95,
                'min' => 0,
                'max' => 100,
                'warning' => 'High quota limits require owner confirmation.',
            ]]], [
                $this->sampleVariant('Warning', ['type' => 'slider', 'items' => [[
                    'name' => 'warning_slider',
                    'label' => 'Warning slider',
                    'value' => 95,
                    'warning' => 'High values require owner confirmation.',
                ]]]),
            ]),
        ], ['label', 'range input', 'track', 'thumb marker', 'value output', 'optional number input', 'helper or validation text'], [
            'Use when a numeric value is easier to adjust visually across a bounded range.',
            'Use range slider when a lower and upper bound are both required.',
        ], [
            'Do not use Slider when exact numeric entry is primary; use Number input.',
            'Do not use unbounded values or hide min/max context.',
        ], [
            'Default',
            'Hover-capable',
            'Focus-visible',
            'Disabled',
            'Read-only',
            'Warning',
            'Single value',
            'Range',
            'Value input',
        ], [
            'Native range inputs update the visible value output.',
            'Optional number inputs synchronize with single-value sliders.',
            'Disabled sliders cannot be changed.',
        ], [
            'Label the value being changed, not the control type.',
            'Show units in helper text or value output when needed.',
            'Warning copy should explain why a value needs review.',
        ], [
            'The native input keeps keyboard support.',
            'Visible labels and value outputs are required.',
            'Focus-visible must be clear against the current theme.',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function containedListComponent(): array
    {
        return $this->correctedImplemented('contained-list', 'Contained list', 'Contained list presents bounded row-like items inside cards, panels, and compact review regions.', [
            $this->exampleFromSample('Basic contained list', 'A compact bounded list with title, description, and row metadata.', ['type' => 'contained-list', 'items' => [[
                'title' => 'Workspace reviews',
                'description' => 'Recent review checkpoints.',
                'variant' => 'on-page',
                'size' => 'lg',
                'rows' => [
                    ['title' => 'Domain rules', 'description' => 'Routing policy ready', 'meta' => 'Reviewed', 'href' => '#', 'selected' => true],
                    ['title' => 'Security settings', 'description' => 'Owner approval pending', 'meta' => 'Pending'],
                ],
            ]]], [
                $this->sampleVariant('On-page list', ['type' => 'contained-list', 'items' => [[
                    'title' => 'On-page list',
                    'description' => 'Persistent bounded row group for a card or sidebar.',
                    'variant' => 'on-page',
                    'size' => 'lg',
                    'rows' => [
                        ['title' => 'Domain rules', 'description' => 'Persistent review item.', 'meta' => 'Ready'],
                        ['title' => 'Security settings', 'description' => 'Persistent review item.', 'meta' => 'Pending'],
                    ],
                ]]]),
                $this->sampleVariant('Disclosed list', ['type' => 'contained-list', 'items' => [[
                    'title' => 'Disclosed list',
                    'variant' => 'disclosed',
                    'size' => 'lg',
                    'rows' => [
                        ['title' => 'Recent filters', 'description' => 'Compact row inside a temporary surface.', 'meta' => '3'],
                        ['title' => 'Saved views', 'description' => 'Temporary-context row treatment.', 'meta' => '2'],
                    ],
                ]]]),
                $this->sampleVariant('Selected row', ['type' => 'contained-list', 'items' => [[
                    'title' => 'Selected review',
                    'rows' => [
                        ['title' => 'Domain rules', 'description' => 'Selected row uses layer-selected token.', 'meta' => 'Selected', 'selected' => true],
                    ],
                ]]]),
                $this->sampleVariant('Actionable row', ['type' => 'contained-list', 'items' => [[
                    'title' => 'Actionable review',
                    'rows' => [
                        ['title' => 'Open review', 'description' => 'Rows may link when the entire item navigates.', 'href' => '#'],
                    ],
                ]]]),
            ]),
            $this->exampleFromSample('With icons', 'Non-interactive icons can help visually scan row category or row status.', ['type' => 'contained-list', 'items' => [[
                'title' => 'Review signals',
                'description' => 'Icons are decorative unless paired with status text.',
                'inset_dividers' => true,
                'rows' => [
                    ['title' => 'Security alert', 'description' => 'Status icon is backed by row text.', 'meta' => 'Warning', 'status' => 'warning'],
                    ['title' => 'Billing update', 'description' => 'Decorative row icon supports scanability.', 'meta' => 'Info', 'icon' => 'heroicon-o-credit-card'],
                ],
            ]]], [
                $this->sampleVariant('With icons', ['type' => 'contained-list', 'items' => [[
                    'title' => 'Icon rows',
                    'rows' => [
                        ['title' => 'Workspace', 'description' => 'Decorative icon before the row label.', 'icon' => 'heroicon-o-building-office'],
                        ['title' => 'Completed check', 'description' => 'Semantic status remains visible in text.', 'status' => 'success', 'meta' => 'Complete'],
                    ],
                ]]]),
            ]),
            $this->exampleFromSample('With actions', 'Inline actions belong to the row and use approved button or icon-button APIs.', ['type' => 'contained-list', 'items' => [[
                'title' => 'Invitations',
                'rows' => [
                    ['title' => 'laura@example.com', 'description' => 'Invited as Admin', 'meta' => 'Pending', 'actions' => [
                        ['label' => 'Resend', 'semantic' => 'ghost', 'icon_only' => false],
                        ['label' => 'Cancel invitation', 'icon' => 'heroicon-o-x-mark', 'semantic' => 'danger-ghost', 'icon_only' => true],
                    ]],
                    ['title' => 'sam@example.com', 'description' => 'Invited as Viewer', 'meta' => 'Pending', 'actions' => [
                        ['label' => 'Resend', 'semantic' => 'ghost', 'icon_only' => false],
                    ]],
                ],
            ]]], [
                $this->sampleVariant('With actions', ['type' => 'contained-list', 'items' => [[
                    'title' => 'Row actions',
                    'rows' => [
                        ['title' => 'Invite pending', 'description' => 'Row-owned actions sit at the end.', 'actions' => [
                            ['label' => 'Resend', 'semantic' => 'ghost', 'icon_only' => false],
                            ['label' => 'Cancel', 'icon' => 'heroicon-o-x-mark', 'semantic' => 'danger-ghost'],
                        ]],
                    ],
                ]]]),
            ]),
            $this->exampleFromSample('With interactive items', 'Rows may be interactive when the whole row has one navigation target.', ['type' => 'contained-list', 'items' => [[
                'title' => 'Related records',
                'variant' => 'disclosed',
                'rows' => [
                    ['title' => 'Acme Tenant', 'description' => 'Open the tenant record.', 'href' => '#', 'current' => true],
                    ['title' => 'Billing profile', 'description' => 'Open the billing record.', 'href' => '#'],
                ],
            ]]], [
                $this->sampleVariant('With interactive items', ['type' => 'contained-list', 'items' => [[
                    'title' => 'Linked rows',
                    'rows' => [
                        ['title' => 'Open workspace', 'description' => 'The whole row navigates.', 'href' => '#'],
                    ],
                ]]]),
            ]),
            $this->exampleFromSample('With interactive items and actions', 'When actions are present, controls own interaction instead of nesting controls inside a whole-row link.', ['type' => 'contained-list', 'items' => [[
                'title' => 'Workspace tasks',
                'rows' => [
                    ['title' => 'Review domain', 'description' => 'Open details or dismiss the row-owned task.', 'meta' => 'Due today', 'actions' => [
                        ['label' => 'Open', 'semantic' => 'ghost', 'icon_only' => false],
                        ['label' => 'Dismiss task', 'icon' => 'heroicon-o-x-mark', 'semantic' => 'ghost'],
                    ]],
                    ['title' => 'Confirm owner', 'description' => 'Multiple row-owned controls remain aligned.', 'meta' => 'Waiting', 'actions' => [
                        ['label' => 'Open', 'semantic' => 'ghost', 'icon_only' => false],
                        ['label' => 'Archive task', 'icon' => 'heroicon-o-archive-box', 'semantic' => 'ghost'],
                    ]],
                ],
            ]]], [
                $this->sampleVariant('With interactive items and actions', ['type' => 'contained-list', 'items' => [[
                    'title' => 'Interactive controls',
                    'rows' => [
                        ['title' => 'Review item', 'description' => 'Inline controls are the interaction target.', 'actions' => [
                            ['label' => 'Open', 'semantic' => 'ghost', 'icon_only' => false],
                            ['label' => 'Archive', 'icon' => 'heroicon-o-archive-box', 'semantic' => 'ghost'],
                        ]],
                    ],
                ]]]),
            ]),
            $this->exampleFromSample('With list title decorators', 'List headers may include a decorative title icon and one compact header action.', ['type' => 'contained-list', 'items' => [[
                'title' => 'Recent files',
                'description' => 'Header action supports list-local search or filtering entry points.',
                'title_icon' => 'heroicon-o-folder',
                'header_action_label' => 'Search files',
                'header_action_icon' => 'heroicon-o-magnifying-glass',
                'rows' => [
                    ['title' => 'Contract.pdf', 'description' => 'Uploaded today', 'meta' => 'PDF', 'icon' => 'heroicon-o-document-text'],
                    ['title' => 'Renewal notes', 'description' => 'Updated yesterday', 'meta' => 'Doc', 'icon' => 'heroicon-o-document'],
                ],
            ]]], [
                $this->sampleVariant('With list title decorators', ['type' => 'contained-list', 'items' => [[
                    'title' => 'Decorated title',
                    'title_icon' => 'heroicon-o-folder',
                    'header_action_label' => 'Search list',
                    'rows' => [
                        ['title' => 'Decorated row', 'description' => 'Header icon and action are component-owned.'],
                    ],
                ]]]),
            ]),
            $this->exampleFromSample('Contained list states', 'Empty, loading, disabled, and current row states remain explicit.', ['type' => 'contained-list', 'items' => [
                ['title' => 'Loading reviews', 'loading' => true],
                ['title' => 'Empty reviews', 'empty_title' => 'No reviews yet', 'empty_description' => 'Completed reviews will appear here.'],
            ]], [
                $this->sampleVariant('Loading', ['type' => 'contained-list', 'items' => [
                    ['title' => 'Loading list', 'loading' => true],
                ]]),
                $this->sampleVariant('Empty', ['type' => 'contained-list', 'items' => [
                    ['title' => 'Empty list', 'empty_title' => 'No rows', 'empty_description' => 'Rows appear after a review is created.'],
                ]]),
                $this->sampleVariant('Disabled row', ['type' => 'contained-list', 'items' => [[
                    'title' => 'Disabled row',
                    'rows' => [
                        ['title' => 'Locked policy', 'description' => 'Disabled rows explain unavailable state nearby.', 'disabled' => true],
                    ],
                ]]]),
            ]),
        ], ['container', 'header', 'list title', 'list title decorator', 'header action', 'list body', 'item', 'non-interactive icon', 'title', 'description', 'metadata', 'row action', 'row divider', 'empty/loading state'], [
            'Use inside panels, modals, and cards where a bounded list is clearer than a full table.',
            'Use when rows need short descriptions or metadata but not column comparison.',
            'Use in small spaces or disclosure situations where related rows share the same content structure.',
        ], [
            'Do not use Contained list for sortable tabular data; use Data table.',
            'Do not use Contained list for body copy; use native List.',
            'Do not nest row controls inside a whole-row link.',
        ], [
            'Default',
            'Hover',
            'Focus-visible',
            'Active',
            'Selected',
            'Current',
            'Disabled',
            'Loading',
            'Empty',
            'Info',
            'Success',
            'Warning',
            'Error',
            'On-page',
            'Disclosed',
            'Elevated',
        ], [
            'Actionable rows navigate as a whole item.',
            'Rows with actions are not rendered as whole-row links.',
            'Inline actions use Button or Icon button APIs.',
            'Non-interactive icons are decorative unless row status text supports them.',
            'Inset row dividers are available when adjacent components would create converging rule lines.',
            'Selected and current rows use token-backed layer state.',
            'Loading and empty states are owned by the list container.',
        ], [
            'Use short item titles and one supporting sentence when needed.',
            'Metadata should be brief and scannable.',
        ], [
            'Actionable rows need a clear accessible name.',
            'Disabled rows must not be focusable.',
            'Empty and loading states need visible text.',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function listComponent(): array
    {
        return $this->correctedImplemented('list', 'List', 'List presents ordered, unordered, nested, or content-only body copy through native list semantics and app list classes.', [
            $this->exampleFromSample('Unordered list', 'Default content list for short non-sequential supporting information.', ['type' => 'list', 'items' => [
                ['kind' => 'unordered'],
            ]], [
                $this->sampleVariant('Nested boundary', ['type' => 'list', 'items' => [
                    ['kind' => 'unordered'],
                ]]),
            ]),
            $this->exampleFromSample('Ordered list', 'Sequential content uses ordered browser semantics plus app list styling.', ['type' => 'list', 'items' => [
                ['kind' => 'ordered'],
            ]], [
                $this->sampleVariant('Ordered steps', ['type' => 'list', 'items' => [
                    ['kind' => 'ordered'],
                ]]),
            ]),
            $this->exampleFromSample('Content-only guidance', 'Content lists remove markers when the layout already supplies the visual grouping.', ['type' => 'list', 'items' => [
                ['kind' => 'content'],
            ]], [
                $this->sampleVariant('Content list', ['type' => 'list', 'items' => [
                    ['kind' => 'content'],
                ]]),
            ]),
        ], ['native list element', 'list item', 'marker', 'nested list', 'content-only item'], [
            'Use for prose content that benefits from list semantics.',
            'Use ordered lists for sequences and unordered lists for peer supporting points.',
        ], [
            'Do not use List for comparable rows; use Structured list or Data table.',
            'Do not use List for navigation or action menus.',
        ], [
            'Unordered',
            'Ordered',
            'Nested',
            'Content-only',
            'Marker',
            'Readable spacing',
        ], [
            'Lists use native browser semantics and app-owned `ui-list*` classes.',
            'Nested lists remain shallow and support the parent list item.',
            'Content-only lists remove marker styling without changing semantic ownership.',
        ], [
            'Keep list items parallel and concise.',
            'Use ordered lists only when sequence matters.',
            'Do not turn long paragraphs into list items to force density.',
        ], [
            'Use native `ul`, `ol`, and `li` elements.',
            'Do not remove semantics when visually removing markers.',
            'Nested content must remain understandable in reading order.',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function treeViewComponent(): array
    {
        return $this->correctedImplemented('tree-view', 'Tree view', 'Tree view browses hierarchical content with expandable branches and selectable leaves.', [
            $this->exampleFromSample('Basic tree view', 'A hierarchical settings tree with one expanded branch and selected leaf.', ['type' => 'tree-view', 'items' => [[
                'label' => 'Settings tree',
                'selected' => 'domain-rules',
                'nodes' => [
                    ['id' => 'platform', 'label' => 'Platform', 'expanded' => true, 'children' => [
                        ['id' => 'security', 'label' => 'Security settings', 'expanded' => true, 'children' => [
                            ['id' => 'domain-rules', 'label' => 'Domain rules', 'selected' => true],
                        ]],
                    ]],
                    ['id' => 'billing', 'label' => 'Billing', 'children' => [
                        ['id' => 'invoices', 'label' => 'Invoices'],
                    ]],
                ],
            ]]], [
                $this->sampleVariant('Expanded branch', ['type' => 'tree-view', 'items' => [[
                    'label' => 'Expanded branch',
                    'nodes' => [
                        ['id' => 'expanded', 'label' => 'Expanded branch', 'expanded' => true, 'children' => [
                            ['id' => 'leaf', 'label' => 'Leaf item'],
                        ]],
                    ],
                ]]]),
                $this->sampleVariant('Selected leaf', ['type' => 'tree-view', 'items' => [[
                    'label' => 'Selected leaf',
                    'selected' => 'leaf-selected',
                    'nodes' => [
                        ['id' => 'root', 'label' => 'Root', 'expanded' => true, 'children' => [
                            ['id' => 'leaf-selected', 'label' => 'Selected leaf', 'selected' => true],
                        ]],
                    ],
                ]]]),
            ]),
            $this->exampleFromSample('Disabled tree item', 'Unavailable branches remain visible when they may become available later.', ['type' => 'tree-view', 'items' => [[
                'label' => 'Disabled branch tree',
                'nodes' => [
                    ['id' => 'locked', 'label' => 'Locked policy branch', 'disabled' => true, 'children' => [
                        ['id' => 'locked-child', 'label' => 'Locked child'],
                    ]],
                    ['id' => 'active', 'label' => 'Active settings'],
                ],
            ]]], [
                $this->sampleVariant('Disabled branch', ['type' => 'tree-view', 'items' => [[
                    'label' => 'Disabled branch',
                    'nodes' => [
                        ['id' => 'locked-policy', 'label' => 'Locked policy', 'disabled' => true],
                    ],
                ]]]),
            ]),
        ], ['tree container', 'branch node', 'leaf node', 'trigger', 'caret', 'label', 'nested group', 'selected/active state'], [
            'Use when users browse or select nested hierarchical content.',
            'Use for in-page hierarchy where expanding branches is more efficient than separate pages.',
        ], [
            'Do not use Tree view for primary app navigation unless the Navigation Pattern owns it.',
            'Do not use Tree view for shallow lists; use List, Structured list, or Contained list.',
        ], [
            'Collapsed',
            'Expanded',
            'Selected',
            'Active',
            'Hover',
            'Focus-visible',
            'Disabled',
            'Branch',
            'Leaf',
        ], [
            'Branch triggers expand and collapse nested groups.',
            'Tree nodes expose selected, active, expanded, and disabled markers.',
            'Keyboard activation toggles focused branch triggers.',
        ], [
            'Use short node labels that map to the represented object or section.',
            'Avoid repeating parent labels in every child when hierarchy already provides context.',
        ], [
            'The root exposes a tree label.',
            'Branch nodes expose expanded state.',
            'Selected leaves expose selected state without relying on color alone.',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function checkboxComponent(): array
    {
        return array_replace($this->implemented('checkbox', 'Checkbox', 'Checkbox supports independent choices, visible zero-or-more choice groups, and parent-child mixed state where hierarchy is required.', [
            [
                'Independent choice',
                'One setting can be toggled without affecting nearby choices.',
                'selection',
                [['type' => 'checkbox', 'title' => 'Independent choice']],
                [
                    $this->variant('Unselected', 'selection', [['type' => 'checkbox', 'title' => 'Unselected']]),
                    $this->variant('Selected', 'selection', [['type' => 'checkbox', 'title' => 'Selected']]),
                ],
            ],
            [
                'Multi-select group',
                'Several choices can be selected at the same time under one visible group label.',
                'selection',
                [['type' => 'checkbox', 'title' => 'Multi-select group']],
                [
                    $this->variant('Vertical group', 'selection', [['type' => 'checkbox', 'title' => 'Vertical group']]),
                    $this->variant('Horizontal group', 'selection', [['type' => 'checkbox', 'title' => 'Horizontal group']]),
                ],
            ],
            [
                'Nested group',
                'Parent choices summarize and control child choices with native mixed state.',
                'selection',
                [['type' => 'checkbox', 'title' => 'Nested group']],
                [
                    $this->variant('Parent mixed state', 'selection', [['type' => 'checkbox', 'title' => 'Parent mixed state']]),
                    $this->variant('Child selection sync', 'selection', [['type' => 'checkbox', 'title' => 'Child selection sync']]),
                ],
            ],
            [
                'Group states',
                'Helper, disabled, read-only, error, and warning states apply to the group without repeating messages per option.',
                'selection',
                [['type' => 'checkbox', 'title' => 'Group states']],
                [
                    $this->variant('Helper text', 'selection', [['type' => 'checkbox', 'title' => 'Helper text']]),
                    $this->variant('Error message', 'selection', [['type' => 'checkbox', 'title' => 'Error message']]),
                    $this->variant('Warning message', 'selection', [['type' => 'checkbox', 'title' => 'Warning message']]),
                ],
            ],
            [
                'Overflow and alignment',
                'Long labels wrap below their own label text with the checkbox top aligned to the first line.',
                'selection',
                [['type' => 'checkbox', 'title' => 'Overflow and alignment']],
                [
                    $this->variant('Long wrapping label', 'selection', [['type' => 'checkbox', 'title' => 'Long wrapping label']]),
                    $this->variant('Horizontal short labels', 'selection', [['type' => 'checkbox', 'title' => 'Horizontal short labels']]),
                ],
            ],
        ], ['group label', 'native checkbox input/control', 'option label', 'helper text', 'single group validation message', 'nested children'], [
            'Use when users choose zero or more options from a visible set.',
            'Use a nested checkbox group only when a parent/child relationship is real and the parent can select all children.',
        ], [
            'Do not use standalone indeterminate checkboxes; mixed state belongs to parent-child or owner-approved bulk selection.',
            'Do not truncate checkbox labels or hide small visible option sets in menus.',
        ], [
            'Unselected',
            'Selected',
            'Parent mixed',
            'Focus',
            'Disabled',
            'Read-only',
            'Error',
            'Warning',
            'Helper text',
            'Group-level validation',
            'Wrapping labels',
        ]), [
            'live_examples_view' => 'platform.ui-reference.components.live-examples.checkbox',
            'live_examples_layout' => 'flexible-matrix',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function radioButtonComponent(): array
    {
        return array_replace($this->implemented('radio-button', 'Radio button', 'Radio buttons choose exactly one option from a visible set.', [
            [
                'Vertical radio group',
                'Default readable layout for mutually exclusive choices.',
                'selection',
                [['type' => 'radio', 'title' => 'Vertical radio group', 'orientation' => 'vertical']],
                [
                    $this->variant('Default group', 'selection', [['type' => 'radio', 'title' => 'Default group', 'orientation' => 'vertical']]),
                    $this->variant('Helper text group', 'selection', [['type' => 'radio', 'title' => 'Helper text group', 'orientation' => 'vertical']]),
                ],
            ],
            [
                'Horizontal radio group',
                'Compact layout for a few short options when the group remains easy to scan.',
                'selection',
                [['type' => 'radio', 'title' => 'Horizontal radio group', 'orientation' => 'horizontal']],
                [
                    $this->variant('Horizontal group', 'selection', [['type' => 'radio', 'title' => 'Horizontal group', 'orientation' => 'horizontal']]),
                ],
            ],
            [
                'Selected and unselected',
                'Selection is a scalar value. Choosing a new option replaces the previous choice.',
                'selection',
                [['type' => 'radio', 'title' => 'Selected and unselected', 'value' => 'billing']],
                [
                    $this->variant('Selected state', 'selection', [['type' => 'radio', 'title' => 'Selected state', 'value' => 'owner']]),
                    $this->variant('No preselected value', 'selection', [['type' => 'radio', 'title' => 'No preselected value', 'value' => null]]),
                ],
            ],
            [
                'Group states',
                'Disabled, read-only, error, and warning states apply to the group while preserving single-selection semantics.',
                'selection',
                [
                    ['type' => 'radio', 'title' => 'Disabled group', 'state' => 'disabled'],
                    ['type' => 'radio', 'title' => 'Read-only group', 'state' => 'readonly', 'value' => 'billing'],
                    ['type' => 'radio', 'title' => 'Error group', 'state' => 'error', 'value' => null],
                    ['type' => 'radio', 'title' => 'Warning group', 'state' => 'warning', 'value' => 'audit'],
                ],
                [
                    $this->variant('Disabled group', 'selection', [['type' => 'radio', 'title' => 'Disabled group', 'state' => 'disabled']]),
                    $this->variant('Read-only group', 'selection', [['type' => 'radio', 'title' => 'Read-only group', 'state' => 'readonly', 'value' => 'billing']]),
                    $this->variant('Error group', 'selection', [['type' => 'radio', 'title' => 'Error group', 'state' => 'error', 'value' => null]]),
                    $this->variant('Warning group', 'selection', [['type' => 'radio', 'title' => 'Warning group', 'state' => 'warning', 'value' => 'audit']]),
                ],
            ],
            [
                'Overflow and alignment',
                'Wrapped label behavior keeps long labels beneath the label text while the circular radio input stays top aligned.',
                'selection',
                [['type' => 'radio', 'title' => 'Wrapped label behavior', 'long_label' => true]],
                [
                    $this->variant('Wrapped label behavior', 'selection', [['type' => 'radio', 'title' => 'Wrapped label behavior', 'long_label' => true]]),
                ],
            ],
            [
                'Inline table radio',
                'Compact single-selection radios can be used in row, table, or component-level control contexts.',
                'selection',
                [['type' => 'radio', 'title' => 'Inline table radio', 'compact' => true, 'value' => 'owner']],
                [
                    $this->variant('Inline table radio', 'selection', [['type' => 'radio', 'title' => 'Inline table radio', 'compact' => true, 'value' => 'owner']]),
                ],
            ],
        ], ['group label', 'radio input', 'radio label', 'selected dot', 'helper text', 'error or warning message'], [
            'Use when users must choose exactly one option from a visible set.',
            'Use when options are short, mutually exclusive, and easier to compare when visible.',
        ], [
            'Do not use Radio button for multiple selections; use Checkbox.',
            'Do not use Radio button for long option sets that are better handled by Select.',
            'Do not use Radio button for binary immediate settings; use Toggle.',
        ], [
            'Unselected',
            'Selected',
            'Focus',
            'Disabled',
            'Read-only',
            'Error',
            'Warning',
            'Helper text',
            'Vertical',
            'Horizontal',
            'Wrapped label',
            'Inline/table radio',
        ]), [
            'live_examples_layout' => 'flexible-matrix',
        ]);
    }

    /**
     * @param array<int, array{0: string, 1: string}> $scenarios
     *
     * @return array<string, mixed>
     */
    private function selection(string $slug, string $label, string $purpose, string $type, array $scenarios): array
    {
        $examples = array_map(fn (array $scenario): array => [
            $scenario[0],
            $scenario[1],
            'selection',
            [['type' => $type, 'title' => $scenario[0]]],
            [
                $this->variant('Selected and unselected', 'selection', [['type' => $type, 'title' => 'Selected and unselected']]),
                $this->variant('Focus', 'selection', [['type' => $type, 'title' => 'Focus state', 'state' => 'focus']]),
                $this->variant('Disabled', 'selection', [['type' => $type, 'title' => 'Disabled state', 'state' => 'disabled']]),
                $this->variant('Read-only', 'selection', [['type' => $type, 'title' => 'Read-only state', 'state' => 'readonly']]),
                $this->variant('Validation', 'selection', [['type' => $type, 'title' => 'Validation state', 'state' => 'error']]),
            ],
        ], $scenarios);

        return $this->implemented($slug, $label, $purpose, $examples, ['group label', 'option control', 'option label', 'helper text', 'validation message'], [
            'Use when users choose one or more options from a visible set.',
            'Use checkbox for independent or multi-select choices; use radio for exactly one visible choice.',
        ], [
            'Do not hide critical choices behind a dropdown when a small visible set is clearer.',
            'Do not use toggle when a submit action is required to apply the setting.',
        ], [
            'Selected and unselected, focus, disabled, read-only, error, warning, helper text, and group-level validation where applicable.',
        ]);
    }

    /**
     * @param array<int, string> $scenarios
     *
     * @return array<string, mixed>
     */
    private function feedback(string $slug, string $label, string $purpose, string $type, array $scenarios): array
    {
        $examples = array_map(fn (string $scenario): array => [
            $scenario,
            $scenario.' demonstrates semantic status, copy structure, and reduced-motion/token expectations where applicable.',
            $type,
            [['title' => $scenario]],
            [
                $this->variant('Success', $type, [['title' => 'Success', 'semantic' => 'success']]),
                $this->variant('Info', $type, [['title' => 'Information', 'semantic' => 'info']]),
                $this->variant('Warning', $type, [['title' => 'Warning', 'semantic' => 'warning']]),
                $this->variant('Error', $type, [['title' => 'Error', 'semantic' => 'danger']]),
                $this->variant('Loading', 'loading', [['title' => 'Loading state']]),
            ],
        ], $scenarios);

        return $this->implemented($slug, $label, $purpose, $examples, ['status icon', 'title', 'message', 'action', 'dismiss or progress affordance'], [
            'Use when users need feedback about a system, task, status, or loading state.',
            'Use semantic text plus icon/state treatment; do not rely on color alone.',
        ], [
            'Do not use feedback components for decorative emphasis.',
            'Do not use loading indicators without an understandable pending region or action.',
        ], [
            'Success, error, warning, info, loading, skeleton, disabled where applicable, and reduced-motion for animated states.',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function tagComponent(): array
    {
        return array_replace($this->correctedImplemented('tag', 'Tag', 'Tags label short metadata, semantic state, or filter context without becoming an action.', [
            $this->exampleFromSample('Metadata tags', 'Neutral tags classify an object, owner, type, or compact metadata value.', ['type' => 'tag', 'items' => [
                ['title' => 'Internal', 'tone' => 'neutral'],
                ['title' => 'Trial', 'tone' => 'neutral', 'size' => 'sm'],
                ['title' => 'Owner', 'tone' => 'neutral', 'size' => 'sm'],
            ]], [
                $this->sampleVariant('Neutral medium', ['type' => 'tag', 'items' => [['title' => 'Internal', 'tone' => 'neutral']]]),
                $this->sampleVariant('Neutral small', ['type' => 'tag', 'items' => [['title' => 'Trial', 'tone' => 'neutral', 'size' => 'sm']]]),
            ]),
            $this->exampleFromSample('Semantic status tags', 'Semantic tones communicate real status with visible text and optional supporting icons.', ['type' => 'tag', 'items' => [
                ['title' => 'Information', 'tone' => 'info', 'icon' => 'heroicon-o-information-circle'],
                ['title' => 'Active', 'tone' => 'success', 'icon' => 'heroicon-o-check-circle'],
                ['title' => 'Pending review', 'tone' => 'warning', 'icon' => 'heroicon-o-exclamation-triangle'],
                ['title' => 'Blocked', 'tone' => 'error', 'icon' => 'heroicon-o-x-circle'],
            ]], [
                $this->sampleVariant('Info', ['type' => 'tag', 'items' => [['title' => 'Information', 'tone' => 'info']]]),
                $this->sampleVariant('Success', ['type' => 'tag', 'items' => [['title' => 'Active', 'tone' => 'success']]]),
                $this->sampleVariant('Warning', ['type' => 'tag', 'items' => [['title' => 'Pending review', 'tone' => 'warning']]]),
                $this->sampleVariant('Error', ['type' => 'tag', 'items' => [['title' => 'Blocked', 'tone' => 'error']]]),
            ]),
            $this->exampleFromSample('Icon-supported tags', 'Icons reinforce visible tag text; they do not replace the label.', ['type' => 'tag', 'items' => [
                ['title' => 'Verified', 'tone' => 'success', 'icon' => 'heroicon-o-check-circle'],
                ['title' => 'Synced', 'tone' => 'info', 'icon' => 'heroicon-o-information-circle'],
            ]], [
                $this->sampleVariant('Decorative state icon', ['type' => 'tag', 'items' => [['title' => 'Verified', 'tone' => 'success', 'icon' => 'heroicon-o-check-circle']]]),
            ]),
            $this->exampleFromSample('Filter/removable boundary', 'Static tags do not render remove controls; removable/filter behavior is gated to the owning filter or search Pattern.', ['type' => 'tag', 'items' => [
                ['title' => 'Region: North', 'tone' => 'neutral', 'removable' => true],
            ]], [
                $this->sampleVariant('Removable gated', ['type' => 'tag', 'items' => [['title' => 'Region: North', 'tone' => 'neutral', 'removable' => true]]], 'Gated', 'The component marks the request but does not render a remove button until Pattern ownership is installed.'),
            ]),
        ], ['container', 'short label', 'optional decorative icon', 'tone', 'size', 'gated removable marker'], [
            'Use when the UI needs compact metadata, type, category, ownership, status, or filter-token display.',
            'Use semantic tones only for real state or system meaning.',
        ], [
            'Do not use tags as buttons, tabs, breadcrumbs, notifications, or primary actions.',
            'Do not render removable/filter tags until the owning Pattern defines behavior, focus, persistence, and empty states.',
        ], [
            'Static default',
            'Neutral',
            'Info',
            'Success',
            'Warning',
            'Error',
            'Small',
            'Medium',
            'Icon-supported',
            'Removable gated',
        ], [
            'Static tags are not focusable and do not respond to hover, active, or disabled states.',
            'Semantic tags rely on visible text first; tone and icon treatment only reinforce meaning.',
            'Requested removable tags render a gated marker, not an interactive remove control.',
        ], [
            'Use concise sentence-case labels.',
            'Avoid vague tags such as Other, Misc, or New unless the data model defines them.',
            'Do not use tags for long explanatory messages.',
        ], [
            'Tag text communicates meaning without relying on color alone.',
            'Decorative icons are hidden from assistive technology when the label already carries the meaning.',
            'Static tags do not enter the tab order.',
        ]), [
            'live_examples_view' => 'platform.ui-reference.components.live-examples.tag',
            'live_examples_layout' => 'flexible-matrix',
        ]);
    }

    /**
     * @param array<int, string> $scenarios
     *
     * @return array<string, mixed>
     */
    private function overlay(string $slug, string $label, string $purpose, string $type, array $scenarios): array
    {
        $examples = array_map(fn (string $scenario): array => [
            $scenario,
            $scenario.' demonstrates open/closed, focus, dismissal, and motion expectations.',
            $type,
            [['title' => $scenario]],
            [
                $this->variant('Open', $type, [['title' => 'Open state']]),
                $this->variant('Focus-visible', $type, [['title' => 'Focus state', 'state' => 'focus']]),
                $this->variant('Disabled trigger', $type, [['title' => 'Disabled trigger', 'state' => 'disabled']]),
                $this->variant('Reduced motion', $type, [['title' => 'Reduced-motion safe']]),
            ],
        ], $scenarios);

        return $this->implemented($slug, $label, $purpose, $examples, ['trigger', 'surface', 'title', 'body', 'dismiss control', 'focus target'], [
            'Use when contextual or blocking detail belongs near the user task.',
            'Use the least-disruptive overlay that satisfies the interaction.',
        ], [
            'Do not put required page content in hover-only disclosure.',
            'Do not use overlays to avoid designing a clear page layout.',
        ], [
            'Open/closed, hover, focus, disabled, dismiss, Escape/outside-click rules, focus return, and reduced motion.',
        ]);
    }

    /**
     * @param array<int, string> $scenarios
     *
     * @return array<string, mixed>
     */
    private function dataDisplay(string $slug, string $label, string $purpose, string $type, array $scenarios): array
    {
        $examples = array_map(fn (string $scenario): array => [
            $scenario,
            $scenario.' demonstrates scan hierarchy, spacing, state, and responsive expectations.',
            $type,
            [['title' => $scenario]],
            [
                $this->variant('Standard density', $type, [['title' => 'Standard density']]),
                $this->variant('Compact density', $type, [['title' => 'Compact density', 'density' => 'compact']]),
                $this->variant('Focus/current', $type, [['title' => 'Focus/current', 'state' => 'focus']]),
                $this->variant('Disabled/empty', $type, [['title' => 'Disabled or empty', 'state' => 'disabled']]),
                $this->variant('Loading/skeleton', 'loading', [['title' => 'Loading skeleton']]),
            ],
        ], $scenarios);

        return $this->implemented($slug, $label, $purpose, $examples, ['container', 'title or caption', 'row or item', 'metadata', 'action region', 'state indicator'], [
            'Use when users need to scan, compare, or inspect structured content.',
            'Use tables for aligned columns and sorting; use lists or tiles for simpler content.',
        ], [
            'Do not force body content into table structure when alignment is not needed.',
            'Do not create local density, border, or row-hover treatments.',
        ], [
            'Empty, loading/skeleton, selected/current, focus, disabled, overflow, and responsive behavior.',
        ]);
    }

    /**
     * @param array<int, string> $scenarios
     *
     * @return array<string, mixed>
     */
    private function navigation(string $slug, string $label, string $purpose, string $type, array $scenarios): array
    {
        $examples = array_map(fn (string $scenario): array => [
            $scenario,
            $scenario.' demonstrates location, current state, focus order, and responsive behavior.',
            $type,
            [['title' => $scenario]],
            [
                $this->variant('Standard layout', $type, [['title' => 'Standard layout']]),
                $this->variant('Current/selected', $type, [['title' => 'Current state', 'state' => 'selected']]),
                $this->variant('Focus-visible', $type, [['title' => 'Focus state', 'state' => 'focus']]),
                $this->variant('Disabled/overflow', $type, [['title' => 'Disabled or overflow', 'state' => 'disabled']]),
            ],
        ], $scenarios);

        return $this->implemented($slug, $label, $purpose, $examples, ['container', 'current item', 'trigger or link', 'panel/content region', 'overflow affordance'], [
            'Use when users need orientation, peer switching, or app shell structure.',
            'Use current-location and focus states consistently.',
        ], [
            'Do not use navigation primitives for task progress unless the component contract explicitly allows it.',
            'Do not create local shell or tab behavior outside the owner route.',
        ], [
            'Current location',
            'Keyboard navigation',
            'Focus order',
            'Responsive collapse',
            'Overflow',
            'Skip-link and focus expectations',
        ]);
    }

    /**
     * @param array<int, string> $triggerConditions
     *
     * @return array<string, mixed>
     */
    private function deferred(string $slug, string $label, string $purpose, array $triggerConditions): array
    {
        return array_replace($this->implemented($slug, $label, $purpose, [[
            'Trigger conditions',
            'This component stays in the catalog so future work has an owner route and boundary.',
            'deferred',
            array_map(fn (string $condition): array => ['label' => $condition], $triggerConditions),
            [
                $this->variant('Deferred', 'deferred', [['label' => 'No app-approved API yet.']]),
                $this->variant('Alternative', 'deferred', [['label' => $triggerConditions[0] ?? 'Use a documented nearby component.']]),
            ],
        ]], ['owner route', 'trigger condition', 'alternative component', 'queued API boundary'], [
            'Use this page to confirm the current boundary before adding the component.',
        ], [
            'Do not build speculative UI before the trigger condition is approved.',
        ], [
            'Keyboard, focus, screen reader, contrast, and behavior requirements must be defined before implementation.',
        ]), [
            'status' => 'Deferred',
            'disposition' => 'Queued Gap',
            'current_decision' => $purpose,
            'queued_gaps' => $triggerConditions,
        ]);
    }

    private function doNotImplement(string $slug, string $label, string $purpose): array
    {
        return array_replace($this->deferred($slug, $label, $purpose, [
            'Trigger only when a product AI decision record approves AI-assisted behavior.',
            'Do not add AI-specific visual markers to non-AI workflows.',
        ]), [
            'status' => 'Do not implement',
            'disposition' => 'Not Applicable Yet',
        ]);
    }

    /**
     * @param array<int, array{0: string, 1: string, 2: string, 3: array<int, array<string, mixed>>, 4: array<int, array<string, mixed>>}> $exampleRows
     * @param array<int, string> $anatomy
     * @param array<int, string> $useWhen
     * @param array<int, string> $doNotUse
     * @param array<int, string> $states
     *
     * @return array<string, mixed>
     */
    private function implemented(string $slug, string $label, string $purpose, array $exampleRows, array $anatomy, array $useWhen, array $doNotUse, array $states): array
    {
        return [
            'status' => 'Implemented Pending Correction',
            'disposition' => 'Implement Component Page',
            'purpose' => $purpose,
            'summary' => $purpose,
            'current_decision' => $label.' now has component-specific UI Reference examples that consume approved Foundation Elements.',
            'use_when' => $useWhen,
            'do_not_use_when' => $doNotUse,
            'states' => $states,
            'variants' => [],
            'anatomy' => $anatomy,
            'behavior' => [
                'Use native semantics first and layer JavaScript only where behavior requires it.',
                'Keyboard, pointer, focus, disabled, loading, validation, overflow, and responsive behavior must match the live examples.',
                'Motion and state changes must use approved Foundation Motion and respect reduced-motion preferences where applicable.',
            ],
            'accessibility' => [
                'Provide visible focus on every interactive element.',
                'Use semantic names, labels, and ARIA only where native semantics are not enough.',
                'Do not rely on color alone for state or meaning.',
                'Maintain contrast in supported light and dark themes.',
            ],
            'content_guidance' => [
                'Use sentence case and concrete labels.',
                'Prefer specific nouns and verb-led action labels over vague copy.',
                'Keep helper, error, and status copy short enough to scan.',
            ],
            'developer_api' => $this->developerApi($slug),
            'developer_api_example_markup' => $this->codeExampleMarkupFor($slug),
            'live_examples' => array_map(fn (array $row): array => $this->example($row[0], $row[1], $row[2], $row[3], $row[4]), $exampleRows),
            'related' => $this->related($slug),
            'queued_gaps' => [],
        ];
    }

    /**
     * @param array<int, array<string, mixed>> $examples
     * @param array<int, string> $anatomy
     * @param array<int, string> $useWhen
     * @param array<int, string> $doNotUse
     * @param array<int, string> $states
     * @param array<int, string> $behavior
     * @param array<int, string> $contentGuidance
     * @param array<int, string> $accessibility
     *
     * @return array<string, mixed>
     */
    private function correctedImplemented(string $slug, string $label, string $purpose, array $examples, array $anatomy, array $useWhen, array $doNotUse, array $states, array $behavior, array $contentGuidance, array $accessibility): array
    {
        return array_replace($this->implemented($slug, $label, $purpose, [], $anatomy, $useWhen, $doNotUse, $states), [
            'status' => 'Implemented - pending manual review',
            'current_decision' => $label.' has a corrected component-specific UI Reference page with canonical app examples, rendered variants, and recovery assertions.',
            'behavior' => $behavior,
            'content_guidance' => $contentGuidance,
            'accessibility' => $accessibility,
            'live_examples' => $examples,
        ]);
    }

    /**
     * @param array<int, array<string, mixed>> $items
     * @param array<int, array<string, mixed>> $variants
     *
     * @return array<string, mixed>
     */
    private function example(string $title, string $description, string $type, array $items, array $variants): array
    {
        return [
            'id' => str($title)->slug()->toString(),
            'title' => $title,
            'description' => $description,
            'view' => null,
            'sample' => ['type' => $type, 'items' => $items],
            'context_notes' => [
                'This scenario uses the app token, spacing, typography, and state rules rather than local visual decisions.',
            ],
            'variants' => $variants,
        ];
    }

    /**
     * @param array<int, array<string, mixed>> $items
     *
     * @return array<string, mixed>
     */
    private function variant(string $label, string $type, array $items, string $status = 'Implemented'): array
    {
        return [
            'label' => $label,
            'status' => $status,
            'sample' => ['type' => $type, 'items' => $items],
            'notes' => $status === 'Deferred' ? 'Requires a documented product trigger before implementation.' : 'Rendered with approved app styles for this scenario.',
        ];
    }

    /**
     * @param array<string, mixed> $sample
     * @param array<int, string> $contextNotes
     * @param array<int, array<string, mixed>> $variants
     *
     * @return array<string, mixed>
     */
    private function exampleFromSample(string $title, string $description, array $sample, array $variants, array $contextNotes = []): array
    {
        return [
            'id' => str($title)->slug()->toString(),
            'title' => $title,
            'description' => $description,
            'view' => null,
            'sample' => $sample,
            'context_notes' => $contextNotes ?: [
                'This scenario is rendered with the canonical app component API and Foundation Element tokens.',
            ],
            'variants' => $variants,
        ];
    }

    /**
     * @param array<string, mixed> $sample
     *
     * @return array<string, mixed>
     */
    private function sampleVariant(string $label, array $sample, string $status = 'Implemented', ?string $notes = null): array
    {
        return [
            'label' => $label,
            'status' => $status,
            'sample' => $sample,
            'notes' => $notes ?? ($status === 'Deferred' ? 'Requires a documented product trigger before implementation.' : 'Rendered with the component API for this scenario.'),
        ];
    }

    /**
     * @return array<string, string>
     */
    private function developerApi(string $slug): array
    {
        $blade = match ($slug) {
            'breadcrumb' => 'x-ui.breadcrumb',
            'button' => 'x-ui.button / x-ui.icon-button',
            'code-snippet' => 'x-ui.code-snippet',
            'text-input' => 'Native input[type=text/email/password/search/url/tel] with ui-field and ui-text-input classes',
            'textarea' => 'Native textarea with ui-field and ui-textarea classes',
            'link' => 'x-ui.link',
            'pagination' => 'x-ui.pagination',
            'search' => 'x-ui.search',
            'dropdown' => 'x-ui.dropdown',
            'file-uploader' => 'x-ui.file-uploader',
            'number-input' => 'x-ui.number-input',
            'select' => 'x-ui.select',
            'radio-button' => 'x-ui.radio-button / x-ui.radio-group',
            'toggle' => 'x-ui.toggle',
            'inline-loading' => 'x-ui.inline-loading',
            'loading' => 'Native status markup with ui-loading / ui-spinner / ui-skeleton classes',
            'progress-bar' => 'x-ui.progress-bar',
            'progress-indicator' => 'x-ui.progress-indicator / x-ui.progress-step',
            'tag' => 'x-ui.tag',
            'structured-list' => 'x-ui.structured-list / x-ui.structured-list-row',
            'tile' => 'x-ui.tile',
            'tooltip' => 'x-ui.tooltip',
            'toggletip' => 'x-ui.toggletip',
            'content-switcher' => 'x-ui.content-switcher',
            'notification' => 'x-ui.inline-alert / x-ui.toast',
            'modal' => 'x-ui.modal',
            'menu' => 'x-ui.menu / x-ui.menu-item',
            'menu-buttons' => 'x-ui.menu-button / x-ui.combo-button / x-ui.overflow-menu',
            'accordion' => 'x-ui.accordion',
            'tabs' => 'x-ui.tabs',
            'checkbox' => 'x-ui.checkbox / x-ui.checkbox-group',
            'data-table' => 'x-ui.data-table',
            'date-picker' => 'x-ui.date-picker',
            'contained-list' => 'x-ui.contained-list / x-ui.contained-list-item',
            'list' => 'Native ul/ol/li with ui-list classes',
            'multiselect' => 'x-ui.multiselect',
            'popover' => 'x-ui.popover',
            'slider' => 'x-ui.slider / x-ui.range-slider',
            'tree-view' => 'x-ui.tree-view',
            default => 'Use the component owner route and app CSS classes documented here.',
        };

        return [
            'owner_route' => '/platform/ui-reference/components/'.$slug,
            'blade' => $blade,
            'js_controller' => match ($slug) {
            'breadcrumb', 'menu', 'menu-buttons' => 'initMenus exported from resources/js/ui-controls/menus.js',
                'tabs' => 'initTabs exported from resources/js/ui-controls/tabs.js',
                'accordion' => 'initAccordions exported from resources/js/ui-controls/accordions.js',
                'code-snippet' => 'initCodeSnippets exported from resources/js/ui-controls/code-snippets.js',
                'dropdown' => 'initDropdowns exported from resources/js/ui-controls/dropdowns.js',
                'content-switcher' => 'initContentSwitchers exported from resources/js/ui-controls/content-switchers.js',
                'checkbox' => 'initCheckboxes exported from resources/js/ui-controls/checkboxes.js',
                'search' => 'initSearchControls exported from resources/js/ui-controls/search.js',
                'structured-list' => 'initStructuredLists exported from resources/js/ui-controls/structured-lists.js',
                'file-uploader', 'number-input', 'select', 'radio-button', 'toggle', 'inline-loading', 'loading', 'progress-bar', 'progress-indicator', 'tag', 'tile', 'link', 'pagination', 'text-input', 'textarea' => 'No dedicated JavaScript controller required for the installed baseline API.',
                'tooltip', 'toggletip' => 'initDisclosureHelpers exported from resources/js/ui-controls.js where richer dismissal behavior is needed.',
                'multiselect' => 'initMultiselects exported from resources/js/ui-controls/multiselects.js',
                'popover' => 'initPopovers exported from resources/js/ui-controls/popovers.js',
                'slider' => 'initSliders exported from resources/js/ui-controls/sliders.js',
                'tree-view' => 'initTreeViews exported from resources/js/ui-controls/tree-views.js',
                'date-picker' => 'No dedicated JavaScript controller required for the native-control API.',
                default => 'No dedicated JavaScript controller required.',
            },
            'css_classes' => match ($slug) {
                'menu-buttons' => 'ui-menu-button, ui-combo-button, ui-overflow-menu, ui-menu, ui-menu-item',
                'date-picker' => 'ui-date-picker, ui-field, ui-field-label, ui-input-date, ui-field-helper, ui-field-error, ui-field-warning',
                'text-input' => 'ui-field, ui-field-label, ui-input, ui-text-input, ui-field-helper, ui-field-error, ui-field-warning',
                'textarea' => 'ui-field, ui-field-label, ui-textarea, ui-field-helper, ui-field-error, ui-field-warning',
                'link' => 'ui-link, ui-link-inline, ui-link-standalone, ui-link-sm, ui-link-md, ui-link-lg, ui-link-with-icon, ui-link-external, ui-link-unavailable',
                'pagination' => 'ui-pagination-control, ui-select, data-ui-pagination-page-size',
                'search' => 'ui-search, ui-search-field, ui-search-input, ui-search-icon, ui-search-clear, ui-search-loading, data-ui-search',
                'dropdown' => 'ui-dropdown, ui-dropdown-trigger, ui-dropdown-menu, ui-dropdown-option, ui-dropdown-sm, ui-dropdown-md, ui-dropdown-lg',
                'file-uploader' => 'ui-field, ui-field-label, ui-input, data-ui-file-uploader',
                'number-input' => 'ui-field, ui-field-label, ui-input',
                'select' => 'ui-select-field, ui-select, ui-select-shell, ui-select-readonly-value, data-ui-select-field, data-ui-select',
                'checkbox' => 'ui-checkbox, ui-checkbox-group, ui-checkbox-box, data-ui-checkbox-input, data-ui-checkbox-nested-group',
                'radio-button' => 'ui-checkbox-group, ui-radio, ui-control-label',
                'toggle' => 'ui-switch, ui-switch-input, ui-switch-track, ui-switch-thumb',
                'content-switcher' => 'ui-content-switcher, ui-content-switcher-list, ui-content-switcher-option, ui-content-switcher-panel',
                'inline-loading' => 'ui-spinner, data-ui-inline-loading-status',
                'loading' => 'ui-loading, ui-spinner, ui-skeleton',
                'progress-bar' => 'data-ui-component=progress-bar, ui progressbar semantics',
                'progress-indicator' => 'data-ui-component=progress-indicator, data-ui-component=progress-step',
                'tag' => 'ui-tag, ui-tag-sm, ui-tag-md, ui-tag-neutral, ui-tag-info, ui-tag-success, ui-tag-warning, ui-tag-error',
                'structured-list' => 'ui-structured-list, ui-structured-list-row, ui-structured-list-condensed, ui-structured-list-hang, ui-structured-list-flush, ui-structured-list-selectable, ui-structured-list-selection-cell',
                'tile' => 'data-ui-component=tile, ui tile state markers',
                'tooltip' => 'data-ui-tooltip-trigger, data-ui-tooltip-content',
                'toggletip' => 'data-ui-toggletip-trigger, data-ui-toggletip-panel, data-ui-toggletip-close',
                'contained-list' => 'ui-contained-list, ui-contained-list-item',
                'list' => 'ui-list, ui-list-ordered, ui-list-unordered, ui-list-nested, ui-list-content',
                'multiselect' => 'ui-multiselect, ui-multiselect-trigger, ui-multiselect-panel, ui-multiselect-tag',
                'popover' => 'ui-popover, ui-popover-panel, ui-popover-close',
                'slider' => 'ui-slider, ui-range-slider, ui-slider-input, ui-slider-value',
                'tree-view' => 'ui-tree-view, ui-tree-view-node, ui-tree-view-node-control',
                default => 'ui-* component classes plus Foundation Element token variables',
            },
            'tokens' => 'Color, Spacing, Typography, Themes, Motion, Icons, and Grid where applicable',
            'example' => $this->codeExampleFor($slug),
        ];
    }

    private function codeExampleFor(string $slug): string
    {
        return match ($slug) {
            'breadcrumb' => '<x-ui.breadcrumb :items="$items" size="sm" :current="$currentPage" overflow />',
            'button' => '<x-ui.button semantic="primary">Save changes</x-ui.button>',
            'code-snippet' => '<x-ui.code-snippet language="Blade" copyable>...</x-ui.code-snippet>',
            'text-input' => '<input name="workspace_name" class="ui-input ui-text-input" type="text" value="Workspace alpha">',
            'textarea' => '<textarea name="notes" class="ui-textarea">Workspace notes</textarea>',
            'link' => '<x-ui.link href="/platform/docs" variant="standalone" size="md" icon="heroicon-o-arrow-right">Open docs</x-ui.link>',
            'pagination' => '<x-ui.pagination :current-page="2" :last-page="5" :page-size-options="[10, 25]" />',
            'search' => '<x-ui.search name="query" label="Search records" value="tenant" />',
            'dropdown' => '<x-ui.dropdown name="role" label="Role" :options="$options" value="owner" />',
            'file-uploader' => '<x-ui.file-uploader name="evidence" label="Upload evidence" accept="application/pdf" />',
            'number-input' => '<x-ui.number-input name="seats" label="Seats" value="5" min="1" max="20" />',
            'select' => '<x-ui.select name="role" label="Role" :options="$options" value="admin" />',
            'radio-button' => '<x-ui.radio-group name="visibility" label="Visibility" :options="$options" value="team" />',
            'toggle' => '<x-ui.toggle name="enabled" label="Enable notifications" checked />',
            'content-switcher' => '<x-ui.content-switcher label="View mode" :options="$options" value="summary" />',
            'inline-loading' => '<x-ui.inline-loading status="loading" label="Saving changes" />',
            'loading' => '<span class="ui-loading" role="status"><span class="ui-spinner"></span>Loading</span>',
            'progress-bar' => '<x-ui.progress-bar value="66" label="Import progress" />',
            'progress-indicator' => '<x-ui.progress-indicator :steps="$steps" />',
            'tag' => '<x-ui.tag tone="success">Active</x-ui.tag>',
            'structured-list' => '<x-ui.structured-list :rows="$rows" selectable />',
            'tile' => '<x-ui.tile title="Workspace" description="Open details" href="#" variant="clickable" />',
            'tooltip' => '<x-ui.tooltip text="Edit workspace"><x-ui.icon-button label="Edit workspace">...</x-ui.icon-button></x-ui.tooltip>',
            'toggletip' => '<x-ui.toggletip label="About domains">Domains route users into a tenant.</x-ui.toggletip>',
            'menu' => '<x-ui.menu :items="$items" trigger-label="Actions" />',
            'menu-buttons' => '<x-ui.menu-button label="Create" type="primary" :items="$items" />',
            'notification' => '<x-ui.inline-alert semantic="danger" title="API failure">Retry the request.</x-ui.inline-alert>',
            'modal' => '<x-ui.modal id="confirm-delete">...</x-ui.modal>',
            'tabs' => '<x-ui.tabs :tabs="$tabs" variant="line" />',
            'checkbox' => '<x-ui.checkbox-group name="permissions" legend="Permissions" :options="$options" :selected="$selected" />',
            'data-table' => '<x-ui.data-table title="Users" :columns="$columns" :rows="$rows" sortable />',
            'date-picker' => '<x-ui.date-picker name="start_date" label="Start date" min="2026-01-01" />',
            'contained-list' => '<x-ui.contained-list title="Workspace reviews" :items="$items" />',
            'list' => '<ul class="ui-list ui-list-unordered"><li>List item</li></ul>',
            'multiselect' => '<x-ui.multiselect name="roles" label="Roles" :options="$options" :value="$selected" filterable />',
            'popover' => '<x-ui.popover label="Review rules">Short contextual content.</x-ui.popover>',
            'slider' => '<x-ui.slider name="retention" label="Retention days" min="0" max="90" value="30" />',
            'tree-view' => '<x-ui.tree-view label="Settings tree" :nodes="$nodes" selected="domain-rules" />',
            default => 'Component-specific API pending correction.',
        };
    }

    private function codeExampleMarkupFor(string $slug): ?string
    {
        $markup = match ($slug) {
            'accordion' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.accordion</span> <span class="ui-code-token-property">:items</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$items"</span> <span class="ui-code-token-punctuation">/&gt;</span>',
            'breadcrumb' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.breadcrumb</span> <span class="ui-code-token-property">:items</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$items"</span> <span class="ui-code-token-property">size</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"sm"</span> <span class="ui-code-token-property">:current</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$currentPage"</span> <span class="ui-code-token-property">overflow</span> <span class="ui-code-token-punctuation">/&gt;</span>',
            'button' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.button</span> <span class="ui-code-token-property">semantic</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"primary"</span><span class="ui-code-token-punctuation">&gt;</span>Save changes<span class="ui-code-token-punctuation">&lt;/</span><span class="ui-code-token-keyword">x-ui.button</span><span class="ui-code-token-punctuation">&gt;</span>',
            'code-snippet' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.code-snippet</span> <span class="ui-code-token-property">language</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Blade"</span> <span class="ui-code-token-property">copyable</span><span class="ui-code-token-punctuation">&gt;</span>...<span class="ui-code-token-punctuation">&lt;/</span><span class="ui-code-token-keyword">x-ui.code-snippet</span><span class="ui-code-token-punctuation">&gt;</span>',
            'menu' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.menu</span> <span class="ui-code-token-property">:items</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$items"</span> <span class="ui-code-token-property">trigger-label</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Actions"</span> <span class="ui-code-token-punctuation">/&gt;</span>',
            'menu-buttons' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.menu-button</span> <span class="ui-code-token-property">label</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Create"</span> <span class="ui-code-token-property">type</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"primary"</span> <span class="ui-code-token-property">:items</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$items"</span> <span class="ui-code-token-punctuation">/&gt;</span>',
            'tabs' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.tabs</span> <span class="ui-code-token-property">:tabs</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$tabs"</span> <span class="ui-code-token-property">variant</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"line"</span> <span class="ui-code-token-punctuation">/&gt;</span>',
            'checkbox' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.checkbox-group</span> <span class="ui-code-token-property">name</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"permissions"</span> <span class="ui-code-token-property">legend</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Permissions"</span> <span class="ui-code-token-property">:options</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$options"</span> <span class="ui-code-token-punctuation">/&gt;</span>',
            'content-switcher' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.content-switcher</span> <span class="ui-code-token-property">label</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"View mode"</span> <span class="ui-code-token-property">:options</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$options"</span> <span class="ui-code-token-property">value</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"summary"</span> <span class="ui-code-token-punctuation">/&gt;</span>',
            'data-table' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.data-table</span> <span class="ui-code-token-property">title</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Users"</span> <span class="ui-code-token-property">:columns</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$columns"</span> <span class="ui-code-token-property">:rows</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$rows"</span> <span class="ui-code-token-property">sortable</span> <span class="ui-code-token-punctuation">/&gt;</span>',
            'date-picker' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.date-picker</span> <span class="ui-code-token-property">name</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"start_date"</span> <span class="ui-code-token-property">label</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Start date"</span> <span class="ui-code-token-property">min</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"2026-01-01"</span> <span class="ui-code-token-punctuation">/&gt;</span>',
            'contained-list' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.contained-list</span> <span class="ui-code-token-property">title</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Workspace reviews"</span> <span class="ui-code-token-property">:items</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$items"</span> <span class="ui-code-token-punctuation">/&gt;</span>',
            'list' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">ul</span> <span class="ui-code-token-property">class</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"ui-list ui-list-unordered"</span><span class="ui-code-token-punctuation">&gt;</span>...<span class="ui-code-token-punctuation">&lt;/</span><span class="ui-code-token-keyword">ul</span><span class="ui-code-token-punctuation">&gt;</span>',
            'multiselect' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.multiselect</span> <span class="ui-code-token-property">name</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"roles"</span> <span class="ui-code-token-property">label</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Roles"</span> <span class="ui-code-token-property">:options</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$options"</span> <span class="ui-code-token-property">filterable</span> <span class="ui-code-token-punctuation">/&gt;</span>',
            'popover' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.popover</span> <span class="ui-code-token-property">label</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Review rules"</span><span class="ui-code-token-punctuation">&gt;</span>Short contextual content.<span class="ui-code-token-punctuation">&lt;/</span><span class="ui-code-token-keyword">x-ui.popover</span><span class="ui-code-token-punctuation">&gt;</span>',
            'slider' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.slider</span> <span class="ui-code-token-property">name</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"retention"</span> <span class="ui-code-token-property">label</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Retention days"</span> <span class="ui-code-token-property">value</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"30"</span> <span class="ui-code-token-punctuation">/&gt;</span>',
            'tree-view' => '<span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.tree-view</span> <span class="ui-code-token-property">label</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Settings tree"</span> <span class="ui-code-token-property">:nodes</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$nodes"</span> <span class="ui-code-token-punctuation">/&gt;</span>',
            default => null,
        };

        return $markup ?? $this->highlightBladeExample($this->codeExampleFor($slug));
    }

    private function highlightBladeExample(string $example): string
    {
        if ($example === 'Component-specific API pending correction.') {
            return '<span class="ui-code-token-string">No public component API approved.</span>';
        }

        $escaped = e($example);
        $escaped = preg_replace('/(&lt;\\/?)(x-ui\\.[a-z0-9.-]+)/', '$1<span class="ui-code-token-keyword">$2</span>', $escaped) ?? $escaped;
        $escaped = preg_replace('/\\s(:?[a-zA-Z0-9_-]+)=/', ' <span class="ui-code-token-property">$1</span><span class="ui-code-token-punctuation">=</span>', $escaped) ?? $escaped;
        $escaped = preg_replace('/(&quot;[^&]*&quot;)/', '<span class="ui-code-token-string">$1</span>', $escaped) ?? $escaped;
        $escaped = str_replace(['&lt;', '&gt;', '/&gt;'], ['<span class="ui-code-token-punctuation">&lt;</span>', '<span class="ui-code-token-punctuation">&gt;</span>', '<span class="ui-code-token-punctuation">/&gt;</span>'], $escaped);

        return $escaped;
    }

    /**
     * @return array<int, array{label: string, href: string}>
     */
    private function related(string $slug): array
    {
        $map = [
            'button' => [['label' => 'Menu buttons', 'href' => '/platform/ui-reference/components/menu-buttons'], ['label' => 'Forms pattern', 'href' => '/platform/ui-reference/patterns/forms']],
            'text-input' => [['label' => 'Textarea', 'href' => '/platform/ui-reference/components/textarea'], ['label' => 'Form patterns', 'href' => '/platform/ui-reference/patterns/forms']],
            'checkbox' => [['label' => 'Radio button', 'href' => '/platform/ui-reference/components/radio-button'], ['label' => 'Form patterns', 'href' => '/platform/ui-reference/patterns/forms']],
            'notification' => [['label' => 'Tag', 'href' => '/platform/ui-reference/components/tag'], ['label' => 'Overlay and feedback patterns', 'href' => '/platform/ui-reference/patterns/overlays-feedback']],
            'modal' => [['label' => 'Tooltip', 'href' => '/platform/ui-reference/components/tooltip'], ['label' => 'Overlay and feedback patterns', 'href' => '/platform/ui-reference/patterns/overlays-feedback']],
            'data-table' => [['label' => 'Pagination', 'href' => '/platform/ui-reference/components/pagination'], ['label' => 'Table patterns', 'href' => '/platform/ui-reference/patterns/tables']],
            'date-picker' => [['label' => 'Text input', 'href' => '/platform/ui-reference/components/text-input'], ['label' => 'Form patterns', 'href' => '/platform/ui-reference/patterns/forms'], ['label' => 'Table patterns', 'href' => '/platform/ui-reference/patterns/tables']],
            'tabs' => [['label' => 'Breadcrumb', 'href' => '/platform/ui-reference/components/breadcrumb'], ['label' => 'Navigation patterns', 'href' => '/platform/ui-reference/patterns/navigation']],
        ];

        return array_values(array_merge(
            $map[$slug] ?? [],
            [['label' => 'Components overview', 'href' => '/platform/ui-reference/components']]
        ));
    }

    private function fieldValue(string $type): string
    {
        return match ($type) {
            'number' => '5',
            'date' => '2026-06-08',
            'search' => 'workspace',
            'select', 'dropdown' => 'Enabled',
            'file' => '',
            'textarea' => 'This workspace note explains the setting in concise language.',
            default => 'Workspace name',
        };
    }

    private function fieldState(string $scenario): string
    {
        return match (true) {
            str_contains($scenario, 'Validation'), str_contains($scenario, 'Error'), str_contains($scenario, 'warning') => 'error',
            str_contains($scenario, 'Read-only') => 'readonly',
            str_contains($scenario, 'Disabled') => 'disabled',
            default => 'default',
        };
    }
}
