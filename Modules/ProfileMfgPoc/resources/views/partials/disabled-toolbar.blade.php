{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/partials/disabled-toolbar.blade.php
    Purpose: Shows intentionally unavailable list controls in the static POC.
    ========================================================================== --}}

@props([
    'showCreate' => true,
    'createLabel' => 'Create preview',
])

<x-ui.data-table.toolbar aria-label="Preview-only table controls" size="sm">
    <x-ui.data-table.toolbar.search
        id="profile-mfg-preview-search"
        label-text="Search records"
        placeholder="Search — Preview only"
        persistent
        disabled
    />

    <x-ui.data-table.toolbar.content>
        <x-ui.select
            id="profile-mfg-preview-status"
            label-text="Status"
            :items="[['value' => '', 'label' => 'All statuses']]"
            size="sm"
            disabled
            hide-label
            aria-label="Status filter preview"
        />

        @if ($showCreate)
            <x-ui.button kind="tertiary" size="sm" disabled>
                {{ $createLabel }}
            </x-ui.button>
        @endif
    </x-ui.data-table.toolbar.content>
</x-ui.data-table.toolbar>
