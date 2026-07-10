<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/tag/contract.php
| Purpose: Tag Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Tag API that can be called from Blade,
| validated by tooling, and consumed by app layouts or Patterns.
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
        'slug' => 'tag',
        'label' => 'Tag',
        'component' => 'x-ui.tag',
        'summary' => 'Compact read-only, dismissible, selectable, and operational labels for metadata, status, filtering, and compact disclosure triggers.',
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
        'usage_context' => 'Use x-ui.tag for compact metadata, semantic labels, removable filters, selectable filter chips, or operational disclosure tags. Do not use tags as primary actions, alerts, tabs, or long-form descriptions.',

        'props' => [
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional root tag ID.'],
            ['name' => 'variant', 'type' => 'string', 'required' => false, 'default' => 'read-only', 'values' => ['readonly', 'read-only', 'filter', 'dismissible', 'selectable', 'operational'], 'description' => 'Tag behavior variant. filter is accepted as a compatibility alias for dismissible.'],
            ['name' => 'type', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['gray', 'cool-gray', 'cool_gray', 'warm-gray', 'warm_gray', 'red', 'magenta', 'purple', 'blue', 'cyan', 'teal', 'green', 'high-contrast', 'outline'], 'description' => 'Installed tag color type. Takes precedence over tone when both are supplied.'],
            ['name' => 'tone', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['gray', 'neutral', 'blue', 'info', 'notice', 'green', 'success', 'red', 'danger', 'error', 'yellow', 'warning', 'purple'], 'description' => 'Semantic tone alias mapped to an installed tag type.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'md', 'values' => ['sm', 'md', 'lg'], 'description' => 'Tag size.'],
            ['name' => 'text', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Visible tag text. Takes precedence over label and slot text.'],
            ['name' => 'label', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Alias for visible tag text when text is not provided.'],
            ['name' => 'icon', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional decorative x-ui.icon name.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disabled state for interactive tag variants and disabled marker for read-only tags.'],
            ['name' => 'selected', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false, null], 'description' => 'Controlled selectable tag pressed state. When null, defaultSelected determines initial selected state.'],
            ['name' => 'defaultSelected', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Initial selectable tag pressed state when selected is null.'],
            ['name' => 'dismissLabel', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Compatibility alias for the dismissible tag close control label.'],
            ['name' => 'dismissTooltipLabel', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Accessible label and title for the dismissible tag close control. Takes precedence over dismissLabel.'],
            ['name' => 'dismissTooltipAlignment', 'type' => 'string', 'required' => false, 'default' => 'bottom', 'values' => ['top', 'bottom', 'left', 'right', 'top-start', 'top-end', 'bottom-start', 'bottom-end', 'left-start', 'left-end', 'right-start', 'right-end', 'start', 'center', 'end'], 'description' => 'Tooltip alignment marker for the dismissible close control. start/center/end map to bottom-start/bottom/bottom-end.'],
            ['name' => 'tagTitle', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Full text exposed on the visible label title attribute.'],
            ['name' => 'title', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'App compatibility alias for the visible label title attribute when tagTitle is not provided.'],
            ['name' => 'truncate', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['start', 'middle', 'end'], 'description' => 'One-line truncation behavior.'],
            ['name' => 'dir', 'type' => 'string', 'required' => false, 'default' => 'ltr', 'values' => ['ltr', 'rtl', 'auto'], 'description' => 'Direction for visible label text.'],
            ['name' => 'disclosureTarget', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Target element ID for operational disclosure tags. Leading # is accepted and stripped.'],
            ['name' => 'expanded', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Initial expanded state for operational disclosure tags. Installed JavaScript owns runtime updates.'],
            ['name' => 'decorator', 'type' => 'string|HtmlString|ComponentSlot|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional trusted decorator content for read-only and dismissible tags, such as an AI label.'],
            ['name' => 'slug', 'type' => 'string|HtmlString|ComponentSlot|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Deprecated compatibility alias for decorator.', 'compatibility' => true],
        ],

        'slots' => [
            ['name' => 'default', 'required' => false, 'description' => 'Visible text fallback used when text and label are not provided. Markup is stripped for label text.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'tag', 'description' => 'Generated component identity marker.'],
            ['name' => 'data-ui-tag', 'required' => true, 'description' => 'Generated tag initializer marker.'],
            ['name' => 'data-ui-tag-variant', 'required' => true, 'description' => 'Generated resolved tag variant marker.'],
            ['name' => 'data-ui-tag-type', 'required' => true, 'description' => 'Generated resolved tag type marker.'],
            ['name' => 'data-ui-tag-size', 'required' => true, 'description' => 'Generated resolved tag size marker.'],
            ['name' => 'data-ui-tag-selected', 'required' => false, 'description' => 'Generated selectable state marker.'],
            ['name' => 'data-ui-tag-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-tag-dismissible', 'required' => false, 'description' => 'Generated dismissible marker.'],
            ['name' => 'data-ui-tag-dismiss', 'required' => false, 'description' => 'Generated dismiss button marker.'],
            ['name' => 'data-ui-tag-operational', 'required' => false, 'description' => 'Generated operational tag marker.'],
            ['name' => 'data-ui-tag-expanded', 'required' => false, 'description' => 'Generated operational expanded marker.'],
            ['name' => 'data-ui-tag-disclosure-target', 'required' => false, 'description' => 'Generated operational disclosure target marker.'],
            ['name' => 'data-ui-tag-decorator', 'required' => false, 'description' => 'Generated decorator presence marker.'],
            ['name' => 'data-ui-tag-decorator-source', 'required' => false, 'description' => 'Generated decorator source marker: decorator or slug.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-tag',
        'required' => [
            'ui-tag',
        ],
        'optional' => [
            'ui-tag-read-only',
            'ui-tag-dismissible',
            'ui-tag-selectable',
            'ui-tag-operational',
            'ui-tag-type-gray',
            'ui-tag-type-cool-gray',
            'ui-tag-type-warm-gray',
            'ui-tag-type-red',
            'ui-tag-type-magenta',
            'ui-tag-type-purple',
            'ui-tag-type-blue',
            'ui-tag-type-cyan',
            'ui-tag-type-teal',
            'ui-tag-type-green',
            'ui-tag-type-high-contrast',
            'ui-tag-type-outline',
            'ui-tag-sm',
            'ui-tag-md',
            'ui-tag-lg',
            'ui-tag-has-icon',
            'ui-tag-has-decorator',
            'ui-tag-selected',
            'ui-tag-disabled',
            'ui-tag-truncate-start',
            'ui-tag-truncate-middle',
            'ui-tag-truncate-end',
        ],
        'internal' => [
            'ui-tag-label',
            'ui-tag-label-middle',
            'ui-tag-label-start',
            'ui-tag-label-end',
            'ui-tag-icon',
            'ui-tag-icon-decorative',
            'ui-tag-close',
            'ui-tag-close-icon',
            'ui-tag-decorator',
        ],
        'deprecated' => [
            'feature-local tag color classes',
            'raw support-color utility clusters on tag markup',
            'Carbon filter prop behavior; use variant="dismissible"',
            'Carbon onClose prop behavior; use data-ui-tag-dismiss and installed JavaScript',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Behavior Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'read-only' => ['label' => 'Read-only', 'api' => ['variant' => 'read-only'], 'class' => 'ui-tag-read-only', 'description' => 'Default non-interactive metadata or status tag.'],
        'dismissible' => ['label' => 'Dismissible', 'api' => ['variant' => 'dismissible'], 'class' => 'ui-tag-dismissible', 'description' => 'Tag with a named close control for removing filters or metadata.'],
        'selectable' => ['label' => 'Selectable', 'api' => ['variant' => 'selectable'], 'class' => 'ui-tag-selectable', 'description' => 'Toggleable tag that exposes pressed state.'],
        'operational' => ['label' => 'Operational', 'api' => ['variant' => 'operational'], 'class' => 'ui-tag-operational', 'description' => 'Compact disclosure trigger paired with a target element.'],
        'with-icon' => ['label' => 'With icon', 'api' => ['icon' => 'tag'], 'class' => 'ui-tag-has-icon', 'description' => 'Tag with a decorative icon.'],
        'with-decorator' => ['label' => 'With decorator', 'api' => ['decorator' => 'AI'], 'class' => 'ui-tag-has-decorator', 'description' => 'Tag with trusted decorator content.'],
        'selected' => ['label' => 'Selected', 'api' => ['variant' => 'selectable', 'selected' => true], 'class' => 'ui-tag-selected', 'description' => 'Selectable tag selected state.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['disabled' => true], 'class' => 'ui-tag-disabled', 'description' => 'Disabled tag state.'],
        'high-contrast' => ['label' => 'High contrast', 'api' => ['type' => 'high-contrast'], 'class' => 'ui-tag-type-high-contrast', 'description' => 'High contrast tag color type.'],
        'outline' => ['label' => 'Outline', 'api' => ['type' => 'outline'], 'class' => 'ui-tag-type-outline', 'description' => 'Outline tag color type.'],
        'truncate-start' => ['label' => 'Truncate start', 'api' => ['truncate' => 'start'], 'class' => 'ui-tag-truncate-start', 'description' => 'Start truncation treatment.'],
        'truncate-middle' => ['label' => 'Truncate middle', 'api' => ['truncate' => 'middle'], 'class' => 'ui-tag-truncate-middle', 'description' => 'Middle truncation treatment.'],
        'truncate-end' => ['label' => 'Truncate end', 'api' => ['truncate' => 'end'], 'class' => 'ui-tag-truncate-end', 'description' => 'End truncation treatment.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-tag-sm', 'description' => 'Small compact tag.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-tag-md', 'description' => 'Default tag size.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-tag-lg', 'description' => 'Large compact tag.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default non-interactive tag state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled tag state.'],
        'dismissible' => ['label' => 'Dismissible', 'required' => false, 'description' => 'Dismiss control is rendered.'],
        'selectable' => ['label' => 'Selectable', 'required' => false, 'description' => 'Selectable tag is rendered as a button.'],
        'selected' => ['label' => 'Selected', 'required' => false, 'description' => 'Selectable tag is pressed/selected.'],
        'operational' => ['label' => 'Operational', 'required' => false, 'description' => 'Operational disclosure trigger state.'],
        'truncated' => ['label' => 'Truncated', 'required' => false, 'description' => 'Tag label uses truncation treatment.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for selectable, operational, and dismiss controls.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-tag',
        ],
        'component_tokens' => [
            '--ui-tag-*',
            'tag',
            'filter-chip',
            'status-label',
            'metadata-label',
        ],
        'deprecated' => [
            'feature-local tag color classes',
            'raw support-color utility clusters on tag markup',
            'tag markup used as a replacement for buttons, alerts, tabs, or long descriptions',
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
            'tooltip',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'close',
                'dynamic decorative icon through icon prop',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'tag dismiss/select/disclosure behavior if installed',
            ],
        ],
        'blocks' => [
            'metadata',
            'filters',
            'status-labels',
            'compact-disclosure',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Read-only tags are not keyboard interactive.',
            'Selectable and operational tags must be keyboard reachable unless disabled.',
            'Dismissible close control must be keyboard reachable unless disabled.',
        ],
        'aria' => [
            'Read-only tags should not receive interactive ARIA roles.',
            'Selectable tags emit aria-pressed.',
            'Operational tags emit aria-expanded and may emit aria-controls when disclosureTarget is provided.',
            'Dismissible tags expose a named close control.',
            'Disabled interactive tags use native disabled and may expose aria-disabled.',
        ],
        'focus' => [
            'Interactive tag controls must show visible focus.',
            'Non-interactive tags should not receive focus.',
        ],
        'screen_reader' => [
            'Tone must not be the only cue for meaningful status.',
            'Dismiss labels should identify which tag will be removed.',
            'Operational tag labels should describe the disclosure target clearly.',
            'Tags should use short text and not replace long descriptions.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'variant=readonly', 'replacement' => 'variant=read-only', 'description' => 'readonly remains accepted as a compatibility alias.'],
            ['name' => 'variant=filter', 'replacement' => 'variant=dismissible', 'description' => 'filter remains accepted as a compatibility alias for dismissible tag behavior.'],
            ['name' => 'slug', 'replacement' => 'decorator', 'description' => 'slug remains accepted as a deprecated compatibility alias for decorator.'],
            ['name' => 'dismissLabel', 'replacement' => 'dismissTooltipLabel', 'description' => 'dismissLabel remains accepted as a compatibility alias for the close control accessible label.'],
            ['name' => 'title', 'replacement' => 'tagTitle', 'description' => 'title remains accepted as an app alias for the visible label title attribute.'],
        ],
        'classes' => [
            'feature-local tag color classes',
            'non-token tag background classes',
            'non-token tag text color classes',
        ],
        'components' => [
            'ad hoc badge/tag markup outside x-ui.tag',
            'Carbon filter prop behavior; use variant="dismissible"',
            'Carbon onClose prop behavior; use data-ui-tag-dismiss and installed JavaScript',
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
            'resources/views/components/ui/tag/index.blade.php',
        ],
        'css' => [
            'resources/css/components/tag.css',
        ],
        'tokens' => [
            'resources/css/tokens/components/tags.css',
        ],
        'contract' => [
            'resources/views/components/ui/tag/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/tag.md',
        ],
    ],
]);
