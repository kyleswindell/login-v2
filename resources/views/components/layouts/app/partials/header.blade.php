{{-- ==========================================================================
    File: resources/views/components/layouts/app/partials/header.blade.php
    Purpose: Authenticated app header composition.

    Notes:
    - Composes the app header, primary header navigation, and global actions.
    - Navigation data is prepared by the global app layout shell data.
    - Header actions own search and generic module action slots.
    - This partial normalizes route-backed and href-backed header items before
      rendering shell header primitives.
    ========================================================================== --}}

@php
    /*
    |--------------------------------------------------------------------------
    | Header Navigation
    |--------------------------------------------------------------------------
    */

    $headerNavigation = is_iterable($headerNavigation ?? null)
        ? $headerNavigation
        : [];

    /*
    |--------------------------------------------------------------------------
    | Header Link Resolution
    |--------------------------------------------------------------------------
    |
    | Header items may provide route or href. Route names are preferred when
    | present and registered. Missing routes fall back to href so partial shell
    | data does not break header rendering.
    |
    */

    $resolveHeaderHref = static function (array $item): string {
        $route = $item['route'] ?? null;
        $parameters = $item['parameters'] ?? $item['routeParameters'] ?? [];

        if (is_string($route) && \Illuminate\Support\Facades\Route::has($route)) {
            return route($route, is_array($parameters) ? $parameters : []);
        }

        return $item['href'] ?? '#';
    };

    /*
    |--------------------------------------------------------------------------
    | Header Current-State Resolution
    |--------------------------------------------------------------------------
    |
    | current can be supplied directly by AppShellData. Otherwise active route
    | patterns or the route name itself are used.
    |
    */

    $resolveHeaderCurrent = static function (array $item): bool {
        if (array_key_exists('current', $item)) {
            return (bool) $item['current'];
        }

        $active = array_values((array) ($item['active'] ?? []));

        if ($active !== []) {
            return request()->routeIs(...$active);
        }

        $route = $item['route'] ?? null;

        return is_string($route) && request()->routeIs($route);
    };

    /*
    |--------------------------------------------------------------------------
    | Wire Navigate Resolution
    |--------------------------------------------------------------------------
    */

    $resolveWireNavigate = static function (array $item): bool {
        $value = $item['wireNavigate'] ?? true;

        if (is_bool($value)) {
            return $value;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? true;
    };
@endphp

<x-layouts.app.frame.header
    :variant="$headerVariant"
    :label="$headerLabel"
    :side-nav-id="$sideNavId"
    :brand-href="$brandHref"
    :brand-prefix="$brandPrefix"
    :brand-name="$brandName"
>
    {{-- ----------------------------------------------------------------------
        Primary header navigation
        ---------------------------------------------------------------------- --}}
    @forelse ($headerNavigation as $item)
        @php
            $item = is_array($item) ? $item : [];
            $href = $resolveHeaderHref($item);
            $label = $item['label'] ?? '';
            $current = $resolveHeaderCurrent($item);
            $wireNavigate = $resolveWireNavigate($item);
        @endphp

        <x-shell.header.menu-item
            :href="$href"
            :current="$current"
            :wire-navigate="$wireNavigate"
        >
            {{ $label }}
        </x-shell.header.menu-item>
    @empty
        <x-shell.header.menu-item :href="$brandHref" current wire-navigate>
            {{ $brandName }}
        </x-shell.header.menu-item>
    @endforelse

    {{-- ----------------------------------------------------------------------
        Header global actions
        ---------------------------------------------------------------------- --}}
    <x-slot:actions>
        <x-layouts.app.frame.header.actions
            :show-search="$showHeaderSearch"
            :show-switcher="$showHeaderSwitcher"
            :header-global-actions="$headerGlobalActions"
        />
    </x-slot:actions>
</x-layouts.app.frame.header>
