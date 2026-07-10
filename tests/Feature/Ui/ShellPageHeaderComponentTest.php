<?php

declare(strict_types=1);

namespace Tests\Feature\Ui;

use App\Surfaces\Contracts\Repository;
use Illuminate\Support\Facades\Blade;
use Symfony\Component\Finder\Finder;
use Tests\TestCase;

class ShellPageHeaderComponentTest extends TestCase
{
    public function test_page_title_renders_title_block_api_with_new_markers(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-shell.page-title
                title="Users"
                subtitle="Manage account access."
                :items="$items"
            >
                <button type="button">Create user</button>
            </x-shell.page-title>
        BLADE, [
            'items' => [
                ['label' => 'Dashboard', 'href' => '/dashboard'],
                ['label' => 'Users', 'current' => true],
            ],
        ]);

        $this->assertStringContainsString('data-ui-component="shell-page-title"', $html);
        $this->assertStringContainsString('data-ui-shell-page-title', $html);
        $this->assertStringContainsString('ui-shell-page-title__title', $html);
        $this->assertStringContainsString('ui-shell-page-title__breadcrumb-link', $html);
        $this->assertStringContainsString('Create user', $html);
        $this->assertStringNotContainsString('data-ui-component="shell-page-header"', $html);
    }

    public function test_page_header_composes_page_title_and_route_page_tabs(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-shell.page-header
                title="Users"
                subtitle="Manage account access."
                :breadcrumb-items="$breadcrumbs"
                :tab-items="$tabs"
            />
        BLADE, [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'href' => '/dashboard'],
                ['label' => 'Users', 'current' => true],
            ],
            'tabs' => [
                ['label' => 'Overview', 'href' => '/users', 'current' => true],
                ['label' => 'Invitations', 'href' => '/users/invitations'],
            ],
        ]);

        $this->assertStringContainsString('data-ui-component="shell-page-header"', $html);
        $this->assertStringContainsString('data-ui-shell-page-header-page-title', $html);
        $this->assertStringContainsString('data-ui-component="shell-page-title"', $html);
        $this->assertStringContainsString('data-ui-component="shell-page-tabs"', $html);
        $this->assertStringContainsString('data-ui-shell-page-header-tabs="true"', $html);
        $this->assertStringContainsString('aria-current="page"', $html);
        $this->assertStringNotContainsString('role="tablist"', $html);
        $this->assertStringNotContainsString('role="tab"', $html);
    }

    public function test_page_header_composes_page_actions_inside_title_region(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-shell.content page-title="Users" page-subtitle="Manage account access.">
                <x-slot:pageActions>
                    <button type="button">Create user</button>
                </x-slot:pageActions>

                Body content
            </x-shell.content>
        BLADE);

        $this->assertStringContainsString('data-ui-shell-page-header-actions="true"', $html);
        $this->assertStringContainsString('data-ui-shell-page-title-actions="true"', $html);
        $this->assertStringContainsString('data-ui-shell-page-title-actions-region', $html);
        $this->assertStringContainsString('Create user', $html);
    }

    public function test_page_header_reserves_tabs_without_empty_nav(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-shell.page-header title="Users" />
        BLADE);

        $this->assertStringContainsString('data-ui-shell-page-header-tabs="false"', $html);
        $this->assertStringContainsString('data-ui-shell-page-header-reserve-tabs="true"', $html);
        $this->assertStringContainsString('data-ui-shell-page-header-tabs-spacer', $html);
        $this->assertStringNotContainsString('data-ui-component="shell-page-tabs"', $html);
        $this->assertStringNotContainsString('<nav', $html);
    }

    public function test_page_header_can_skip_reserved_tabs(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-shell.page-header title="Users" :reserve-tabs="false" />
        BLADE);

        $this->assertStringContainsString('data-ui-shell-page-header-tabs="false"', $html);
        $this->assertStringContainsString('data-ui-shell-page-header-reserve-tabs="false"', $html);
        $this->assertStringNotContainsString('data-ui-shell-page-header-tabs-spacer', $html);
        $this->assertStringNotContainsString('data-ui-component="shell-page-tabs"', $html);
    }

    public function test_shell_content_uses_composed_page_header_for_page_tabs(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-shell.content page-title="Users" :tab-items="$tabs">
                Body content
            </x-shell.content>
        BLADE, [
            'tabs' => [
                ['label' => 'Overview', 'href' => '/users', 'current' => true],
                ['label' => 'Invitations', 'href' => '/users/invitations'],
            ],
        ]);

        $this->assertStringContainsString('data-ui-component="shell-page-header"', $html);
        $this->assertStringContainsString('data-ui-component="shell-page-title"', $html);
        $this->assertStringContainsString('data-ui-component="shell-page-tabs"', $html);
        $this->assertStringContainsString('data-ui-shell-content-reserve-page-tabs="true"', $html);
        $this->assertSame(1, substr_count($html, 'data-ui-component="shell-page-tabs"'));
    }

    public function test_surface_repository_loads_shell_page_surfaces(): void
    {
        $repository = app(Repository::class);

        foreach (['ui-shell-page-title', 'ui-shell-page-header', 'ui-shell-page-tabs'] as $slug) {
            $contract = $repository->find('component', $slug);

            $this->assertIsArray($contract);
            $this->assertSame($slug, data_get($contract, 'identity.slug'));
            $this->assertSame('component', data_get($contract, 'identity.type'));
        }
    }

    public function test_active_authenticated_module_views_use_layout_page_header_instead_of_legacy_title_action_row(): void
    {
        $violations = [];

        foreach ($this->bladeFilesForShellPageTitleMigration() as $path) {
            $contents = file_get_contents($path);

            if (is_string($contents) && str_contains($contents, '<x-patterns.page-title-actions-row')) {
                $violations[] = str_replace(base_path().DIRECTORY_SEPARATOR, '', $path);
            }
        }

        $this->assertSame([], $violations);
    }

    /**
     * @return list<string>
     */
    private function bladeFilesForShellPageTitleMigration(): array
    {
        $roots = [
            base_path('Modules'),
            resource_path('views'),
        ];

        $files = [];

        foreach ($roots as $root) {
            if (! is_dir($root)) {
                continue;
            }

            foreach (Finder::create()->files()->name('*.blade.php')->ignoreUnreadableDirs()->in($root) as $file) {
                $path = $file->getPathname();
                $relative = str_replace('\\', '/', str_replace(base_path().DIRECTORY_SEPARATOR, '', $path));

                if (
                    str_starts_with($relative, 'Modules/Auth/')
                    || str_starts_with($relative, 'resources/views/platform/')
                ) {
                    continue;
                }

                $files[] = $path;
            }
        }

        sort($files);

        return $files;
    }
}
