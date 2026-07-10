<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class AppShellStructureTest extends TestCase
{
    public function test_active_app_shell_files_exist(): void
    {
        foreach ([
            'resources/views/components/layouts/app.blade.php',
            'resources/views/components/layouts/app/partials/head.blade.php',
            'resources/views/components/layouts/app/partials/header.blade.php',
            'resources/views/components/layouts/app/partials/header-panels.blade.php',
            'resources/views/components/layouts/app/partials/authenticated-main.blade.php',
            'resources/views/components/layouts/app/partials/guest-main.blade.php',
            'resources/views/components/layouts/app/frame/header/index.blade.php',
            'resources/views/components/layouts/app/frame/sidebar.blade.php',
            'resources/views/components/layouts/app/frame/nav-link.blade.php',
            'resources/views/components/layouts/app/frame/header/actions.blade.php',
            'resources/views/components/layouts/app/frame/header/panels.blade.php',
            'resources/views/components/layouts/app/frame/header/search.blade.php',
            'Modules/Account/resources/views/header/action.blade.php',
            'Modules/Notifications/resources/views/header/action.blade.php',
        ] as $path) {
            $this->assertFileExists($this->basePath($path));
        }
    }

    public function test_stale_shell_blade_files_are_removed(): void
    {
        foreach ([
            'resources/views/components/layouts/app/account-menu.blade.php',
            'resources/views/components/layouts/app/notification-menu.blade.php',
            'resources/views/components/layouts/app/realtime-notifications.blade.php',
            'resources/views/components/layouts/app/shell-header-actions.blade.php',
            'resources/views/components/layouts/app/sidebar.blade.php',
            'resources/views/components/app/header/notifications-menu.blade.php',
            'resources/views/components/layouts/mobile-sidebar.blade.php',
            'resources/views/components/layouts/app/head.blade.php',
            'resources/views/components/layouts/app/header.blade.php',
            'resources/views/components/layouts/app/authenticated-main.blade.php',
            'resources/views/components/layouts/app/guest-main.blade.php',
            'resources/views/components/layouts/app/shell-header-panels.blade.php',
            'resources/views/components/app/header.blade.php',
            'resources/views/components/app/sidebar.blade.php',
            'resources/views/components/app/nav-link.blade.php',
            'resources/views/components/layouts/app/frame/header/account-menu.blade.php',
            'resources/views/components/app/header/index.blade.php',
            'resources/views/components/app/header/docs.php',
        ] as $path) {
            $this->assertFileDoesNotExist($this->basePath($path));
        }
    }

    public function test_app_js_uses_current_shell_initializers(): void
    {
        $appJs = file_get_contents($this->basePath('resources/js/app.js'));

        $this->assertIsString($appJs);
        $this->assertStringNotContainsString('./setup-sidebar', $appJs);
        $this->assertStringNotContainsString('./shell-ui', $appJs);
        $this->assertStringNotContainsString('initSidebarToggle', $appJs);
        $this->assertStringNotContainsString('initNotificationMenus', $appJs);
        $this->assertStringNotContainsString('initAccountMenu', $appJs);
        $this->assertStringNotContainsString('initMobileSidebarDock', $appJs);
        $this->assertStringContainsString('initDocsTree', $appJs);
        $this->assertStringContainsString('initUiShell', $appJs);
        $this->assertStringContainsString('initSideNavs', $appJs);
        $this->assertStringContainsString('initAppHeaderSearch', $appJs);
        $this->assertStringContainsString('initAppHeaderNotifications', $appJs);
    }

    public function test_shell_css_uses_split_entrypoint(): void
    {
        $componentsCss = file_get_contents($this->basePath('resources/css/components/index.css'));

        $this->assertIsString($componentsCss);
        $this->assertStringContainsString('@import "./ui-shell/index.css";', $componentsCss);
        $this->assertFileDoesNotExist($this->basePath('resources/css/backup-app.css'));
        $this->assertFileDoesNotExist($this->basePath('resources/css/components/ui-shell.css'));
        $this->assertFileDoesNotExist($this->basePath('resources/css/components/ui-shell.monolith.backup.css'));
    }

    private function basePath(string $path = ''): string
    {
        $basePath = dirname(__DIR__, 2);

        return $path === '' ? $basePath : $basePath.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $path);
    }
}
