{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/partials/additional-information.blade.php
    Purpose: Displays escaped source fields that do not map to the POC contract.
    ========================================================================== --}}

<x-patterns.content-section-block title="Additional information">
    @if (! empty($fields))
        <x-patterns.key-value-display
            :items="collect($fields)->map(fn ($value, $label) => ['label' => $label, 'value' => $value ?? '—'])->values()"
            :columns="2"
        />
    @else
        <p class="text-sm ui-platform-text-muted">—</p>
    @endif
</x-patterns.content-section-block>
