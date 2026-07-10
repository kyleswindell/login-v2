{{-- ==========================================================================
    File: Modules/Notifications/resources/views/account/partials/delivery-preferences.blade.php
    Purpose: Account notification delivery preferences panel.

    Notes:
    - Rendered inside the Notifications account page local section-tabs pattern.
    - Uses simple account card structure to match the Profile tab setup.
    - Uses x-patterns.key-value-display for compact delivery facts.
    ========================================================================== --}}

@php
    $emailEnabled = filter_var(data_get($preference, 'email_enabled', true), FILTER_VALIDATE_BOOLEAN);

    $deliveryDetails = [
        [
            'label' => 'Email notifications',
            'value' => $emailEnabled ? 'Enabled' : 'Disabled',
            'status' => $emailEnabled ? 'Enabled' : 'Disabled',
            'statusType' => $emailEnabled ? 'green' : 'cool-gray',
        ],
        [
            'label' => 'Digest frequency',
            'value' => $digestLabel,
        ],
    ];
@endphp

<section
    class="border border-[color:var(--ui-border-subtle-01)] bg-[color:var(--ui-layer)] p-6"
    aria-labelledby="account-notifications-delivery-heading"
    data-account-notifications-delivery-pane
>
    <header class="mb-6">
        <h2 id="account-notifications-delivery-heading" class="ui-card-title">
            Delivery preferences
        </h2>

        <p class="ui-card-copy mt-2">These settings apply only to future email and digest delivery.</p>
    </header>

    <x-patterns.key-value-display :items="$deliveryDetails" :columns="2" />

    <footer class="mt-6 flex justify-end">
        <x-ui.button
            type="button"
            kind="primary"
            size="sm"
            icon="edit"
            aria-controls="account-notifications-modal"
            data-ui-dialog-trigger="account-notifications-modal"
        >
            Edit preferences
        </x-ui.button>
    </footer>
</section>
