{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/partials/summary-tile.blade.php
    Purpose: Composes a Carbon-aligned static tile for operational metrics.
    ========================================================================== --}}

<x-ui.tile
    :title="$label"
    variant="static"
    density="compact"
>
    <p class="mt-3 ui-type-heading-05 ui-type-regular ui-platform-text-strong">{{ $value }}</p>

    @if (filled($supportingText ?? null))
        <p class="mt-2 ui-type-body-compact-01 ui-platform-text-muted">{{ $supportingText }}</p>
    @endif

    @if (filled($status ?? null))
        <div class="mt-3">
            <x-ui.tag
                :label="$status"
                :tone="$statusTone ?? 'neutral'"
                size="sm"
            />
        </div>
    @endif
</x-ui.tile>
