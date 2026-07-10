<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/shell/content/contract.php
| Purpose: UI Shell Content Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public UI Shell Content API that can be called
| from Blade, validated by tooling, and consumed by shell layouts.
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
        'slug' => 'ui-shell-content',
        'label' => 'UI Shell Content',
        'component' => 'x-shell.content',
        'summary' => 'Shell content container with constrained root tag, optional composed page header, optional composed page tabs, and body wrapper.',
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
        'usage_context' => 'Use x-shell.content as the primary shell content region. It may compose x-shell.page-header before the body wrapper, with page-title and page-tabs behavior delegated to the composed header. Page header content, page tabs, and body content remain caller-owned.',

        'props' => [
            [
                'name' => 'tag',
                'type' => 'string',
                'required' => false,
                'default' => 'main',
                'values' => ['main', 'div', 'section', 'article'],
                'description' => 'Root HTML tag for the shell content container.',
            ],
            [
                'name' => 'pageTitle',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional title forwarded to x-shell.page-header.',
            ],
            [
                'name' => 'pageSubtitle',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional subtitle forwarded to x-shell.page-header.',
            ],
            [
                'name' => 'headingTag',
                'type' => 'string',
                'required' => false,
                'default' => 'h1',
                'values' => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
                'description' => 'Heading tag forwarded to x-shell.page-header.',
            ],
            [
                'name' => 'breadcrumbs',
                'type' => 'array',
                'required' => false,
                'default' => [],
                'values' => [],
                'description' => 'Breadcrumb items forwarded to the x-shell.page-header page-title region.',
            ],
            [
                'name' => 'tabItems',
                'type' => 'array',
                'required' => false,
                'default' => [],
                'values' => [],
                'description' => 'Page tab items forwarded to the x-shell.page-header page-tabs region.',
            ],
            [
                'name' => 'tabsLabel',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Accessible label forwarded to the composed x-shell.page-tabs region. Defaults from pageTitle when omitted.',
            ],
            [
                'name' => 'reservePageTabs',
                'type' => 'bool|string',
                'required' => false,
                'default' => true,
                'values' => [true, false],
                'description' => 'Whether the composed x-shell.page-header reserves the page-tabs rail when no tabs render.',
            ],
        ],

        'slots' => [
            [
                'name' => 'pageHeader',
                'required' => false,
                'description' => 'Custom page header markup. Takes precedence over composed page-header props.',
            ],
            [
                'name' => 'headerBreadcrumbs',
                'required' => false,
                'description' => 'Custom breadcrumbs slot forwarded into the composed x-shell.page-header.',
            ],
            [
                'name' => 'pageActions',
                'required' => false,
                'description' => 'Page-level actions forwarded into the composed x-shell.page-header title region.',
            ],
            [
                'name' => 'pageTabs',
                'required' => false,
                'description' => 'Custom page tabs markup. Forwarded into x-shell.page-header unless a full pageHeader slot is supplied.',
            ],
            [
                'name' => 'default',
                'required' => false,
                'description' => 'Main shell content body.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'shell-content', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-shell-content', 'required' => true, 'description' => 'Generated shell content root marker.'],
            ['name' => 'data-ui-shell-content-tag', 'required' => true, 'description' => 'Generated resolved root tag marker.'],
            ['name' => 'data-ui-shell-content-page-header', 'required' => true, 'description' => 'Generated page-header presence marker.'],
            ['name' => 'data-ui-shell-content-page-header-source', 'required' => true, 'description' => 'Generated page-header source marker: slot, props, or none.'],
            ['name' => 'data-ui-shell-content-page-tabs', 'required' => true, 'description' => 'Generated page-tabs presence marker.'],
            ['name' => 'data-ui-shell-content-page-tabs-source', 'required' => true, 'description' => 'Generated page-tabs source marker: slot, items, or none.'],
            ['name' => 'data-ui-shell-content-reserve-page-tabs', 'required' => true, 'description' => 'Generated page-tabs rail reservation marker forwarded to the composed page header.'],
            ['name' => 'data-ui-shell-content-body', 'required' => true, 'description' => 'Generated body content presence marker.'],
            ['name' => 'data-ui-shell-content-body-region', 'required' => true, 'description' => 'Generated body wrapper marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-shell-content',
        'required' => [
            'ui-shell-content',
            'ui-shell-content__body',
        ],
        'optional' => [
            'ui-shell-content--with-page-header',
            'ui-shell-content--with-page-tabs',
        ],
        'internal' => [],
        'deprecated' => [
            'unvalidated custom shell content tag names',
            'feature-local shell content wrappers',
            'ad hoc shell content containers outside x-shell.content',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => [
            'label' => 'Default',
            'api' => ['tag' => 'main'],
            'class' => 'ui-shell-content',
            'description' => 'Default main shell content container.',
        ],
        'custom-tag' => [
            'label' => 'Custom tag',
            'api' => ['tag' => 'section'],
            'description' => 'Shell content rendered with a constrained custom root tag.',
        ],
        'with-page-header' => [
            'label' => 'With page header',
            'api' => ['pageTitle' => 'Page title'],
            'class' => 'ui-shell-content--with-page-header',
            'description' => 'Shell content with composed page header.',
        ],
        'with-page-actions' => [
            'label' => 'With page actions',
            'api' => ['slot' => 'pageActions'],
            'class' => 'ui-shell-content--with-page-header',
            'description' => 'Shell content with page actions forwarded into the composed page title region.',
        ],
        'page-header-slot' => [
            'label' => 'Page header slot',
            'api' => ['slot' => 'pageHeader'],
            'class' => 'ui-shell-content--with-page-header',
            'description' => 'Shell content with caller-provided page header slot.',
        ],
        'with-page-tabs' => [
            'label' => 'With page tabs',
            'api' => ['tabItems' => [['label' => 'Usage', 'href' => '#']]],
            'class' => 'ui-shell-content--with-page-tabs',
            'description' => 'Shell content with composed page tabs inside the page header.',
        ],
        'page-tabs-slot' => [
            'label' => 'Page tabs slot',
            'api' => ['slot' => 'pageTabs'],
            'class' => 'ui-shell-content--with-page-tabs',
            'description' => 'Shell content with caller-provided page tabs forwarded into the page header.',
        ],
        'reserved-page-tabs' => [
            'label' => 'Reserved page-tabs rail',
            'api' => ['reservePageTabs' => true],
            'description' => 'Shell content forwards tabs rail reservation to the composed page header.',
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
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => [
            'label' => 'Default',
            'required' => true,
            'description' => 'Default shell content state.',
        ],
        'with-page-header' => [
            'label' => 'With page header',
            'required' => false,
            'description' => 'Page header is rendered.',
        ],
        'without-page-header' => [
            'label' => 'Without page header',
            'required' => false,
            'description' => 'No page header is rendered.',
        ],
        'with-page-tabs' => [
            'label' => 'With page tabs',
            'required' => false,
            'description' => 'Page tabs are rendered.',
        ],
        'without-page-tabs' => [
            'label' => 'Without page tabs',
            'required' => false,
            'description' => 'No page tabs are rendered.',
        ],
        'with-body-content' => [
            'label' => 'With body content',
            'required' => false,
            'description' => 'Default slot content is present inside the body wrapper.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-shell-content',
        ],
        'component_tokens' => [
            'ui-shell',
            'content',
            'page-header',
            'page-tabs',
            'page-title',
            'layout',
        ],
        'deprecated' => [
            'feature-local shell content wrappers',
            'ad hoc shell content containers outside x-shell.content',
            'unvalidated dynamic shell content tag names',
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
            'ui-shell-page-title',
            'ui-shell-page-header',
            'ui-shell-page-tabs',
        ],
        'uses' => [
            'icons' => [],
            'components' => [
                'shell.page-title',
                'shell.page-header',
                'shell.page-tabs',
            ],
            'js_initializers' => [],
        ],
        'blocks' => [
            'ui-shell',
            'app-shell',
            'main-content',
            'page-layout',
            'route-navigation',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Shell content does not add keyboard behavior.',
            'Slotted controls inside content must use native or component-owned keyboard behavior.',
        ],
        'aria' => [
            'Default root tag is main and should usually pair with skip-to-content target behavior.',
            'Custom root tags must preserve the intended page landmark structure.',
            'Composed page header and page tabs keep their own accessibility contracts.',
        ],
        'focus' => [
            'Shell content does not manage focus.',
            'Skip-to-content target focus behavior belongs to the page layout and target element.',
        ],
        'screen_reader' => [
            'Shell content should contain the primary page content when rendered as main.',
            'Page header and page tabs should not replace the main content landmark.',
            'Do not create multiple unlabeled main landmarks on the same page.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            [
                'name' => 'unvalidated tag values',
                'replacement' => 'main, div, section, or article',
                'description' => 'Shell content root tag is constrained to safe structural tags.',
            ],
        ],
        'classes' => [
            'feature-local shell content wrappers',
            'raw shell content utility clusters',
        ],
        'components' => [
            'ad hoc shell content containers outside x-shell.content',
            'shell content used as a replacement for page header or page tabs contracts',
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
            'resources/views/components/shell/content/index.blade.php',
        ],
        'css' => [
            'resources/css/components/ui-shell/index.css',
        ],
        'contract' => [
            'resources/views/components/shell/content/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/ui-shell.md',
        ],
    ],
]);
