<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/shell/page-header/contract.php
| Purpose: UI Shell Page Header Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the composed shell page header API that can be called
| from Blade, validated by tooling, and consumed by shell layouts.
|
*/

return Surface::component([
    'identity' => [
        'slug' => 'ui-shell-page-header',
        'label' => 'UI Shell Page Header',
        'component' => 'x-shell.page-header',
        'summary' => 'Composed shell page header with optional page title region and reserved page-tabs region.',
    ],

    'lifecycle' => [
        'status' => 'provisional',
    ],

    'api' => [
        'usage_context' => 'Use x-shell.page-header for the complete shell page header area. It composes x-shell.page-title for breadcrumbs/title/subtitle/actions and x-shell.page-tabs for route-style page navigation. Use x-shell.page-title alone only when the title block is needed without the full header/tabs region.',

        'props' => [
            ['name' => 'title', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional page title text forwarded to x-shell.page-title.'],
            ['name' => 'subtitle', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional page subtitle forwarded to x-shell.page-title.'],
            ['name' => 'headingTag', 'type' => 'string', 'required' => false, 'default' => 'h1', 'values' => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'], 'description' => 'Heading tag forwarded to x-shell.page-title.'],
            ['name' => 'breadcrumbItems', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Breadcrumb items forwarded to x-shell.page-title. Each item accepts label, href, current, and wireNavigate keys.'],
            ['name' => 'breadcrumbLabel', 'type' => 'string', 'required' => false, 'default' => 'Breadcrumb', 'values' => [], 'description' => 'Accessible label forwarded to the page title breadcrumb nav.'],
            ['name' => 'tabItems', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Page tab items forwarded to x-shell.page-tabs. Each item accepts label, href, current or active, and wireNavigate keys.'],
            ['name' => 'tabLabel', 'type' => 'string', 'required' => false, 'default' => 'Page sections', 'values' => [], 'description' => 'Accessible label forwarded to x-shell.page-tabs.'],
            ['name' => 'reserveTabs', 'type' => 'bool|string', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Whether to reserve the page-tabs rail when no tabs render.'],
        ],

        'slots' => [
            ['name' => 'breadcrumbs', 'required' => false, 'description' => 'Custom breadcrumb markup forwarded to x-shell.page-title.'],
            ['name' => 'actions', 'required' => false, 'description' => 'Page action controls forwarded to x-shell.page-title.'],
            ['name' => 'tabs', 'required' => false, 'description' => 'Custom page-tab link markup rendered through x-shell.page-tabs.'],
            ['name' => 'default', 'required' => false, 'description' => 'Optional page-title content forwarded to x-shell.page-title.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'shell-page-header', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-shell-page-header', 'required' => true, 'description' => 'Generated root shell page header marker.'],
            ['name' => 'data-ui-shell-page-header-title-region', 'required' => true, 'description' => 'Generated title-region presence marker.'],
            ['name' => 'data-ui-shell-page-header-tabs', 'required' => true, 'description' => 'Generated page-tabs presence marker.'],
            ['name' => 'data-ui-shell-page-header-reserve-tabs', 'required' => true, 'description' => 'Generated page-tabs rail reservation marker.'],
            ['name' => 'data-ui-shell-page-header-actions', 'required' => true, 'description' => 'Generated page action presence marker.'],
            ['name' => 'data-ui-shell-page-header-page-title', 'required' => false, 'description' => 'Generated marker on the composed x-shell.page-title region.'],
            ['name' => 'data-ui-shell-page-header-tabs-region', 'required' => true, 'description' => 'Generated page-tabs region marker.'],
            ['name' => 'data-ui-shell-page-header-tabs-region-visible', 'required' => true, 'description' => 'Generated page-tabs region visibility marker.'],
            ['name' => 'data-ui-shell-page-header-page-tabs', 'required' => false, 'description' => 'Generated marker on the composed x-shell.page-tabs instance.'],
            ['name' => 'data-ui-shell-page-header-tabs-spacer', 'required' => false, 'description' => 'Generated spacer marker when tabs are absent but reserved.'],
        ],
    ],

    'class_contract' => [
        'root' => 'ui-shell-page-header',
        'required' => [
            'ui-shell-page-header',
            'ui-shell-page-header__tabs-region',
        ],
        'optional' => [
            'ui-shell-page-header__title-region',
            'ui-shell-page-header__tabs-spacer',
        ],
        'internal' => [],
        'deprecated' => [
            'title-only behavior implemented directly in x-shell.page-header',
            'feature-local page header classes',
            'ad hoc shell page header markup outside x-shell.page-header',
        ],
    ],

    'variants' => [
        'with-title' => ['label' => 'With page title', 'api' => ['title' => 'Page title'], 'description' => 'Page header with composed page-title region.'],
        'with-actions' => ['label' => 'With actions', 'api' => ['slot' => 'actions'], 'description' => 'Page header with actions in the composed page-title region.'],
        'with-tabs' => ['label' => 'With page tabs', 'api' => ['tabItems' => [['label' => 'Usage', 'href' => '#']]], 'description' => 'Page header with route-style page tabs.'],
        'reserved-tabs' => ['label' => 'Reserved page-tabs rail', 'api' => ['reserveTabs' => true], 'class' => 'ui-shell-page-header__tabs-spacer', 'description' => 'Page header reserves the page-tabs rail without rendering an empty nav.'],
        'unreserved-tabs' => ['label' => 'Unreserved page-tabs rail', 'api' => ['reserveTabs' => false], 'description' => 'Page header does not reserve page-tabs rail when no tabs render.'],
        'custom-tabs' => ['label' => 'Custom tabs slot', 'api' => ['slot' => 'tabs'], 'description' => 'Page header renders caller-provided page-tab link markup through x-shell.page-tabs.'],
    ],

    'sizes' => [],

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default composed page header state.'],
        'with-title-region' => ['label' => 'With title region', 'required' => false, 'description' => 'Composed x-shell.page-title is rendered.'],
        'without-title-region' => ['label' => 'Without title region', 'required' => false, 'description' => 'No page-title region is rendered.'],
        'with-actions' => ['label' => 'With actions', 'required' => false, 'description' => 'Page action slot is rendered inside the page-title region.'],
        'with-tabs' => ['label' => 'With tabs', 'required' => false, 'description' => 'Composed x-shell.page-tabs is rendered.'],
        'without-tabs' => ['label' => 'Without tabs', 'required' => false, 'description' => 'No page-tabs nav is rendered.'],
        'reserved-tabs' => ['label' => 'Reserved tabs rail', 'required' => false, 'description' => 'Tabs spacer is rendered when no tabs are present.'],
    ],

    'tokens' => [
        'class_families' => [
            'ui-shell-page-header',
        ],
        'component_tokens' => [
            'ui-shell',
            'page-header',
            'page-title',
            'page-tabs',
        ],
        'deprecated' => [
            'feature-local page header wrappers',
            'ad hoc shell page headers outside x-shell.page-header',
        ],
    ],

    'dependencies' => [
        'build_tier' => 5,
        'depends_on' => [
            'color',
            'themes',
            'spacing',
            'typography',
            'ui-shell-page-title',
            'ui-shell-page-tabs',
        ],
        'uses' => [
            'icons' => [],
            'components' => [
                'shell.page-title',
                'shell.page-tabs',
            ],
            'js_initializers' => [],
        ],
        'blocks' => [
            'ui-shell',
            'page-layout',
            'route-navigation',
        ],
    ],

    'accessibility' => [
        'keyboard' => [
            'Composed breadcrumb links, page-tab links, and slotted actions must use native or child-component keyboard behavior.',
        ],
        'aria' => [
            'Page header must not render an empty page-tabs nav landmark when tabs are absent.',
            'x-shell.page-title owns breadcrumb nav labeling and heading level.',
            'x-shell.page-tabs owns route navigation labeling and aria-current state.',
        ],
        'focus' => [
            'Child links and slotted controls must show visible focus.',
        ],
        'screen_reader' => [
            'Page header must not replace the main content landmark.',
            'Reserved tabs rail spacer must be aria-hidden.',
        ],
    ],

    'deprecations' => [
        'props' => [
            ['name' => 'items', 'replacement' => 'breadcrumbItems', 'description' => 'Breadcrumb items now belong to the nested page-title region.'],
        ],
        'classes' => [
            'title-only ui-shell-page-header classes',
            'feature-local page header classes',
            'raw page header utility clusters',
        ],
        'components' => [
            'ad hoc shell page header markup outside x-shell.page-header',
            'using x-shell.page-header as only a title block instead of x-shell.page-title',
        ],
    ],

    'enforcement' => [
        'mode' => 'legacy-compatible',
        'invalid_usage' => 'warn',
    ],

    'source' => [
        'blade' => [
            'resources/views/components/shell/page-header/index.blade.php',
        ],
        'css' => [
            'resources/css/components/ui-shell/index.css',
        ],
        'tokens' => [
            'resources/css/tokens/components/ui-shell.css',
        ],
        'contract' => [
            'resources/views/components/shell/page-header/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/ui-shell.md',
            'docs/02-standards/ui/patterns/navigation.md',
            'docs/02-standards/ui/patterns/layout.md',
        ],
    ],
]);
