{{-- ==========================================================================
    File: Modules/Account/resources/views/security/index.blade.php
    Purpose: Account security page.

    Notes:
    - Uses route/page tabs from the app layout for account page navigation.
    - Uses x-patterns.account.section-tabs for local in-page security sections.
    - Keeps password updates in a focused modal dialog.
    ========================================================================== --}}

@php
    $passwordErrors = $errors->getBag('passwordUpdate');

    $securityPanelData = [
        'user' => $user,
        'hasMfa' => $hasMfa,
        'passwordErrors' => $passwordErrors,
    ];

    $securityPanels = [
        [
            'key' => 'overview',
            'id' => 'account-security-overview-tab',
            'panel_id' => 'account-security-overview-panel',
            'label' => 'Overview',
            'selected' => true,
            'view' => 'account::partials.security.overview',
            'data' => $securityPanelData,
        ],
        [
            'key' => 'password',
            'id' => 'account-security-password-tab',
            'panel_id' => 'account-security-password-panel',
            'label' => 'Password',
            'view' => 'account::partials.security.password',
            'data' => $securityPanelData,
        ],
        [
            'key' => 'mfa',
            'id' => 'account-security-mfa-tab',
            'panel_id' => 'account-security-mfa-panel',
            'label' => 'MFA',
            'secondary' => 'Authenticator app',
            'view' => 'account::partials.security.mfa',
            'data' => $securityPanelData,
        ],
    ];
@endphp

<x-layouts.app
    grid
    title="Security"
    page-title="Security"
    page-subtitle="Review password and multi-factor authentication controls for your account."
    :tab-items="$accountTabs"
    tabs-label="Account pages"
>
    <x-ui.grid-column
        tag="section"
        span="100"
        lg="16"
        xlg="14"
        max="12"
        data-account-security-page
    >
        <x-ui.v-stack :gap="6">
            @if (session("success"))
                <x-ui.notification.inline
                    kind="success"
                    title="Security updated"
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
                id="account-security-tabs"
                label="Security sections"
                :panels="$securityPanels"
                orientation="vertical"
                variant="contained"
                data-account-security-tabs
            />
        </x-ui.v-stack>

        @include ("account::partials.security.password-modal",
            [
                "passwordErrors" => $passwordErrors
            ])
    </x-ui.grid-column>
</x-layouts.app>
