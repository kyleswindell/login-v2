{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/settings/index.blade.php
    Purpose: Static Profile Mfg application-settings preview.

    Notes:
    - Uses installed form controls in disabled states to demonstrate planned
      configuration without introducing write behavior.
    - Values describe the POC presentation workflow, not confirmed production
      customer configuration.
    ========================================================================== --}}

<x-layouts.app
    header-variant="workspace"
    :grid="false"
    :reserve-page-tabs="false"
    title="Application settings"
    page-title="Application settings"
    page-subtitle="Preview workspace defaults for shipping, inventory readiness, and exception visibility."
    brand-name="Profile Mfg"
    header-label="Profile Mfg"
    side-nav-area-title="Profile Mfg"
    :side-nav-expanded="false"
    :side-nav-fixed="false"
>
    <x-slot:pageActions>
        <x-ui.button kind="primary" disabled>Save settings — Preview</x-ui.button>
    </x-slot:pageActions>

    <x-slot:sidebar>
        @include('profile-mfg-poc::partials.sidebar')
    </x-slot:sidebar>

    <div class="space-y-6">
        @include('profile-mfg-poc::partials.preview-banner')

        <x-ui.notification.inline
            kind="info"
            title="Presentation configuration"
            subtitle="These controls demonstrate an application settings workflow. Values are illustrative and cannot be changed in the static proof of concept."
            hide-close-button
        />

        <x-patterns.dashboard-grid columns="2">
            <x-patterns.content-section-block
                title="Shipping schedule"
                description="Defaults for the daily coordination workspace."
            >
                <div class="grid gap-5 md:grid-cols-2">
                    <x-ui.select
                        id="profile-mfg-default-landing"
                        label-text="Default landing page"
                        :items="[['value' => 'shipping-schedule', 'label' => 'Shipping schedule']]"
                        value="shipping-schedule"
                        helper-text="Shown after authentication."
                        disabled
                    />

                    <x-ui.select
                        id="profile-mfg-schedule-horizon"
                        label-text="Schedule horizon"
                        :items="[['value' => 'two-weeks', 'label' => 'Current and next work week']]"
                        value="two-weeks"
                        helper-text="Longer planning totals remain visible."
                        disabled
                    />

                    <x-ui.select
                        id="profile-mfg-due-date-meaning"
                        label-text="Order due-date label"
                        :items="[['value' => 'expected-ship-date', 'label' => 'Expected ship date']]"
                        value="expected-ship-date"
                        disabled
                    />

                    <x-ui.select
                        id="profile-mfg-default-density"
                        label-text="Table density"
                        :items="[['value' => 'compact', 'label' => 'Compact operations view']]"
                        value="compact"
                        disabled
                    />
                </div>
            </x-patterns.content-section-block>

            <x-patterns.content-section-block
                title="Inventory and exceptions"
                description="Signals used to assess finished-goods readiness."
            >
                <div class="grid gap-5 md:grid-cols-2">
                    <x-ui.select
                        id="profile-mfg-inventory-signal"
                        label-text="Inventory readiness signal"
                        :items="[['value' => 'serialized-boxes', 'label' => 'Serialized finished-goods boxes']]"
                        value="serialized-boxes"
                        helper-text="System part balances remain visible for comparison."
                        disabled
                    />

                    <x-ui.select
                        id="profile-mfg-shortage-rule"
                        label-text="Potential shortage rule"
                        :items="[['value' => 'remaining-minus-onhand', 'label' => 'Remaining demand minus on hand']]"
                        value="remaining-minus-onhand"
                        disabled
                    />

                    <x-ui.select
                        id="profile-mfg-scan-exceptions"
                        label-text="Scan exception visibility"
                        :items="[['value' => 'daily-activity', 'label' => 'Show in daily scan activity']]"
                        value="daily-activity"
                        disabled
                    />

                    <x-ui.select
                        id="profile-mfg-change-policy"
                        label-text="Record-changing actions"
                        :items="[['value' => 'preview', 'label' => 'Unavailable in static POC']]"
                        value="preview"
                        disabled
                    />
                </div>
            </x-patterns.content-section-block>
        </x-patterns.dashboard-grid>
    </div>
</x-layouts.app>
