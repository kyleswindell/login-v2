<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/data-table/contract.php
| Purpose: Data Table Component family public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Data Table API that can be called from
| Blade, validated by tooling, and consumed by app layouts or Patterns.
|
| Rendered evidence pages, examples/proofs, testing status, and
| manual review state are intentionally owned outside this contract.
|
*/

return Surface::component([
    /*
    |--------------------------------------------------------------------------
    | Identity
    |--------------------------------------------------------------------------
    */

    'identity' => [
        'slug' => 'data-table',
        'label' => 'Data Table',
        'component' => 'x-ui.data-table',
        'summary' => 'Array-driven and composable native table family with headers, rows, cells, sorting affordances, selection cells, expansion rows, batch actions, loading, empty, error, and pagination composition points.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Lifecycle
    |--------------------------------------------------------------------------
    */

    'lifecycle' => [
        'status' => 'provisional',
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Blade API
    |--------------------------------------------------------------------------
    */

    'api' => [
        'usage_context' => 'Use x-ui.data-table for static server-rendered data tables. Sorting, filtering, pagination state, selection state, expansion state, loading state, and server data ownership remain with the caller, controller, Livewire component, or future JavaScript controller.',

        'props' => [
            ['name' => 'columns', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Column definitions for the array-driven table entry point.'],
            ['name' => 'rows', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Row data for the array-driven table entry point.'],
            ['name' => 'title', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional table title rendered by the data-table container.'],
            ['name' => 'description', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional table description rendered by the data-table container.'],
            ['name' => 'ariaLabel', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Fallback accessible label for the native table.'],
            ['name' => 'size', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['xs', 'sm', 'md', 'lg', 'xl'], 'description' => 'Data table size. Defaults from density when omitted.'],
            ['name' => 'toolbarSize', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['sm', 'lg'], 'description' => 'Toolbar size marker emitted by the entry point. Toolbar file surfaces are excluded from this contract.'],
            ['name' => 'density', 'type' => 'string', 'required' => false, 'default' => 'standard', 'values' => ['standard', 'compact'], 'description' => 'Density shortcut. compact resolves default table size to sm.'],
            ['name' => 'sortable', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Enables sortable header rendering when individual columns are also sortable.'],
            ['name' => 'sortBy', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Current sorted column key.'],
            ['name' => 'sortDirection', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['asc', 'desc'], 'description' => 'Current sort direction.'],
            ['name' => 'loading', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Renders table skeleton state through the installed skeleton companion component.'],
            ['name' => 'empty', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false], 'description' => 'Explicit empty state override. Defaults to rows count.'],
            ['name' => 'emptyTitle', 'type' => 'string', 'required' => false, 'default' => 'No records', 'values' => [], 'description' => 'Empty state title.'],
            ['name' => 'emptyDescription', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Empty state description.'],
            ['name' => 'error', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Error message rendered through the data-table empty-state subcomponent.'],
            ['name' => 'rowActions', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Adds the default row actions column or enables rowActionsSlot rendering.'],
            ['name' => 'pagination', 'type' => 'bool|string|HtmlString|null', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Controls pagination composition. true renders demo/default pagination; filled content renders caller pagination.'],
            ['name' => 'responsive', 'type' => 'string', 'required' => false, 'default' => 'overflow', 'values' => ['overflow', 'static'], 'description' => 'Responsive table strategy. static forces static-width treatment.'],
            ['name' => 'striped', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Applies zebra row treatment.'],
            ['name' => 'stickyHeader', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Applies sticky header wrapping and classes.'],
            ['name' => 'useStaticWidth', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Applies static-width table treatment.'],
            ['name' => 'overflowMenuOnHover', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Controls visible overflow menu treatment for row actions.'],
            ['name' => 'experimentalAutoAlign', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Emits experimental auto-alignment data hook.'],
        ],

        'slots' => [
            ['name' => 'toolbar', 'required' => false, 'description' => 'Optional toolbar slot. Toolbar component files are intentionally excluded from this contract.'],
            ['name' => 'rowActionsSlot', 'required' => false, 'description' => 'Optional custom row action content.'],
            ['name' => 'paginationSlot', 'required' => false, 'description' => 'Optional pagination slot rendered below the table.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'data-table', 'description' => 'Generated container component marker.'],
            ['name' => 'data-ui-data-table', 'required' => false, 'description' => 'Generated entry point marker.'],
            ['name' => 'data-ui-data-table-size', 'required' => false, 'description' => 'Generated resolved size marker.'],
            ['name' => 'data-ui-data-table-toolbar-size', 'required' => false, 'description' => 'Generated resolved toolbar size marker.'],
            ['name' => 'data-ui-data-table-content', 'required' => false, 'description' => 'Generated horizontal overflow wrapper marker.'],
            ['name' => 'data-ui-data-table-cell', 'required' => false, 'description' => 'Generated body cell marker.'],
            ['name' => 'data-ui-data-table-row', 'required' => false, 'description' => 'Generated body row marker.'],
            ['name' => 'data-ui-data-table-sort', 'required' => false, 'description' => 'Generated sortable header button marker.'],
            ['name' => 'data-ui-data-table-auto-align', 'required' => false, 'description' => 'Generated experimental auto-align table marker.'],
            ['name' => 'data-ui-table-select-all', 'required' => false, 'description' => 'Generated select-all input marker.'],
            ['name' => 'data-ui-table-select-row', 'required' => false, 'description' => 'Generated row selection input marker.'],
            ['name' => 'data-ui-table-select-indeterminate', 'required' => false, 'description' => 'Generated indeterminate select-all marker.'],
            ['name' => 'data-ui-table-expand-all', 'required' => false, 'description' => 'Generated expand-all trigger marker.'],
            ['name' => 'data-ui-table-expand-parent', 'required' => false, 'description' => 'Generated expandable parent row marker.'],
            ['name' => 'data-ui-table-expand-trigger', 'required' => false, 'description' => 'Generated row expand trigger marker.'],
            ['name' => 'data-ui-table-expanded-row', 'required' => false, 'description' => 'Generated expanded child row marker.'],
            ['name' => 'data-ui-table-batch-actions', 'required' => false, 'description' => 'Generated batch actions region marker.'],
            ['name' => 'data-ui-table-batch-action', 'required' => false, 'description' => 'Generated batch action button marker.'],
            ['name' => 'data-ui-table-action-list', 'required' => false, 'description' => 'Generated batch action list marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Subcomponents
    |--------------------------------------------------------------------------
    */

    'subcomponents' => [
        'container' => [
            'component' => 'x-ui.data-table.container',
            'description' => 'Outer data-table region, title, and description wrapper.',
            'props' => ['title', 'description', 'titleId', 'descriptionId', 'stickyHeader', 'useStaticWidth', 'aiEnabled'],
            'slots' => ['default'],
        ],
        'table' => [
            'component' => 'x-ui.data-table.table',
            'description' => 'Native table and horizontal overflow wrapper.',
            'props' => ['size', 'sortable', 'striped', 'stickyHeader', 'useStaticWidth', 'overflowMenuOnHover', 'experimentalAutoAlign', 'ariaLabelledby', 'ariaDescribedby', 'ariaLabel'],
            'slots' => ['default'],
        ],
        'head' => [
            'component' => 'x-ui.data-table.head',
            'description' => 'Native thead wrapper.',
            'props' => [],
            'slots' => ['default'],
        ],
        'header' => [
            'component' => 'x-ui.data-table.header',
            'description' => 'Native th wrapper with optional sortable button affordance.',
            'props' => ['sortable', 'sorted', 'sortDirection', 'align', 'scope'],
            'slots' => ['default'],
        ],
        'body' => [
            'component' => 'x-ui.data-table.body',
            'description' => 'Native tbody wrapper with constrained aria-live value.',
            'props' => ['ariaLive'],
            'slots' => ['default'],
        ],
        'row' => [
            'component' => 'x-ui.data-table.row',
            'description' => 'Native body tr wrapper with selected, current, and disabled state classes.',
            'props' => ['selected', 'current', 'disabled'],
            'slots' => ['default'],
        ],
        'cell' => [
            'component' => 'x-ui.data-table.cell',
            'description' => 'Native td wrapper with alignment, headers, and colspan support.',
            'props' => ['align', 'headers', 'colspan'],
            'slots' => ['default'],
        ],
        'empty-state' => [
            'component' => 'x-ui.data-table.empty-state',
            'description' => 'Data-table owned empty/error state region rendered by the high-level array-driven table.',
            'props' => ['title', 'description'],
            'slots' => ['default'],
        ],
        'select-all' => [
            'component' => 'x-ui.data-table.select-all',
            'description' => 'Select-all header checkbox cell.',
            'props' => ['id', 'name', 'ariaLabel', 'checked', 'indeterminate', 'disabled'],
            'slots' => [],
        ],
        'select-row' => [
            'component' => 'x-ui.data-table.select-row',
            'description' => 'Body row selection cell with checkbox or radio input.',
            'props' => ['id', 'name', 'value', 'ariaLabel', 'checked', 'disabled', 'radio'],
            'slots' => [],
        ],
        'expand-header' => [
            'component' => 'x-ui.data-table.expand-header',
            'description' => 'Expandable-row header cell with optional expand-all trigger.',
            'props' => ['id', 'ariaControls', 'ariaLabel', 'enableToggle', 'enableExpando', 'expanded', 'isExpanded', 'expandIconDescription'],
            'slots' => ['default'],
        ],
        'expand-row' => [
            'component' => 'x-ui.data-table.expand-row',
            'description' => 'Expandable parent row with expand/collapse trigger cell.',
            'props' => ['ariaControls', 'ariaLabel', 'expanded', 'isExpanded', 'selected', 'isSelected', 'expandHeader', 'expandIconDescription', 'disabled'],
            'slots' => ['default'],
        ],
        'expanded-row' => [
            'component' => 'x-ui.data-table.expanded-row',
            'description' => 'Expandable child detail row controlled by an expandable parent row.',
            'props' => ['id', 'colspan', 'colSpan', 'expanded', 'isExpanded'],
            'slots' => ['default'],
        ],
        'decorator-row' => [
            'component' => 'x-ui.data-table.decorator-row',
            'description' => 'Leading decorator cell for decorator / AI-label table rows.',
            'props' => ['decorator', 'active'],
            'slots' => ['default'],
        ],
        'slug-row' => [
            'component' => 'x-ui.data-table.slug-row',
            'description' => 'Deprecated compatibility alias for decorator-row-style leading cell.',
            'props' => ['slug', 'active'],
            'slots' => ['default'],
        ],
        'batch-actions' => [
            'component' => 'x-ui.data-table.batch-actions',
            'description' => 'Batch actions toolbar region for selected item summary and action controls.',
            'props' => ['active', 'shouldShowBatchActions', 'totalSelected', 'totalCount', 'showSelectAll', 'cancelLabel', 'selectAllLabel'],
            'slots' => ['default'],
        ],
        'batch-action' => [
            'component' => 'x-ui.data-table.batch-action',
            'description' => 'Batch action button wrapper around x-ui.button.',
            'props' => ['type', 'semantic', 'size', 'disabled', 'hasIconOnly'],
            'slots' => ['default'],
        ],
        'action-list' => [
            'component' => 'x-ui.data-table.action-list',
            'description' => 'Batch action list wrapper.',
            'props' => [],
            'slots' => ['default'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-data-table-container',
        'required' => [
            'ui-data-table-container',
            'ui-data-table-content',
            'ui-data-table',
        ],
        'optional' => [
            'ui-data-table-header',
            'ui-data-table-header__content',
            'ui-data-table-header__title',
            'ui-data-table-header-title',
            'ui-data-table-header__description',
            'ui-data-table-header-description',
            'ui-data-table-inner-container',
            'ui-data-table_inner-container',
            'ui-data-table--max-width',
            'ui-data-table-container--static',
            'ui-data-table-container--ai-enabled',
            'ui-data-table--xs',
            'ui-data-table--sm',
            'ui-data-table--md',
            'ui-data-table--lg',
            'ui-data-table--xl',
            'ui-data-table-xs',
            'ui-data-table-sm',
            'ui-data-table-md',
            'ui-data-table-lg',
            'ui-data-table-xl',
            'ui-data-table--sort',
            'ui-data-table-sort',
            'ui-data-table--zebra',
            'ui-data-table-zebra',
            'ui-data-table--static',
            'ui-data-table-static',
            'ui-data-table--sticky-header',
            'ui-data-table-sticky-header',
            'ui-data-table--visible-overflow-menu',
            'ui-data-table-visible-overflow-menu',
            'ui-data-table-header-cell',
            'ui-data-table-cell',
            'ui-data-table-cell-align-start',
            'ui-data-table-cell-align-center',
            'ui-data-table-cell-align-end',
            'ui-data-table-row',
            'ui-table-row',
            'ui-data-table--selected',
            'ui-data-table-selected',
            'ui-data-table-row-current',
            'ui-data-table-row-disabled',
            'ui-table-sort__header',
            'ui-table-sort__header--active',
            'ui-table-sort__header--descending',
            'ui-table-sort__description',
            'ui-table-sort',
            'ui-table-sort--active',
            'ui-table-sort--descending',
            'ui-table-sort__flex',
            'ui-table-header-label',
            'ui-table-sort__icon',
            'ui-table-sort__icon-unsorted',
            'ui-table-column-checkbox',
            'ui-table-column-radio',
            'ui-table-column-menu',
            'ui-table-column-decorator',
            'ui-table-column-decorator--active',
            'ui-table-column-slug',
            'ui-table-column-slug--active',
            'ui-parent-row',
            'ui-expandable-row',
            'ui-table-expand',
            'ui-table-expand__button',
            'ui-table-expand__svg',
            'ui-child-row-inner-container',
            'ui-data-table-pagination',
            'ui-data-table-error',
            'ui-batch-actions',
            'ui-batch-actions--active',
            'ui-batch-summary',
            'ui-batch-summary__para',
            'ui-batch-summary__divider',
            'ui-batch-summary__cancel',
            'ui-batch-action',
            'ui-batch-action--icon-only',
            'ui-action-list',
            'ui-checkbox',
            'ui-checkbox-label',
            'ui-radio-button',
            'ui-radio-button-label',
            'ui-radio-button-appearance',
            'ui-radio-button__appearance',
            'ui-visually-hidden',
            'sr-only',
        ],
        'internal' => [],
        'deprecated' => [
            'ui-table-column-slug',
            'ui-table-column-slug--active',
            'ad hoc table markup outside x-ui.data-table.*',
            'feature-local data table classes',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'array-driven' => ['label' => 'Array driven', 'api' => ['component' => 'x-ui.data-table'], 'description' => 'High-level array-driven table entry point.'],
        'composable' => ['label' => 'Composable anatomy', 'api' => ['component' => 'x-ui.data-table.*'], 'description' => 'Low-level table anatomy components for manually composed tables.'],
        'sortable' => ['label' => 'Sortable', 'api' => ['sortable' => true], 'description' => 'Sortable header affordances.'],
        'striped' => ['label' => 'Striped', 'api' => ['striped' => true], 'description' => 'Zebra row treatment.'],
        'sticky-header' => ['label' => 'Sticky header', 'api' => ['stickyHeader' => true], 'description' => 'Sticky header wrapping and classes.'],
        'static-width' => ['label' => 'Static width', 'api' => ['useStaticWidth' => true], 'description' => 'Static-width table treatment.'],
        'visible-overflow-menu' => ['label' => 'Visible overflow menu', 'api' => ['overflowMenuOnHover' => false], 'description' => 'Overflow menu remains visible instead of hover-only.'],
        'compact-density' => ['label' => 'Compact density', 'api' => ['density' => 'compact'], 'description' => 'Compact table density.'],
        'loading' => ['label' => 'Loading', 'api' => ['loading' => true], 'description' => 'Loading table skeleton state.'],
        'empty' => ['label' => 'Empty', 'api' => ['empty' => true], 'description' => 'Empty table state.'],
        'error' => ['label' => 'Error', 'api' => ['error' => 'Table failed to load'], 'description' => 'Error table state.'],
        'row-actions' => ['label' => 'Row actions', 'api' => ['rowActions' => true], 'description' => 'Adds an actions column.'],
        'pagination' => ['label' => 'Pagination', 'api' => ['pagination' => true], 'description' => 'Pagination composition below table.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'xs' => ['label' => 'Extra small', 'api' => ['size' => 'xs'], 'class' => 'ui-data-table--xs', 'description' => 'Extra small data table size.'],
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-data-table--sm', 'description' => 'Small data table size.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-data-table--md', 'description' => 'Default data table size.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-data-table--lg', 'description' => 'Large data table size.'],
        'xl' => ['label' => 'Extra large', 'api' => ['size' => 'xl'], 'class' => 'ui-data-table--xl', 'description' => 'Extra large data table size.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default table state.'],
        'loading' => ['label' => 'Loading', 'required' => false, 'description' => 'Loading skeleton state.'],
        'empty' => ['label' => 'Empty', 'required' => false, 'description' => 'No rows available.'],
        'error' => ['label' => 'Error', 'required' => false, 'description' => 'Table failed to load.'],
        'sorted-ascending' => ['label' => 'Sorted ascending', 'required' => false, 'description' => 'Column sorted ascending.'],
        'sorted-descending' => ['label' => 'Sorted descending', 'required' => false, 'description' => 'Column sorted descending.'],
        'selected-row' => ['label' => 'Selected row', 'required' => false, 'description' => 'Row selected state.'],
        'current-row' => ['label' => 'Current row', 'required' => false, 'description' => 'Current row state.'],
        'disabled-row' => ['label' => 'Disabled row', 'required' => false, 'description' => 'Disabled row state.'],
        'expanded' => ['label' => 'Expanded', 'required' => false, 'description' => 'Expanded parent/child row state.'],
        'collapsed' => ['label' => 'Collapsed', 'required' => false, 'description' => 'Collapsed expandable row state.'],
        'batch-actions-active' => ['label' => 'Batch actions active', 'required' => false, 'description' => 'Batch actions region active state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus for sortable headers, selection inputs, expansion controls, batch actions, row actions, and pagination controls.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-data-table',
            'ui-data-table-container',
            'ui-table-sort',
            'ui-table-column',
            'ui-table-expand',
            'ui-batch-actions',
            'ui-batch-action',
        ],
        'component_tokens' => [
            'data-table',
            'table',
            'sort',
            'selection',
            'expansion',
            'batch-actions',
            'pagination',
        ],
        'deprecated' => [
            'ui-table-column-slug',
            'feature-local table wrappers',
            'feature-local row selection controls',
            'ad hoc sortable table markup outside x-ui.data-table.*',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    'dependencies' => [
        'depends_on' => [
            'color',
            'themes',
            'spacing',
            'typography',
            'icons',
            'button',
            'checkbox',
            'radio-button',
            'pagination',
        ],
        'uses' => [
            'icons' => [
                'sort--ascending',
                'sort--descending',
                'caret--sort',
                'close',
                'chevron--right inline svg for expand controls',
            ],
            'components' => [
                'ui.icon',
                'ui.button',
                'ui.pagination',
                'ui.data-table.empty-state',
                'ui.data-table-skeleton if installed',
            ],
            'js_initializers' => [
                'table sorting behavior if installed',
                'row selection behavior if installed',
                'row expansion behavior if installed',
                'batch action behavior if installed',
            ],
        ],
        'blocks' => [
            'data-table-toolbar',
            'table-patterns',
            'search-results',
            'admin-indexes',
            'reporting-tables',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Sortable header buttons must be keyboard reachable.',
            'Selection inputs must remain native checkbox or radio controls.',
            'Expandable row triggers must be keyboard reachable and expose aria-expanded.',
            'Batch action controls must be removed from tab order when inactive.',
            'Horizontally scrollable table content must remain keyboard reachable.',
        ],
        'aria' => [
            'Native table semantics must remain intact.',
            'Tables require aria-label or aria-labelledby.',
            'Descriptions should be associated through aria-describedby when present.',
            'Sortable headers should expose aria-sort when sortable state exists.',
            'Select-all indeterminate state uses aria-checked="mixed" and requires JavaScript to set input.indeterminate.',
            'Expandable parent triggers use aria-expanded and may use aria-controls.',
            'Expanded child rows use aria-hidden and hidden when collapsed.',
            'Disabled rows may expose aria-disabled.',
        ],
        'focus' => [
            'Sortable buttons, selection controls, expand controls, row actions, batch actions, and pagination controls must show visible focus.',
            'Focus behavior after sorting, selection, expansion, and pagination changes belongs to the caller or JavaScript controller.',
        ],
        'screen_reader' => [
            'Column headers must describe column data clearly.',
            'Action buttons must include row-specific accessible names.',
            'Empty, loading, and error states must be announced by the consuming Pattern when table data changes dynamically.',
            'Selection summaries must communicate selected count accurately.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'density:compact', 'replacement' => 'size="sm"', 'description' => 'compact remains accepted as a density shortcut.'],
            ['name' => 'responsive:static', 'replacement' => 'useStaticWidth', 'description' => 'responsive static remains accepted as a shortcut for static-width treatment.'],
            ['name' => 'slug-row.slug', 'replacement' => 'decorator-row.decorator', 'description' => 'Slug row remains as compatibility alias for decorator row usage.'],
            ['name' => 'expanded-row.colSpan', 'replacement' => 'colspan', 'description' => 'colSpan remains accepted as a compatibility alias.'],
            ['name' => 'expand-row.isExpanded', 'replacement' => 'expanded', 'description' => 'isExpanded remains accepted as a compatibility alias.'],
            ['name' => 'expand-row.isSelected', 'replacement' => 'selected', 'description' => 'isSelected remains accepted as a compatibility alias.'],
            ['name' => 'batch-actions.shouldShowBatchActions', 'replacement' => 'active', 'description' => 'shouldShowBatchActions remains accepted as a compatibility alias.'],
        ],
        'classes' => [
            'ui-table-column-slug',
            'ui-table-column-slug--active',
            'feature-local data table classes',
            'raw table utility clusters',
        ],
        'components' => [
            'x-ui.data-table.slug-row',
            'ad hoc table markup outside x-ui.data-table.*',
            'data table toolbar anatomy is governed by the data-table-toolbar contract',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Enforcement
    |--------------------------------------------------------------------------
    */

    'enforcement' => [
        'mode' => 'legacy-compatible',
        'invalid_usage' => 'warn',
    ],

    /*
    |--------------------------------------------------------------------------
    | Source
    |--------------------------------------------------------------------------
    */

    'source' => [
        'blade' => [
            'resources/views/components/ui/data-table/index.blade.php',
            'resources/views/components/ui/data-table/container.blade.php',
            'resources/views/components/ui/data-table/table.blade.php',
            'resources/views/components/ui/data-table/head.blade.php',
            'resources/views/components/ui/data-table/header.blade.php',
            'resources/views/components/ui/data-table/body.blade.php',
            'resources/views/components/ui/data-table/row.blade.php',
            'resources/views/components/ui/data-table/cell.blade.php',
            'resources/views/components/ui/data-table/select-all.blade.php',
            'resources/views/components/ui/data-table/select-row.blade.php',
            'resources/views/components/ui/data-table/expand-header.blade.php',
            'resources/views/components/ui/data-table/expand-row.blade.php',
            'resources/views/components/ui/data-table/expanded-row.blade.php',
            'resources/views/components/ui/data-table/decorator-row.blade.php',
            'resources/views/components/ui/data-table/slug-row.blade.php',
            'resources/views/components/ui/data-table/batch-actions.blade.php',
            'resources/views/components/ui/data-table/batch-action.blade.php',
            'resources/views/components/ui/data-table/action-list.blade.php',
        ],
        'css' => [
            'resources/css/components/data-table.css',
        ],
        'contract' => [
            'resources/views/components/ui/data-table/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/data-table.md',
        ],
    ],
]);
