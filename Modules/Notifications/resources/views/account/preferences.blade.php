@php
    use Illuminate\Support\HtmlString;

    $digestValue = $preference->digest_frequency ?? 'never';
    $digestLabel = $digestOptions[$digestValue] ?? $digestValue;

    $deliveryTabs = [
        [
            'id' => 'account-notifications-delivery-tab',
            'panel_id' => 'account-notifications-delivery-panel',
            'label' => 'Delivery preferences',
            'panel_title' => null,
            'selected' => true,
            'panel' => new HtmlString(view('notifications::account.partials.delivery-preferences', [
                'preference' => $preference,
                'digestLabel' => $digestLabel,
            ])->render()),
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
        lg="12"
        xlg="10"
        max="8"
        data-account-notifications-page
    >
        <x-ui.grid subgrid row-gap>
            @if (session('success'))
                <x-ui.grid-column span="100">
                    <x-ui.notification.inline kind="success" title="Notification preferences saved">
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
                    id="account-notifications-tabs"
                    label="Notification sections"
                    :tabs="$deliveryTabs"
                    orientation="vertical"
                    variant="line"
                    grid-aware
                    data-account-notifications-tabs
                />
            </x-ui.grid-column>
        </x-ui.grid>

        @include('notifications::account.partials.modals.edit-delivery-preferences', [
            'preference' => $preference,
            'digestItems' => $digestItems,
            'notificationPreferenceErrors' => $errors,
        ])
    </x-ui.grid-column>
</x-layouts.app>
