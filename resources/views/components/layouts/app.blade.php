@props(['title' => null])
@php($bootThemeMode = auth()->user()?->theme_preference)
@php($bootThemeMode = in_array($bootThemeMode, ['system', 'dark', 'light'], true) ? $bootThemeMode : 'system')
@php($themeBootPayload = json_encode(['mode' => $bootThemeMode], JSON_THROW_ON_ERROR))

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('components.layouts.app.head')
    <body
        @class([
            'min-h-screen antialiased',
            'has-auth-shell' => auth()->check(),
        ])
        data-theme-update-url="{{ auth()->check() ? route('platform.account.preferences.update') : '' }}"
        data-sidebar-context="{{ request()->routeIs('platform.setup.*', 'platform.settings.*') ? 'setup' : 'primary' }}"
    >
        @php($user = auth()->user())
        @php($hasCustomSidebar = isset($sidebar))
        @inject('platformNavigation', \App\Platform\Navigation\PlatformNavigation::class)
        @php($unreadNotificationCount = $user ? \App\Models\PlatformNotification::query()->visibleTo($user)->whereNull('read_at')->count() : 0)
        @php($recentNotifications = $user ? \App\Models\PlatformNotification::query()->visibleTo($user)->latest()->limit(5)->get() : collect())
        @php($realtimeNotificationsEnabled = $user && $user->can('platform.notifications.view'))
        @php($navigation = $platformNavigation->forUser($user))
        @php($accountNavigation = $navigation['account'])
        @php($primaryBaseNavigation = $navigation['primaryBase'] ?? [])
        @php($primaryAdminNavigation = $navigation['primaryAdmin'] ?? [])
        @php($logsNavigation = $navigation['logs'] ?? [])
        @php($setupBaseNavigation = $navigation['setupBase'] ?? [])
        @php($setupAdminNavigation = $navigation['setupAdmin'] ?? [])

        <div class="min-h-screen">
            @include('components.layouts.app.realtime-notifications')

            @if ($user)
                @include('components.layouts.app.header')
                @include('components.layouts.app.authenticated-main')
            @else
                @include('components.layouts.app.guest-main')
            @endif
        </div>
        @livewireScripts
    </body>
</html>
