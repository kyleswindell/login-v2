<?php

namespace Tests\Feature\Platform;

use App\Models\User;
use App\Platform\UiReference\UiReferenceComponentCatalog;
use App\Platform\UiReference\UiReferenceElementCatalog;
use Database\Seeders\PlatformRolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class PlatformUiReferenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_users_can_view_ui_reference_workspace(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $response = $this->get('/platform/ui-reference')
            ->assertOk()
            ->assertSee('UI Reference Workspace')
            ->assertSee('ui-card', false)
            ->assertSee('Foundation Elements')
            ->assertSee('Grid')
            ->assertSee('Color')
            ->assertSee('Token Palette')
            ->assertSee('Typography')
            ->assertSee('Type Sets')
            ->assertSee('Form Patterns')
            ->assertSee('Data + Content')
            ->assertSee('Components')
            ->assertSee('Patterns')
            ->assertDontSee('T1 Components')
            ->assertDontSee('Pattern Standards')
            ->assertSee('data-ui-reference-element-dropdown="color"', false)
            ->assertSee('data-ui-reference-element-dropdown="typography"', false)
            ->assertSee('data-ui-reference-sidebar-disclosure="foundation-elements"', false)
            ->assertSee('data-ui-reference-sidebar-disclosure="color"', false)
            ->assertSee('data-ui-reference-sidebar-disclosure="typography"', false)
            ->assertSee('data-ui-reference-sidebar-disclosure="components"', false)
            ->assertSee('data-ui-reference-sidebar-disclosure-motion="productive"', false)
            ->assertSee('data-ui-reference-sidebar-disclosure-trigger', false)
            ->assertSee('data-ui-reference-sidebar-disclosure-panel', false)
            ->assertSee('data-ui-reference-sidebar-disclosure-icon', false)
            ->assertSee('data-ui-reference-sidebar-scroll-owner="shell"', false)
            ->assertSee('aria-label="UI Reference overview"', false)
            ->assertSee('aria-label="UI Reference foundation elements"', false)
            ->assertSee('aria-label="UI Reference components"', false)
            ->assertSee('aria-label="UI Reference patterns"', false)
            ->assertSee('aria-current="page"', false)
            ->assertSee('data-ui-reference-component-sidebar-sort="alphabetical"', false)
            ->assertSee('data-ui-reference-sidebar-approved="component:accordion"', false)
            ->assertSee('data-ui-reference-sidebar-approved="component:breadcrumb"', false)
            ->assertSee('data-ui-reference-sidebar-approved="component:button"', false)
            ->assertSee('data-ui-reference-sidebar-approved="component:menu-buttons"', false)
            ->assertSee('data-ui-reference-sidebar-approved="component:tooltip"', false)
            ->assertDontSee('data-ui-reference-component-sidebar-group=', false)
            ->assertDontSee('Legacy Index Surfaces')
            ->assertSee('Number input')
            ->assertSee('Structured list')
            ->assertSee('Widget Content')
            ->assertSee('Starter Catalog')
            ->assertSee('Archetype Proofs');

        $content = $response->getContent();
        $this->assertMatchesRegularExpression('/data-ui-reference-element-dropdown="color"[\s\S]*?data-ui-reference-element-dropdown-open="false"/', $content);
        $this->assertMatchesRegularExpression('/data-ui-reference-element-dropdown="typography"[\s\S]*?data-ui-reference-element-dropdown-open="false"/', $content);
        $this->assertMatchesRegularExpression('/data-ui-reference-sidebar-disclosure="foundation-elements"[\s\S]*?data-ui-reference-sidebar-disclosure-state="open"[\s\S]*?aria-expanded="true"[\s\S]*?aria-controls="ui-reference-sidebar-foundation-elements-panel"/', $content);
        $this->assertMatchesRegularExpression('/data-ui-reference-sidebar-disclosure="color"[\s\S]*?data-ui-reference-sidebar-disclosure-state="closed"[\s\S]*?aria-expanded="false"[\s\S]*?aria-controls="ui-reference-sidebar-color-panel"/', $content);
        $this->assertMatchesRegularExpression('/data-ui-reference-sidebar-disclosure="typography"[\s\S]*?data-ui-reference-sidebar-disclosure-state="closed"[\s\S]*?aria-expanded="false"[\s\S]*?aria-controls="ui-reference-sidebar-typography-panel"/', $content);
        $this->assertMatchesRegularExpression('/data-ui-reference-sidebar-disclosure="components"[\s\S]*?data-ui-reference-sidebar-disclosure-state="open"[\s\S]*?aria-expanded="true"[\s\S]*?aria-controls="ui-reference-sidebar-components-panel"/', $content);
        $sidebarPartial = file_get_contents(resource_path('views/platform/ui-reference/partials/sidebar.blade.php'));
        $this->assertStringContainsString('ui-reference-sidebar-link', $sidebarPartial);
        $this->assertStringContainsString('<button', $sidebarPartial);
        $this->assertStringContainsString('aria-current="page"', $sidebarPartial);
        $this->assertStringContainsString('x-heroicon-o-chevron-down', $sidebarPartial);
        $this->assertStringContainsString('$approvedComponentSlugs = [\'accordion\', \'breadcrumb\', \'button\', \'menu-buttons\', \'tooltip\'];', $sidebarPartial);
        $this->assertStringContainsString('x-heroicon-o-check-circle', $sidebarPartial);
        $this->assertStringNotContainsString('<details', $sidebarPartial);
        $this->assertStringNotContainsString('<summary', $sidebarPartial);
        $this->assertStringNotContainsString('border-slate-', $sidebarPartial);
        $this->assertStringNotContainsString('bg-slate-', $sidebarPartial);
        $this->assertStringNotContainsString('text-slate-', $sidebarPartial);
        $this->assertStringNotContainsString('>v</span>', $sidebarPartial);
        $this->assertMatchesRegularExpression('/<nav[^>]*data-ui-reference-component-sidebar[^>]*>/', $content, 'Component sidebar nav is missing.');

        preg_match('/<nav[^>]*data-ui-reference-component-sidebar[^>]*>/', $content, $componentSidebarNav);
        $this->assertStringNotContainsString('overflow-y-auto', $componentSidebarNav[0]);
        $this->assertStringNotContainsString('max-h-[34rem]', $componentSidebarNav[0]);

        $appCss = file_get_contents(resource_path('css/app.css'));
        $this->assertStringContainsString('.ui-reference-sidebar-panel', $appCss);
        $this->assertStringContainsString('.ui-reference-sidebar-link', $appCss);
        $this->assertStringContainsString('.ui-reference-sidebar-approved-badge', $appCss);
        $this->assertStringContainsString('var(--ui-text-secondary)', $appCss);
        $this->assertStringContainsString('var(--ui-layer-selected-01)', $appCss);
        $this->assertStringContainsString('max-block-size: calc(100dvh - 7rem)', $appCss);
        $this->assertStringContainsString('scrollbar-gutter: stable', $appCss);
        $this->assertStringContainsString('.ui-reference-sidebar-disclosure-trigger:hover', $appCss);
        $this->assertStringContainsString('.ui-reference-sidebar-disclosure-panel', $appCss);
        $this->assertStringContainsString(".ui-reference-sidebar-disclosure[data-ui-reference-sidebar-disclosure-state='open'] > .ui-reference-sidebar-disclosure-trigger .ui-reference-sidebar-disclosure-icon", $appCss);
        $this->assertStringNotContainsString('.ui-reference-sidebar-disclosure[open]', $appCss);
        $this->assertStringContainsString('prefers-reduced-motion: reduce', $appCss);

        $appJs = file_get_contents(resource_path('js/app.js'));
        $uiReferenceJs = file_get_contents(resource_path('js/ui-reference.js'));
        $this->assertStringContainsString('initUiReferenceSidebarDisclosures', $appJs);
        $this->assertStringContainsString('initializer(document)', $appJs);
        $this->assertStringContainsString("document.readyState === 'loading'", $appJs);
        $this->assertStringContainsString('initUiReferenceSidebarDisclosures', $uiReferenceJs);
    }

    public function test_tier_one_component_catalog_routes_are_discoverable(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $catalog = app(UiReferenceComponentCatalog::class)->primaryPages();

        $overview = $this->get('/platform/ui-reference/components')
            ->assertOk()
            ->assertSee('Components')
            ->assertSee('Components are reusable UI building blocks')
            ->assertSee('data-ui-reference-component-foundation-dependency', false)
            ->assertSee('data-ui-reference-component-priority-buckets', false)
            ->assertSee('data-ui-reference-component-status-legend', false)
            ->assertSee('data-ui-reference-component-inventory', false)
            ->assertSee('min-w-[1320px] table-fixed', false)
            ->assertSee('w-[13.5rem]', false)
            ->assertSee('Canonical Doc')
            ->assertSee('Implement Component Page')
            ->assertSee('Represent As Pattern')
            ->assertSee('Foundation Elements')
            ->assertSee('inline-flex items-center whitespace-nowrap rounded-full', false);

        $sidebarContent = $overview->getContent();
        $lastPosition = -1;

        foreach (collect($catalog)->sortBy('label', SORT_NATURAL | SORT_FLAG_CASE) as $component) {
            $needle = 'data-ui-reference-component-sidebar-label="'.$component['label'].'"';
            $position = strpos($sidebarContent, $needle);

            $this->assertNotFalse($position, 'Missing alphabetical sidebar label for '.$component['label'].'.');
            $this->assertGreaterThan($lastPosition, $position, $component['label'].' is not alphabetized in the component sidebar.');

            $lastPosition = $position;
        }

        $overview
            ->assertSee('data-ui-reference-component-sidebar-sort="alphabetical"', false)
            ->assertDontSee('data-ui-reference-component-sidebar-group=', false)
            ->assertDontSee('Legacy Index Surfaces');

        foreach ($catalog as $component) {
            $overview
                ->assertSee($component['label'])
                ->assertSee('/platform/ui-reference/components/'.$component['slug'])
                ->assertSee($component['doc_path'])
                ->assertSee($component['priority']);

            $componentPage = $this->get('/platform/ui-reference/components/'.$component['slug'])
                ->assertOk()
                ->assertSee('data-ui-reference-component="'.$component['slug'].'"', false)
                ->assertSee('data-ui-reference-t1-component="'.$component['slug'].'"', false)
                ->assertSee('data-ui-reference-component-disposition="'.$component['disposition'].'"', false)
                ->assertSee('data-ui-reference-component-status="'.$component['status'].'"', false)
                ->assertSee('data-component-card="purpose"', false)
                ->assertSee('data-component-card="use-cases"', false)
                ->assertSee('data-component-card="component-contract"', false)
                ->assertSee('data-component-card="live-examples"', false)
                ->assertSee('data-component-card="related-components-and-patterns"', false)
                ->assertSee('data-component-section="purpose"', false)
                ->assertSee('data-component-section="use-when"', false)
                ->assertSee('data-component-section="do-not-use-when"', false)
                ->assertSee('data-component-section="live-examples"', false)
                ->assertSee('data-component-section="states"', false)
                ->assertSee('data-component-section="anatomy"', false)
                ->assertSee('data-component-section="behavior"', false)
                ->assertSee('data-component-section="accessibility"', false)
                ->assertSee('data-component-section="content-guidance"', false)
                ->assertSee('data-component-section="developer-implementation"', false)
                ->assertSee('data-component-section="related-components-and-patterns"', false)
                ->assertSee('data-component-section="implementation-status"', false)
                ->assertSee('data-component-section="foundation-elements-used"', false)
                ->assertSee($component['label'])
                ->assertSee($component['owner_route'])
                ->assertSee($component['doc_path'])
                ->assertSee($component['status'])
                ->assertSee('Use this page to see what the component looks like in the app')
                ->assertSee('Component overview')
                ->assertSee('Usage boundary')
                ->assertSee('Implementation rules')
                ->assertSee('Rendered scenarios')
                ->assertSee('Composition links')
                ->assertDontSee('Purpose Card')
                ->assertDontSee('Use Cases Card')
                ->assertDontSee('Live Examples Card')
                ->assertDontSee('Legacy Contract Summary')
                ->assertDontSee($component['label'].' Reference Examples')
                ->assertDontSee('data-ui-reference-example="'.$component['slug'].'-shared-live-example"', false)
                ->assertDontSee('data-ui-reference-example="'.$component['slug'].'-queued-trigger"', false);

            if (in_array($component['slug'], ['button', 'menu-buttons'], true)) {
                $componentPage->assertSee('data-ui-reference-live-examples-layout="flexible-matrix"', false);
            } else {
                $componentPage->assertSee('data-component-section="variants-for-example"', false);
            }
        }

        $this->get('/platform/ui-reference/components/not-a-component')
            ->assertNotFound();
    }

    public function test_ui_standards_docs_use_api_contract_sections(): void
    {
        $componentHeadings = [
            'API summary',
            'Status and ownership',
            'Installed standard',
            'Public API',
            'Allowed variants, options, and modifiers',
            'States',
            'Token, class, and helper usage',
            'Composition rules',
            'Selection guidance',
            'Accessibility contract',
            'Content contract',
            'Prohibited usage',
            'Deferred or gated capabilities',
            'UI Reference requirements',
            'Testing and acceptance criteria',
            'Related APIs',
            'References',
        ];

        $elementHeadings = [
            'API summary',
            'Status and ownership',
            'Installed standard',
            'Token API',
            'CSS variable API',
            'Utility class/helper API',
            'Allowed usage',
            'Component and pattern consumers',
            'Theme behavior',
            'State behavior',
            'Prohibited usage',
            'Deferred or gated capabilities',
            'UI Reference requirements',
            'Testing and acceptance criteria',
            'Related APIs',
            'References',
        ];

        $patternHeadings = [
            'API summary',
            'Status and ownership',
            'Installed standard',
            'Pattern API',
            'Required composition',
            'Optional composition',
            'Consumed Element APIs',
            'Owned Component APIs',
            'Allowed variants and layout options',
            'State ownership',
            'Responsive behavior',
            'Composition rules',
            'Selection guidance',
            'Accessibility contract',
            'Content contract',
            'Prohibited usage',
            'Deferred or gated capabilities',
            'UI Reference requirements',
            'Testing and acceptance criteria',
            'Related APIs',
            'References',
        ];

        $this->assertMarkdownFilesContainHeadings(
            base_path('docs/02-standards/ui/components'),
            ['AGENTS.md', 'checklist.md', 'family-depth-pages.md', 'index.md', 'UI UX Component Library Standards.md', 'UI UX Component Taxonomy And Coverage Matrix.md'],
            $componentHeadings
        );

        $this->assertMarkdownFilesContainHeadings(
            base_path('docs/02-standards/ui/elements'),
            ['AGENTS.md', 'index.md'],
            $elementHeadings
        );

        $this->assertMarkdownFilesContainHeadings(
            base_path('docs/02-standards/ui/patterns'),
            ['AGENTS.md', 'checklist.md', 'index.md'],
            $patternHeadings
        );

        $contractsIndexPath = base_path('docs/02-standards/ui/contracts/Component Contracts Index.md');

        if (file_exists($contractsIndexPath)) {
            $contractsIndex = file_get_contents($contractsIndexPath);

            $this->assertStringContainsString('transitional source material only', $contractsIndex);
            $this->assertStringContainsString('Canonical UI rules now live', $contractsIndex);
        } else {
            $this->assertDirectoryDoesNotExist(base_path('docs/02-standards/ui/contracts'));
        }
    }

    public function test_component_public_api_wrappers_render_documented_markers(): void
    {
        $items = [
            ['label' => 'Open', 'href' => '#'],
            ['label' => 'Archive', 'shortcut' => 'A'],
            ['divider' => true],
            ['label' => 'Delete', 'danger' => true],
        ];
        $options = [
            ['label' => 'Owner', 'value' => 'owner'],
            ['label' => 'Admin', 'value' => 'admin'],
        ];
        $rows = [
            ['title' => 'Tenant status', 'description' => 'Ready for review', 'meta' => 'Active', 'selected' => true],
        ];
        $containedItems = [
            ['title' => 'Domain rules', 'description' => 'Routing policy ready', 'meta' => 'Reviewed', 'href' => '#', 'selected' => true],
        ];
        $steps = [
            ['label' => 'Draft', 'state' => 'complete'],
            ['label' => 'Review', 'state' => 'current'],
            ['label' => 'Approve', 'state' => 'upcoming'],
        ];
        $treeNodes = [
            [
                'id' => 'platform',
                'label' => 'Platform',
                'expanded' => true,
                'children' => [
                    ['id' => 'security', 'label' => 'Security settings', 'selected' => true],
                ],
            ],
        ];

        $html = Blade::render(<<<'BLADE'
            <x-ui.link href="#" icon="heroicon-o-arrow-top-right-on-square">Docs</x-ui.link>
            <x-ui.menu-button :items="$items" label="More actions" open />
            <x-ui.combo-button :items="$items" label="Run report" open />
            <x-ui.overflow-menu :items="$items" label="Row actions" open />
            <x-ui.pagination :current-page="2" :last-page="4" :total="40" :per-page="10" :page-size-options="[10, 25]" />
            <x-ui.search name="query" label="Search records" value="tenant" />
            <x-ui.dropdown name="role" label="Role" :options="$options" value="owner" open />
            <x-ui.file-uploader name="upload" label="Upload evidence" helper="PDF only" />
            <x-ui.number-input name="seats" label="Seats" value="5" min="1" max="20" />
            <x-ui.select name="native_role" label="Native role" :options="$options" value="admin" />
            <x-ui.radio-group name="visibility" label="Visibility" :options="$options" value="owner" />
            <x-ui.toggle name="enabled" label="Enabled" checked />
            <x-ui.inline-loading status="loading" label="Saving changes" />
            <x-ui.progress-bar value="40" label="Import progress" />
            <x-ui.progress-indicator :steps="$steps" />
            <x-ui.tag tone="success" icon="heroicon-o-check-circle">Active</x-ui.tag>
            <x-ui.structured-list :rows="$rows" selectable />
            <x-ui.contained-list title="Contained workspaces" :items="$containedItems" />
            <ul class="ui-list ui-list-unordered"><li>Native list API</li></ul>
            <x-ui.tile title="Workspace" description="Open workspace details" href="#" variant="clickable" />
            <x-ui.tooltip text="Edit workspace"><x-ui.icon-button label="Edit workspace">✎</x-ui.icon-button></x-ui.tooltip>
            <x-ui.toggletip label="About tenant domains" open>Domains route users into the tenant workspace.</x-ui.toggletip>
            <x-ui.multiselect name="roles" label="Roles" :options="$options" :value="['owner']" filterable clearable select-all open />
            <x-ui.popover label="More context" open>Use popovers for short contextual panels.</x-ui.popover>
            <x-ui.slider name="retention" label="Retention" value="30" min="0" max="90" show-input />
            <x-ui.range-slider name-min="min_score" name-max="max_score" label="Score range" value-min="20" value-max="80" show-inputs />
            <x-ui.tree-view label="Settings tree" :nodes="$treeNodes" selected="security" />
        BLADE, compact('items', 'options', 'rows', 'containedItems', 'steps', 'treeNodes'));

        foreach ([
            'data-ui-component="link"',
            'data-ui-component="menu-button"',
            'data-ui-component="combo-button"',
            'data-ui-component="overflow-menu"',
            'data-ui-component="pagination"',
            'data-ui-component="search"',
            'data-ui-component="dropdown"',
            'data-ui-component="file-uploader"',
            'data-ui-component="number-input"',
            'data-ui-component="select"',
            'data-ui-component="radio-group"',
            'data-ui-component="radio-button"',
            'data-ui-component="toggle"',
            'data-ui-component="inline-loading"',
            'data-ui-component="progress-bar"',
            'data-ui-component="progress-indicator"',
            'data-ui-component="progress-step"',
            'data-ui-component="tag"',
            'data-ui-component="structured-list"',
            'data-ui-component="structured-list-row"',
            'data-ui-component="contained-list"',
            'data-ui-component="contained-list-item"',
            'ui-list',
            'data-ui-component="tile"',
            'data-ui-component="tooltip"',
            'data-ui-component="toggletip"',
            'data-ui-component="multiselect"',
            'data-ui-component="popover"',
            'data-ui-component="slider"',
            'data-ui-component="range-slider"',
            'data-ui-component="tree-view"',
        ] as $marker) {
            $this->assertStringContainsString($marker, $html);
        }

        $this->assertStringContainsString('data-ui-menu-trigger', $html);
        $this->assertStringContainsString('data-ui-dropdown-option', $html);
        $this->assertStringContainsString('data-ui-pagination-page-size', $html);
        $this->assertStringContainsString('data-ui-toggletip-panel', $html);
        $this->assertStringContainsString('data-ui-multiselect-option', $html);
        $this->assertStringContainsString('data-ui-multiselect-filter', $html);
        $this->assertStringContainsString('data-ui-multiselect-clear', $html);
        $this->assertStringContainsString('data-ui-popover-trigger', $html);
        $this->assertStringContainsString('data-ui-popover-panel', $html);
        $this->assertStringContainsString('data-ui-popover-close', $html);
        $this->assertStringContainsString('data-ui-slider-input', $html);
        $this->assertStringContainsString('data-ui-slider-value', $html);
        $this->assertStringContainsString('data-ui-slider-thumb', $html);
        $this->assertStringContainsString('data-ui-slider-state', $html);
        $this->assertStringContainsString('data-ui-tree-node', $html);
        $this->assertStringContainsString('data-ui-tree-expanded', $html);
        $this->assertStringContainsString('data-ui-tree-selected', $html);
        $this->assertStringContainsString('data-ui-tree-active', $html);
    }

    private function assertMarkdownFilesContainHeadings(string $directory, array $ignoredFiles, array $headings): void
    {
        $files = glob($directory.DIRECTORY_SEPARATOR.'*.md') ?: [];

        foreach ($files as $file) {
            if (in_array(basename($file), $ignoredFiles, true)) {
                continue;
            }

            $contents = file_get_contents($file);

            foreach ($headings as $heading) {
                $this->assertMatchesRegularExpression(
                    '/^##\s+(?:\d+(?:\.\d+)*\.\s+)?'.preg_quote($heading, '/').'\r?$/m',
                    $contents,
                    basename($file).' is missing the '.$heading.' API-contract section.'
                );
            }
        }
    }

    public function test_foundation_element_catalog_routes_are_discoverable(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $catalog = app(UiReferenceElementCatalog::class)->all();

        $overview = $this->get('/platform/ui-reference/elements')
            ->assertOk()
            ->assertSee('Foundation Elements')
            ->assertSee('data-ui-reference-element-inventory', false)
            ->assertSee('Guide Status')
            ->assertSee('System Maturity')
            ->assertSee('Foundation Elements')
            ->assertSee('Components')
            ->assertSee('Patterns')
            ->assertSee('T3 Feature Modules')
            ->assertSee('Canonical Doc');

        foreach ($catalog as $element) {
            $overview
                ->assertSee($element['label'])
                ->assertSee('/platform/ui-reference/elements/'.$element['slug'])
                ->assertSee($element['doc_path'])
                ->assertSee($element['disposition']);

            $this->get('/platform/ui-reference/elements/'.$element['slug'])
                ->assertOk()
                ->assertSee('data-ui-reference-foundation-element="'.$element['slug'].'"', false)
                ->assertSee('data-ui-reference-element-disposition="'.$element['disposition'].'"', false)
                ->assertSee('data-ui-reference-element-system-status="'.$element['system_status'].'"', false)
                ->assertSee('data-foundation-section="purpose"', false)
                ->assertSee('data-foundation-section="implementation-status"', false)
                ->assertSee('data-foundation-section="live-examples"', false)
                ->assertSee('data-foundation-section="token-class-api-reference"', false)
                ->assertSee('data-foundation-section="usage-guidance"', false)
                ->assertSee('data-foundation-section="accessibility-notes"', false)
                ->assertSee('data-foundation-section="developer-notes"', false)
                ->assertSee('data-foundation-section="related-implementation-links"', false)
                ->assertSee($element['label'])
                ->assertSee($element['doc_path'])
                ->assertSee($element['guide_status'])
                ->assertSee($element['system_status'])
                ->assertSee('Standard Reference Notes')
                ->assertSee('This page defines the current Login App expectation for '.$element['label']);
        }

        $this->get('/platform/ui-reference/elements/color/tokens')
            ->assertOk()
            ->assertSee('data-ui-reference-foundation-element="color"', false)
            ->assertSee('data-ui-reference-color-token-palette', false)
            ->assertSee('data-ui-reference-element-dropdown="color"', false)
            ->assertSee('data-ui-reference-element-dropdown-open="true"', false)
            ->assertSee('data-ui-reference-sidebar-disclosure="color"', false)
            ->assertSee('aria-controls="ui-reference-sidebar-color-panel"', false)
            ->assertSee('aria-expanded="true"', false)
            ->assertSee('data-ui-reference-sidebar-disclosure="color"', false)
            ->assertSee('data-ui-reference-color-sidebar', false)
            ->assertSee('data-ui-reference-color-sidebar-item="overview"', false)
            ->assertSee('data-ui-reference-color-sidebar-item="token-palette"', false)
            ->assertSee('data-ui-reference-color-sidebar-item="background-layering"', false)
            ->assertSee('Color Token Palette');

        $this->get('/platform/ui-reference/elements/color/layering')
            ->assertOk()
            ->assertSee('data-color-background-layering-page', false)
            ->assertSee('data-ui-reference-foundation-element="color"', false)
            ->assertSee('data-ui-reference-element-dropdown="color"', false)
            ->assertSee('data-ui-reference-element-dropdown-open="true"', false)
            ->assertSee('data-ui-reference-sidebar-disclosure="color"', false)
            ->assertSee('data-ui-reference-color-sidebar-item="background-layering"', false)
            ->assertSee('aria-current="page"', false)
            ->assertSee('Background Layering');

        $this->get('/platform/ui-reference/elements/typography/type-sets')
            ->assertOk()
            ->assertSee('data-typography-type-sets-page', false)
            ->assertSee('data-ui-reference-foundation-element="typography"', false)
            ->assertSee('data-ui-reference-element-dropdown="typography"', false)
            ->assertSee('data-ui-reference-element-dropdown-open="true"', false)
            ->assertSee('data-ui-reference-sidebar-disclosure="typography"', false)
            ->assertSee('aria-controls="ui-reference-sidebar-typography-panel"', false)
            ->assertSee('aria-expanded="true"', false)
            ->assertSee('data-ui-reference-sidebar-disclosure="typography"', false)
            ->assertSee('data-ui-reference-typography-sidebar', false)
            ->assertSee('data-ui-reference-typography-sidebar-item="overview"', false)
            ->assertSee('data-ui-reference-typography-sidebar-item="type-sets"', false)
            ->assertSee('Type Sets');

        $this->get('/platform/ui-reference/elements/2x-grid')
            ->assertOk()
            ->assertSee('data-ui-reference-foundation-element="2x-grid"', false)
            ->assertSee('2x Grid');

        $this->get('/platform/ui-reference/elements/not-an-element')
            ->assertNotFound();
    }

    public function test_foundation_element_pages_expose_required_examples(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/elements/color')
            ->assertOk()
            ->assertSee('data-color-example="full-palette"', false)
            ->assertSee('data-color-example="token-role-groups"', false)
            ->assertSee('data-color-example="state-token-contract"', false)
            ->assertSee('data-color-example="theme-layering-model"', false)
            ->assertSee('data-color-example="common-app-states"', false)
            ->assertSee('data-color-example="high-contrast-inverse"', false)
            ->assertSee('Neutral ramp')
            ->assertSee('Blue/action ramp')
            ->assertSee('Active')
            ->assertSee('Selected')
            ->assertSee('Focus')
            ->assertSee('Disabled')
            ->assertSee('Background: White')
            ->assertSee('Nested surface: G10')
            ->assertSee('Background: G90')
            ->assertSee('Nested surface: G60')
            ->assertSee('Background: G100')
            ->assertSee('Nested surface: G70')
            ->assertSee('ui-inline-alert-success', false)
            ->assertSee('Selected and active states use explicit role tokens');

        $this->get('/platform/ui-reference/elements/color/layering')
            ->assertOk()
            ->assertSee('data-background-layering-section="model"', false)
            ->assertSee('data-background-layering-section="stack-sequence"', false)
            ->assertSee('data-background-layering-section="card-header-footer"', false)
            ->assertSee('data-background-layering-section="component-containers"', false)
            ->assertSee('data-background-layering-section="implementation-rules"', false)
            ->assertSee('data-background-layer-example="card-with-header-footer"', false)
            ->assertSee('data-background-layer-example="code-snippet-container"', false)
            ->assertSee('--ui-background')
            ->assertSee('--ui-layer-01')
            ->assertSee('--ui-layer-02')
            ->assertSee('--ui-layer-03')
            ->assertSee('data-background-layer-depth="4"', false)
            ->assertSee('data-background-layer-stack-sequence="background-layer-01-layer-02-layer-03"', false)
            ->assertSee('Light: G10')
            ->assertSee('Light: White')
            ->assertSee('Header, body, and footer share the same background layer by default')
            ->assertSee('Do not use accent layers or borders for card headers and footers by default')
            ->assertSee('Do not alternate white/gray manually in component examples');

        $layeringView = file_get_contents(resource_path('views/platform/ui-reference/elements/color-layering.blade.php'));
        $this->assertIsString($layeringView);
        $this->assertStringContainsString('data-background-layer-depth="4"', $layeringView);
        $this->assertStringContainsString('data-background-layer-stack-sequence="background-layer-01-layer-02-layer-03"', $layeringView);
        $this->assertStringNotContainsString('Return to layer 01', $layeringView);
        $this->assertStringNotContainsString('Inline nested note', $layeringView);
        $this->assertStringContainsString('data-background-layer-example="code-snippet-container"', $layeringView);
        $this->assertStringNotContainsString('<div class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);" data-background-layer-example="code-snippet-container">', $layeringView);
        $this->assertStringNotContainsString('class="border-b px-4 py-3"', $layeringView);
        $this->assertStringNotContainsString('class="border-t px-4 py-3', $layeringView);

        $this->get('/platform/ui-reference/elements/themes')
            ->assertOk()
            ->assertSee('data-theme-example="theme-terms"', false)
            ->assertSee('data-theme-example="theme-matrix"', false)
            ->assertSee('data-theme-example="token-role-value-matrix"', false)
            ->assertSee('data-theme-example="component-preview-matrix"', false)
            ->assertSee('data-theme-example="token-categories"', false)
            ->assertSee('Theme')
            ->assertSee('Token')
            ->assertSee('Role')
            ->assertSee('Value')
            ->assertSee('High-contrast and inverse examples are owned by the')
            ->assertDontSee('data-theme-example="inline-theme-examples"', false);

        $this->get('/platform/ui-reference/elements/2x-grid')
            ->assertOk()
            ->assertSee('data-grid-example="responsive-grid-visualizer"', false)
            ->assertSee('data-grid-example="breakpoint-examples"', false)
            ->assertSee('data-grid-example="column-span-examples"', false)
            ->assertSee('data-grid-example="gutter-padding-margin-examples"', false)
            ->assertSee('data-grid-example="fluid-fixed-hybrid"', false)
            ->assertSee('data-grid-example="app-scaffold"', false)
            ->assertSee('320px')
            ->assertSee('672px')
            ->assertSee('1056px')
            ->assertSee('1312px')
            ->assertSee('1584px');

        $this->get('/platform/ui-reference/elements/grid')
            ->assertOk()
            ->assertSee('data-ui-reference-foundation-element="2x-grid"', false)
            ->assertSee('2x Grid');

        $this->get('/platform/ui-reference/elements/spacing')
            ->assertOk()
            ->assertSee('data-spacing-example="spacing-scale"', false)
            ->assertSee('data-spacing-example="margin-padding-examples"', false)
            ->assertSee('data-spacing-example="stack-examples"', false)
            ->assertSee('data-spacing-example="relationship-density-examples"', false)
            ->assertSee('$spacing-13')
            ->assertSee('Components own internal spacing');

        $this->get('/platform/ui-reference/elements/typography')
            ->assertOk()
            ->assertSee('data-typography-example="type-sets-overview"', false)
            ->assertSee('data-typography-example="font-specimens"', false)
            ->assertSee('data-typography-example="type-scale"', false)
            ->assertSee('data-typography-example="type-role-examples"', false)
            ->assertSee('data-typography-example="productive-content-examples"', false)
            ->assertSee('data-typography-example="weight-examples"', false)
            ->assertSee('data-typography-example="type-color-examples"', false)
            ->assertSee('data-typography-example="highlighted-code-token"', false)
            ->assertSee('Light 300')
            ->assertSee('Regular 400')
            ->assertSee('Semibold 600')
            ->assertSee('5.75rem')
            ->assertSee('92px')
            ->assertSee('Scale formula reference')
            ->assertSee('Color is not decoration')
            ->assertSee('Code snippet with highlighted token')
            ->assertSee('ui-code-snippet', false)
            ->assertSee('ui-code-token-keyword', false)
            ->assertSee('ui-code-token-property', false)
            ->assertSee('ui-code-token-string', false)
            ->assertSee('ui-control-error', false)
            ->assertSee('/platform/ui-reference/elements/typography/type-sets', false)
            ->assertSee('Productive Type Set')
            ->assertSee('Expressive Type Set');

        $typeSets = $this->get('/platform/ui-reference/elements/typography/type-sets')
            ->assertOk()
            ->assertSee('data-typography-type-sets-page', false)
            ->assertSee('data-type-set="productive"', false)
            ->assertSee('data-type-set="expressive"', false)
            ->assertSee('data-type-set-example="comparison"', false)
            ->assertSee('data-type-set-example="blending"', false)
            ->assertSee('14px productive base')
            ->assertSee('16px expressive base')
            ->assertSee('fixed productive headings')
            ->assertSee('fluid expressive headings')
            ->assertSee('--ui-type-productive-base-size')
            ->assertSee('--ui-type-expressive-base-size')
            ->assertSee('--ui-type-fluid-max')
            ->assertSee('Expressive form labels')
            ->assertSee('Expressive table cell text')
            ->assertSee('IBM Plex adoption')
            ->assertDontSee('Expressive type is deferred')
            ->assertDontSee('cds--type-', false)
            ->assertDontSee('bx--type-', false);

        foreach ([
            'ui-type-set-productive',
            'ui-type-set-expressive',
            'ui-type-productive-label',
            'ui-type-productive-helper',
            'ui-type-productive-legal',
            'ui-type-productive-body-compact',
            'ui-type-productive-body',
            'ui-type-productive-heading-compact',
            'ui-type-productive-heading-01',
            'ui-type-productive-heading-02',
            'ui-type-productive-heading-03',
            'ui-type-productive-heading-04',
            'ui-type-productive-heading-05',
            'ui-type-productive-heading-06',
            'ui-type-expressive-label',
            'ui-type-expressive-helper',
            'ui-type-expressive-legal',
            'ui-type-expressive-body-compact',
            'ui-type-expressive-body',
            'ui-type-expressive-heading-compact',
            'ui-type-expressive-heading-01',
            'ui-type-expressive-heading-02',
            'ui-type-expressive-heading-03',
            'ui-type-expressive-heading-04',
            'ui-type-expressive-heading-05',
            'ui-type-expressive-heading-06',
            'ui-type-expressive-display-01',
            'ui-type-expressive-display-02',
        ] as $className) {
            $typeSets->assertSee($className, false);
        }

        $this->get('/platform/ui-reference/elements/icons')
            ->assertOk()
            ->assertSee('data-icons-example="approved-heroicons-list"', false)
            ->assertSee('data-icons-example="icon-size-matrix"', false)
            ->assertSee('data-icons-example="icon-with-text"', false)
            ->assertSee('data-icons-example="icon-only-controls"', false)
            ->assertSee('data-icons-example="status-decorative-meaningful"', false)
            ->assertSee('44px')
            ->assertSee('16px and 20px icons are optimized')
            ->assertSee('ui-status-inline-success', false)
            ->assertSee('Heroicons remain the approved UI icon library');

        $this->get('/platform/ui-reference/elements/pictograms')
            ->assertOk()
            ->assertSee('data-pictograms-example="asset-disposition"', false)
            ->assertSee('data-pictograms-example="candidate-library-audit"', false)
            ->assertSee('data-pictograms-example="size-clearance-examples"', false)
            ->assertSee('data-pictograms-example="productive-expressive-comparison"', false)
            ->assertSee('data-pictograms-example="trigger-conditions"', false)
            ->assertSee('Current decision')
            ->assertSee('Candidate Library Audit')
            ->assertSee('Do not import unapproved pictograms')
            ->assertSee('App-specific SVG primitives');

        $this->get('/platform/ui-reference/elements/motion')
            ->assertOk()
            ->assertSee('data-motion-example="easing-demos"', false)
            ->assertSee('data-motion-example="expressive-motion-gate"', false)
            ->assertSee('data-motion-example="component-motion-previews"', false)
            ->assertSee('data-motion-example="pattern-motion-gates"', false)
            ->assertSee('data-motion-example="skeleton-transition"', false)
            ->assertSee('data-motion-example="reduced-motion-preview"', false)
            ->assertSee('data-motion-example="do-dont-samples"', false)
            ->assertSee('Productive motion is the installed default')
            ->assertSee('transition duration-150 ease-out')
            ->assertSee('Expressive motion is not installed as a general app API')
            ->assertSee('Gated')
            ->assertSee('data-motion-owner="component-accordion"', false)
            ->assertSee('data-ui-component="accordion"', false)
            ->assertSee('data-motion-owner="component-menu"', false)
            ->assertSee('data-motion-state="reduced-preview"', false)
            ->assertSee('prefers-reduced-motion')
            ->assertSee('/platform/ui-reference/patterns/layout')
            ->assertDontSee('Expressive standard')
            ->assertDontSee('Expressive entrance')
            ->assertDontSee('Expressive exit')
            ->assertDontSee('Accordion / collapse')
            ->assertDontSee('<summary class="cursor-pointer text-sm font-semibold">Accordion / collapse</summary>', false)
            ->assertDontSee('/platform/ui-reference/patterns/app-shell');
    }

    public function test_color_token_palette_exposes_role_family_matrix(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/elements/color/tokens')
            ->assertOk()
            ->assertSee('data-ui-reference-color-token-palette', false)
            ->assertSee('data-color-token-section="inventory-map"', false)
            ->assertSee('data-color-token-section="background-layer-field"', false)
            ->assertSee('data-color-token-section="border"', false)
            ->assertSee('data-color-token-section="text-icon"', false)
            ->assertSee('data-color-token-section="link"', false)
            ->assertSee('data-color-token-section="support-status"', false)
            ->assertSee('data-color-token-section="focus-skeleton"', false)
            ->assertSee('data-color-token-section="syntax-code"', false)
            ->assertSee('data-color-token-section="component-ai-disposition"', false)
            ->assertSee('Background')
            ->assertSee('Layer accent')
            ->assertSee('Component tokens')
            ->assertSee('AI tokens')
            ->assertSee('Implemented')
            ->assertSee('Covered By App Alias')
            ->assertSee('Queued Token Gap')
            ->assertSee('Not Applicable Yet')
            ->assertSee('--ui-background')
            ->assertSee('--ui-layer-01')
            ->assertSee('--ui-layer-accent-01')
            ->assertSee('--ui-field-01')
            ->assertSee('--ui-border-subtle-01')
            ->assertSee('--ui-border-strong-01')
            ->assertSee('--ui-text-primary')
            ->assertSee('--ui-text-placeholder')
            ->assertSee('--ui-icon-primary')
            ->assertSee('--ui-link-primary')
            ->assertSee('--ui-support-error')
            ->assertSee('--ui-focus')
            ->assertSee('--ui-skeleton-background')
            ->assertSee('--ui-syntax-keyword')
            ->assertSee('data-color-token-family="syntax-code"', false);
    }

    public function test_accordion_component_reference_exemplar_uses_approved_scaffold(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/components/accordion')
            ->assertOk()
            ->assertSee('Use cases')
            ->assertSee('Component contract')
            ->assertSee('Live examples')
            ->assertSee('Related components and patterns')
            ->assertDontSee('Live Examples Card')
            ->assertDontSee('Use Cases Card')
            ->assertDontSee('Purpose Card')
            ->assertDontSee('Related Components And Patterns Card')
            ->assertSee('Component overview')
            ->assertSee('Usage boundary')
            ->assertSee('Implementation rules')
            ->assertSee('Rendered scenarios')
            ->assertSee('Composition links')
            ->assertSee('data-component-card="purpose"', false)
            ->assertSee('data-component-card="use-cases"', false)
            ->assertSee('data-component-card="component-contract"', false)
            ->assertSee('data-component-card="live-examples"', false)
            ->assertSee('data-component-card="related-components-and-patterns"', false)
            ->assertSee('data-component-section="anatomy"', false)
            ->assertSee('data-component-section="states"', false)
            ->assertSee('data-component-section="behavior"', false)
            ->assertSee('data-component-section="developer-implementation"', false)
            ->assertSee('data-component-section="content-guidance"', false)
            ->assertSee('data-component-section="accessibility"', false)
            ->assertSee('x-ui.accordion')
            ->assertSee('ui-code-snippet', false)
            ->assertSee('ui-code-token-keyword', false)
            ->assertSee('ui-code-token-property', false)
            ->assertSee('initAccordions')
            ->assertSee('data-ui-component="accordion"', false)
            ->assertSee('data-ui-accordion-trigger', false)
            ->assertSee('aria-expanded="true"', false)
            ->assertSee('aria-controls', false)
            ->assertSee('Basic accordion')
            ->assertSee('Multiple independent sections')
            ->assertSee('Long content accordion')
            ->assertSee('Accordion inside card or panel')
            ->assertSee('Form assistance accordion')
            ->assertSee('Variants for this example')
            ->assertSee('Compact')
            ->assertSee('Flush alignment')
            ->assertSee('Start icon alignment')
            ->assertSee('Single-open')
            ->assertSee('Scrollable panel')
            ->assertSee('Contained contextual')
            ->assertSee('data-ui-reference-variant-example="compact"', false)
            ->assertSee('data-ui-reference-variant-example="flush-alignment"', false)
            ->assertSee('data-ui-reference-variant-example="start-icon-alignment"', false)
            ->assertSee('data-ui-reference-variant-example="single-open"', false)
            ->assertSee('data-ui-reference-variant-example="scrollable-panel"', false)
            ->assertSee('data-ui-reference-variant-example="contained-contextual"', false)
            ->assertSee('data-ui-accordion-alignment="flush"', false)
            ->assertSee('data-ui-accordion-icon-alignment="start"', false)
            ->assertSee('data-ui-accordion-mode="single"', false)
            ->assertSee('data-ui-accordion-panel-open="true"', false)
            ->assertSee('ui-accordion-flush', false)
            ->assertSee('ui-accordion-icon-start', false)
            ->assertSee('ui-accordion-compact', false)
            ->assertSee('ui-accordion-scrollable', false)
            ->assertSee('panelMaxHeight')
            ->assertSee('Disabled until integration setup exists')
            ->assertSee('Users must read the content before continuing')
            ->assertSee('Click, tap, Enter, and Space toggle the focused trigger')
            ->assertSee('Use a semantic button for every trigger')
            ->assertSee('Name the disclosed content directly')
            ->assertDontSee('Compact&lt;/p&gt;', false)
            ->assertDontSee('Requires explicit product need')
            ->assertDontSee('Avoid internal scroll regions unless a specific workflow requires them')
            ->assertDontSee('>Default<', false)
            ->assertDontSee('Legacy Contract Summary')
            ->assertDontSee('Accordion Reference Examples')
            ->assertDontSee('data-ui-reference-example="accordion-shared-live-example"', false);

        $accordionScript = file_get_contents(resource_path('js/ui-controls/accordions.js'));
        $accordionCss = file_get_contents(resource_path('css/app.css'));
        $flushExample = file_get_contents(resource_path('views/platform/ui-reference/components/examples/accordion-variant-flush.blade.php'));

        $this->assertIsString($accordionScript);
        $this->assertIsString($accordionCss);
        $this->assertIsString($flushExample);
        $this->assertStringContainsString('prefers-reduced-motion: reduce', $accordionScript);
        $this->assertStringContainsString('initAccordions = (root = document)', $accordionScript);
        $this->assertStringContainsString('data-ui-accordion-focus', $accordionScript);
        $this->assertStringContainsString('clearPersistedAccordionFocus', $accordionScript);
        $this->assertStringContainsString('data-ui-accordion-item-open', $accordionScript);
        $this->assertStringContainsString('requestAnimationFrame', $accordionScript);
        $this->assertStringContainsString('transitionend', $accordionScript);
        $this->assertStringContainsString('.ui-accordion-flush .ui-accordion-trigger', $accordionCss);
        $this->assertStringContainsString("data-ui-accordion-focus='true'", $accordionCss);
        $this->assertStringContainsString('inline-size: calc(100% + 2rem);', $accordionCss);
        $this->assertStringContainsString('margin-inline: -1rem;', $accordionCss);
        $this->assertStringContainsString('.ui-accordion-contained', $accordionCss);
        $this->assertStringNotContainsString('border-y py-2', $flushExample);
        $this->assertMatchesRegularExpression('/\.ui-accordion\s*\{\s*@apply overflow-hidden;\s*background-color: transparent;/s', $accordionCss);
        $this->assertDoesNotMatchRegularExpression('/\.ui-accordion\s*\{[^}]*rounded[^}]*border/s', $accordionCss);
        $this->assertStringNotContainsString('.ui-accordion-panel {'."\n".'        @apply border-t;', $accordionCss);
        $this->assertStringContainsString("data-ui-accordion-panel-open='false'", $accordionCss);
        $this->assertStringContainsString('block-size 200ms', $accordionCss);
        $this->assertStringContainsString('panel.scrollHeight', $accordionScript);
        $this->assertStringContainsString('@media (prefers-reduced-motion: reduce)', $accordionCss);

        foreach (['ui-shell-header', 'ui-shell-left-panel', 'ui-shell-right-panel'] as $shellAlias) {
            $this->get('/platform/ui-reference/components/'.$shellAlias)
                ->assertOk()
                ->assertSee('data-ui-reference-t1-component="ui-shell"', false)
                ->assertSee('Implementation rules');
        }
    }

    public function test_platform_reviewer_can_view_ui_reference_workspace(): void
    {
        $this->actingAsPlatformReviewer();

        $this->get('/platform/ui-reference')
            ->assertOk()
            ->assertSee('UI Reference Workspace');
    }

    public function test_authorized_users_can_view_tier_one_forms_and_navigation_reference_surfaces(): void
    {
        $this->actingAsPlatformSuperAdmin();
        $this->useActiveBatchReviewIds(['P2-B-CQ-001', 'P2-B-CQ-014', 'P2-B-CQ-017']);

        $this->get('/platform/ui-reference/components/actions')
            ->assertOk()
            ->assertSee('Buttons And Icon Buttons')
            ->assertSee('P2-B-CQ-014')
            ->assertSee('data-ui-component="button"', false)
            ->assertSee('data-ui-component="icon-button"', false);

        $this->get('/platform/ui-reference/components/forms')
            ->assertOk()
            ->assertDontSee('Active Batch Review')
            ->assertSee('Date And Time Selection')
            ->assertDontSee('P2-B-CQ-007')
            ->assertSee('Selectable Controls')
            ->assertSee('Utility Primitives')
            ->assertSee('Lock after 15 minutes')
            ->assertDontSee('data-ui-pattern="proof-review-target"', false);

        $this->get('/platform/ui-reference/patterns/navigation')
            ->assertOk()
            ->assertSee('Sub-navigation Bar')
            ->assertSee('Dropdown Action Menu')
            ->assertSee('Search And Filter Bar')
            ->assertSee('Active Batch Review')
            ->assertSee('P2-B-CQ-014')
            ->assertDontSee('P2-B-CQ-004')
            ->assertDontSee('P2-B-CQ-008')
            ->assertDontSee('P2-B-CQ-010')
            ->assertDontSee('P2-B-CQ-011')
            ->assertDontSee('P2-B-CQ-016')
            ->assertSee('data-ui-pattern="date-range-filter"', false)
            ->assertSee('data-ui-pattern="proof-review-target"', false)
            ->assertSee('Reset / Apply:')
            ->assertSee('data-ui-pattern="page-title-actions-row"', false)
            ->assertSee('data-ui-pattern="sub-navigation-bar"', false)
            ->assertSee('data-ui-pattern="dropdown-action-menu"', false)
            ->assertSee('data-ui-component="inline-alert"', false);

        $this->get('/platform/ui-reference/patterns/forms')
            ->assertOk()
            ->assertSee('Active Batch Review')
            ->assertSee('Validation Summary and Form Actions')
            ->assertSee('Support Email')
            ->assertSee('P2-B-CQ-001')
            ->assertSee('P2-B-CQ-017')
            ->assertDontSee('P2-B-CQ-003')
            ->assertSee('data-ui-phone-input', false)
            ->assertSee('data-ui-component="searchable-select"', false)
            ->assertSee('data-ui-searchable-select-trigger', false)
            ->assertSee('data-ui-pattern="form-section"', false)
            ->assertSee('data-ui-pattern="validation-summary"', false);

        $this->get('/platform/ui-reference/patterns/data-content')
            ->assertOk()
            ->assertSee('Data And Content Patterns')
            ->assertSee('Identity Summary Card')
            ->assertSee('Active Batch Review')
            ->assertSee('P2-B-CQ-014')
            ->assertDontSee('P2-B-CQ-003')
            ->assertDontSee('P2-B-CQ-011')
            ->assertDontSee('P2-B-CQ-016')
            ->assertDontSee('P2-B-CQ-009')
            ->assertDontSee('P2-B-CQ-012')
            ->assertSee('data-ui-pattern="identity-summary-card"', false)
            ->assertSee('data-ui-pattern="stat-card"', false)
            ->assertSee('Support Runbook')
            ->assertSee('<a href="#" class="ui-link"', false)
            ->assertSee('data-ui-pattern="empty-state"', false)
            ->assertSee('Para Solutions')
            ->assertSee('Identity-summary variants');

        $this->get('/platform/ui-reference/patterns/layout')
            ->assertOk()
            ->assertSee('Layout And Dashboard Patterns')
            ->assertDontSee('Active Batch Review')
            ->assertDontSee('P2-B-CQ-006')
            ->assertSee('Dashboard customization proof')
            ->assertSee('Dashboard support boundaries')
            ->assertSee('Content allowances moved')
            ->assertSee('Open widget standards')
            ->assertDontSee('Widget sizing contract')
            ->assertDontSee('Multi-row span proof')
            ->assertSee('data-dashboard-proof-demo', false)
            ->assertSee('data-dashboard-proof-support', false)
            ->assertSee('data-ui-pattern="content-section-block"', false);

        $this->get('/platform/ui-reference/patterns/widget-content')
            ->assertOk()
            ->assertSee('Widget Content Standards')
            ->assertSee('Geometry decision')
            ->assertSee('Content-space unit system')
            ->assertSee('data-widget-content-unit-system', false)
            ->assertSee('data-widget-size-navigation', false)
            ->assertSee('data-ui-pattern="dashboard-grid"', false)
            ->assertSee('data-ui-pattern="widget-shell"', false);

        $this->get('/platform/ui-reference/patterns/archetypes')
            ->assertOk()
            ->assertSee('Archetype Proofs')
            ->assertDontSee('Active Batch Review')
            ->assertDontSee('P2-B-CQ-006')
            ->assertDontSee('P2-B-CQ-008')
            ->assertSee('Apply range')
            ->assertSee('Create / Edit Form')
            ->assertSee('Settings')
            ->assertSee('Account / Profile');

        $this->get('/platform/ui-reference/patterns/tables?workspace_sort=policy_count&workspace_direction=desc&audit_sort=event_type&audit_direction=asc&error_sort=message&error_direction=asc')
            ->assertOk()
            ->assertSee('Enhanced Data Table')
            ->assertSee('Policies')
            ->assertSee('Settings')
            ->assertSee('Export')
            ->assertSee('ui-table-sort-icon', false)
            ->assertDontSee('ui-table-sort-state', false)
            ->assertSee('Sorted descending. Activate to sort ascending.')
            ->assertSee('Sorted ascending. Activate to sort descending.')
            ->assertSee('aria-sort="descending"', false)
            ->assertSee('aria-sort="ascending"', false);

        $this->get('/platform/ui-reference/patterns/overlays-feedback')
            ->assertOk()
            ->assertSee('Toast Baseline')
            ->assertSee('Generate Example Toast')
            ->assertSee('data-ui-component="inline-alert"', false)
            ->assertSee('data-ui-component="toast"', false)
            ->assertSee('data-ui-component="drawer"', false)
            ->assertSee('data-ui-component="modal"', false)
            ->assertSee('data-ui-demo-toast-generated-stack', false)
            ->assertSee('data-ui-demo-toast-generated-overlay', false);
    }

    public function test_component_family_depth_pages_render_specific_examples_and_variants(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $expectations = [
            'button' => ['Variant purpose matrix', 'Size scale', 'State matrix', 'Button groups', 'Icon usage', 'Content behavior', 'Token and style roles', 'data-component-live-layout="button-matrix"'],
            'link' => ['Inline content link', 'External/help link', 'Navigation link', 'Icon trailing', 'Unavailable treatment', 'data-ui-reference-sample-type="links"'],
            'menu' => ['Contextual action menu', 'Row action menu', 'Danger item', 'Divided groups', 'Submenu actions', 'data-ui-reference-sample-type="menu"'],
            'menu-buttons' => ['Variant purpose matrix', 'Base options', 'Trigger style matrix', 'Size scale', 'Placement and width behavior', 'States and keyboard behavior', 'data-component-live-layout="menu-buttons-matrix"'],
            'tooltip' => ['Anatomy', 'Placement and alignment', 'Sizing and structure', 'Behavior and accessibility', 'Content', 'Related overlays', 'data-component-live-layout="tooltip-matrix"'],
            'text-input' => ['Login form field', 'Settings form field', 'Validation field', 'Read-only field', 'Disabled field', 'data-ui-reference-sample-type="field"'],
            'number-input' => ['Min/max/step', 'Increment/decrement', 'Error/warning icon', 'Compact/fluid', 'data-ui-reference-sample-type="field"'],
            'checkbox' => ['Independent choice', 'Multi-select group', 'Nested group', 'Group states', 'Overflow and alignment', 'data-component-live-layout="checkbox-matrix"'],
            'radio-button' => ['Vertical radio group', 'Horizontal radio group', 'Selected/unselected', 'Validation group', 'data-ui-reference-sample-type="selection"'],
            'notification' => ['Form validation error', 'Record saved', 'API failure', 'Background job completed', 'Maintenance notice', 'data-ui-reference-sample-type="alert"'],
            'modal' => ['Confirmation dialog', 'Form modal', 'Read-only detail', 'Destructive action', 'Wizard deferred', 'data-ui-component="modal-preview"'],
            'data-table' => ['Basic sortable table', 'Filterable table', 'Row actions', 'Loading', 'Responsive overflow', 'ui-table-row'],
            'pagination' => ['Full pagination', 'Compact pagination', 'Page-size selector', 'Disabled prev/next', 'Overflow', 'ui-pagination-control'],
            'tabs' => ['Line tabs', 'Contained tabs', 'Vertical tabs', 'Icon-leading', 'Icon-only', 'Overflow/scroll', 'Disabled', 'data-ui-reference-sample-type="tabs"'],
            'ui-shell' => ['Header baseline', 'Left panel', 'Account menu', 'Notification/action area', 'Mobile/collapsed behavior', 'Right panel deferred', 'data-ui-reference-sample-type="shell"'],
            'code-snippet' => ['Anatomy and variants', 'Inline', 'Single line with horizontal overflow', 'Multi-line with show more', 'Copy controls', 'Highlighted syntax tokens', 'data-component-live-layout="code-snippet-matrix"'],
            'content-switcher' => ['Peer view switcher', 'Icon view switcher', 'Toolbar mode switcher', 'Default', 'Compact', 'Disabled option', 'No panel mode', 'data-ui-reference-sample-type="content-switcher"'],
        ];

        foreach ($expectations as $slug => $needles) {
            $response = $this->get('/platform/ui-reference/components/'.$slug)
                ->assertOk()
                ->assertSee('data-component-card="purpose"', false)
                ->assertSee('data-component-card="component-contract"', false)
                ->assertSee('data-component-card="live-examples"', false)
                ->assertSee('data-component-section="foundation-elements-used"', false)
                ->assertSee('ui-code-snippet', false)
                ->assertDontSee('Family-depth implementation pending');

            if (in_array($slug, ['button', 'menu-buttons', 'tooltip', 'checkbox', 'code-snippet'], true)) {
                $response
                    ->assertSee('data-ui-reference-live-examples-layout="flexible-matrix"', false)
                    ->assertDontSee('Live Examples Card');
            } else {
                $response
                    ->assertSee('Variants for this example')
                    ->assertSee('data-ui-reference-variant-example', false);
            }

            foreach ($needles as $needle) {
                $response->assertSee($needle, false);
            }
        }
    }

    public function test_component_recovery_pages_do_not_render_generic_fallback_content(): void
    {
        $this->actingAsPlatformSuperAdmin();

        foreach (['breadcrumb', 'tabs', 'menu', 'code-snippet', 'button', 'tooltip'] as $slug) {
            $response = $this->get('/platform/ui-reference/components/'.$slug)
                ->assertOk()
                ->assertSee('data-component-section="developer-code-example"', false)
                ->assertDontSee('<!-- Use the documented component contract before adding local markup. -->', false)
                ->assertDontSee('Use the documented component contract before adding local markup')
                ->assertDontSee('Family-depth implementation pending')
                ->assertDontSee('Current location, keyboard navigation, focus order, responsive collapse, overflow, and skip-link/focus expectations')
                ->assertDontSee('Default, hover-capable, focus-visible, disabled, read-only, helper, error, warning, and loading where applicable.');

            if (in_array($slug, ['button', 'tooltip'], true)) {
                $response
                    ->assertSee('Implemented - pending manual review')
                    ->assertSee('data-ui-reference-live-examples-layout="flexible-matrix"', false);
            } else {
                $response
                    ->assertSee('Implemented - pending manual review')
                    ->assertSee('data-ui-reference-variant-example', false);
            }
        }
    }

    public function test_breadcrumb_component_recovery_page_renders_required_examples(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $response = $this->get('/platform/ui-reference/components/breadcrumb');

        $response
            ->assertOk()
            ->assertSee('x-ui.breadcrumb')
            ->assertSee('Small size')
            ->assertSee('Medium size')
            ->assertSee('Truncated menu')
            ->assertSee('Current page listed')
            ->assertSee('Truncated menu with current page listed')
            ->assertSee('data-ui-component="breadcrumb"', false)
            ->assertSee('data-ui-breadcrumb-size="sm"', false)
            ->assertSee('data-ui-breadcrumb-size="md"', false)
            ->assertSee('data-ui-breadcrumb-overflow="true"', false)
            ->assertSee('data-ui-breadcrumb-current-included="false"', false)
            ->assertSee('data-ui-breadcrumb-current-included="true"', false)
            ->assertSee('data-ui-breadcrumb-visible-items="4"', false)
            ->assertSee('data-ui-breadcrumb-visible-items="5"', false)
            ->assertSee('data-ui-breadcrumb-truncate-after="4"', false)
            ->assertSee('data-ui-breadcrumb-truncate-after="5"', false)
            ->assertSee('ui-breadcrumb-trailing', false)
            ->assertSee('data-ui-menu-trigger', false)
            ->assertSee('aria-haspopup="menu"', false)
            ->assertSee('aria-expanded="false"', false)
            ->assertSee('data-ui-menu', false)
            ->assertSee('data-ui-menu-panel', false)
            ->assertSee('data-ui-menu-item', false)
            ->assertSee('ui-breadcrumb-overflow-menu', false)
            ->assertSee('ui-breadcrumb-overflow-desktop-item', false)
            ->assertSee('ui-breadcrumb-overflow-compact-item', false)
            ->assertSee('aria-current="page"', false)
            ->assertSee('Tenant admin')
            ->assertSeeInOrder(['Platform', 'Operations', 'Security settings', 'Domain rules'])
            ->assertSee('Default')
            ->assertSee('Overflow menu open')
            ->assertSee('Disabled not applicable')
            ->assertDontSee('aria-current="page" class="ui-link"', false);

        preg_match_all('/<button[^>]*data-ui-breadcrumb-overflow-trigger[^>]*>/s', $response->getContent(), $overflowTriggers);

        $this->assertNotEmpty($overflowTriggers[0]);

        foreach ($overflowTriggers[0] as $triggerMarkup) {
            $this->assertStringContainsString('aria-expanded="false"', $triggerMarkup);
            $this->assertStringNotContainsString('aria-expanded="true"', $triggerMarkup);
        }

        preg_match_all('/<div[^>]*class="[^"]*ui-menu[^"]*ui-menu-sm[^"]*ui-menu-align-bottom-start[^"]*ui-breadcrumb-overflow-menu[^"]*"[^>]*data-ui-menu[^>]*>/s', $response->getContent(), $overflowMenus);

        $this->assertNotEmpty($overflowMenus[0]);

        foreach ($overflowMenus[0] as $menuMarkup) {
            $this->assertStringContainsString('hidden', $menuMarkup);
        }

        $breadcrumbCatalog = file_get_contents(app_path('Platform/UiReference/UiReferenceComponentDepthCatalog.php'));
        $breadcrumbView = file_get_contents(resource_path('views/components/ui/breadcrumb.blade.php'));
        $breadcrumbCss = file_get_contents(resource_path('css/app.css'));
        $menuScript = file_get_contents(resource_path('js/ui-controls/menus.js'));

        $this->assertIsString($breadcrumbCatalog);
        $this->assertIsString($breadcrumbView);
        $this->assertIsString($breadcrumbCss);
        $this->assertIsString($menuScript);
        $this->assertStringNotContainsString("'menu_open' => true", $breadcrumbCatalog);
        $this->assertStringContainsString('<x-ui.menu-item', $breadcrumbView);
        $this->assertStringContainsString('heroicon-o-ellipsis-horizontal', $breadcrumbView);
        $this->assertStringContainsString('data-ui-menu-panel', $breadcrumbView);
        $this->assertStringContainsString('ui-breadcrumb-overflow-compact-item', $breadcrumbView);
        $this->assertStringContainsString(".ui-breadcrumb[data-ui-breadcrumb-overflow='true'] .ui-breadcrumb-overflow", $breadcrumbCss);
        $this->assertStringContainsString(".ui-breadcrumb[data-ui-breadcrumb-overflow='true'] .ui-breadcrumb-item:not(.ui-breadcrumb-overflow):not(:last-child)", $breadcrumbCss);
        $this->assertStringContainsString('.ui-breadcrumb .ui-breadcrumb-overflow-compact-item', $breadcrumbCss);
        $this->assertStringContainsString('.ui-breadcrumb[data-ui-breadcrumb-overflow=\'true\'] .ui-breadcrumb-overflow-desktop-item', $breadcrumbCss);
        $this->assertStringContainsString('calc(100vw - 7rem)', $breadcrumbCss);
        $this->assertStringContainsString('item.getClientRects().length > 0', $menuScript);
    }

    public function test_tabs_component_recovery_page_renders_required_examples(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/components/tabs')
            ->assertOk()
            ->assertSee('x-ui.tabs')
            ->assertSee('Line tabs')
            ->assertSee('Contained tabs')
            ->assertSee('Vertical tabs')
            ->assertSee('Scrollable line tabs')
            ->assertSee('Tabs with icons')
            ->assertSee('Icon-only tabs')
            ->assertSee('Secondary labels')
            ->assertSee('Dismissible tabs')
            ->assertSee('Dismissible tabs with icons')
            ->assertSee('Manual activation')
            ->assertSee('Small breakpoint handoff')
            ->assertSee('data-ui-component="tabs"', false)
            ->assertSee('data-ui-tabs-activation="manual"', false)
            ->assertSee('role="tablist"', false)
            ->assertSee('role="tabpanel"', false)
            ->assertSee('Overview panel')
            ->assertSee('Activity panel')
            ->assertSee('Settings panel')
            ->assertSee('Selected')
            ->assertSee('Unselected')
            ->assertSee('Focus-visible')
            ->assertSee('Scrollable')
            ->assertSee('Dismissible');
    }

    public function test_menu_component_recovery_page_renders_required_examples(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/components/menu')
            ->assertOk()
            ->assertSee('x-ui.menu')
            ->assertSee('Contextual action menu')
            ->assertSee('Row action menu')
            ->assertSee('Grouped and selected menu')
            ->assertSee('Alignment and RTL')
            ->assertSee('Extra small')
            ->assertSee('Small')
            ->assertSee('Medium')
            ->assertSee('Large')
            ->assertSee('Bottom start')
            ->assertSee('Bottom end')
            ->assertSee('Top start')
            ->assertSee('Top end')
            ->assertSee('RTL mirrored')
            ->assertSee('Keyboard shortcut')
            ->assertSee('Submenu actions')
            ->assertSee('Multi-section grouping')
            ->assertSee('Single-select')
            ->assertSee('Multi-select')
            ->assertSee('Truncated label with title')
            ->assertSee('Preview details')
            ->assertSee('Active workspaces')
            ->assertSee('Danger hover and focus')
            ->assertSee('The visible proof panel represents the menu surface itself')
            ->assertSee('data-ui-component="menu-composition"', false)
            ->assertSee('data-ui-menu-open="false"', false)
            ->assertSee('data-ui-menu-trigger', false)
            ->assertSee('aria-haspopup="menu"', false)
            ->assertSee('aria-expanded="false"', false)
            ->assertSee('aria-controls="ui-menu-', false)
            ->assertSee('data-ui-menu-panel', false)
            ->assertSee('data-ui-menu-placement="bottom-end"', false)
            ->assertSee('data-ui-menu-size="xs"', false)
            ->assertSee('data-ui-menu-proof-panel', false)
            ->assertSee('Static proof panel uses', false)
            ->assertSee('without forcing the interactive menu open')
            ->assertSee('data-ui-component="menu-item"', false)
            ->assertSee('data-ui-menu-item', false)
            ->assertSee('data-ui-menu-item-size="xs"', false)
            ->assertSee('data-ui-menu-item-size="lg"', false)
            ->assertSee('data-ui-menu-item-state="danger-focus-hover"', false)
            ->assertSee('ui-menu-item-xs', false)
            ->assertSee('ui-menu-item-lg', false)
            ->assertSee('ui-menu-align-bottom-end', false)
            ->assertSee('role="separator"', false)
            ->assertSee('role="menuitem"', false)
            ->assertSee('role="menuitemradio"', false)
            ->assertSee('role="menuitemcheckbox"', false)
            ->assertSee('aria-checked="true"', false)
            ->assertSee('data-ui-menu-submenu-trigger', false)
            ->assertSee('data-ui-menu-submenu-panel', false)
            ->assertSee('ui-menu-submenu-panel', false)
            ->assertSee('ui-menu-composition-rtl', false)
            ->assertSee('ui-menu-item-check', false)
            ->assertSee('ui-menu-item-check-icon', false)
            ->assertSee('title="Open the complete workspace audit evidence package"', false)
            ->assertSee('Open actions for Workspace alpha')
            ->assertDontSee('data-ui-menu-open="true"', false);

        $menuView = file_get_contents(resource_path('views/components/ui/menu.blade.php'));
        $menuItemView = file_get_contents(resource_path('views/components/ui/menu-item.blade.php'));
        $menuSampleView = file_get_contents(resource_path('views/platform/ui-reference/components/examples/sample.blade.php'));
        $menuScript = file_get_contents(resource_path('js/ui-controls/menus.js'));
        $menuCss = file_get_contents(resource_path('css/app.css'));
        $menuStandard = file_get_contents(base_path('docs/02-standards/ui/components/menu.md'));

        $this->assertIsString($menuView);
        $this->assertIsString($menuItemView);
        $this->assertIsString($menuSampleView);
        $this->assertIsString($menuScript);
        $this->assertIsString($menuCss);
        $this->assertIsString($menuStandard);
        $this->assertStringContainsString('$reservesSelectionIndicator', $menuView);
        $this->assertStringContainsString('data-ui-menu-submenu-panel', $menuView);
        $this->assertStringContainsString('reserveIndicator', $menuItemView);
        $this->assertStringContainsString('heroicon-o-chevron-right', $menuItemView);
        $this->assertStringContainsString('ui-menu-item-disabled', $menuItemView);
        $this->assertStringNotContainsString('text-[var(--ui-action-disabled-text)]', $menuItemView);
        $this->assertStringContainsString('data-ui-menu-submenu-panel', $menuSampleView);
        $this->assertStringContainsString('hidden', $menuSampleView);
        $this->assertStringContainsString('openSubmenu', $menuScript);
        $this->assertStringNotContainsString("submenuTrigger.addEventListener('focus'", $menuScript);
        $this->assertStringContainsString('const isRtlMenu', $menuScript);
        $this->assertStringContainsString('openSubmenuKey', $menuScript);
        $this->assertStringContainsString('closeSubmenuKey', $menuScript);
        $this->assertStringContainsString('ArrowRight', $menuScript);
        $this->assertStringContainsString('ArrowLeft', $menuScript);
        $this->assertStringContainsString("data-ui-menu-item-state='disabled'", $menuCss);
        $this->assertStringContainsString('.ui-menu-submenu-panel', $menuCss);
        $this->assertStringContainsString('.ui-menu-composition-rtl .ui-menu', $menuCss);
        $this->assertStringContainsString('.ui-menu-composition-rtl .ui-menu-submenu-panel', $menuCss);
        $this->assertStringContainsString('reserve the same indicator column', $menuStandard);
        $this->assertStringContainsString('must not expand the submenu by itself', $menuStandard);
        $this->assertStringContainsString('RTL menus must mirror the full menu surface', $menuStandard);
    }

    public function test_code_snippet_component_recovery_page_renders_required_examples(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/components/code-snippet')
            ->assertOk()
            ->assertSee('x-ui.code-snippet')
            ->assertSee('Anatomy and variants')
            ->assertSee('Inline')
            ->assertSee('Single line with horizontal overflow')
            ->assertSee('Multi-line with show more')
            ->assertSee('Show more')
            ->assertSee('Show less')
            ->assertSee('Copy controls')
            ->assertSee('Copy to clipboard')
            ->assertSee('Copied to clipboard')
            ->assertSee('Highlighted syntax tokens')
            ->assertSee('Light modifier')
            ->assertSee('data-component-live-layout="code-snippet-matrix"', false)
            ->assertSee('data-ui-component="code-snippet"', false)
            ->assertSee('data-ui-code-snippet', false)
            ->assertSee('data-ui-code-copy-button', false)
            ->assertSee('data-ui-code-copy-source', false)
            ->assertSee('data-ui-code-show-more', false)
            ->assertSee('data-ui-code-snippet-variant="single"', false)
            ->assertSee('data-ui-code-snippet-variant="multi"', false)
            ->assertSee('data-ui-code-snippet-variant="inline"', false)
            ->assertSee('ui-code-token-keyword', false)
            ->assertSee('ui-code-token-property', false)
            ->assertSee('ui-code-token-string', false)
            ->assertSee('data-ui-code-copy-state="copied"', false)
            ->assertDontSee('Live clipboard behavior   | Gated')
            ->assertDontSee('Show more/show less for multi-line snippets | Gated');

        $componentView = file_get_contents(resource_path('views/components/ui/code-snippet.blade.php'));
        $examplesView = file_get_contents(resource_path('views/platform/ui-reference/components/live-examples/code-snippet.blade.php'));
        $componentCss = file_get_contents(resource_path('css/app.css'));
        $componentScript = file_get_contents(resource_path('js/ui-controls/code-snippets.js'));
        $interactionFocusScript = file_get_contents(resource_path('js/ui-controls/interaction-focus.js'));
        $uiControls = file_get_contents(resource_path('js/ui-controls.js'));
        $appJs = file_get_contents(resource_path('js/app.js'));
        $catalog = file_get_contents(app_path('Platform/UiReference/UiReferenceComponentDepthCatalog.php'));
        $standard = file_get_contents(base_path('docs/02-standards/ui/components/code-snippet.md'));

        $this->assertStringContainsString("['inline', 'single', 'multi']", $componentView);
        $this->assertStringContainsString("'ui-card',", $componentView);
        $this->assertStringContainsString('data-ui-code-copy-button', $componentView);
        $this->assertStringContainsString('data-ui-code-show-more', $componentView);
        $this->assertStringContainsString('heroicon-o-clipboard-document', $componentView);
        $this->assertStringContainsString('tooltip-placement="auto"', $componentView);
        $this->assertStringContainsString('<x-ui.tooltip', $componentView);
        $this->assertStringContainsString('data-component-live-layout="code-snippet-matrix"', $examplesView);
        $this->assertStringContainsString('Multi-line with show more', $examplesView);
        $this->assertStringContainsString('<span class="ui-code-token-function">docker compose</span>', $examplesView);
        $this->assertStringContainsString('<span class="ui-code-token-keyword">x-ui.data-table</span>', $examplesView);
        $this->assertStringContainsString('.ui-code-snippet-shell-expandable', $componentCss);
        $this->assertStringContainsString('background-color: var(--ui-card-layer, var(--ui-layer-01));', $componentCss);
        $this->assertStringContainsString('@apply relative w-full max-w-3xl overflow-visible;', $componentCss);
        $this->assertStringContainsString('--ui-code-snippet-layer: var(--ui-layer-02);', $componentCss);
        $this->assertStringContainsString('--ui-card-layer: var(--ui-code-snippet-layer);', $componentCss);
        $this->assertStringContainsString('background-color: var(--ui-code-snippet-layer);', $componentCss);
        $this->assertStringNotContainsString('@apply relative w-full max-w-3xl overflow-visible rounded-lg border', $componentCss);
        $this->assertStringContainsString('@apply flex min-h-10 items-center justify-between gap-3 px-4 py-2 text-xs font-semibold uppercase tracking-[0.12em];', $componentCss);
        $this->assertStringContainsString('@apply px-4 py-2;', $componentCss);
        $this->assertStringNotContainsString('@apply flex min-h-10 items-center justify-between gap-3 border-b px-4 py-2 text-xs font-semibold uppercase tracking-[0.12em];', $componentCss);
        $this->assertStringNotContainsString('@apply border-t px-4 py-2;', $componentCss);
        $this->assertStringContainsString(".ui-code-snippet-shell[data-ui-code-copy-state='copied'] .ui-code-snippet-copy-control .ui-icon-button", $componentCss);
        $this->assertStringContainsString("[data-ui-interaction-focus='true']", $componentCss);
        $this->assertStringContainsString('.ui-code-snippet-inline', $componentCss);
        $this->assertStringContainsString('export function initCodeSnippets(root = document)', $componentScript);
        $this->assertStringContainsString('navigator.clipboard', $componentScript);
        $this->assertStringContainsString('export function initInteractionFocus(root = document)', $interactionFocusScript);
        $this->assertStringContainsString('export { initCodeSnippets }', $uiControls);
        $this->assertStringContainsString('export { initInteractionFocus }', $uiControls);
        $this->assertStringContainsString('initCodeSnippets', $appJs);
        $this->assertStringContainsString('initInteractionFocus', $appJs);
        $this->assertStringContainsString('initCodeSnippets exported from resources/js/ui-controls/code-snippets.js', $catalog);
        $this->assertStringContainsString('Show more/show less', $standard);
        $this->assertStringContainsString('consume the standard `.ui-card` surface contract', $standard);
        $this->assertStringContainsString('Nested block snippets default to `--ui-layer-02`', $standard);
    }

    public function test_button_component_recovery_page_renders_required_examples(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $response = $this->get('/platform/ui-reference/components/button');

        $response
            ->assertOk()
            ->assertSee('x-ui.button')
            ->assertSee('x-ui.icon-button')
            ->assertSee('data-ui-reference-live-examples-layout="flexible-matrix"', false)
            ->assertSee('data-component-live-layout="button-matrix"', false)
            ->assertSee('Variant purpose matrix')
            ->assertSee('Size scale')
            ->assertSee('State matrix')
            ->assertSee('Structure measurements')
            ->assertSee('Button groups')
            ->assertSee('Icon usage')
            ->assertSee('Content behavior')
            ->assertSee('Token and style roles')
            ->assertSee('Primary')
            ->assertSee('Secondary')
            ->assertSee('Tertiary')
            ->assertSee('Ghost')
            ->assertSee('Danger primary')
            ->assertSee('Danger tertiary')
            ->assertSee('Danger ghost')
            ->assertSee('Extra small')
            ->assertSee('Small')
            ->assertSee('Medium')
            ->assertSee('Large productive')
            ->assertSee('Large expressive')
            ->assertSee('Extra large')
            ->assertSee('2XL')
            ->assertSee('Default')
            ->assertSee('Hover')
            ->assertSee('Focus-visible')
            ->assertSee('Active')
            ->assertSee('Disabled')
            ->assertSee('Loading')
            ->assertSee('Danger hover')
            ->assertSee('Horizontal static')
            ->assertSee('Horizontal fluid')
            ->assertSee('Vertical static')
            ->assertSee('Vertical fluid')
            ->assertSee('Approved groups with primary')
            ->assertSee('Approved groups without primary')
            ->assertSee('Avoided group styling')
            ->assertSee('Primary + Secondary')
            ->assertSee('Primary + Secondary + Tertiary')
            ->assertSee('2 Tertiary + 1 Danger tertiary')
            ->assertSee('More than 3 actions')
            ->assertSee('Menu buttons or Toolbar')
            ->assertSee('Button icons appear to the right of the label')
            ->assertSee('Icon-only buttons use the same state tokens')
            ->assertSee('always require a tooltip plus an accessible name')
            ->assertSee('Danger icon-only is not allowed')
            ->assertSee('data-button-token-contract="carbon-button-colors"', false)
            ->assertSee('data-button-token-row="secondary"', false)
            ->assertSee('$button-secondary / hover / active')
            ->assertSee('--ui-action-secondary-bg / -hover / -active')
            ->assertSee('Gray 80 #393939')
            ->assertSee('Gray 80 hover #4c4c4c')
            ->assertSee('Gray 60 active #6f6f6f')
            ->assertSee('data-button-live-section="structure-measurements"', false)
            ->assertSee('data-button-structure-row="button-without-icon-padding-right"', false)
            ->assertSee('data-button-structure-row="button-with-icon-label-icon-spacing"', false)
            ->assertSee('data-button-structure-row="ghost-with-icon-label-icon-spacing"', false)
            ->assertSee('data-button-structure-proof="standard-icon-gap"', false)
            ->assertSee('data-button-structure-proof="ghost-icon-gap"', false)
            ->assertSee('$spacing-10')
            ->assertSee('$spacing-07')
            ->assertSee('$spacing-03')
            ->assertSee('Prefer verb + noun labels')
            ->assertSee('Use sentence case')
            ->assertSee('Labels remain left-aligned')
            ->assertSee('RTL mirrors')
            ->assertSee('wrap to a second line instead of truncating')
            ->assertSee('data-button-content-rule="group-height-follows-tallest"', false)
            ->assertSee('data-button-content-proof="wrapped-label-second"', false)
            ->assertSee('data-button-group-height-rule="tallest-label"', false)
            ->assertSee('data-ui-component="button"', false)
            ->assertSee('data-ui-component="icon-button"', false)
            ->assertSee('data-button-variant-row="danger-ghost"', false)
            ->assertSee('data-button-size-row="2xl"', false)
            ->assertSee('ui-action-lg-expressive', false)
            ->assertSee('ui-action-xl', false)
            ->assertSee('ui-action-2xl', false)
            ->assertSee('data-button-group-layout="horizontal-static"', false)
            ->assertSee('data-button-group-layout="horizontal-fluid"', false)
            ->assertSee('data-button-group-layout="vertical-static"', false)
            ->assertSee('data-button-group-layout="vertical-fluid"', false)
            ->assertSee('data-button-group-example="horizontal-static-no-icons"', false)
            ->assertSee('data-button-group-example="horizontal-fluid-icons"', false)
            ->assertSee('data-button-group-example="vertical-static-no-icons"', false)
            ->assertSee('data-button-group-example="vertical-fluid-icons"', false)
            ->assertSee('data-button-group-width-rule="equal-non-ghost"', false)
            ->assertSee('data-button-group-icon-rule="all-or-none"', false)
            ->assertSee('data-button-icon-group="all-icons"', false)
            ->assertSee('data-button-icon-group="no-icons"', false)
            ->assertSee('data-button-icon-only-tooltip-rule="always-required"', false)
            ->assertSee('data-button-group-written-guidance="approved-combinations"', false)
            ->assertSee('data-ui-component="tooltip"', false)
            ->assertSee('data-ui-tooltip-content', false)
            ->assertSee('data-button-icon-only-rule="danger-prohibited"', false)
            ->assertSee('data-button-rule="no-danger-icon-only"', false)
            ->assertDontSee('data-button-group-overflow-rule="menu-buttons"', false)
            ->assertDontSee('data-ui-component="menu-button"', false)
            ->assertDontSee('data-button-icon-state-matrix', false)
            ->assertDontSee('data-button-icon-state-row="default"', false)
            ->assertSee('is-hover', false)
            ->assertSee('is-focus', false)
            ->assertSee('is-active', false)
            ->assertSee('aria-busy="true"', false)
            ->assertDontSee('title="Refresh data"', false)
            ->assertSee('Icon-only danger prohibited')
            ->assertDontSee('Family-depth implementation pending');

        $buttonView = file_get_contents(resource_path('views/components/ui/button.blade.php'));
        $iconButtonView = file_get_contents(resource_path('views/components/ui/icon-button.blade.php'));
        $buttonCss = file_get_contents(resource_path('css/app.css'));
        $buttonStandard = file_get_contents(base_path('docs/02-standards/ui/components/button.md'));
        $colorStandard = file_get_contents(base_path('docs/02-standards/ui/elements/color.md'));

        $this->assertIsString($buttonView);
        $this->assertIsString($iconButtonView);
        $this->assertIsString($buttonCss);
        $this->assertIsString($buttonStandard);
        $this->assertIsString($colorStandard);
        $this->assertStringContainsString("'secondary' => ['secondary', 'base']", $buttonView);
        $this->assertStringContainsString("'secondary' => ['secondary', 'base']", $iconButtonView);
        $this->assertStringContainsString("'tertiary' => ['tertiary', 'outline']", $buttonView);
        $this->assertStringContainsString("'tertiary' => ['tertiary', 'outline']", $iconButtonView);
        $this->assertStringContainsString('--ui-action-secondary-bg: rgb(57 57 57);', $buttonCss);
        $this->assertStringContainsString('--ui-action-secondary-bg-hover: rgb(76 76 76);', $buttonCss);
        $this->assertStringContainsString('--ui-action-secondary-bg-active: rgb(111 111 111);', $buttonCss);
        $this->assertStringContainsString('--ui-action-secondary-bg: rgb(111 111 111);', $buttonCss);
        $this->assertStringContainsString('--ui-action-secondary-bg-hover: rgb(96 96 96);', $buttonCss);
        $this->assertStringContainsString('--ui-action-secondary-bg-active: rgb(57 57 57);', $buttonCss);
        $this->assertStringContainsString('.ui-action-secondary:active', $buttonCss);
        $this->assertStringContainsString('.ui-icon-button.ui-action-secondary', $buttonCss);
        $this->assertStringContainsString('--ui-button-padding-start: 1rem;', $buttonCss);
        $this->assertStringContainsString('--ui-button-padding-end: 4rem;', $buttonCss);
        $this->assertStringContainsString('--ui-button-gap: 2rem;', $buttonCss);
        $this->assertStringContainsString('--ui-button-label-line-height: 1.25rem;', $buttonCss);
        $this->assertStringContainsString('padding-block: max(0rem, calc((var(--ui-button-height) - var(--ui-button-label-line-height)) / 2));', $buttonCss);
        $this->assertStringContainsString('.ui-action-with-icon', $buttonCss);
        $this->assertStringContainsString('.ui-action-with-icon .ui-button-icon', $buttonCss);
        $this->assertStringContainsString('margin-inline-start: auto;', $buttonCss);
        $this->assertStringContainsString('.ui-action-with-icon.ui-action-ghost .ui-button-icon', $buttonCss);
        $this->assertStringContainsString('margin-inline-start: 0;', $buttonCss);
        $this->assertStringContainsString('.ui-action-tertiary.ui-action-outline', $buttonCss);
        $this->assertStringContainsString('--ui-action-tertiary-border: var(--ui-action-outline-primary-border);', $buttonCss);
        $this->assertStringContainsString('--ui-action-tertiary-text: var(--ui-action-outline-primary-text);', $buttonCss);
        $this->assertStringContainsString('--ui-action-tertiary-bg-hover: var(--ui-action-primary-bg-hover);', $buttonCss);
        $this->assertStringContainsString('--ui-action-tertiary-text-hover: var(--ui-text-inverse);', $buttonCss);
        $this->assertStringContainsString('--ui-action-tertiary-border: var(--ui-background-inverse);', $buttonCss);
        $this->assertStringContainsString('--ui-action-tertiary-bg-hover: var(--ui-background-inverse);', $buttonCss);
        $this->assertStringContainsString('--ui-action-tertiary-text-hover: rgb(3 105 161);', $buttonCss);
        $this->assertStringContainsString('.ui-button-group-equal', $buttonCss);
        $this->assertStringContainsString('.ui-button-group-fluid', $buttonCss);
        $this->assertStringContainsString('.ui-button-group-vertical', $buttonCss);
        $this->assertStringContainsString('grid-auto-columns: minmax(0, 1fr);', $buttonCss);
        $this->assertStringContainsString('grid-auto-rows: minmax(var(--ui-button-height), 1fr);', $buttonCss);
        $this->assertStringContainsString('Use Button groups only when users need to consider two or three visible actions together.', $buttonStandard);
        $this->assertStringContainsString('Related non-ghost buttons in a group must be equal width.', $buttonStandard);
        $this->assertStringContainsString('share the tallest required button height when any label wraps to a second line', $buttonStandard);
        $this->assertStringContainsString('The Button UI Reference page should render compact proof examples for horizontal static, horizontal fluid, vertical static, vertical fluid, all-icons, and no-icons groups;', $buttonStandard);
        $this->assertStringContainsString('Always required for icon-only buttons; copy must explain the action if clicked.', $buttonStandard);
        $this->assertStringContainsString('pins the icon to the right padding and lets label-icon space expand', $buttonStandard);
        $this->assertStringContainsString('data-ui-tooltip-content', $iconButtonView);
        $this->assertStringContainsString('Tertiary is a primary-color outline role, not neutral outline.', $buttonStandard);
        $this->assertStringContainsString('Action tertiary must stay mapped to the primary-color Button tertiary role, not neutral outline.', $colorStandard);
        $this->assertStringContainsString('Same role / same Carbon gray value family', $buttonStandard);
        $this->assertStringContainsString('Secondary is a filled gray action role, not a neutral outline/white button.', $colorStandard);
    }

    public function test_menu_buttons_component_recovery_page_renders_required_examples(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $response = $this->get('/platform/ui-reference/components/menu-buttons');

        $response
            ->assertOk()
            ->assertSee('x-ui.menu-button')
            ->assertSee('x-ui.combo-button')
            ->assertSee('x-ui.overflow-menu')
            ->assertSee('data-ui-reference-live-examples-layout="flexible-matrix"', false)
            ->assertSee('data-component-live-layout="menu-buttons-matrix"', false)
            ->assertSee('data-menu-buttons-live-section="variant-purpose-matrix"', false)
            ->assertSee('data-menu-buttons-live-section="base-options"', false)
            ->assertSee('data-menu-buttons-live-section="trigger-style-matrix"', false)
            ->assertSee('data-menu-buttons-live-section="size-scale"', false)
            ->assertSee('data-menu-buttons-live-section="placement-width"', false)
            ->assertSee('data-menu-buttons-live-section="states-keyboard"', false)
            ->assertSee('data-menu-buttons-live-section="content-boundaries"', false)
            ->assertSee('data-menu-buttons-live-section="developer-implementation"', false)
            ->assertSee('data-menu-buttons-variant-row="menu-button"', false)
            ->assertSee('data-menu-buttons-variant-row="combo-button"', false)
            ->assertSee('data-menu-buttons-variant-row="overflow-menu"', false)
            ->assertSee('data-menu-buttons-base="menu-button"', false)
            ->assertSee('data-menu-buttons-base="combo-button"', false)
            ->assertSee('data-menu-buttons-base="overflow-menu"', false)
            ->assertSee('data-menu-buttons-trigger-row="primary-menu-button"', false)
            ->assertSee('data-menu-buttons-trigger-row="outline-menu-button"', false)
            ->assertSee('data-menu-buttons-trigger-row="ghost-menu-button"', false)
            ->assertSee('data-menu-buttons-trigger-row="combo-primary-only"', false)
            ->assertSee('data-menu-buttons-trigger-row="overflow-ghost-only"', false)
            ->assertSee('data-menu-buttons-base-variant="primary"', false)
            ->assertSee('data-menu-buttons-base-variant="outline"', false)
            ->assertSee('data-menu-buttons-base-variant="ghost"', false)
            ->assertSee('data-menu-buttons-overflow-rule="ghost-only-vertical-ellipsis"', false)
            ->assertSee('data-menu-buttons-size-row="extra-small"', false)
            ->assertSee('data-menu-buttons-size-row="small"', false)
            ->assertSee('data-menu-buttons-size-row="medium"', false)
            ->assertSee('data-menu-buttons-size-row="large"', false)
            ->assertSee('data-ui-component="menu-button"', false)
            ->assertSee('data-ui-component="combo-button"', false)
            ->assertSee('data-ui-component="overflow-menu"', false)
            ->assertSee('data-ui-menu-button-kind="menu"', false)
            ->assertSee('data-ui-menu-button-kind="combo"', false)
            ->assertSee('data-ui-menu-button-kind="overflow"', false)
            ->assertSee('data-ui-menu-open="false"', false)
            ->assertSee('data-ui-menu-open="true"', false)
            ->assertSee('data-ui-menu-proof-panel', false)
            ->assertSee('data-ui-menu-size="xs"', false)
            ->assertSee('data-ui-menu-size="lg"', false)
            ->assertSee('data-menu-buttons-size-proof="xs"', false)
            ->assertSee('data-menu-buttons-size-proof="lg"', false)
            ->assertSee('data-menu-buttons-width-rule="minimum-160"', false)
            ->assertSee('data-menu-buttons-width-rule="ghost-exception"', false)
            ->assertSee('data-menu-buttons-keyboard-rule="aria-expanded"', false)
            ->assertSee('data-menu-buttons-keyboard-rule="escape"', false)
            ->assertSee('data-menu-buttons-keyboard-rule="arrows"', false)
            ->assertSee('data-menu-buttons-keyboard-rule="activate"', false)
            ->assertSee('data-menu-buttons-boundary="not-value-selection"', false)
            ->assertSee('data-menu-buttons-boundary="not-rich-content"', false)
            ->assertSee('aria-haspopup="menu"', false)
            ->assertSee('aria-expanded="false"', false)
            ->assertSee('aria-expanded="true"', false)
            ->assertSee('Menu button')
            ->assertSee('Combo button')
            ->assertSee('Overflow menu')
            ->assertSee('Overflow menu can only use a ghost button')
            ->assertSee('vertical ellipsis')
            ->assertSee('Extra small')
            ->assertSee('48px / 3rem')
            ->assertSee('Ghost trigger width follows the button')
            ->assertSee('Menu buttons are for actions, not value selection')
            ->assertSee('Menu button triggers follow Button style guidance')
            ->assertDontSee('Component-specific API pending correction')
            ->assertDontSee('Family-depth implementation pending')
            ->assertDontSee('<x-ui.menu', false)
            ->assertDontSee('data-ui-reference-sample-type="menu-button"', false);

        $menuView = file_get_contents(resource_path('views/components/ui/menu.blade.php'));
        $menuButtonView = file_get_contents(resource_path('views/components/ui/menu-button.blade.php'));
        $comboButtonView = file_get_contents(resource_path('views/components/ui/combo-button.blade.php'));
        $overflowMenuView = file_get_contents(resource_path('views/components/ui/overflow-menu.blade.php'));
        $menuButtonExamples = file_get_contents(resource_path('views/platform/ui-reference/components/live-examples/menu-buttons.blade.php'));
        $appCss = file_get_contents(resource_path('css/app.css'));
        $menuButtonsStandard = file_get_contents(base_path('docs/02-standards/ui/components/menu-buttons.md'));

        $this->assertIsString($menuView);
        $this->assertIsString($menuButtonView);
        $this->assertIsString($comboButtonView);
        $this->assertIsString($overflowMenuView);
        $this->assertIsString($menuButtonExamples);
        $this->assertIsString($appCss);
        $this->assertIsString($menuButtonsStandard);
        $this->assertStringContainsString('icon="heroicon-o-chevron-down"', $menuView);
        $this->assertStringContainsString('heroicon-o-ellipsis-vertical', $menuView);
        $this->assertStringContainsString('trigger-icon="heroicon-o-chevron-down"', $comboButtonView);
        $this->assertStringContainsString('trigger-icon="heroicon-o-ellipsis-vertical"', $overflowMenuView);
        $this->assertStringNotContainsString('<span aria-hidden="true">...</span>', $menuView);
        $this->assertStringContainsString('Outline menu button', $menuButtonExamples);
        $this->assertStringContainsString('.ui-combo-button [data-ui-combo-button-trigger] .ui-icon-button', $appCss);
        $this->assertStringContainsString('border-start-start-radius: 0;', $appCss);
        $this->assertStringContainsString('.ui-overflow-menu .ui-icon-button', $appCss);
        $this->assertStringContainsString('any approved secondary trigger must consume `--ui-action-secondary-*`', $menuButtonsStandard);
        $this->assertStringContainsString('The caret must render to the right of the label and must not wrap to a new text line.', $menuButtonsStandard);
        $this->assertStringContainsString('Overflow menu triggers must be icon-only ghost buttons using the approved vertical ellipsis icon', $menuButtonsStandard);
    }

    public function test_tooltip_component_recovery_page_renders_required_examples(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $response = $this->get('/platform/ui-reference/components/tooltip');

        $response
            ->assertOk()
            ->assertSee('x-ui.tooltip')
            ->assertSee('data-ui-reference-live-examples-layout="flexible-matrix"', false)
            ->assertSee('data-component-live-layout="tooltip-matrix"', false)
            ->assertSee('Anatomy')
            ->assertSee('Placement and alignment')
            ->assertSee('Sizing and structure')
            ->assertSee('Behavior and accessibility')
            ->assertSee('Related overlays')
            ->assertSee('UI trigger')
            ->assertSee('Caret tip')
            ->assertSee('Container')
            ->assertSee('data-tooltip-anatomy-part="caret"', false)
            ->assertSee('data-ui-tooltip-caret', false)
            ->assertSee('data-ui-tooltip-placement="auto"', false)
            ->assertSee('data-tooltip-placement-proof="top"', false)
            ->assertSee('data-tooltip-placement-proof="right"', false)
            ->assertSee('data-tooltip-placement-proof="bottom"', false)
            ->assertSee('data-tooltip-placement-proof="left"', false)
            ->assertSee('data-tooltip-alignment-proof="start"', false)
            ->assertSee('data-tooltip-alignment-proof="center"', false)
            ->assertSee('data-tooltip-alignment-proof="end"', false)
            ->assertSee('data-tooltip-size-proof="single"', false)
            ->assertSee('data-tooltip-size-proof="multi"', false)
            ->assertSee('data-tooltip-size-proof="definition"', false)
            ->assertSee('data-ui-tooltip-size="single"', false)
            ->assertSee('data-ui-tooltip-size="multi"', false)
            ->assertSee('data-ui-tooltip-size="definition"', false)
            ->assertSee('ui-tooltip-definition-trigger', false)
            ->assertSee('data-tooltip-state-proof="closed"', false)
            ->assertSee('data-tooltip-state-proof="focus"', false)
            ->assertSee('data-tooltip-state-proof="disabled-wrapper"', false)
            ->assertSee('aria-describedby=', false)
            ->assertSee('data-ui-tooltip-state="open"', false)
            ->assertSee('data-ui-tooltip-state="closed"', false)
            ->assertSee('Refresh data')
            ->assertSee('A workspace groups users, roles, and settings for one account.')
            ->assertSee('You need admin access to delete this workspace.')
            ->assertSee('Toggletip')
            ->assertSee('Popover')
            ->assertSee('Modal')
            ->assertSee('Helper text')
            ->assertDontSee('Family-depth implementation pending')
            ->assertDontSee('data-bs-toggle="tooltip"', false)
            ->assertDontSee('bootstrap-tooltip');

        $tooltipView = file_get_contents(resource_path('views/components/ui/tooltip.blade.php'));
        $iconButtonView = file_get_contents(resource_path('views/components/ui/icon-button.blade.php'));
        $tooltipExamples = file_get_contents(resource_path('views/platform/ui-reference/components/live-examples/tooltip.blade.php'));
        $buttonCss = file_get_contents(resource_path('css/app.css'));
        $tooltipsJs = file_get_contents(resource_path('js/ui-controls/tooltips.js'));
        $uiControlsJs = file_get_contents(resource_path('js/ui-controls.js'));
        $appJs = file_get_contents(resource_path('js/app.js'));
        $catalog = file_get_contents(app_path('Platform/UiReference/UiReferenceComponentDepthCatalog.php'));
        $tooltipStandard = file_get_contents(base_path('docs/02-standards/ui/components/tooltip.md'));

        $this->assertIsString($tooltipView);
        $this->assertIsString($iconButtonView);
        $this->assertIsString($tooltipExamples);
        $this->assertIsString($buttonCss);
        $this->assertIsString($tooltipsJs);
        $this->assertIsString($uiControlsJs);
        $this->assertIsString($appJs);
        $this->assertIsString($catalog);
        $this->assertIsString($tooltipStandard);

        $this->assertStringContainsString("'placement' => 'auto'", $tooltipView);
        $this->assertStringContainsString("'align' => 'center'", $tooltipView);
        $this->assertStringContainsString("'open' => false", $tooltipView);
        $this->assertStringContainsString('data-ui-tooltip-caret', $tooltipView);
        $this->assertStringContainsString('data-ui-tooltip-resolved-placement', $tooltipView);
        $this->assertStringNotContainsString('title="', $tooltipView);
        $this->assertStringContainsString('aria-describedby', $iconButtonView);
        $this->assertStringContainsString('data-ui-tooltip-caret', $iconButtonView);
        $this->assertStringContainsString('text="You need admin access to delete this workspace." placement="top" size="multi"', $tooltipExamples);
        $this->assertStringContainsString('.ui-tooltip-content', $buttonCss);
        $this->assertStringContainsString('.ui-tooltip-caret', $buttonCss);
        $this->assertStringContainsString('max-inline-size: 13rem;', $buttonCss);
        $this->assertStringContainsString('max-inline-size: 18rem;', $buttonCss);
        $this->assertStringContainsString('max-inline-size: 11rem;', $buttonCss);
        $this->assertStringContainsString('width: 0.375rem;', $buttonCss);
        $this->assertStringContainsString('initTooltips', $tooltipsJs);
        $this->assertStringContainsString('aria-describedby', $tooltipsJs);
        $this->assertStringContainsString("event.key !== 'Escape'", $tooltipsJs);
        $this->assertStringContainsString('window.innerWidth < 640', $tooltipsJs);
        $this->assertStringContainsString('fitsViewport', $tooltipsJs);
        $this->assertStringContainsString('export { initTooltips }', $uiControlsJs);
        $this->assertStringContainsString('initTooltips', $appJs);
        $this->assertStringContainsString("'live_examples_view' => 'platform.ui-reference.components.live-examples.tooltip'", $catalog);
        $this->assertStringContainsString('Tooltip now uses a component-owned overlay surface with caret, sizing, placement, alignment, accessible description, and hover/focus/Escape behavior.', $catalog);
        $this->assertStringContainsString('Caret tip', $tooltipStandard);
    }

    public function test_date_picker_component_page_renders_installed_api_examples(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/components/date-picker')
            ->assertOk()
            ->assertSee('x-ui.date-picker')
            ->assertSee('Native single date')
            ->assertSee('Date-time')
            ->assertSee('Validation date')
            ->assertSee('Disabled and read-only dates')
            ->assertSee('Range picker boundary')
            ->assertSee('Required date')
            ->assertSee('Bounded date')
            ->assertSee('Minute step')
            ->assertSee('Warning state')
            ->assertSee('Pattern-owned range')
            ->assertSee('data-ui-component="date-picker"', false)
            ->assertSee('data-ui-date-picker-type="date"', false)
            ->assertSee('data-ui-date-picker-type="datetime-local"', false)
            ->assertSee('aria-invalid="true"', false)
            ->assertSee('data-ui-field-warning="true"', false)
            ->assertSee('readonly', false)
            ->assertSee('disabled', false)
            ->assertSee('ui-input-date', false)
            ->assertSee('Date range filter Pattern')
            ->assertDontSee('Component-specific API pending correction')
            ->assertDontSee('Family-depth implementation pending');
    }

    public function test_deferred_component_pages_show_trigger_conditions_instead_of_complete_ui(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $expectations = [
            'ai-label' => ['Do not implement', 'AI label is not implemented until an approved AI-assisted feature exists', 'Trigger only when a product AI decision record approves AI-assisted behavior'],
        ];

        foreach ($expectations as $slug => $needles) {
            $response = $this->get('/platform/ui-reference/components/'.$slug)
                ->assertOk()
                ->assertSee('data-ui-reference-sample-type="deferred"', false)
                ->assertSee('Trigger conditions')
                ->assertSee('Variants for this example')
                ->assertDontSee('Family-depth implementation pending');

            foreach ($needles as $needle) {
                $response->assertSee($needle);
            }
        }
    }

    public function test_content_switcher_component_page_renders_installed_api_examples(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/components/content-switcher')
            ->assertOk()
            ->assertSee('x-ui.content-switcher')
            ->assertSee('Peer view switcher')
            ->assertSee('Icon view switcher')
            ->assertSee('Toolbar mode switcher')
            ->assertSee('Default')
            ->assertSee('Compact')
            ->assertSee('Disabled option')
            ->assertSee('No panel mode')
            ->assertSee('data-ui-component="content-switcher"', false)
            ->assertSee('data-ui-content-switcher', false)
            ->assertSee('data-ui-content-switcher-option', false)
            ->assertSee('data-ui-content-switcher-panel', false)
            ->assertSee('data-ui-content-switcher-size="sm"', false)
            ->assertSee('role="tablist"', false)
            ->assertSee('role="tab"', false)
            ->assertSee('role="tabpanel"', false)
            ->assertSee('aria-selected="true"', false)
            ->assertSee('disabled', false)
            ->assertDontSee('data-ui-reference-sample-type="deferred"', false)
            ->assertDontSee('Content switcher remains deferred')
            ->assertDontSee('No public API approved');

        $componentView = file_get_contents(resource_path('views/components/ui/content-switcher.blade.php'));
        $tabsView = file_get_contents(resource_path('views/components/ui/tabs.blade.php'));
        $componentCss = file_get_contents(resource_path('css/app.css'));
        $componentScript = file_get_contents(resource_path('js/ui-controls/content-switchers.js'));
        $uiControls = file_get_contents(resource_path('js/ui-controls.js'));
        $appJs = file_get_contents(resource_path('js/app.js'));
        $catalog = file_get_contents(app_path('Platform/UiReference/UiReferenceComponentDepthCatalog.php'));
        $standard = file_get_contents(base_path('docs/02-standards/ui/components/content-switcher.md'));

        $this->assertStringContainsString('data-ui-content-switcher', $componentView);
        $this->assertStringContainsString('data-ui-content-switcher-option', $componentView);
        $this->assertStringContainsString('data-ui-content-switcher-panel', $componentView);
        $this->assertStringContainsString('role="tablist"', $componentView);
        $this->assertStringContainsString('(int) $index === $selectedIndex', $componentView);
        $this->assertStringContainsString('(int) $index === $selectedIndex', $tabsView);
        $this->assertStringContainsString('.ui-content-switcher-option', $componentCss);
        $this->assertStringContainsString('--ui-content-switcher-background', $componentCss);
        $this->assertStringContainsString('--ui-content-switcher-selected', $componentCss);
        $this->assertStringContainsString('initContentSwitchers(root = document)', $componentScript);
        $this->assertStringContainsString('initializeSelectedOption(switcherRoot, list)', $componentScript);
        $this->assertStringContainsString('uiContentSwitcherInitialized', $componentScript);
        $this->assertStringContainsString('export { initContentSwitchers }', $uiControls);
        $this->assertStringContainsString('initContentSwitchers', $appJs);
        $this->assertStringContainsString('\'content-switcher\' => $this->contentSwitcherComponent()', $catalog);
        $this->assertStringContainsString('x-ui.content-switcher', $standard);
    }

    public function test_checkbox_component_page_renders_installed_api_examples(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/components/checkbox')
            ->assertOk()
            ->assertSee('x-ui.checkbox / x-ui.checkbox-group')
            ->assertSee('Independent choice')
            ->assertSee('Multi-select group')
            ->assertSee('States')
            ->assertSee('Group states')
            ->assertSee('Nested group')
            ->assertSee('Overflow and alignment')
            ->assertSee('Multiline single label')
            ->assertSee('data-checkbox-alignment-example="multiline-single"', false)
            ->assertSee('data-component-live-layout="checkbox-matrix"', false)
            ->assertSee('data-ui-checkbox-group', false)
            ->assertSee('data-ui-checkbox-nested-group', false)
            ->assertSee('data-ui-checkbox-parent', false)
            ->assertSee('data-ui-checkbox-child', false)
            ->assertSee('data-ui-checkbox-input', false)
            ->assertSee('aria-checked="mixed"', false)
            ->assertDontSee('Selected and unselected')
            ->assertDontSee('Component-specific API pending correction')
            ->assertDontSee('Family-depth implementation pending');

        $checkboxView = file_get_contents(resource_path('views/components/ui/checkbox.blade.php'));
        $checkboxGroupView = file_get_contents(resource_path('views/components/ui/checkbox-group.blade.php'));
        $checkboxExamples = file_get_contents(resource_path('views/platform/ui-reference/components/live-examples/checkbox.blade.php'));
        $checkboxCss = file_get_contents(resource_path('css/app.css'));
        $checkboxScript = file_get_contents(resource_path('js/ui-controls/checkboxes.js'));
        $uiControls = file_get_contents(resource_path('js/ui-controls.js'));
        $appJs = file_get_contents(resource_path('js/app.js'));
        $catalog = file_get_contents(app_path('Platform/UiReference/UiReferenceComponentDepthCatalog.php'));
        $standard = file_get_contents(base_path('docs/02-standards/ui/components/checkbox.md'));

        $this->assertStringContainsString('data-ui-checkbox-input', $checkboxView);
        $this->assertStringContainsString('data-ui-checkbox-root', $checkboxView);
        $this->assertStringContainsString('ui-checkbox-status-icon', $checkboxView);
        $this->assertStringContainsString('h-4 w-4 shrink-0', $checkboxView);
        $this->assertStringContainsString('data-ui-checkbox-nested-group', $checkboxGroupView);
        $this->assertStringContainsString('data-ui-checkbox-parent', $checkboxGroupView);
        $this->assertStringContainsString('data-ui-checkbox-child', $checkboxGroupView);
        $this->assertStringContainsString('ui-checkbox-status-icon', $checkboxGroupView);
        $this->assertStringContainsString('h-4 w-4 shrink-0', $checkboxGroupView);
        $checkboxGroupOptionsPosition = strpos($checkboxGroupView, '<div class="ui-checkbox-group-options">');
        $checkboxGroupHelperPosition = strpos($checkboxGroupView, 'class="ui-checkbox-group-helper"');

        $this->assertNotFalse($checkboxGroupOptionsPosition);
        $this->assertNotFalse($checkboxGroupHelperPosition);
        $this->assertLessThan($checkboxGroupHelperPosition, $checkboxGroupOptionsPosition);
        $this->assertStringContainsString('data-component-live-layout="checkbox-matrix"', $checkboxExamples);
        $this->assertStringContainsString('data-checkbox-alignment-example="multiline-single"', $checkboxExamples);
        $this->assertStringContainsString('Indeterminate appears only as a parent state', $checkboxExamples);
        $this->assertStringContainsString('.ui-checkbox-input:indeterminate + .ui-checkbox-box', $checkboxCss);
        $this->assertStringContainsString('border-radius: 0.125rem', $checkboxCss);
        $this->assertStringContainsString('--ui-checkbox-disabled-border: color-mix(in srgb, var(--ui-border-disabled) 70%, var(--ui-action-disabled-bg))', $checkboxCss);
        $this->assertStringContainsString('background-color: var(--ui-checkbox-disabled-background)', $checkboxCss);
        $this->assertStringContainsString('--ui-checkbox-disabled-text: color-mix(in srgb, var(--ui-text-disabled) 45%, var(--ui-background))', $checkboxCss);
        $this->assertStringContainsString('.ui-checkbox[data-ui-checkbox-focus=\'true\'] .ui-checkbox-box', $checkboxCss);
        $this->assertStringContainsString('.ui-checkbox-readonly .ui-checkbox-input:checked + .ui-checkbox-box', $checkboxCss);
        $this->assertStringContainsString('.ui-checkbox-group.ui-checkbox-invalid .ui-checkbox-box', $checkboxCss);
        $this->assertStringNotContainsString('.ui-checkbox-control:hover .ui-checkbox-box', $checkboxCss);
        $this->assertStringContainsString('export function initCheckboxes(root = document)', $checkboxScript);
        $this->assertStringContainsString('syncParentFromChildren(group, parentRoot)', $checkboxScript);
        $this->assertStringContainsString('syncChildrenFromParent(group, parentRoot)', $checkboxScript);
        $this->assertStringContainsString('data-ui-checkbox-focus', $checkboxScript);
        $this->assertStringContainsString('export { initCheckboxes }', $uiControls);
        $this->assertStringContainsString('initCheckboxes', $appJs);
        $this->assertStringContainsString('\'checkbox\' => $this->checkboxComponent()', $catalog);
        $this->assertStringContainsString('initCheckboxes exported from resources/js/ui-controls/checkboxes.js', $catalog);
        $this->assertStringContainsString('Parent/child indeterminate', $standard);
    }

    public function test_popover_component_page_renders_interactive_tip_and_trigger_examples(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/components/popover')
            ->assertOk()
            ->assertSee('x-ui.popover')
            ->assertSee('No tip')
            ->assertSee('Caret tip')
            ->assertSee('Tab tip')
            ->assertSee('Placement options')
            ->assertSee('Overflow content')
            ->assertSee('Text trigger')
            ->assertSee('Ghost trigger')
            ->assertSee('Hover trigger')
            ->assertSee('Focus trigger')
            ->assertSee('Disabled trigger')
            ->assertSee('data-ui-component="popover"', false)
            ->assertSee('data-ui-popover-tip="none"', false)
            ->assertSee('data-ui-popover-tip="caret"', false)
            ->assertSee('data-ui-popover-tip="tab"', false)
            ->assertSee('data-ui-popover-trigger-kind="icon"', false)
            ->assertSee('data-ui-popover-trigger-kind="button"', false)
            ->assertSee('data-ui-popover-trigger-kind="ghost"', false)
            ->assertSee('data-ui-popover-interaction="hover"', false)
            ->assertSee('data-ui-popover-interaction="focus"', false)
            ->assertSee('data-ui-popover-content', false)
            ->assertSee('aria-expanded="false"', false)
            ->assertDontSee('Context popover')
            ->assertDontSee('Placement and size');

        $popoverView = file_get_contents(resource_path('views/components/ui/popover.blade.php'));
        $popoverScript = file_get_contents(resource_path('js/ui-controls/popovers.js'));
        $popoverCss = file_get_contents(resource_path('css/app.css'));
        $catalog = file_get_contents(app_path('Platform/UiReference/UiReferenceComponentDepthCatalog.php'));
        $standard = file_get_contents(base_path('docs/02-standards/ui/components/popover.md'));

        $this->assertStringContainsString("'tip' => 'caret'", $popoverView);
        $this->assertStringContainsString("'triggerKind' => 'icon'", $popoverView);
        $this->assertStringContainsString("'interaction' => 'click'", $popoverView);
        $this->assertStringContainsString('data-ui-popover-tip="{{ $resolvedTip }}"', $popoverView);
        $this->assertStringContainsString('data-ui-popover-content', $popoverView);
        $this->assertStringContainsString('data-ui-popover-tip-shape', $popoverView);
        $this->assertStringContainsString("interaction === 'hover'", $popoverScript);
        $this->assertStringContainsString("interaction === 'focus'", $popoverScript);
        $this->assertStringContainsString(".ui-popover[data-ui-popover-tip='tab'] .ui-popover-tip", $popoverCss);
        $this->assertStringContainsString('overflow-y-auto', $popoverCss);
        $this->assertStringContainsString("'No tip'", $catalog);
        $this->assertStringContainsString("'Caret tip'", $catalog);
        $this->assertStringContainsString("'Tab tip'", $catalog);
        $this->assertStringContainsString('Trigger button options', $standard);
    }

    public function test_component_api_proof_sync_pages_render_installed_apis(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $expectations = [
            'contained-list' => [
                'x-ui.contained-list',
                'data-ui-component="contained-list"',
                'data-ui-component="contained-list-item"',
                'Basic contained list',
                'Contained list states',
                'Selected row',
                'Actionable row',
                'Loading',
                'Empty',
            ],
            'list' => [
                'Native ul/ol/li with ui-list classes',
                'ui-list ui-list-unordered',
                'ui-list ui-list-ordered',
                'ui-list-nested',
                'Ordered list',
                'Unordered list',
                'Nested boundary',
                'Content-only guidance',
            ],
            'multiselect' => [
                'x-ui.multiselect',
                'data-ui-component="multiselect"',
                'data-ui-multiselect-option',
                'data-ui-multiselect-filter',
                'data-ui-multiselect-clear',
                'Filterable multiselect',
                'Validation multiselect',
                'Disabled and loading multiselect',
                'Select all',
            ],
            'popover' => [
                'x-ui.popover',
                'data-ui-component="popover"',
                'data-ui-popover-trigger',
                'data-ui-popover-panel',
                'data-ui-popover-close',
                'No tip',
                'Caret tip',
                'Tab tip',
                'Placement options',
                'Overflow content',
            ],
            'slider' => [
                'x-ui.slider',
                'x-ui.range-slider',
                'data-ui-component="slider"',
                'data-ui-component="range-slider"',
                'data-ui-slider-input',
                'data-ui-slider-value',
                'data-ui-slider-thumb',
                'data-ui-slider-state',
                'Single-value slider',
                'Range slider',
                'Validation slider',
            ],
            'tree-view' => [
                'x-ui.tree-view',
                'data-ui-component="tree-view"',
                'data-ui-tree-node',
                'data-ui-tree-expanded',
                'data-ui-tree-selected',
                'data-ui-tree-active',
                'Basic tree view',
                'Disabled tree item',
                'Expanded branch',
                'Selected leaf',
            ],
        ];

        foreach ($expectations as $slug => $needles) {
            $response = $this->get('/platform/ui-reference/components/'.$slug)
                ->assertOk()
                ->assertSee('data-component-card="live-examples"', false)
                ->assertSee('data-component-section="developer-code-example"', false)
                ->assertDontSee('Component-specific API pending correction')
                ->assertDontSee('data-ui-reference-sample-type="deferred"', false)
                ->assertDontSee('Family-depth implementation pending');

            foreach ($needles as $needle) {
                $response->assertSee($needle, false);
            }
        }
    }

    public function test_remaining_component_recovery_pages_render_canonical_api_proof(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $expectations = [
            'link' => [
                'x-ui.link',
                'data-ui-component="link"',
                'Inline content link',
                'External/help link',
                'Icon trailing',
                'Visited policy',
                'aria-disabled="true"',
                'data-ui-link-visited-policy',
            ],
            'pagination' => [
                'x-ui.pagination',
                'data-ui-component="pagination"',
                'data-ui-pagination-page-size',
                'Full pagination',
                'Compact pagination',
                'Page-size selector',
                'Disabled prev/next',
            ],
            'search' => [
                'x-ui.search',
                'data-ui-component="search"',
                'data-ui-search-input',
                'Page search',
                'Table search',
                'Clear action',
                'Loading/no-results',
            ],
            'dropdown' => [
                'x-ui.dropdown',
                'data-ui-component="dropdown"',
                'data-ui-dropdown-trigger',
                'data-ui-dropdown-option',
                'Long known-option handoff',
                'Validation selection',
            ],
            'file-uploader' => [
                'x-ui.file-uploader',
                'data-ui-component="file-uploader"',
                'data-ui-file-uploader',
                'Button upload',
                'File validation',
                'Drag-drop deferred',
            ],
            'number-input' => [
                'x-ui.number-input',
                'data-ui-component="number-input"',
                'Min/max/step',
                'Increment/decrement',
                'Compact/fluid',
            ],
            'select' => [
                'x-ui.select',
                'data-ui-component="select"',
                'data-ui-select',
                'Short native selection',
                'Validation selection',
            ],
            'radio-button' => [
                'x-ui.radio-button / x-ui.radio-group',
                'data-ui-component="radio-group"',
                'data-ui-component="radio-button"',
                'Vertical radio group',
                'Horizontal radio group',
            ],
            'toggle' => [
                'x-ui.toggle',
                'data-ui-component="toggle"',
                'data-ui-toggle',
                'Immediate setting',
                'Disabled setting',
            ],
            'inline-loading' => [
                'x-ui.inline-loading',
                'data-ui-component="inline-loading"',
                'data-ui-inline-loading-status',
                'Button/action pending',
                'Local save pending',
            ],
            'progress-bar' => [
                'x-ui.progress-bar',
                'data-ui-component="progress-bar"',
                'role="progressbar"',
                'Determinate progress',
                'Success/error completion',
            ],
            'progress-indicator' => [
                'x-ui.progress-indicator / x-ui.progress-step',
                'data-ui-component="progress-indicator"',
                'data-ui-component="progress-step"',
                'Step flow',
                'Current/completed/error step',
            ],
            'tag' => [
                'x-ui.tag',
                'data-ui-component="tag"',
                'Metadata tag',
                'Status tag',
                'Filter/removable tag',
                'Semantic tag',
            ],
            'structured-list' => [
                'x-ui.structured-list / x-ui.structured-list-row',
                'data-ui-component="structured-list"',
                'data-ui-component="structured-list-row"',
                'Default structured list',
                'Selectable structured list',
                'Condensed list',
            ],
            'tile' => [
                'x-ui.tile',
                'data-ui-component="tile"',
                'Static tile',
                'Clickable tile',
                'Selectable tile',
            ],
            'tooltip' => [
                'x-ui.tooltip',
                'data-ui-component="tooltip"',
                'data-ui-tooltip-trigger',
                'data-ui-tooltip-content',
                'Icon-only button tooltip',
                'Definition tooltip',
            ],
            'toggletip' => [
                'x-ui.toggletip',
                'data-ui-component="toggletip"',
                'data-ui-toggletip-trigger',
                'data-ui-toggletip-panel',
                'data-ui-toggletip-close',
                'Contextual help',
                'Dismissible rich help',
            ],
            'checkbox' => [
                'x-ui.checkbox / x-ui.checkbox-group',
                'data-ui-checkbox-group',
                'data-ui-checkbox-nested-group',
                'initCheckboxes exported from resources/js/ui-controls/checkboxes.js',
                'Independent choice',
                'Multi-select group',
                'Nested group',
                'Group states',
            ],
            'text-input' => [
                'Native input[type=text/email/password/search/url/tel] with ui-field and ui-text-input classes',
                'data-ui-component="text-input"',
                'ui-text-input',
                'Login form field',
                'Validation field',
            ],
            'data-table' => [
                'x-ui.data-table',
                'data-ui-data-table',
                'Basic sortable table',
                'Filterable table',
                'Responsive overflow',
            ],
            'loading' => [
                'Native status markup with ui-loading / ui-spinner / ui-skeleton classes',
                'data-ui-component="loading"',
                'ui-loading',
                'ui-spinner',
                'Skeleton text/card/table',
            ],
            'modal' => [
                'x-ui.modal',
                'data-ui-component="modal-preview"',
                'Confirmation dialog',
                'Form modal',
                'Destructive action',
            ],
            'notification' => [
                'x-ui.inline-alert / x-ui.toast',
                'data-ui-component="inline-alert"',
                'Form validation error',
                'Record saved',
                'API failure',
            ],
        ];

        foreach ($expectations as $slug => $needles) {
            $response = $this->get('/platform/ui-reference/components/'.$slug)
                ->assertOk()
                ->assertSee('data-component-card="live-examples"', false)
                ->assertSee('data-component-section="developer-code-example"', false)
                ->assertDontSee('Component-specific API pending correction')
                ->assertDontSee('Use the component owner route and app CSS classes documented here')
                ->assertDontSee('Family-depth implementation pending');

            foreach ($needles as $needle) {
                $response->assertSee($needle, false);
            }
        }
    }

    public function test_batch_f_button_variant_and_action_label_guidance_is_documented(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/components/actions')
            ->assertOk()
            ->assertSee('data-ui-guidance="action-usage"', false)
            ->assertSee('data-guidance-id="P2-F-CQ-008"', false)
            ->assertSee('G-ACT-01')
            ->assertSee('G-ACT-02')
            ->assertSee('G-ACT-03')
            ->assertSee('G-ACT-04')
            ->assertSee('G-ACT-05')
            ->assertSee('standard filled treatment')
            ->assertSee('soft')
            ->assertSee('ghost')
            ->assertSee('outline')
            ->assertSee('danger semantic')
            ->assertSee('G-LABEL-01')
            ->assertSee('G-LABEL-06')
            ->assertSee('Apply when the user stays on the same page')
            ->assertSee('Delete, Archive, Disable, or Remove')
            ->assertSee('data-ui-reference-example="button-variant-contract"', false)
            ->assertSee('data-ui-reference-example="button-state-contract"', false)
            ->assertSee('data-ui-implementation-guide="actions"', false)
            ->assertSee('&lt;x-ui.button semantic=&quot;primary&quot;&gt;Save Workspace&lt;/x-ui.button&gt;', false)
            ->assertSee('&lt;x-ui.button semantic=&quot;notice&quot; variant=&quot;soft&quot;&gt;Queue Review&lt;/x-ui.button&gt;', false)
            ->assertSee('&lt;x-ui.icon-button label=&quot;Open filters&quot;&gt;...&lt;/x-ui.icon-button&gt;', false)
            ->assertSee('x-ui.patterns.dropdown-action-menu')
            ->assertSee('One primary action');

        $this->get('/platform/ui-reference/patterns/navigation')
            ->assertOk()
            ->assertSee('data-ui-guidance="page-action-hierarchy"', false)
            ->assertSee('data-ui-reference-example="t2-action-composition"', false)
            ->assertSee('G-ACT-01')
            ->assertSee('G-LABEL-01')
            ->assertSee('G-LABEL-03')
            ->assertSee('G-LABEL-06')
            ->assertSee('the page title row keeps one primary action')
            ->assertSee('Page-header actions')
            ->assertSee('Filter actions stay on page')
            ->assertSee('Form action bar')
            ->assertSee('Row action overflow');
    }

    public function test_batch_f_form_field_and_selection_control_guidance_is_documented(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/components/forms')
            ->assertOk()
            ->assertSee('data-ui-guidance="form-field-standards"', false)
            ->assertSee('data-guidance-id="P2-F-CQ-010"', false)
            ->assertSee('G-FORM-01')
            ->assertSee('G-FORM-02')
            ->assertSee('G-FORM-03')
            ->assertSee('G-FORM-04')
            ->assertSee('error, warning, disabled, read-only, and focused states')
            ->assertSee('data-ui-guidance="selection-control-usage"', false)
            ->assertSee('G-SEL-01')
            ->assertSee('G-SEL-02')
            ->assertSee('G-SEL-03')
            ->assertSee('Select / combo box / multi-select')
            ->assertSee('Example Warning Field')
            ->assertSee('workspace-subdomain-warning', false)
            ->assertSee('data-ui-reference-example="form-field-state-contract"', false)
            ->assertSee('data-ui-reference-example="selection-control-contract"', false)
            ->assertSee('data-ui-implementation-guide="forms"', false)
            ->assertSee('Component Field Reference Matrix')
            ->assertSee('Button file uploader')
            ->assertSee('Searchable select / combo')
            ->assertSee('Queued gap: multi-select component')
            ->assertSee('x-ui.searchable-select')
            ->assertSee('ui-input')
            ->assertSee('ui-switch');

        $this->get('/platform/ui-reference/patterns/forms')
            ->assertOk()
            ->assertSee('data-ui-guidance="form-pattern-usage"', false)
            ->assertSee('data-ui-reference-example="t2-form-composition"', false)
            ->assertSee('P2-F-CQ-010')
            ->assertSee('submit validation belongs in the form-level summary')
            ->assertSee('short exclusive choices stay visible as radio options')
            ->assertSee('Settings-style form section')
            ->assertSee('Compact account/profile form')
            ->assertSee('Validation summary + field error')
            ->assertSee('Form action bar');
    }

    public function test_batch_f_notification_badge_and_feedback_guidance_is_documented(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/components/status')
            ->assertOk()
            ->assertSee('data-ui-guidance="badge-feedback-semantics"', false)
            ->assertSee('data-guidance-id="P2-F-CQ-009"', false)
            ->assertSee('G-BADGE-01')
            ->assertSee('G-BADGE-02')
            ->assertSee('G-BADGE-03')
            ->assertSee('G-BADGE-04')
            ->assertSee('text-first')
            ->assertSee('do not adopt Carbon visual tokens')
            ->assertSee('data-ui-reference-example="badge-status-contract"', false)
            ->assertSee('data-ui-implementation-guide="feedback-status"', false)
            ->assertSee('Base semantic badges')
            ->assertSee('Outline + no-icon states')
            ->assertSee('Inline status for dense rows')
            ->assertSee('List context')
            ->assertSee('x-ui.badge')
            ->assertSee('x-ui.status');

        $this->get('/platform/ui-reference/patterns/overlays-feedback')
            ->assertOk()
            ->assertSee('data-ui-guidance="notification-feedback-usage"', false)
            ->assertSee('data-ui-reference-example="feedback-surface-contract"', false)
            ->assertSee('data-ui-reference-example="toast-stacking-contract"', false)
            ->assertSee('data-ui-reference-example="notification-center-handoff"', false)
            ->assertSee('data-ui-implementation-guide="feedback"', false)
            ->assertSee('P2-F-CQ-009')
            ->assertSee('G-NOTIF-01')
            ->assertSee('G-NOTIF-02')
            ->assertSee('G-NOTIF-03')
            ->assertSee('G-NOTIF-04')
            ->assertSee('G-NOTIF-05')
            ->assertSee('Stack toasts from newest to oldest')
            ->assertSee('AJAX feedback should not imply a full page refresh')
            ->assertSee('Persisted notifications belong in the notification center')
            ->assertSee('Form validation feedback')
            ->assertSee('Table/list feedback')
            ->assertSee('Page-level callout/banner')
            ->assertSee('Persisted notification handoff');
    }

    public function test_batch_f_broader_data_navigation_overlay_loading_and_input_guidance_is_documented(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/patterns/tables')
            ->assertOk()
            ->assertSee('data-ui-guidance="table-pagination-usage"', false)
            ->assertSee('data-ui-reference-example="table-pagination-contract"', false)
            ->assertSee('data-ui-implementation-guide="tables-pagination"', false)
            ->assertSee('G-TABLE-01')
            ->assertSee('G-TABLE-02')
            ->assertSee('G-TABLE-03')
            ->assertSee('G-PAGIN-01')
            ->assertSee('G-PAGIN-02')
            ->assertSee('Basic read-only table')
            ->assertSee('Selectable row + overflow action')
            ->assertSee('Table skeleton while loading')
            ->assertSee('Pagination placement');

        $this->get('/platform/ui-reference/patterns/navigation')
            ->assertOk()
            ->assertSee('data-ui-guidance="navigation-search-overflow-usage"', false)
            ->assertSee('data-ui-reference-example="navigation-search-contract"', false)
            ->assertSee('data-ui-implementation-guide="navigation-search-overflow"', false)
            ->assertSee('G-TABS-01')
            ->assertSee('G-TABS-02')
            ->assertSee('G-SEARCH-01')
            ->assertSee('G-SEARCH-02')
            ->assertSee('G-OVERFLOW-01')
            ->assertSee('G-OVERFLOW-02')
            ->assertSee('G-BREADCRUMB-01')
            ->assertSee('G-BREADCRUMB-02')
            ->assertSee('Line tabs for peer sections')
            ->assertSee('Contained tabs for dense panels')
            ->assertSee('Page search + known filters')
            ->assertSee('Breadcrumb with middle overflow');

        $this->get('/platform/ui-reference/patterns/overlays-feedback')
            ->assertOk()
            ->assertSee('data-ui-guidance="overlay-loading-usage"', false)
            ->assertSee('data-ui-reference-example="overlay-loading-contract"', false)
            ->assertSee('data-ui-implementation-guide="overlays-loading"', false)
            ->assertSee('G-MODAL-01')
            ->assertSee('G-MODAL-02')
            ->assertSee('G-MODAL-03')
            ->assertSee('G-TOOLTIP-01')
            ->assertSee('G-TOOLTIP-02')
            ->assertSee('G-LOAD-01')
            ->assertSee('G-LOAD-02')
            ->assertSee('Modal variants')
            ->assertSee('Tooltip vs toggletip')
            ->assertSee('Inline loading')
            ->assertSee('Skeleton loading');

        $this->get('/platform/ui-reference/components/forms')
            ->assertOk()
            ->assertSee('data-ui-guidance="input-file-date-usage"', false)
            ->assertSee('data-ui-reference-example="input-file-date-contract"', false)
            ->assertSee('data-ui-implementation-guide="inputs-file-date"', false)
            ->assertSee('G-INPUT-01')
            ->assertSee('G-INPUT-02')
            ->assertSee('G-FILEUP-01')
            ->assertSee('G-FILEUP-02')
            ->assertSee('G-DATEPICK-01')
            ->assertSee('G-DATEPICK-02')
            ->assertSee('Default width input')
            ->assertSee('Fluid search input')
            ->assertSee('Button file uploader')
            ->assertSee('Date picker family')
            ->assertSee('Queued gap: calendar range control');

        $this->get('/platform/ui-reference/patterns/data-content')
            ->assertOk()
            ->assertSee('data-ui-guidance="structured-list-tile-usage"', false)
            ->assertSee('data-ui-reference-example="structured-list-tile-contract"', false)
            ->assertSee('data-ui-implementation-guide="structured-list-tile"', false)
            ->assertSee('G-STRLIST-01')
            ->assertSee('G-STRLIST-02')
            ->assertSee('G-TILE-01')
            ->assertSee('G-TILE-02')
            ->assertSee('Structured list for compact comparison')
            ->assertSee('Selectable structured list')
            ->assertSee('Tile variants')
            ->assertSee('Queued component gaps');

        $this->get('/platform/ui-reference/patterns/layout')
            ->assertOk()
            ->assertSee('data-ui-guidance="grid-layout-usage"', false)
            ->assertSee('data-ui-reference-example="grid-layout-contract"', false)
            ->assertSee('data-ui-implementation-guide="grid-layout"', false)
            ->assertSee('G-GRID-01')
            ->assertSee('G-GRID-02')
            ->assertSee('Standard page-section grid')
            ->assertSee('Dashboard grid and widget span model');
    }

    public function test_starter_catalog_route_is_discoverable_and_maps_batch_f_starters(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/patterns/starters')
            ->assertOk()
            ->assertSee('Starter Catalog')
            ->assertSee('P2-F-CQ-007')
            ->assertSee('Module Home / Module Overview')
            ->assertSee('Settings Page')
            ->assertSee('Account / Profile Editable')
            ->assertSee('Content Browser / Split View')
            ->assertSee('Blocked / Empty / Unavailable')
            ->assertSee('UI Reference Route Disposition Matrix')
            ->assertSee('data-ui-reference-starter-catalog', false)
            ->assertSee('data-route-disposition-matrix', false)
            ->assertSee('data-starter-route="/platform/ui-reference/patterns/starters/module-home"', false)
            ->assertSee('/platform/ui-reference/patterns/starters/empty-unavailable')
            ->assertSee('/platform/ui-reference/patterns/widget-content/{size}')
            ->assertSee('P2-F-CQ-002')
            ->assertSee('P2-F-CQ-003')
            ->assertSee('P2-F-CQ-004')
            ->assertSee('P2-F-CQ-005')
            ->assertSee('Keep and extend')
            ->assertSee('Add');
    }

    public function test_layout_reference_surface_includes_dashboard_customization_proof(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/patterns/layout')
            ->assertOk()
            ->assertSee('Dashboard customization proof')
            ->assertSee('Saved per-user layout')
            ->assertSee('Customize proof')
            ->assertSee('Hidden widget tray')
            ->assertSee('Saved layout preview')
            ->assertSee('Watch the insertion line and swap target before dropping.')
            ->assertSee('data-dashboard-proof-demo', false)
            ->assertSee('data-dashboard-proof-main-content', false)
            ->assertSee('data-dashboard-proof-support', false)
            ->assertSee('data-dashboard-proof-widget-card', false)
            ->assertSee('data-dashboard-reorder-surface', false)
            ->assertSee('data-dashboard-proof-saved-layout', false)
            ->assertSee('data-dashboard-proof-saved-layout-card', false)
            ->assertSee('x-bind:data-dashboard-proof-widget-span="widget.span"', false)
            ->assertSee('Header content')
            ->assertSee('Body content')
            ->assertSee('dashboard-proof-grid', false)
            ->assertSee('ui-pattern-widget-shell', false)
            ->assertDontSee('ui-soft-card', false)
            ->assertDontSee('ui-soft-card-neutral', false)
            ->assertDontSee('ui-soft-card-success', false)
            ->assertDontSee('ui-soft-card-notice', false)
            ->assertDontSee('ui-soft-card-danger', false)
            ->assertSee('data-dashboard-proof-widget', false);

        $proofScript = file_get_contents(resource_path('js/dashboard-proof-demo.js'));

        $this->assertIsString($proofScript);
        $this->assertStringContainsString('dashboard-proof-widget-span-1x2', $proofScript);
        $this->assertStringContainsString('dashboard-proof-widget-span-2x1', $proofScript);
        $this->assertStringContainsString('dashboard-proof-widget-span-2x2', $proofScript);
        $this->assertStringContainsString('dashboard-proof-widget-span-3x1', $proofScript);
        $this->assertStringContainsString('dashboard-proof-widget-span-3x2', $proofScript);
        $this->assertStringContainsString('ui-reference.dashboard-proof-layout.v2', $proofScript);
        $this->assertStringNotContainsString("tone: 'success'", $proofScript);
        $this->assertStringNotContainsString("tone: 'notice'", $proofScript);
        $this->assertStringNotContainsString("tone: 'danger'", $proofScript);
        $this->assertStringNotContainsString('ui-soft-card', $proofScript);
    }

    public function test_widget_content_reference_surface_includes_size_aware_allowances(): void
    {
        $this->actingAsPlatformSuperAdmin();
        $this->useActiveBatchReviewIds(['P2-B-CQ-023']);

        $this->get('/platform/ui-reference/patterns/widget-content')
            ->assertOk()
            ->assertSee('Active Batch Review')
            ->assertSee('P2-B-CQ-023')
            ->assertSee('Widget Content Standards')
            ->assertSee('Geometry decision')
            ->assertSee('Four-unit dashboard model')
            ->assertSee('18rem one-row baseline')
            ->assertSee('No implicit 3x full row')
            ->assertSee('Viewport review baseline')
            ->assertSee('1024px')
            ->assertSee('1280px')
            ->assertSee('1366px')
            ->assertSee('1440px')
            ->assertSee('1920px')
            ->assertSee('Content-space unit system')
            ->assertSee('Pixel budget')
            ->assertSee('Size-standard pages')
            ->assertSee('data-widget-geometry-decision', false)
            ->assertSee('data-widget-viewport-baseline', false)
            ->assertSee('data-widget-content-unit-system', false)
            ->assertSee('data-widget-px-budget', false)
            ->assertSee('data-widget-size-navigation', false)
            ->assertSee('data-widget-size-nav-item="shape-map"', false)
            ->assertSee('data-widget-size-nav-item="3x3"', false)
            ->assertDontSee('Filled widget size examples')
            ->assertDontSee('Allowance matrix')
            ->assertDontSee('Negative boundary')
            ->assertDontSee('3x1 Full Row')
            ->assertDontSee('3x2 Tall Surface')
            ->assertDontSee('md:auto-rows-[minmax(11rem,auto)]', false);

        $css = file_get_contents(resource_path('css/app.css'));
        $dashboardGrid = file_get_contents(resource_path('views/components/ui/patterns/dashboard-grid.blade.php'));

        $this->assertIsString($css);
        $this->assertIsString($dashboardGrid);
        $this->assertStringContainsString("xl:grid-cols-4", $dashboardGrid);
        $this->assertStringNotContainsString("xl:grid-cols-6", $dashboardGrid);
        $this->assertStringContainsString('--ui-dashboard-grid-row-size: 18rem', $css);
        $this->assertStringContainsString('--ui-dashboard-grid-row-size: 24rem', $css);
        $this->assertStringContainsString('grid-auto-rows: var(--ui-dashboard-grid-row-size)', $css);
        $this->assertStringContainsString('.dashboard-proof-widget-span-1x2', $css);
        $this->assertStringContainsString('.ui-pattern-widget-span-1x2', $css);
        $this->assertStringContainsString('block-size: calc((var(--ui-dashboard-grid-row-size) * 2) + var(--ui-dashboard-grid-gap))', $css);
        $this->assertStringContainsString('block-size: var(--ui-dashboard-grid-row-size)', $css);
        $this->assertStringContainsString('.ui-pattern-widget-span-3x3', $css);
        $this->assertStringNotContainsString('grid-auto-rows: minmax(11rem, auto)', $css);
    }

    public function test_widget_content_size_pages_are_accessible(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $sizes = ['shape-map', '1x1', '2x1', '1x2', '2x2', '3x1', '3x2', '3x3', '4x0-5'];

        foreach ($sizes as $size) {
            $response = $this->get('/platform/ui-reference/patterns/widget-content/'.$size);
            $response->assertOk();

            if ($size === 'shape-map') {
                $response->assertSee('data-widget-shape-map', false);
                $response->assertSee('data-widget-composition-matrix', false);
            } else {
                $response->assertSee('data-widget-size-page="'.$size.'"', false);
                $response->assertSee('data-widget-size-module-scaffold="'.$size.'"', false);
            }
        }

        $this->get('/platform/ui-reference/patterns/widget-content/invalid-size')
            ->assertNotFound();

        $css = file_get_contents(resource_path('css/app.css'));
        $this->assertStringContainsString('.ui-pattern-widget-span-3x3', $css);
    }

    public function test_standard_users_cannot_view_ui_reference_workspace(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/platform/ui-reference')
            ->assertForbidden();
    }

    public function test_non_super_admin_users_with_docs_permission_still_cannot_view_ui_reference_workspace(): void
    {
        $user = User::factory()->create();

        $this->seed(PlatformRolesAndPermissionsSeeder::class);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permission = Permission::findByName('platform.docs.view', 'web');
        $user->givePermissionTo($permission);

        $this->actingAs($user)
            ->get('/platform/ui-reference')
            ->assertForbidden();
    }

    public function test_authorized_users_can_load_audit_sample_payload(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->getJson('/platform/ui-reference/audit-logs/user-update')
            ->assertOk()
            ->assertJsonPath('event_type', 'platform.user.updated')
            ->assertJsonPath('result', 'success')
            ->assertJsonPath('route', 'platform.users.update');
    }

    public function test_authorized_users_can_load_error_sample_payload(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->getJson('/platform/ui-reference/error-logs/queue-timeout')
            ->assertOk()
            ->assertJsonPath('exception_class', 'RuntimeException')
            ->assertJsonPath('severity', 'error')
            ->assertJsonPath('route', 'queue:work');
    }

    public function test_unknown_demo_samples_return_not_found(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/audit-logs/not-real')->assertNotFound();
        $this->get('/platform/ui-reference/error-logs/not-real')->assertNotFound();
    }
}
