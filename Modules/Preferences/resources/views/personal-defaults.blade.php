@php
    use Illuminate\Support\HtmlString;

    $timezoneLabel = collect($timezoneOptions)->firstWhere('value', $user->timezone)['label'] ?? ($user->timezone ?: 'Not set');
    $languageLabel = collect($localeOptions)->firstWhere('value', $user->default_language)['label'] ?? ($user->default_language ?: 'Not set');
    $themeLabels = [
        'system' => 'System',
        'dark' => 'Dark',
        'light' => 'Light',
    ];
    $themeLabel = $themeLabels[$user->theme_preference ?? 'system'] ?? 'System';

    $personalDefaultsTabs = [
        [
            'id' => 'account-preferences-personal-defaults-tab',
            'panel_id' => 'account-preferences-personal-defaults-panel',
            'label' => 'Personal defaults',
            'panel_title' => null,
            'selected' => true,
            'panel' => new HtmlString(view('preferences::partials.personal-defaults', [
                'timezoneLabel' => $timezoneLabel,
                'languageLabel' => $languageLabel,
                'themeLabel' => $themeLabel,
            ])->render()),
        ],
    ];
@endphp

<x-layouts.app
    grid
    title="Preferences"
    page-title="Preferences"
    page-subtitle="Review your personal timezone, language, and theme defaults."
    :tab-items="$accountTabs"
    tabs-label="Account pages"
>
    <x-ui.grid-column
        tag="section"
        span="100"
        lg="12"
        xlg="10"
        max="8"
        data-account-preferences-page
    >
        <x-ui.grid subgrid row-gap>
            @if (session('success'))
                <x-ui.grid-column span="100">
                    <x-ui.notification.inline kind="success" title="Preferences saved">
                        {{ session('success') }}
                    </x-ui.notification.inline>
                </x-ui.grid-column>
            @endif

            @if ($errors->any())
                <x-ui.grid-column span="100">
                    <x-patterns.validation-summary :errors="$errors->all()" />
                </x-ui.grid-column>
            @endif

            <x-ui.grid-column span="100">
                <x-ui.tabs
                    id="account-preferences-tabs"
                    label="Preference sections"
                    :tabs="$personalDefaultsTabs"
                    orientation="vertical"
                    variant="line"
                    grid-aware
                    data-account-preferences-tabs
                />
            </x-ui.grid-column>
        </x-ui.grid>

        @include('preferences::partials.modals.edit-personal-defaults', [
            'user' => $user,
            'timezoneOptions' => $timezoneOptions,
            'localeOptions' => $localeOptions,
            'preferenceErrors' => $errors,
        ])
    </x-ui.grid-column>
</x-layouts.app>
