{{-- ==========================================================================
    File: resources/views/components/layouts/app/frame/sidebar.blade.php
    Purpose: Application sidebar navigation composition.

    Notes:
    - Composes the Shell Side Nav component with app navigation data.
    - Navigation arrays are prepared upstream by AppShellData and passed through
      the global app layout.
    - If slot content is provided, the slot fully replaces generated navigation.
    - This component resolves route-backed navigation items into href/current
      state before rendering app or shell navigation primitives.
    ========================================================================== --}}

@props ([
    /*
|--------------------------------------------------------------------------
| Side Nav Shell
|--------------------------------------------------------------------------
*/

    "id" => "app-side-nav",
    "label" => "Application navigation",
    "areaTitle" => null,
    "expanded" => true,
    "fixed" => true,
    "persistent" => true,

    /*
|--------------------------------------------------------------------------
| Navigation Groups
|--------------------------------------------------------------------------
*/

    "primaryBaseNavigation" => [],
    "primaryAdminNavigation" => [],
    "logsNavigation" => [],
    "setupBaseNavigation" => [],
    "setupAdminNavigation" => [],
])

@php
    /*
    |--------------------------------------------------------------------------
    | Navigation URL Resolution
    |--------------------------------------------------------------------------
    |
    | Navigation items may provide either:
    | - route: named Laravel route
    | - href: explicit URL fallback
    |
    | Route names are preferred when they exist. Missing routes fall back to href
    | so partially configured navigation does not break the shell render.
    |
    */

    $resolveHref = static function (array $item): string {
        $route = $item['route'] ?? null;

        if (is_string($route) && \Illuminate\Support\Facades\Route::has($route)) {
            return route($route);
        }

        return $item['href'] ?? '#';
    };

    /*
    |--------------------------------------------------------------------------
    | Navigation Current-State Resolution
    |--------------------------------------------------------------------------
    |
    | active accepts one or more route patterns and takes precedence over route.
    | When active is empty, the route name itself is used for current-state
    | matching.
    |
    */

    $resolveCurrent = static function (array $item): bool {
        $active = array_values((array) ($item['active'] ?? []));

        if ($active !== []) {
            return request()->routeIs(...$active);
        }

        $route = $item['route'] ?? null;

        return is_string($route) && request()->routeIs($route);
    };

    /*
    |--------------------------------------------------------------------------
    | Navigation Link View Model
    |--------------------------------------------------------------------------
    |
    | Converts raw navigation item arrays into the normalized shape consumed by
    | app and shell navigation primitives.
    |
    */

    $renderLink = static function (array $item) use ($resolveHref, $resolveCurrent): array {
        return [
            'href' => $resolveHref($item),
            'current' => $resolveCurrent($item),
            'label' => $item['label'] ?? '',
            'icon' => $item['icon'] ?? null,
            'wireNavigate' => $item['wireNavigate'] ?? true,
        ];
    };

    /*
    |--------------------------------------------------------------------------
    | Slot Override Detection
    |--------------------------------------------------------------------------
    |
    | Custom sidebar slot content replaces the generated navigation tree.
    |
    */

    $hasSlotContent = trim((string) $slot) !== '';
@endphp

<x-shell.side-nav
    :id="$id"
    :label="$label"
    :expanded="$expanded"
    :fixed="$fixed"
    :persistent="$persistent"
    {{ $attributes }}
>
    @if ($hasSlotContent)
        {{-- ------------------------------------------------------------------
            Custom sidebar content
            ------------------------------------------------------------------ --}}
        {{ $slot }}
    @else
        {{-- ------------------------------------------------------------------
            Generated sidebar navigation
            ------------------------------------------------------------------ --}}
        @if (filled($areaTitle))
            <x-shell.side-nav.header :expanded="$expanded">
                <span data-app-sidebar-area-title>{{ $areaTitle }}</span>
            </x-shell.side-nav.header>
        @endif

        <x-shell.side-nav.items>
            {{-- --------------------------------------------------------------
                Primary base navigation
                -------------------------------------------------------------- --}}
            @foreach ($primaryBaseNavigation as $item)
                @php ($link = $renderLink($item))

                <x-layouts.app.frame.nav-link
                    :href="$link['href']"
                    :current="$link['current']"
                    :wire-navigate="$link['wireNavigate']"
                    :icon="$link['icon']"
                >
                    {{ $link["label"] }}
                </x-layouts.app.frame.nav-link>
            @endforeach

            {{-- --------------------------------------------------------------
                Primary admin and logs navigation
                -------------------------------------------------------------- --}}
            @if (count($primaryAdminNavigation) > 0 || count($logsNavigation) > 0)
                <x-shell.side-nav.divider />

                @foreach ($primaryAdminNavigation as $item)
                    @php ($link = $renderLink($item))

                    <x-layouts.app.frame.nav-link
                        :href="$link['href']"
                        :current="$link['current']"
                        :wire-navigate="$link['wireNavigate']"
                        :icon="$link['icon']"
                    >
                        {{ $link["label"] }}
                    </x-layouts.app.frame.nav-link>
                @endforeach

                @if (count($logsNavigation) > 0)
                    @php ($logsActive = collect($logsNavigation)->contains( fn(array $item): bool => $resolveCurrent($item) ))

                    <x-shell.side-nav.menu
                        title="Logs"
                        :active="$logsActive"
                        :expanded="$logsActive"
                    >
                        @foreach ($logsNavigation as $item)
                            @php ($link = $renderLink($item))

                            <x-shell.side-nav.menu-item
                                :href="$link['href']"
                                :current="$link['current']"
                                :wire-navigate="$link['wireNavigate']"
                            >
                                {{ $link["label"] }}
                            </x-shell.side-nav.menu-item>
                        @endforeach
                    </x-shell.side-nav.menu>
                @endif
            @endif

            {{-- --------------------------------------------------------------
                Setup navigation
                -------------------------------------------------------------- --}}
            @if (count($setupBaseNavigation) > 0 || count($setupAdminNavigation) > 0)
                @php ($setupItems = [ ...$setupBaseNavigation, ...$setupAdminNavigation ])
                @php ($setupActive = collect($setupItems)->contains( fn(array $item): bool => $resolveCurrent($item) ))

                <x-shell.side-nav.divider />

                <x-shell.side-nav.menu
                    title="Setup"
                    :active="$setupActive"
                    :expanded="$setupActive"
                >
                    @foreach ($setupItems as $item)
                        @php ($link = $renderLink($item))

                        <x-shell.side-nav.menu-item
                            :href="$link['href']"
                            :current="$link['current']"
                            :wire-navigate="$link['wireNavigate']"
                        >
                            {{ $link["label"] }}
                        </x-shell.side-nav.menu-item>
                    @endforeach
                </x-shell.side-nav.menu>
            @endif
        </x-shell.side-nav.items>
    @endif
</x-shell.side-nav>
