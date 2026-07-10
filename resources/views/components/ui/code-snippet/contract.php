<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/code-snippet/contract.php
| Purpose: Code Snippet Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Code Snippet API that can be called from
| Blade, validated by tooling, and consumed by documentation, reference pages,
| implementation guides, or app layouts.
|
| Rendered evidence pages, examples/proofs, testing status, and
| manual review state are intentionally owned outside this contract.
|
*/

return Surface::component([
    'identity' => [
        'slug' => 'code-snippet',
        'label' => 'Code Snippet',
        'component' => 'x-ui.code-snippet',
        'summary' => 'Code snippet component supporting inline, single-line, and multi-line variants with optional copy behavior, copied feedback, syntax token markup, light/disabled/wrap states, and multi-line expansion metadata.',
    ],

    'lifecycle' => [
        'status' => 'provisional',
    ],

    'api' => [
        'usage_context' => 'Use x-ui.code-snippet for implementation syntax, command examples, tokenized code samples, and reusable snippets. Do not use it for ordinary prose or labels.',

        'props' => [
            ['name' => 'variant', 'type' => 'string', 'required' => false, 'default' => 'single', 'values' => ['inline', 'single', 'multi'], 'description' => 'Canonical snippet variant.'],
            ['name' => 'type', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['inline', 'single', 'multi'], 'description' => 'Compatibility alias for variant. Takes precedence when supplied.'],
            ['name' => 'ariaLabel', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Accessible label for copyable inline snippets and single/multi snippet textboxes.'],
            ['name' => 'copyable', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Enables copy behavior unless hideCopyButton is explicitly supplied.'],
            ['name' => 'hideCopyButton', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false, null], 'description' => 'Explicitly hides or shows copy controls. Takes precedence over copyable.'],
            ['name' => 'copyText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Explicit text to copy instead of extracting text from the rendered code source.'],
            ['name' => 'copyButtonDescription', 'type' => 'string', 'required' => false, 'default' => 'Copy to clipboard', 'values' => [], 'description' => 'Copy button accessible label.'],
            ['name' => 'feedback', 'type' => 'string', 'required' => false, 'default' => 'Copied to clipboard', 'values' => [], 'description' => 'Copied feedback text.'],
            ['name' => 'feedbackTimeout', 'type' => 'int|string', 'required' => false, 'default' => 2000, 'values' => [], 'description' => 'Copied feedback timeout metadata.'],
            ['name' => 'copyState', 'type' => 'string', 'required' => false, 'default' => 'idle', 'values' => ['idle', 'copied'], 'description' => 'Initial copy state.'],
            ['name' => 'language', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Language metadata. Preserved as data attribute; not rendered as visible header.'],
            ['name' => 'light', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Light snippet treatment.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disabled snippet state.'],
            ['name' => 'wrapText', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Allows text wrapping treatment.'],
            ['name' => 'expandable', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Allows multi-line expansion behavior.'],
            ['name' => 'showMoreText', 'type' => 'string', 'required' => false, 'default' => 'Show more', 'values' => [], 'description' => 'Show-more button text.'],
            ['name' => 'showLessText', 'type' => 'string', 'required' => false, 'default' => 'Show less', 'values' => [], 'description' => 'Show-less button text.'],
            ['name' => 'showMoreLabel', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Compatibility label alias for showMoreText.'],
            ['name' => 'showLessLabel', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Compatibility label alias for showLessText.'],
            ['name' => 'maxCollapsedNumberOfRows', 'type' => 'int|string', 'required' => false, 'default' => 15, 'values' => [], 'description' => 'Maximum collapsed row count metadata.'],
            ['name' => 'maxExpandedNumberOfRows', 'type' => 'int|string', 'required' => false, 'default' => 0, 'values' => [], 'description' => 'Maximum expanded row count metadata.'],
            ['name' => 'minCollapsedNumberOfRows', 'type' => 'int|string', 'required' => false, 'default' => 3, 'values' => [], 'description' => 'Minimum collapsed row count metadata.'],
            ['name' => 'minExpandedNumberOfRows', 'type' => 'int|string', 'required' => false, 'default' => 16, 'values' => [], 'description' => 'Minimum expanded row count metadata.'],
            ['name' => 'align', 'type' => 'string', 'required' => false, 'default' => 'bottom', 'values' => ['auto', 'top', 'top-start', 'top-end', 'right', 'right-start', 'right-end', 'bottom', 'bottom-start', 'bottom-end', 'left', 'left-start', 'left-end'], 'description' => 'Copy button tooltip placement compatibility prop.'],
            ['name' => 'autoAlign', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Tooltip auto-align compatibility metadata.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => true, 'description' => 'Code content. May contain trusted syntax-token markup such as ui-code-token-* spans. Plain untrusted code should be escaped before passing.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'code-snippet', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-code-snippet', 'required' => true, 'description' => 'Generated snippet marker.'],
            ['name' => 'data-ui-code-snippet-variant', 'required' => true, 'description' => 'Generated resolved variant marker.'],
            ['name' => 'data-ui-code-snippet-language', 'required' => true, 'description' => 'Generated language metadata marker.'],
            ['name' => 'data-ui-code-snippet-light', 'required' => true, 'description' => 'Generated light state marker.'],
            ['name' => 'data-ui-code-snippet-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-code-snippet-wrap-text', 'required' => true, 'description' => 'Generated wrap text marker.'],
            ['name' => 'data-ui-code-copy-button', 'required' => false, 'description' => 'Generated copy trigger marker.'],
            ['name' => 'data-ui-code-copy-state', 'required' => false, 'description' => 'Generated copy state marker.'],
            ['name' => 'data-ui-code-copy-source', 'required' => true, 'description' => 'Generated code copy source marker.'],
            ['name' => 'data-ui-code-copy-text', 'required' => false, 'description' => 'Generated explicit copy text marker.'],
            ['name' => 'data-ui-code-copy-feedback', 'required' => false, 'description' => 'Generated copy feedback marker.'],
            ['name' => 'data-ui-code-copy-feedback-timeout', 'required' => false, 'description' => 'Generated copy feedback timeout marker.'],
            ['name' => 'data-ui-code-snippet-container', 'required' => false, 'description' => 'Generated single/multi container marker.'],
            ['name' => 'data-ui-code-snippet-code', 'required' => false, 'description' => 'Generated pre/code wrapper marker.'],
            ['name' => 'data-ui-code-snippet-copy-control', 'required' => false, 'description' => 'Generated copy control wrapper marker.'],
            ['name' => 'data-ui-code-snippet-expandable', 'required' => false, 'description' => 'Generated multi-line expandable marker.'],
            ['name' => 'data-ui-code-snippet-expanded', 'required' => false, 'description' => 'Generated expanded state marker.'],
            ['name' => 'data-ui-code-snippet-expand', 'required' => false, 'description' => 'Generated expand button marker.'],
            ['name' => 'data-ui-code-snippet-expand-text', 'required' => false, 'description' => 'Generated expand text marker.'],
        ],
    ],

    'class_contract' => [
        'root' => 'ui-code-snippet-shell',
        'required' => [
            'ui-code-snippet-shell',
        ],
        'optional' => [
            'ui-code-snippet-shell-inline',
            'ui-code-snippet-shell-inline-copyable',
            'ui-code-snippet-shell-single',
            'ui-code-snippet-shell-multi',
            'ui-code-snippet-shell-disabled',
            'ui-code-snippet-shell-light',
            'ui-code-snippet-shell-no-copy',
            'ui-code-snippet-shell-wraptext',
            'ui-code-snippet-shell-expandable',
            'ui-code-snippet-container',
            'ui-code-snippet',
            'ui-code-snippet-copy-control',
            'ui-code-snippet-expand-button',
            'ui-code-snippet-expand-icon',
            'ui-code-token-keyword',
            'ui-code-token-property',
            'ui-code-token-string',
            'ui-code-token-punctuation',
            'sr-only',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local code block wrappers',
            'raw pre/code copy controls',
            'ad hoc copy controls inside snippets',
            'hard-coded syntax token colors',
        ],
    ],

    'variants' => [
        'inline' => ['label' => 'Inline', 'api' => ['variant' => 'inline'], 'class' => 'ui-code-snippet-shell-inline', 'description' => 'Inline code snippet.'],
        'inline-copyable' => ['label' => 'Inline copyable', 'api' => ['variant' => 'inline', 'copyable' => true], 'class' => 'ui-code-snippet-shell-inline-copyable', 'description' => 'Inline code snippet rendered as copyable button.'],
        'single' => ['label' => 'Single line', 'api' => ['variant' => 'single'], 'class' => 'ui-code-snippet-shell-single', 'description' => 'Single-line code snippet.'],
        'multi' => ['label' => 'Multi line', 'api' => ['variant' => 'multi'], 'class' => 'ui-code-snippet-shell-multi', 'description' => 'Multi-line code snippet.'],
        'copyable' => ['label' => 'Copyable', 'api' => ['copyable' => true], 'description' => 'Snippet with copy behavior.'],
        'no-copy' => ['label' => 'No copy', 'api' => ['hideCopyButton' => true], 'class' => 'ui-code-snippet-shell-no-copy', 'description' => 'Snippet without copy control.'],
        'copied' => ['label' => 'Copied', 'api' => ['copyState' => 'copied'], 'description' => 'Snippet in copied state.'],
        'light' => ['label' => 'Light', 'api' => ['light' => true], 'class' => 'ui-code-snippet-shell-light', 'description' => 'Light snippet treatment.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['disabled' => true], 'class' => 'ui-code-snippet-shell-disabled', 'description' => 'Disabled snippet treatment.'],
        'wrap-text' => ['label' => 'Wrap text', 'api' => ['wrapText' => true], 'class' => 'ui-code-snippet-shell-wraptext', 'description' => 'Wrapped text treatment.'],
        'expandable' => ['label' => 'Expandable', 'api' => ['variant' => 'multi', 'expandable' => true], 'class' => 'ui-code-snippet-shell-expandable', 'description' => 'Expandable multi-line snippet.'],
    ],

    'sizes' => [],

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default single-line snippet state.'],
        'inline' => ['label' => 'Inline', 'required' => false, 'description' => 'Inline snippet state.'],
        'single' => ['label' => 'Single', 'required' => false, 'description' => 'Single-line snippet state.'],
        'multi' => ['label' => 'Multi', 'required' => false, 'description' => 'Multi-line snippet state.'],
        'copyable' => ['label' => 'Copyable', 'required' => false, 'description' => 'Copy behavior enabled.'],
        'copied' => ['label' => 'Copied', 'required' => false, 'description' => 'Copied feedback state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled snippet state.'],
        'light' => ['label' => 'Light', 'required' => false, 'description' => 'Light treatment state.'],
        'wrap-text' => ['label' => 'Wrap text', 'required' => false, 'description' => 'Text wrap state.'],
        'expandable' => ['label' => 'Expandable', 'required' => false, 'description' => 'Multi-line expansion available.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for copyable inline snippets, copy buttons, textboxes, and expand controls.'],
    ],

    'tokens' => [
        'class_families' => [
            'ui-code-snippet',
            'ui-code-token',
        ],
        'component_tokens' => [
            'code-snippet',
            'copy-button',
            'syntax-token',
            'developer-content',
        ],
        'deprecated' => [
            'feature-local code blocks',
            'hard-coded syntax colors',
            'raw copy controls inside code snippets',
        ],
    ],

    'dependencies' => [
        'depends_on' => [
            'color',
            'themes',
            'spacing',
            'typography',
            'icons',
            'copy-button',
            'tooltip',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'chevron--down',
                'copy--to-clipboard',
            ],
            'components' => [
                'ui.icon',
                'ui.copy-button',
            ],
            'js_initializers' => [
                'code snippet copy behavior if installed',
                'code snippet expansion behavior if installed',
            ],
        ],
        'blocks' => [
            'documentation',
            'implementation-guides',
            'reference-pages',
            'developer-examples',
        ],
    ],

    'accessibility' => [
        'keyboard' => [
            'Copyable inline snippets must be keyboard reachable unless disabled.',
            'Single and multi snippets expose a focusable readonly textbox container unless disabled.',
            'Copy and expand controls must be keyboard reachable unless disabled.',
        ],
        'aria' => [
            'Copyable inline snippets have an accessible label and live feedback text.',
            'Single/multi containers render role="textbox" and aria-readonly.',
            'Multi snippets render aria-multiline.',
            'Expand button exposes aria-expanded and aria-controls.',
            'Disabled snippets expose disabled or aria-disabled as appropriate.',
        ],
        'focus' => [
            'Copyable inline snippets, snippet containers, copy buttons, and expand buttons must show visible focus.',
        ],
        'screen_reader' => [
            'ariaLabel/copyButtonDescription should describe the copy action.',
            'Copied feedback must be announced through live text.',
            'Code examples should be short enough to understand when read linearly.',
        ],
    ],

    'deprecations' => [
        'props' => [
            ['name' => 'type', 'replacement' => 'variant', 'description' => 'type remains accepted as a compatibility alias for variant.'],
            ['name' => 'showMoreLabel', 'replacement' => 'showMoreText', 'description' => 'showMoreLabel remains accepted as a compatibility alias.'],
            ['name' => 'showLessLabel', 'replacement' => 'showLessText', 'description' => 'showLessLabel remains accepted as a compatibility alias.'],
        ],
        'classes' => [
            'feature-local code snippet classes',
            'hard-coded syntax token styles',
        ],
        'components' => [
            'ad hoc code snippets outside x-ui.code-snippet',
        ],
    ],

    'enforcement' => [
        'mode' => 'legacy-compatible',
        'invalid_usage' => 'warn',
    ],

    'source' => [
        'blade' => [
            'resources/views/components/ui/code-snippet/index.blade.php',
        ],
        'css' => [
            'resources/css/components/code-snippet.css',
            'resources/css/components/copy-button.css',
            'resources/css/components/tooltip.css',
        ],
        'js' => [
            'resources/js/ui-controls/code-snippet.js',
        ],
        'contract' => [
            'resources/views/components/ui/code-snippet/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/code-snippet.md',
        ],
    ],
]);
