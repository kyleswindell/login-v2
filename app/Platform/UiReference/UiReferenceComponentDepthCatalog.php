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
            'link' => $this->actions('link', 'Link', 'Links move users to related locations or trusted reference content.', [
                ['Inline content link', 'A link embedded in body copy without taking over action hierarchy.', 'links', [
                    ['label' => 'View audit requirements', 'href' => '#'],
                ], [
                    $this->variant('Inline text', 'links', [['label' => 'View audit requirements', 'href' => '#']]),
                    $this->variant('Icon trailing', 'links', [['label' => 'Open docs', 'href' => '#', 'icon' => 'heroicon-o-arrow-top-right-on-square', 'icon_position' => 'trailing']]),
                ]],
                ['External/help link', 'Reference handoff with an icon cue and accessible text.', 'links', [
                    ['label' => 'Open platform runbook', 'href' => '#', 'icon' => 'heroicon-o-arrow-top-right-on-square', 'icon_position' => 'trailing'],
                ], [
                    $this->variant('Icon leading', 'links', [['label' => 'Help center', 'href' => '#', 'icon' => 'heroicon-o-question-mark-circle']]),
                    $this->variant('Visited policy', 'links', [['label' => 'Previously viewed runbook', 'href' => '#', 'visited' => true]]),
                ]],
                ['Navigation link', 'A lightweight route link where a button would imply a command.', 'links', [
                    ['label' => 'Settings', 'href' => '#'],
                    ['label' => 'Users', 'href' => '#'],
                    ['label' => 'Current profile', 'href' => '#', 'current' => true],
                ], [
                    $this->variant('Current', 'links', [['label' => 'Current profile', 'href' => '#', 'current' => true]]),
                    $this->variant('Unavailable treatment', 'links', [['label' => 'Billing unavailable', 'href' => '#', 'disabled' => true]]),
                ]],
            ], ['anchor', 'label text', 'optional icon', 'visited policy', 'focus ring']),
            'menu' => $this->menuComponent(),
            'menu-buttons' => $this->menuButtonsComponent(),

            'text-input' => $this->inputs('text-input', 'Text input', 'Single-line free-entry text fields capture short user-provided values.', 'text', ['Login form field', 'Settings form field', 'Validation field', 'Read-only field', 'Disabled field']),
            'textarea' => $this->inputs('textarea', 'Textarea', 'Textarea captures longer user-entered copy with visible multiline affordance.', 'textarea', ['Settings form field', 'Validation field', 'Read-only field', 'Disabled field']),
            'select' => $this->inputs('select', 'Select', 'Native select chooses one option from a short known list.', 'select', ['Short native selection', 'Validation selection', 'Disabled/read-only']),
            'dropdown' => $this->inputs('dropdown', 'Dropdown', 'Dropdown chooses from known options when a native select or menu boundary is more appropriate than free text.', 'dropdown', ['Long known-option handoff', 'Validation selection', 'Disabled/read-only']),
            'number-input' => $this->inputs('number-input', 'Number input', 'Number input captures bounded numeric values with optional step controls.', 'number', ['Min/max/step', 'Increment/decrement', 'Error/warning icon', 'Disabled/read-only', 'Compact/fluid']),
            'date-picker' => $this->datePickerComponent(),
            'file-uploader' => $this->inputs('file-uploader', 'File uploader', 'File uploader collects one or more user-selected files through an accessible input.', 'file', ['Button upload', 'File validation', 'Disabled', 'Drag-drop deferred']),
            'search' => $this->inputs('search', 'Search', 'Search captures free-entry keywords for page, table, or component scope.', 'search', ['Page search', 'Table search', 'Clear action', 'Loading/no-results']),
            'multiselect' => $this->multiselectComponent(),
            'slider' => $this->sliderComponent(),

            'checkbox' => $this->selection('checkbox', 'Checkbox', 'Checkbox supports independent choices and multi-select groups.', 'checkbox', [
                ['Independent choice', 'One setting can be toggled without affecting nearby choices.'],
                ['Multi-select group', 'Several choices can be selected at the same time.'],
                ['Settings group', 'Grouped app preferences with helper text.'],
                ['Validation group', 'Required acknowledgement or group validation.'],
            ]),
            'radio-button' => $this->selection('radio-button', 'Radio button', 'Radio buttons choose exactly one option from a visible set.', 'radio', [
                ['Vertical radio group', 'Default layout for readable single-choice groups.'],
                ['Horizontal radio group', 'Compact peer choices with short labels.'],
                ['Selected/unselected', 'Selected state changes value and visual emphasis.'],
                ['Validation group', 'Error or warning applies to the group, not a single option only.'],
            ]),
            'toggle' => $this->selection('toggle', 'Toggle', 'Toggle controls immediate on/off settings.', 'toggle', [
                ['Immediate setting', 'A setting changes as soon as the toggle is changed.'],
                ['Disabled setting', 'A setting is unavailable because of permissions or dependency.'],
                ['Setting with helper text', 'Optional context explains what the setting changes.'],
            ]),
            'content-switcher' => $this->deferred('content-switcher', 'Content switcher', 'Content switcher remains deferred until a compact peer-view switcher API is needed.', ['Use tabs for panel switching today.', 'Trigger when a small inline mode switcher cannot use tabs.']),

            'notification' => $this->feedback('notification', 'Notification', 'Notifications communicate state changes, errors, and system messages.', 'alert', ['Form validation error', 'Record saved', 'API failure', 'Background job completed', 'Maintenance notice']),
            'tag' => $this->feedback('tag', 'Tag', 'Tags label metadata, status, or filter context without becoming the main action.', 'tag', ['Metadata tag', 'Status tag', 'Filter/removable tag', 'Semantic tag']),
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
            'structured-list' => $this->dataDisplay('structured-list', 'Structured list', 'Structured list compares rich rows where a full data table would be excessive.', 'structured-list', ['Default structured list', 'Selectable structured list', 'Condensed list', 'Selected/focus/disabled/skeleton']),
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
            $this->exampleFromSample('Contextual action menu', 'A closed menu button opens object-level actions in a predictable order without covering reference copy until the user interacts.', ['type' => 'menu', 'items' => $items, 'trigger_label' => 'Workspace actions', 'size' => 'md', 'align' => 'bottom-start'], [
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
                'State variants use static proof panels so review text stays visible.',
            ]),
            $this->exampleFromSample('Row action menu', 'Table rows use icon-only overflow triggers and keep menus short.', ['type' => 'menu', 'items' => [
                ['label' => 'View record'],
                ['label' => 'Edit record'],
                ['label' => 'Export record'],
                ['divider' => true],
                ['label' => 'Disable record', 'danger' => true],
            ], 'trigger_label' => 'Open actions for Workspace alpha', 'trigger_kind' => 'icon', 'size' => 'sm'], [
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
            ], 'trigger_label' => 'View options'], [
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
            $this->exampleFromSample('Alignment and RTL', 'Open menus align to the available space and mirror in RTL contexts.', ['type' => 'menu', 'items' => [['label' => 'Open'], ['label' => 'Export']], 'trigger_label' => 'Aligned menu', 'align' => 'bottom-end'], [
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
        return $this->correctedImplemented('code-snippet', 'Code snippet', 'Code snippets present implementation examples with app-approved code typography and syntax token colors.', [
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
        ], [
            'Keep examples short and tied to the current component API.',
            'Use highlighted tokens only for syntax roles such as keyword, property, string, and punctuation.',
            'Do not use colored code text as decoration outside code contexts.',
        ], [
            'Use semantic `pre` and `code` structure.',
            'Copy controls must be keyboard reachable and announce copied state when implemented.',
            'Token colors must meet contrast in light and dark themes.',
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
        return $this->correctedImplemented('date-picker', 'Date picker', 'Date picker uses native date and date-time controls for simple date entry while deferring custom calendar and range-picker behavior.', [
            $this->exampleFromSample('Native single date', 'Minimum viable date entry with a visible label, helper copy, and native browser picker behavior.', ['type' => 'date-picker', 'items' => [
                ['name' => 'start_date', 'label' => 'Start date', 'value' => '2026-06-08', 'helper' => 'Use the first date this setting should apply.'],
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
            $this->exampleFromSample('Date-time', 'Native date-time entry for simple scheduling where the surrounding pattern explains the relevant time zone.', ['type' => 'date-picker', 'items' => [
                ['name' => 'scheduled_at', 'label' => 'Scheduled activation', 'value' => '2026-06-08T09:30', 'date_type' => 'datetime-local', 'helper' => 'Times use the workspace time zone.'],
            ]], [
                $this->sampleVariant('Minute step', ['type' => 'date-picker', 'items' => [
                    ['name' => 'maintenance_start', 'label' => 'Maintenance start', 'value' => '2026-06-08T09:30', 'date_type' => 'datetime-local', 'step' => '60', 'helper' => 'Minute precision is allowed for this scheduling workflow.'],
                ]]),
                $this->sampleVariant('Warning state', ['type' => 'date-picker', 'items' => [
                    ['name' => 'late_window', 'label' => 'Late maintenance window', 'value' => '2026-06-08T23:30', 'date_type' => 'datetime-local', 'state' => 'warning', 'warning' => 'This time is outside the recommended maintenance window.'],
                ]]),
            ]),
            $this->exampleFromSample('Validation date', 'Required date entry with blocking error copy and non-color-only status treatment.', ['type' => 'date-picker', 'items' => [
                ['name' => 'expires_on', 'label' => 'Expiration date', 'value' => '', 'state' => 'error', 'error' => 'Choose an expiration date before saving.', 'required' => true],
            ]], [
                $this->sampleVariant('Error', ['type' => 'date-picker', 'items' => [
                    ['name' => 'cutover_date', 'label' => 'Cutover date', 'value' => '', 'state' => 'error', 'error' => 'Choose a cutover date before continuing.'],
                ]]),
                $this->sampleVariant('Warning', ['type' => 'date-picker', 'items' => [
                    ['name' => 'review_date', 'label' => 'Review date', 'value' => '2026-12-24', 'state' => 'warning', 'warning' => 'Review dates near holidays need owner confirmation.'],
                ]]),
            ]),
            $this->exampleFromSample('Disabled and read-only dates', 'Unavailable and fixed date values stay visible without offering an editable date picker.', ['type' => 'date-picker', 'items' => [
                ['name' => 'created_on', 'label' => 'Created on', 'value' => '2026-06-08', 'state' => 'readonly', 'helper' => 'Created date is system-managed.'],
                ['name' => 'locked_until', 'label' => 'Locked until', 'value' => '2026-06-30', 'state' => 'disabled', 'helper' => 'This date is controlled by tenant policy.'],
            ]], [
                $this->sampleVariant('Read-only', ['type' => 'date-picker', 'items' => [
                    ['name' => 'audit_date', 'label' => 'Audit date', 'value' => '2026-06-08', 'state' => 'readonly', 'helper' => 'Audit dates are generated by the system.'],
                ]]),
                $this->sampleVariant('Disabled', ['type' => 'date-picker', 'items' => [
                    ['name' => 'policy_unlock', 'label' => 'Policy unlock date', 'value' => '2026-07-01', 'state' => 'disabled', 'helper' => 'Policy unlock date is not editable in this state.'],
                ]]),
            ]),
            $this->exampleFromSample('Range picker boundary', 'Range relationships are pattern-owned today; custom calendar range picker behavior remains gated.', ['type' => 'deferred', 'items' => [
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
            $this->exampleFromSample('Context popover', 'A lightweight interactive panel for short supporting detail.', ['type' => 'popover', 'items' => [[
                'label' => 'Review rules',
                'body' => 'Use this panel for short contextual detail and keep primary tasks on the page.',
                'open' => true,
            ]]], [
                $this->sampleVariant('Open', ['type' => 'popover', 'items' => [[
                    'label' => 'Open popover',
                    'body' => 'Open state exposes the panel and close control.',
                    'open' => true,
                ]]]),
                $this->sampleVariant('Closed trigger', ['type' => 'popover', 'items' => [[
                    'label' => 'Closed popover',
                    'body' => 'The panel remains hidden until opened.',
                ]]]),
            ]),
            $this->exampleFromSample('Placement and size', 'Popover placement, alignment, and size are explicit component options.', ['type' => 'popover', 'items' => [[
                'label' => 'End aligned panel',
                'body' => 'This panel is end aligned and uses the large size option.',
                'align' => 'end',
                'size' => 'lg',
                'open' => true,
            ]]], [
                $this->sampleVariant('Small', ['type' => 'popover', 'items' => [[
                    'label' => 'Small popover',
                    'body' => 'Small panels are for concise help.',
                    'size' => 'sm',
                    'open' => true,
                ]]]),
                $this->sampleVariant('End aligned', ['type' => 'popover', 'items' => [[
                    'label' => 'End aligned',
                    'body' => 'Alignment follows the trigger context.',
                    'align' => 'end',
                    'open' => true,
                ]]]),
            ]),
            $this->exampleFromSample('Disabled trigger', 'Disabled popover triggers stay visible when a dependency may later make help available.', ['type' => 'popover', 'items' => [[
                'label' => 'Policy details unavailable',
                'body' => 'Disabled triggers do not reveal a panel.',
                'disabled' => true,
            ]]], [
                $this->sampleVariant('Disabled', ['type' => 'popover', 'items' => [[
                    'label' => 'Disabled popover',
                    'body' => 'Disabled triggers do not open.',
                    'disabled' => true,
                ]]]),
            ]),
        ], ['trigger button', 'panel', 'content region', 'close control', 'placement/alignment marker'], [
            'Use when short interactive contextual content belongs near its trigger.',
            'Use for help that needs a close control or small links/actions.',
        ], [
            'Do not use Popover for blocking decisions; use Modal.',
            'Do not use Popover for non-interactive hover-only text; use Tooltip.',
            'Do not put long workflows or required page content inside a popover.',
        ], [
            'Closed',
            'Open',
            'Focus-visible',
            'Disabled',
            'Placement',
            'Alignment',
            'Small',
            'Medium',
            'Large',
        ], [
            'Trigger click opens or closes the panel.',
            'Escape or the close control closes the panel and returns focus.',
            'Outside click closes an open panel.',
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
                'rows' => [
                    ['title' => 'Domain rules', 'description' => 'Routing policy ready', 'meta' => 'Reviewed', 'href' => '#', 'selected' => true],
                    ['title' => 'Security settings', 'description' => 'Owner approval pending', 'meta' => 'Pending'],
                ],
            ]]], [
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
        ], ['container', 'header', 'list body', 'item', 'title', 'description', 'metadata', 'empty/loading state'], [
            'Use inside panels, modals, and cards where a bounded list is clearer than a full table.',
            'Use when rows need short descriptions or metadata but not column comparison.',
        ], [
            'Do not use Contained list for sortable tabular data; use Data table.',
            'Do not use Contained list for body copy; use native List.',
        ], [
            'Default',
            'Hover',
            'Focus-visible',
            'Selected',
            'Current',
            'Disabled',
            'Loading',
            'Empty',
            'On-page',
            'Disclosed',
            'Elevated',
        ], [
            'Actionable rows navigate as a whole item.',
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
            'Selected/unselected, focus, disabled, read-only, error, warning, helper text, and group-level validation where applicable.',
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
                'dropdown' => 'initDropdowns exported from resources/js/ui-controls/dropdowns.js',
                'file-uploader', 'number-input', 'select', 'radio-button', 'toggle', 'inline-loading', 'loading', 'progress-bar', 'progress-indicator', 'tag', 'structured-list', 'tile', 'link', 'pagination', 'search', 'text-input', 'textarea' => 'No dedicated JavaScript controller required for the installed baseline API.',
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
                'link' => 'ui-link',
                'pagination' => 'ui-pagination-control, ui-select, data-ui-pagination-page-size',
                'search' => 'ui-field, ui-field-label, ui-input, data-ui-search',
                'dropdown' => 'ui-searchable-select, ui-searchable-select-trigger, ui-searchable-select-panel',
                'file-uploader' => 'ui-field, ui-field-label, ui-input, data-ui-file-uploader',
                'number-input' => 'ui-field, ui-field-label, ui-input',
                'select' => 'ui-field, ui-field-label, ui-select',
                'radio-button' => 'ui-checkbox-group, ui-radio, ui-control-label',
                'toggle' => 'ui-switch, ui-switch-input, ui-switch-track, ui-switch-thumb',
                'inline-loading' => 'ui-spinner, data-ui-inline-loading-status',
                'loading' => 'ui-loading, ui-spinner, ui-skeleton',
                'progress-bar' => 'data-ui-component=progress-bar, ui progressbar semantics',
                'progress-indicator' => 'data-ui-component=progress-indicator, data-ui-component=progress-step',
                'tag' => 'ui-status-pill, ui-status-*',
                'structured-list' => 'ui-structured-list, ui-structured-list-row',
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
            'link' => '<x-ui.link href="/platform/docs" icon="heroicon-o-arrow-top-right-on-square">Open docs</x-ui.link>',
            'pagination' => '<x-ui.pagination :current-page="2" :last-page="5" :page-size-options="[10, 25]" />',
            'search' => '<x-ui.search name="query" label="Search records" value="tenant" />',
            'dropdown' => '<x-ui.dropdown name="role" label="Role" :options="$options" value="owner" />',
            'file-uploader' => '<x-ui.file-uploader name="evidence" label="Upload evidence" accept="application/pdf" />',
            'number-input' => '<x-ui.number-input name="seats" label="Seats" value="5" min="1" max="20" />',
            'select' => '<x-ui.select name="role" label="Role" :options="$options" value="admin" />',
            'radio-button' => '<x-ui.radio-group name="visibility" label="Visibility" :options="$options" value="team" />',
            'toggle' => '<x-ui.toggle name="enabled" label="Enable notifications" checked />',
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
