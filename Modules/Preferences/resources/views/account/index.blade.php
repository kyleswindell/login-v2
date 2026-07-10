{{-- ==========================================================================
    File: Modules/Preferences/resources/views/account/index.blade.php
    Purpose: Account preferences page.

    Notes:
    - Uses route/page tabs from the app layout for account page navigation.
    - Uses x-patterns.account.section-tabs for local preference sections.
    - Suppresses local tab chrome when only one panel is supplied.
    ========================================================================== --}}

@php
    $timezoneLabel = collect($timezoneOptions)->firstWhere('value', $user->timezone)['label']
        ?? ($user->timezone ?: 'Not set');

    $languageLabel = collect($localeOptions)->firstWhere('value', $user->default_language)['label']
        ?? ($user->default_language ?: 'Not set');

    $themeLabels = [
        'system' => 'System',
        'dark' => 'Dark',
        'light' => 'Light',
    ];

    $themeLabel = $themeLabels[$user->theme_preference ?? 'system'] ?? 'System';

    $preferencePanels = [
        [
            'key' => 'personal-defaults',
            'id' => 'account-preferences-personal-defaults-tab',
            'panel_id' => 'account-preferences-personal-defaults-panel',
            'label' => 'Personal defaults',
            'selected' => true,
            'view' => 'preferences::partials.personal-defaults',
            'data' => [
                'timezoneLabel' => $timezoneLabel,
                'languageLabel' => $languageLabel,
                'themeLabel' => $themeLabel,
            ],
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
        lg="16"
        xlg="14"
        max="12"
        data-account-preferences-page
    >
        <x-ui.v-stack :gap="6">
            @if (session("success"))
                <x-ui.notification.inline
                    kind="success"
                    title="Preferences saved"
                >
                    {{
                        session(
                            "success",
                        )
                    }}
                </x-ui.notification.inline>
            @endif

            @if ($errors->any())
                <x-patterns.validation-summary :errors="$errors->all()" />
            @endif

            <x-patterns.account.section-tabs
                id="account-preferences-tabs"
                label="Preference sections"
                :panels="$preferencePanels"
                data-account-preferences-tabs
            />
        </x-ui.v-stack>

        @include ("preferences::partials.modals.edit-personal-defaults",
            [
                "user" => $user,
                "timezoneOptions" => $timezoneOptions,
                "localeOptions" => $localeOptions,
                "preferenceErrors" => $errors
            ])
    </x-ui.grid-column>
</x-layouts.app>
