{{-- ==========================================================================
    File: resources/views/components/layouts/app.blade.php
    Purpose: Global application layout shell.

    Notes:
    - Owns document shell, theme boot payload, app shell data, navigation data,
      notification data, authenticated/guest layout branching, and app content
      grid configuration handoff.
    - Does not render the grid wrapper directly. Authenticated and guest main
      partials decide where the app content grid is placed.
    - Grid is enabled by default. Pages that opt out must do so explicitly.
      Grid-enabled pages render direct slot children as x-ui.grid-column.
    - Frame, header, and head partials do not own page grid behavior.
    ========================================================================== --}}

@props ([
    "title" => null,
    "documentTitle" => null,
    "appShell" => null,

    "sidebarContext" => null,
    "sideNav" => [],
    "sideNavId" => null,
    "sideNavLabel" => null,
    "sideNavAreaTitle" => null,
    "sideNavExpanded" => null,
    "sideNavFixed" => null,
    "sideNavPersistent" => null,
    "mainContentId" => "app-main",

    "pageTitle" => null,
    "pageSubtitle" => null,
    "breadcrumbs" => [],
    "tabItems" => [],
    "tabsLabel" => null,
    "reservePageTabs" => true,

    "headerVariant" => "default",
    "headerLabel" => null,
    "brandHref" => null,
    "brandPrefix" => null,
    "brandName" => null,
    "showHeaderSearch" => true,
    "showHeaderNotifications" => true,
    "showHeaderSwitcher" => false,

    "grid" => true,
    "gridFullWidth" => false,
    "gridRowGap" => true,
    "gridMode" => "default",
    "gridAlign" => null,
])

@php
    /*
    |--------------------------------------------------------------------------
    | App Shell Data
    |--------------------------------------------------------------------------
    */

    $user = auth()->user();

    $appShell = is_array($appShell)
        ? $appShell
        : app(\App\Platform\Shell\AppShellData::class)->forUser($user);

    $user = $appShell['user'] ?? $user;
    $navigation = $appShell['navigation'] ?? [];

    $activeArea = is_array($appShell['activeArea'] ?? null)
        ? $appShell['activeArea']
        : [
            'key' => 'dashboard',
            'label' => 'Dashboard',
        ];

    /*
    |--------------------------------------------------------------------------
    | Theme Boot
    |--------------------------------------------------------------------------
    */

    $themeMode = $appShell['themeMode'] ?? $user?->theme_preference ?? 'system';

    $themeMode = in_array($themeMode, ['system', 'dark', 'light'], true)
        ? $themeMode
        : 'system';

    $themeBootPayload = json_encode([
        'mode' => $themeMode,
    ], JSON_THROW_ON_ERROR);

    /*
    |--------------------------------------------------------------------------
    | Header Data
    |--------------------------------------------------------------------------
    */

    $headerNavigation = $appShell['headerNavigation'] ?? [];
    $headerGlobalActions = $appShell['headerGlobalActions'] ?? [];

    $showHeaderSearch = filter_var($showHeaderSearch, FILTER_VALIDATE_BOOLEAN);
    $showHeaderNotifications = filter_var($showHeaderNotifications, FILTER_VALIDATE_BOOLEAN);
    $showHeaderSwitcher = filter_var($showHeaderSwitcher, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | Notification Data
    |--------------------------------------------------------------------------
    */

    $canViewNotifications = (bool) ($appShell['canViewNotifications'] ?? false);
    $realtimeNotificationsEnabled = (bool) ($appShell['realtimeNotificationsEnabled'] ?? false);
    $unreadNotifications = (int) ($appShell['unreadNotifications'] ?? 0);
    $recentNotifications = $appShell['recentNotifications'] ?? [];
    $notificationRoutes = $appShell['notificationRoutes'] ?? [];

    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    */

    $primaryBaseNavigation = $navigation['primaryBase'] ?? [];
    $primaryAdminNavigation = $navigation['primaryAdmin'] ?? [];
    $logsNavigation = $navigation['logs'] ?? [];
    $setupBaseNavigation = $navigation['setupBase'] ?? [];
    $setupAdminNavigation = $navigation['setupAdmin'] ?? [];

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    */

    $hasCustomSidebar = isset($sidebar) && trim((string) $sidebar) !== '';
    $sideNav = is_array($sideNav) ? $sideNav : [];

    $sideNavId = $sideNavId ?? ($sideNav['id'] ?? 'app-side-nav');

    $sideNavAreaTitle = $sideNavAreaTitle
        ?? ($sideNav['areaTitle'] ?? ($activeArea['label'] ?? 'Dashboard'));

    $sideNavLabel = $sideNavLabel
        ?? ($sideNav['label'] ?? "{$sideNavAreaTitle} navigation");

    $sideNavExpanded = ! is_null($sideNavExpanded)
        ? (bool) $sideNavExpanded
        : (bool) ($sideNav['expanded'] ?? true);

    $sideNavFixed = ! is_null($sideNavFixed)
        ? (bool) $sideNavFixed
        : (bool) ($sideNav['fixed'] ?? true);

    $sideNavPersistent = ! is_null($sideNavPersistent)
        ? (bool) $sideNavPersistent
        : (bool) ($sideNav['persistent'] ?? true);

    /*
    |--------------------------------------------------------------------------
    | Document / Branding
    |--------------------------------------------------------------------------
    */

    $headerLabel = $headerLabel ?? config('app.name', 'Application');
    $brandHref = $brandHref ?? ($user ? route('dashboard') : url('/'));
    $brandName = $brandName ?? config('app.name', 'Application');

    $documentTitle = $documentTitle ?? $title ?? config('app.name');
    $title = $documentTitle;

    /*
    |--------------------------------------------------------------------------
    | Sidebar Context
    |--------------------------------------------------------------------------
    */

    $sidebarContext = $sidebarContext
        ?? (request()->routeIs('platform.setup.*', 'platform.settings.*') ? 'setup' : 'primary');

    /*
    |--------------------------------------------------------------------------
    | Page Header Data
    |--------------------------------------------------------------------------
    */

    $breadcrumbs = is_iterable($breadcrumbs) ? $breadcrumbs : [];
    $tabItems = is_iterable($tabItems) ? $tabItems : [];

    $tabsLabel = filled($tabsLabel)
        ? $tabsLabel
        : 'Page sections';

    $reservePageTabs = filter_var($reservePageTabs, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | App Content Grid
    |--------------------------------------------------------------------------
    |
    | These variables are consumed by authenticated-main.blade.php and
    | guest-main.blade.php. The grid wrapper belongs inside the main content
    | region, not around the full app shell.
    |
    | Grid-enabled pages should render x-ui.grid-column as direct slot children.
    |
    */

    $usesGrid = filter_var($grid, FILTER_VALIDATE_BOOLEAN);
    $usesGridFullWidth = filter_var($gridFullWidth, FILTER_VALIDATE_BOOLEAN);
    $usesGridRowGap = filter_var($gridRowGap, FILTER_VALIDATE_BOOLEAN);

    $gridMode = is_string($gridMode) && in_array($gridMode, ['default', 'narrow', 'condensed'], true)
        ? $gridMode
        : 'default';

    $gridAlign = is_string($gridAlign) && in_array($gridAlign, ['start', 'end'], true)
        ? $gridAlign
        : null;
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include ("components.layouts.app.partials.head")

<body
    @class ([
        "min-h-screen antialiased",
        "has-auth-shell" => (bool) $user
    ])
    data-theme-update-url="{{ $user ? route('platform.account.preferences.update') : '' }}"
    data-sidebar-context="{{ $sidebarContext }}"
    data-ui-app-grid-enabled="{{ $usesGrid ? 'true' : 'false' }}"
    data-ui-app-grid-full-width="{{ $usesGridFullWidth ? 'true' : 'false' }}"
    data-ui-app-grid-row-gap="{{ $usesGridRowGap ? 'true' : 'false' }}"
    data-ui-app-grid-mode="{{ $gridMode }}"
    data-ui-app-grid-align="{{ $gridAlign ?? 'auto' }}"
>
    <div class="min-h-screen">
        {{-- ----------------------------------------------------------------
            Authenticated / guest shell branch
            ----------------------------------------------------------------
            Authenticated and guest main partials own placement of the
            x-ui.grid wrapper when the grid prop is enabled.
            ---------------------------------------------------------------- --}}

        @if ($user)
            @include ("components.layouts.app.partials.header")
            @include ("components.layouts.app.partials.header-panels")
            @include ("components.layouts.app.partials.authenticated-main")
        @else
            @include ("components.layouts.app.partials.guest-main")
        @endif
    </div>

    {{-- --------------------------------------------------------------------
        Scripts
        -------------------------------------------------------------------- --}}

    @livewireScripts
    @stack ("scripts")
</body>
</html>
