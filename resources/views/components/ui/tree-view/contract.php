<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/tree-view/contract.php
| Purpose: Tree View Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Tree View API that can be called from
| Blade, validated by tooling, and consumed by app layouts or Patterns.
|
| Tree nodes are intentionally represented by the nodes array API because no
| public x-ui.tree-node Blade component exists at this time.
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
        'slug' => 'tree-view',
        'label' => 'Tree View',
        'component' => 'x-ui.tree-view',
        'summary' => 'Array-driven tree view for hierarchical navigation or selection with active, selected, expanded, disabled, linked, multiselect, hidden-label, and xs/sm size support.',
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
        'usage_context' => 'Use x-ui.tree-view for hierarchical navigation or selection. Tree nodes are supplied through the nodes array. Do not register x-ui.tree-node until an actual tree-node Blade component exists.',

        'props' => [
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Tree view root ID. A generated ID is used when omitted.'],
            ['name' => 'nodes', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Tree node data. Nodes support id, value, label, href, children, expanded, selected, active, and disabled keys.'],
            ['name' => 'label', 'type' => 'string|HtmlString', 'required' => false, 'default' => 'Tree view', 'values' => [], 'description' => 'Tree label used as visible label or accessible aria-label when hidden.'],
            ['name' => 'hideLabel', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Hides the visual label and uses label as the tree accessible name.'],
            ['name' => 'selected', 'type' => 'array|string|int|null', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Selected node ID or selected node ID array.'],
            ['name' => 'active', 'type' => 'string|int|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Active/current node ID.'],
            ['name' => 'expanded', 'type' => 'array|string|int|null', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Expanded parent node ID or expanded node ID array.'],
            ['name' => 'multiselect', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Marks the tree as multiselectable and allows selected to contain multiple IDs. Dynamic multiselect behavior is owned by installed JavaScript.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'sm', 'values' => ['xs', 'sm'], 'description' => 'Tree size.'],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'tree-view', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-tree-view', 'required' => true, 'description' => 'Generated tree view marker.'],
            ['name' => 'data-ui-tree-view-size', 'required' => true, 'description' => 'Generated resolved size marker.'],
            ['name' => 'data-ui-tree-view-multiselect', 'required' => true, 'description' => 'Generated multiselect marker.'],
            ['name' => 'data-ui-tree-view-label-hidden', 'required' => true, 'description' => 'Generated hidden-label marker.'],
            ['name' => 'data-ui-tree-root', 'required' => true, 'description' => 'Generated root tree list marker.'],
            ['name' => 'data-ui-tree-level', 'required' => true, 'description' => 'Generated tree/group depth marker.'],
            ['name' => 'data-ui-tree-node', 'required' => false, 'description' => 'Generated node marker.'],
            ['name' => 'data-ui-tree-node-id', 'required' => false, 'description' => 'Generated node ID marker.'],
            ['name' => 'data-ui-tree-node-level', 'required' => false, 'description' => 'Generated node depth marker.'],
            ['name' => 'data-ui-tree-expanded', 'required' => false, 'description' => 'Generated node expanded state marker.'],
            ['name' => 'data-ui-tree-selected', 'required' => false, 'description' => 'Generated node selected state marker.'],
            ['name' => 'data-ui-tree-active', 'required' => false, 'description' => 'Generated node active/current state marker.'],
            ['name' => 'data-ui-tree-disabled', 'required' => false, 'description' => 'Generated node disabled state marker.'],
            ['name' => 'data-ui-tree-parent-node', 'required' => false, 'description' => 'Generated parent node marker.'],
            ['name' => 'data-ui-tree-leaf', 'required' => false, 'description' => 'Generated leaf node marker.'],
            ['name' => 'data-ui-tree-trigger', 'required' => false, 'description' => 'Generated expandable node trigger marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-tree-view',
        'required' => [
            'ui-tree-view',
            'ui-tree-view-list',
            'ui-tree-view-node',
            'ui-tree-node',
            'ui-tree-view-node-control',
            'ui-tree-view-label',
        ],
        'optional' => [
            'ui-tree-view--xs',
            'ui-tree-view--sm',
            'ui-tree-view--multiselect',
            'ui-tree-view--label-hidden',
            'ui-tree-view-list--root',
            'ui-tree-view-list--nested',
            'ui-tree-node__children',
            'ui-tree-node--hidden',
            'ui-tree-parent-node',
            'ui-tree-leaf-node',
            'ui-tree-node-link-parent',
            'ui-tree-node-link-leaf',
            'ui-tree-node--active',
            'ui-tree-node--selected',
            'ui-tree-node--disabled',
            'ui-tree-node--expanded',
            'ui-tree-node--collapsed',
            'ui-tree-view-caret',
            'ui-tree-view-spacer',
            'ui-label',
        ],
        'internal' => [
            'tree nodes rendered recursively from nodes prop',
        ],
        'deprecated' => [
            'feature-local recursive tree markup',
            'raw treeitem markup outside x-ui.tree-view',
            'invented x-ui.tree-node contract before a Blade file exists',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-tree-view', 'description' => 'Default tree view.'],
        'hidden-label' => ['label' => 'Hidden label', 'api' => ['hideLabel' => true], 'class' => 'ui-tree-view--label-hidden', 'description' => 'Tree view with accessible label only.'],
        'multiselect' => ['label' => 'Multiselect', 'api' => ['multiselect' => true], 'class' => 'ui-tree-view--multiselect', 'description' => 'Tree view marked as multiselectable.'],
        'selected' => ['label' => 'Selected node', 'api' => ['selected' => 'node-1'], 'class' => 'ui-tree-node--selected', 'description' => 'Tree view with selected node.'],
        'active' => ['label' => 'Active node', 'api' => ['active' => 'node-1'], 'class' => 'ui-tree-node--active', 'description' => 'Tree view with active/current node.'],
        'expanded' => ['label' => 'Expanded parent', 'api' => ['expanded' => ['node-1']], 'class' => 'ui-tree-node--expanded', 'description' => 'Tree view with expanded parent node.'],
        'collapsed' => ['label' => 'Collapsed parent', 'api' => ['expanded' => []], 'class' => 'ui-tree-node--collapsed', 'description' => 'Tree view with collapsed parent node.'],
        'disabled-node' => ['label' => 'Disabled node', 'api' => ['nodes' => [['id' => 'a', 'label' => 'A', 'disabled' => true]]], 'class' => 'ui-tree-node--disabled', 'description' => 'Tree view with disabled node.'],
        'linked-node' => ['label' => 'Linked node', 'api' => ['nodes' => [['id' => 'a', 'label' => 'A', 'href' => '#']]], 'description' => 'Tree view with linked node.'],
        'nested' => ['label' => 'Nested', 'api' => ['nodes' => [['id' => 'a', 'label' => 'A', 'children' => [['id' => 'b', 'label' => 'B']]]]], 'class' => 'ui-tree-view-list--nested', 'description' => 'Tree view with nested nodes.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'xs' => ['label' => 'Extra small', 'api' => ['size' => 'xs'], 'class' => 'ui-tree-view--xs', 'description' => 'Extra small tree view.'],
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-tree-view--sm', 'description' => 'Default small tree view.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default tree view state.'],
        'parent' => ['label' => 'Parent node', 'required' => false, 'description' => 'Node has children.'],
        'leaf' => ['label' => 'Leaf node', 'required' => false, 'description' => 'Node has no children.'],
        'expanded' => ['label' => 'Expanded', 'required' => false, 'description' => 'Parent node is expanded.'],
        'collapsed' => ['label' => 'Collapsed', 'required' => false, 'description' => 'Parent node is collapsed.'],
        'selected' => ['label' => 'Selected', 'required' => false, 'description' => 'Node is selected.'],
        'active' => ['label' => 'Active', 'required' => false, 'description' => 'Node is active/current.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Node is disabled.'],
        'multiselect' => ['label' => 'Multiselect', 'required' => false, 'description' => 'Tree allows multiple selected IDs.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for treeitems.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-tree-view',
            'ui-tree-node',
        ],
        'component_tokens' => [
            'tree-view',
            'tree',
            'treeitem',
            'hierarchy',
        ],
        'deprecated' => [
            'feature-local tree renderers',
            'ad hoc nested navigation trees',
            'standalone x-ui.tree-node contract without Blade implementation',
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
            'motion',
        ],
        'uses' => [
            'icons' => [],
            'components' => [],
            'js_initializers' => [
                'tree view behavior if installed',
            ],
        ],
        'blocks' => [
            'navigation-trees',
            'hierarchical-selectors',
            'file-explorers',
            'nested-resource-navigation',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Treeitems must be keyboard reachable through roving tabindex behavior.',
            'Arrow up/down, home/end, left/right expansion, enter/space activation, and multiselect shortcuts are owned by installed Tree View JavaScript.',
            'Disabled nodes must not be included in roving focus behavior.',
        ],
        'aria' => [
            'Root list renders role="tree".',
            'Nested lists render role="group".',
            'Nodes render role="treeitem".',
            'Parent nodes expose aria-expanded and aria-owns.',
            'Selected nodes expose aria-selected.',
            'Active linked nodes expose aria-current="page"; non-linked active nodes expose aria-current="true".',
            'Disabled nodes expose aria-disabled.',
            'Multiselect trees expose aria-multiselectable.',
            'Visible label uses aria-labelledby; hidden label uses aria-label.',
        ],
        'focus' => [
            'Exactly one enabled treeitem should be tabbable initially.',
            'Treeitems must show visible focus.',
        ],
        'screen_reader' => [
            'Label should identify the tree purpose.',
            'Node labels must be concise and unique enough to navigate.',
            'Do not rely on indentation alone to communicate hierarchy.',
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
            'feature-local tree view classes',
            'raw treeitem utility clusters',
        ],
        'components' => [
            'x-ui.tree-node until resources/views/components/ui/tree-node/index.blade.php exists',
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
            'resources/views/components/ui/tree-view/index.blade.php',
        ],
        'css' => [
            'resources/css/components/tree-view.css',
        ],
        'contract' => [
            'resources/views/components/ui/tree-view/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/tree-view.md',
        ],
    ],
]);
