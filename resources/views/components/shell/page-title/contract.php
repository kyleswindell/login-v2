<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/shell/page-title/contract.php
| Purpose: UI Shell Page Title Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the title-region API that can be called from Blade,
| validated by tooling, and consumed by shell page-header composition.
|
*/

return Surface::component([
    'identity' => [
        'slug' => 'ui-shell-page-title',
        'label' => 'UI Shell Page Title',
        'component' => 'x-shell.page-title',
        'summary' => 'Shell page title region with optional breadcrumbs, page title, subtitle, and caller-provided title content.',
    ],

    'lifecycle' => [
        'status' => 'provisional',
    ],

    'api' => [
        'usage_context' => 'Use x-shell.page-title for the title block inside shell page headers. It owns breadcrumbs, page title, subtitle, and optional title-region actions/content. Use x-shell.page-header when the full page header area, including the page-tabs rail, is needed.',

        'props' => [
            ['name' => 'title', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional page title text.'],
            ['name' => 'subtitle', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional page subtitle or supporting description.'],
            ['name' => 'headingTag', 'type' => 'string', 'required' => false, 'default' => 'h1', 'values' => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'], 'description' => 'Heading tag used for the title.'],
            ['name' => 'items', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Breadcrumb items. Each item accepts label, href, current, and wireNavigate keys.'],
            ['name' => 'breadcrumbLabel', 'type' => 'string', 'required' => false, 'default' => 'Breadcrumb', 'values' => [], 'description' => 'Accessible label for the breadcrumb nav landmark.'],
        ],

        'slots' => [
            ['name' => 'breadcrumbs', 'required' => false, 'description' => 'Custom breadcrumb markup. Takes precedence over items.'],
            ['name' => 'actions', 'required' => false, 'description' => 'Optional page actions rendered in the title row.'],
            ['name' => 'default', 'required' => false, 'description' => 'Optional extra title-region content such as supporting controls.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'shell-page-title', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-shell-page-title', 'required' => true, 'description' => 'Generated root shell page title marker.'],
            ['name' => 'data-ui-shell-page-title-heading-tag', 'required' => true, 'description' => 'Generated resolved heading tag marker.'],
            ['name' => 'data-ui-shell-page-title-breadcrumbs', 'required' => true, 'description' => 'Generated breadcrumb presence marker.'],
            ['name' => 'data-ui-shell-page-title-breadcrumb-source', 'required' => true, 'description' => 'Generated breadcrumb source marker: slot, items, or none.'],
            ['name' => 'data-ui-shell-page-title-breadcrumb-count', 'required' => true, 'description' => 'Generated normalized breadcrumb item count marker.'],
            ['name' => 'data-ui-shell-page-title-title', 'required' => true, 'description' => 'Generated title presence marker.'],
            ['name' => 'data-ui-shell-page-title-subtitle', 'required' => true, 'description' => 'Generated subtitle presence marker.'],
            ['name' => 'data-ui-shell-page-title-actions', 'required' => true, 'description' => 'Generated page actions presence marker.'],
            ['name' => 'data-ui-shell-page-title-content', 'required' => true, 'description' => 'Generated default slot content presence marker.'],
            ['name' => 'data-ui-shell-page-title-actions-region', 'required' => false, 'description' => 'Generated page actions region marker.'],
            ['name' => 'data-ui-shell-page-title-breadcrumbs-region', 'required' => false, 'description' => 'Generated breadcrumb nav region marker.'],
            ['name' => 'data-ui-shell-page-title-breadcrumb-item', 'required' => false, 'description' => 'Generated breadcrumb item marker.'],
            ['name' => 'data-ui-shell-page-title-breadcrumb-current', 'required' => false, 'description' => 'Generated current breadcrumb item marker.'],
            ['name' => 'data-ui-shell-page-title-breadcrumb-link', 'required' => false, 'description' => 'Generated breadcrumb link marker.'],
            ['name' => 'data-ui-shell-page-title-breadcrumb-current-label', 'required' => false, 'description' => 'Generated current breadcrumb label marker.'],
        ],
    ],

    'class_contract' => [
        'root' => 'ui-shell-page-title',
        'required' => [
            'ui-shell-page-title',
        ],
        'optional' => [
            'ui-shell-page-title__breadcrumbs',
            'ui-shell-page-title__breadcrumb-list',
            'ui-shell-page-title__breadcrumb-item',
            'ui-shell-page-title__breadcrumb-link',
            'ui-shell-page-title__breadcrumb-current',
            'ui-shell-page-title__title',
            'ui-shell-page-title__subtitle',
            'ui-shell-page-title__row',
            'ui-shell-page-title__text',
            'ui-shell-page-title__actions',
            'ui-shell-page-title__content',
        ],
        'internal' => [],
        'deprecated' => [
            'ui-shell-page-header markers for title-only behavior',
            'feature-local page title/header classes',
            'ad hoc shell page title markup outside x-shell.page-title',
        ],
    ],

    'variants' => [
        'title-only' => ['label' => 'Title only', 'api' => ['title' => 'Page title'], 'class' => 'ui-shell-page-title__title', 'description' => 'Page title region with title only.'],
        'with-subtitle' => ['label' => 'With subtitle', 'api' => ['title' => 'Page title', 'subtitle' => 'Page subtitle'], 'class' => 'ui-shell-page-title__subtitle', 'description' => 'Page title region with title and subtitle.'],
        'with-breadcrumb-items' => ['label' => 'With breadcrumb items', 'api' => ['items' => [['label' => 'Home', 'href' => '/']]], 'description' => 'Page title region with array-rendered breadcrumbs.'],
        'with-breadcrumb-slot' => ['label' => 'With breadcrumb slot', 'api' => ['slot' => 'breadcrumbs'], 'description' => 'Page title region with caller-rendered breadcrumb markup.'],
        'with-actions' => ['label' => 'With actions', 'api' => ['slot' => 'actions'], 'class' => 'ui-shell-page-title__actions', 'description' => 'Page title region with page actions in the title row.'],
        'with-content' => ['label' => 'With content', 'api' => ['slot' => 'default'], 'class' => 'ui-shell-page-title__content', 'description' => 'Page title region with extra supporting content.'],
        'custom-heading-tag' => ['label' => 'Custom heading tag', 'api' => ['headingTag' => 'h2'], 'description' => 'Page title region with caller-selected heading level.'],
    ],

    'sizes' => [],

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default page title state.'],
        'with-title' => ['label' => 'With title', 'required' => false, 'description' => 'Title is rendered.'],
        'without-title' => ['label' => 'Without title', 'required' => false, 'description' => 'No title is rendered.'],
        'with-breadcrumbs' => ['label' => 'With breadcrumbs', 'required' => false, 'description' => 'Breadcrumb navigation is rendered.'],
        'current-breadcrumb' => ['label' => 'Current breadcrumb', 'required' => false, 'description' => 'Current breadcrumb item exposes aria-current="page".'],
        'with-content' => ['label' => 'With content', 'required' => false, 'description' => 'Default slot content is rendered.'],
        'with-actions' => ['label' => 'With actions', 'required' => false, 'description' => 'Actions slot content is rendered.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for breadcrumb links and any slotted actions.'],
    ],

    'tokens' => [
        'class_families' => [
            'ui-shell-page-title',
        ],
        'component_tokens' => [
            'ui-shell',
            'page-title',
            'breadcrumb',
            'heading',
        ],
        'deprecated' => [
            'ui-shell-page-header title-only token/class usage',
            'feature-local page title wrappers',
            'ad hoc shell page titles outside x-shell.page-title',
        ],
    ],

    'dependencies' => [
        'build_tier' => 5,
        'depends_on' => [
            'color',
            'themes',
            'spacing',
            'typography',
        ],
        'uses' => [
            'icons' => [],
            'components' => [],
            'js_initializers' => [],
        ],
        'blocks' => [
            'ui-shell-page-header',
            'page-layout',
            'breadcrumb',
        ],
    ],

    'accessibility' => [
        'keyboard' => [
            'Breadcrumb links and slotted actions must use native keyboard behavior.',
        ],
        'aria' => [
            'Breadcrumb region renders a nav landmark with an accessible label.',
            'Current breadcrumb item renders aria-current="page".',
            'Heading level must fit the page outline selected by the consuming layout.',
        ],
        'focus' => [
            'Breadcrumb links and slotted actions must show visible focus.',
        ],
        'screen_reader' => [
            'Page title should identify the page purpose.',
            'Subtitle should provide concise supporting context.',
            'Breadcrumb labels should describe the route hierarchy.',
            'Page title must not replace the main content landmark.',
        ],
    ],

    'deprecations' => [
        'classes' => [
            'ui-shell-page-header title-only classes',
            'feature-local page title classes',
            'raw page title utility clusters',
        ],
        'components' => [
            'ad hoc shell page title markup outside x-shell.page-title',
            'using x-shell.page-title as the full page header when tabs-region reservation is needed',
        ],
    ],

    'enforcement' => [
        'mode' => 'legacy-compatible',
        'invalid_usage' => 'warn',
    ],

    'source' => [
        'blade' => [
            'resources/views/components/shell/page-title/index.blade.php',
        ],
        'css' => [
            'resources/css/components/ui-shell/index.css',
        ],
        'tokens' => [
            'resources/css/tokens/components/ui-shell.css',
        ],
        'contract' => [
            'resources/views/components/shell/page-title/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/ui-shell.md',
        ],
    ],
]);
