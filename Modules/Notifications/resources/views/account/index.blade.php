{{-- ==========================================================================
    File: Modules/Notifications/resources/views/account/index.blade.php
    Purpose: Account notification preferences page.

    Notes:
    - Uses route/page tabs from the app layout for account page navigation.
    - Uses x-patterns.account.section-tabs for local notification sections.
    - Suppresses local tab chrome when only one panel is supplied.
    ========================================================================== --}}

@php
    $digestValue = $preference->digest_frequency ?? 'never';
    $digestLabel = $digestOptions[$digestValue] ?? $digestValue;

    $notificationPanels = [
        [
            'key' => 'delivery-preferences',
            'id' => 'account-notifications-delivery-tab',
            'panel_id' => 'account-notifications-delivery-panel',
            'label' => 'Delivery preferences',
            'selected' => true,
            'view' => 'notifications::account.partials.delivery-preferences',
            'data' => [
                'preference' => $preference,
                'digestLabel' => $digestLabel,
                'digestItems' => $digestItems ?? [],
            ],
        ],
    ];
@endphp

<x-layouts.app
    grid
    title="Notifications"
    page-title="Notifications"
    page-subtitle="Review future email and digest delivery preferences for your account."
    :tab-items="$accountTabs"
    tabs-label="Account pages"
>
    <x-ui.grid-column
        tag="section"
        span="100"
        lg="16"
        xlg="14"
        max="12"
        data-account-notifications-page
    >
        <x-ui.v-stack :gap="6">
            @if (session("success"))
                <x-ui.notification.inline
                    kind="success"
                    title="Notification preferences saved"
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
                id="account-notifications-tabs"
                label="Notification sections"
                :panels="$notificationPanels"
                data-account-notifications-tabs
            />
        </x-ui.v-stack>

        @include ("notifications::account.partials.modals.edit-delivery-preferences",
            [
                "preference" => $preference,
                "digestItems" => $digestItems ?? [],
                "notificationPreferenceErrors" => $errors
            ])
    </x-ui.grid-column>
</x-layouts.app>
