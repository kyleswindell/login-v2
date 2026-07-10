{{-- ==========================================================================
    File: Modules/Account/resources/views/profile/index.blade.php
    Purpose: Account profile page.

    Notes:
    - Uses route/page tabs from the app layout for account page navigation.
    - Uses x-patterns.account.section-tabs for local in-page profile sections.
    - Keeps edit forms in focused modal dialogs.
    ========================================================================== --}}

@php
    $initials = collect(preg_split('/\s+/', trim($user->name)) ?: [])
        ->filter()
        ->map(fn (string $part) => mb_strtoupper(mb_substr($part, 0, 1)))
        ->take(2)
        ->implode('');

    $accountDetailsErrors = $errors->getBag('accountDetails');
    $profilePhotoErrors = $errors->getBag('profilePhoto');
    $contactEmailErrors = $errors->getBag('contactEmail');

    $profilePanelData = [
        'user' => $user,
        'contactEmails' => $contactEmails,
        'profileImageUrl' => $profileImageUrl,
        'initials' => $initials,
        'accountDetailsErrors' => $accountDetailsErrors,
        'profilePhotoErrors' => $profilePhotoErrors,
        'contactEmailErrors' => $contactEmailErrors,
    ];

    $profilePanels = [
        [
            'key' => 'details',
            'id' => 'account-profile-details-tab',
            'panel_id' => 'account-profile-details-panel',
            'label' => 'Details',
            'selected' => true,
            'view' => 'account::partials.profile.profile',
            'data' => $profilePanelData,
        ],
        [
            'key' => 'contact-methods',
            'id' => 'account-contact-methods-tab',
            'panel_id' => 'account-contact-methods-panel',
            'label' => 'Contact methods',
            'view' => 'account::partials.profile.contact-methods',
            'data' => $profilePanelData,
        ],
    ];
@endphp

<x-layouts.app
    grid
    title="Profile"
    page-title="Profile"
    page-subtitle="Review your account identity, profile photo, and contact methods."
    :tab-items="$accountTabs"
    tabs-label="Account pages"
>
    <x-ui.grid-column
        tag="section"
        span="100"
        lg="16"
        xlg="14"
        max="12"
        data-account-profile-page
    >
        <x-ui.v-stack :gap="6">
            @if (session("success"))
                <x-ui.notification.inline
                    kind="success"
                    title="Profile updated"
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
                id="account-profile-tabs"
                label="Profile sections"
                :panels="$profilePanels"
                orientation="vertical"
                variant="contained"
                data-account-profile-tabs
            />
        </x-ui.v-stack>

        @include ("account::partials.profile.modals",
            [
                "user" => $user,
                "profileImageUrl" => $profileImageUrl,
                "initials" => $initials,
                "accountDetailsErrors" => $accountDetailsErrors,
                "profilePhotoErrors" => $profilePhotoErrors,
                "contactEmailErrors" => $contactEmailErrors
            ])
    </x-ui.grid-column>
</x-layouts.app>
