<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/patterns/tag-group/contract.php
| Purpose: Tag Group Pattern public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Tag Group Pattern API that can be called
| from Blade, validated by tooling, and consumed by app layouts or Patterns.
|
| Tag Group is a Pattern API contract. It composes x-ui.tag instances and
| defines grouping, wrapping, spacing, selection, and accessibility rules.
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
        'slug' => 'tag-group',
        'label' => 'Tag Group',
        'component' => 'x-patterns.tag-group',
        'api_layer' => 'Pattern API',
        'summary' => 'Pattern wrapper for grouping tags with approved spacing, wrapping, selection, and accessible group labelling rules.',
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
        'usage_context' => 'Use x-patterns.tag-group to group related x-ui.tag instances for metadata, filters, selectable tag sets, compact status lists, or operational tag clusters. Use x-ui.multi-select or x-ui.filterable-multi-select when selectable tags become too numerous to scan comfortably.',

        'props' => [
            [
                'name' => 'items',
                'type' => 'array',
                'required' => false,
                'default' => [],
                'values' => [],
                'description' => 'Optional array-driven tags. Items may be strings or arrays using the x-ui.tag public API surface.',
            ],
            [
                'name' => 'label',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Accessible group label. When provided, the wrapper receives role="group" and aria-label.',
            ],
            [
                'name' => 'labelledby',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'ID of an external element that labels the group. Used only when label is not provided.',
            ],
            [
                'name' => 'selectionMode',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => ['single', 'multiple', null],
                'description' => 'Optional selection mode metadata for selectable tag groups. Also causes the wrapper to receive role="group".',
            ],
            [
                'name' => 'orientation',
                'type' => 'string',
                'required' => false,
                'default' => 'horizontal',
                'values' => ['horizontal', 'vertical'],
                'description' => 'Visual layout orientation for the tag group.',
            ],
            [
                'name' => 'wrap',
                'type' => 'bool',
                'required' => false,
                'default' => true,
                'values' => [true, false],
                'description' => 'Allows tags to wrap onto additional rows when horizontal space is constrained.',
            ],
            [
                'name' => 'compact',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Uses tighter group spacing for dense local metadata clusters.',
            ],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => false,
                'description' => 'Manual x-ui.tag children. Prefer slot mode when tags need custom attributes, event hooks, or mixed markup.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-pattern', 'required' => true, 'value' => 'tag-group', 'description' => 'Generated pattern identity marker.'],
            ['name' => 'data-ui-tag-group', 'required' => true, 'description' => 'Generated tag group marker.'],
            ['name' => 'data-ui-tag-group-orientation', 'required' => true, 'description' => 'Generated orientation marker.'],
            ['name' => 'data-ui-tag-group-wrap', 'required' => true, 'description' => 'Generated wrapping state marker.'],
            ['name' => 'data-ui-tag-group-selection-mode', 'required' => false, 'description' => 'Generated selection mode marker.'],
            ['name' => 'data-ui-tag-group-item', 'required' => false, 'description' => 'Generated marker for array-driven x-ui.tag children.'],
            ['name' => 'data-ui-tag-group-item-index', 'required' => false, 'description' => 'Generated array-driven item index marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-tag-group',
        'required' => [
            'ui-tag-group',
        ],
        'optional' => [
            'ui-tag-group--horizontal',
            'ui-tag-group--vertical',
            'ui-tag-group--wrap',
            'ui-tag-group--nowrap',
            'ui-tag-group--compact',
            'ui-tag-group--selectable',
            'ui-tag-group--selection-single',
            'ui-tag-group--selection-multiple',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local tag cluster wrappers',
            'raw tag flex wrappers where x-patterns.tag-group should be used',
            'tag groups registered as Component API contracts',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'horizontal' => [
            'label' => 'Horizontal',
            'api' => ['orientation' => 'horizontal'],
            'class' => 'ui-tag-group--horizontal',
            'description' => 'Default horizontal tag group for short scannable tag sets.',
        ],
        'vertical' => [
            'label' => 'Vertical',
            'api' => ['orientation' => 'vertical'],
            'class' => 'ui-tag-group--vertical',
            'description' => 'Vertical tag group for stacked contexts or narrow layouts.',
        ],
        'wrapping' => [
            'label' => 'Wrapping',
            'api' => ['wrap' => true],
            'class' => 'ui-tag-group--wrap',
            'description' => 'Tags wrap onto additional rows when needed.',
        ],
        'nowrap' => [
            'label' => 'No wrap',
            'api' => ['wrap' => false],
            'class' => 'ui-tag-group--nowrap',
            'description' => 'Tags remain on one line. Use only when overflow is intentionally handled by the surrounding layout.',
        ],
        'compact' => [
            'label' => 'Compact',
            'api' => ['compact' => true],
            'class' => 'ui-tag-group--compact',
            'description' => 'Reduced spacing for dense metadata groups.',
        ],
        'selectable-single' => [
            'label' => 'Selectable single',
            'api' => ['selectionMode' => 'single'],
            'class' => 'ui-tag-group--selection-single',
            'description' => 'Selectable tag group where one tag should be selected at a time.',
        ],
        'selectable-multiple' => [
            'label' => 'Selectable multiple',
            'api' => ['selectionMode' => 'multiple'],
            'class' => 'ui-tag-group--selection-multiple',
            'description' => 'Selectable tag group where multiple tags may be selected.',
        ],
        'array-driven' => [
            'label' => 'Array-driven',
            'api' => ['items' => [['text' => 'Tag', 'type' => 'blue']]],
            'description' => 'Pattern renders x-ui.tag children from item arrays.',
        ],
        'slot-mode' => [
            'label' => 'Slot mode',
            'api' => ['slot' => 'default'],
            'description' => 'Caller provides explicit x-ui.tag children.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [],

    /*
    |--------------------------------------------------------------------------
    | Pattern States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => [
            'label' => 'Default',
            'required' => true,
            'description' => 'Default horizontal wrapping tag group.',
        ],
        'labelled' => [
            'label' => 'Labelled',
            'required' => false,
            'description' => 'Group has an accessible label through aria-label or aria-labelledby.',
        ],
        'unlabelled' => [
            'label' => 'Unlabelled',
            'required' => false,
            'description' => 'Group is visual only and does not receive role="group".',
        ],
        'selectable' => [
            'label' => 'Selectable',
            'required' => false,
            'description' => 'Group contains selectable tags and exposes selection mode metadata.',
        ],
        'wrapping' => [
            'label' => 'Wrapping',
            'required' => true,
            'description' => 'Tags may wrap onto additional lines.',
        ],
        'compact' => [
            'label' => 'Compact',
            'required' => false,
            'description' => 'Reduced group gap is used.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Visible focus state belongs to interactive x-ui.tag children.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Rules
    |--------------------------------------------------------------------------
    */

    'rules' => [
        'layout' => [
            'Use horizontal alignment for small groups of tags that need quick scanning.',
            'Keep groups of six or fewer tags on one row when space allows.',
            'Allow horizontal groups to wrap when there are too many tags for one row.',
            'Use approximately 8px spacing between tags on all sides.',
            'Vertically align the tag group container to nearby text or controls; do not hang the group into grid gutters only to align titles.',
            'Avoid long tag labels that wrap inside the tag. Use truncation or shorter labels instead.',
        ],
        'selection' => [
            'Selectable tags remain individually tabbable.',
            'Use Tab to move through selectable tags in the group.',
            'Use Enter or Space on the focused selectable tag to select or deselect it.',
            'Do not add roving tabindex behavior to selectable tag groups.',
            'If selectable tags exceed roughly five wrapped lines, use multi-select or filterable multi-select instead.',
        ],
        'composition' => [
            'Compose with x-ui.tag children.',
            'Do not use tag group as a replacement for checkbox group, radio group, tabs, segmented controls, or multi-select.',
            'Do not mix unrelated tag meanings in one group.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-tag-group',
            'ui-tag',
        ],
        'component_tokens' => [
            'tag-group',
            'tag',
            'filter-chip-group',
            'metadata-group',
            'status-label-group',
        ],
        'deprecated' => [
            'feature-local tag group classes',
            'raw tag group flex wrappers',
            'component registration for tag-group',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    'dependencies' => [
        'depends_on' => [
            'tag',
            'spacing',
            'layout',
            'forms',
        ],
        'uses' => [
            'icons' => [],
            'components' => [
                'ui.tag',
            ],
            'patterns' => [],
            'js_initializers' => [
                'tag behavior if installed',
            ],
        ],
        'blocks' => [
            'filters',
            'metadata',
            'status-labels',
            'compact-disclosure',
            'tag-clouds',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'The tag group wrapper itself is not keyboard interactive.',
            'Interactive tags inside the group must remain keyboard reachable unless disabled.',
            'Selectable tags use Tab for navigation and Enter or Space for selection.',
            'Do not implement roving tabindex for selectable tag groups.',
        ],
        'aria' => [
            'Use role="group" only when the group needs an accessible label or selection mode metadata.',
            'Provide aria-label or aria-labelledby for selectable tag groups.',
            'Do not add group semantics for purely visual read-only tag clusters unless the grouping must be announced.',
            'Individual x-ui.tag instances own their own pressed, expanded, dismiss, and disabled states.',
        ],
        'focus' => [
            'Visible focus belongs to interactive x-ui.tag children.',
            'The group wrapper should not receive focus unless a caller intentionally adds focus behavior.',
        ],
        'screen_reader' => [
            'The group label should describe the relationship between the tags.',
            'Tag text should be short and scannable.',
            'Do not rely on color or tag tone alone to communicate status.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [],
        'classes' => [
            'feature-local tag group utility classes',
            'raw flex wrappers for grouped tags',
        ],
        'components' => [
            'x-ui.tag-group as a Component API contract',
            'ad hoc tag group wrappers outside x-patterns.tag-group',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Enforcement
    |--------------------------------------------------------------------------
    */

    'enforcement' => [
        'mode' => 'pattern-guidance',
        'invalid_usage' => 'warn',
    ],

    /*
    |--------------------------------------------------------------------------
    | Source
    |--------------------------------------------------------------------------
    */

    'source' => [
        'blade' => [
            'resources/views/components/patterns/tag-group/index.blade.php',
        ],
        'css' => [
            'resources/css/components/tag.css',
        ],
        'contract' => [
            'resources/views/components/patterns/tag-group/contract.php',
        ],
        'docs' => [],
    ],
]);
