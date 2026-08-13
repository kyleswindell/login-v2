{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/parts/index.blade.php
    Purpose: Read-only Profile Mfg part directory.
    ========================================================================== --}}

<x-layouts.app
    header-variant="workspace"
    :grid="false"
    :reserve-page-tabs="false"
    title="Parts"
    page-title="Parts"
    page-subtitle="Production ownership, packaging, finished-goods signals, and near-term demand."
    brand-name="Profile Mfg"
    header-label="Profile Mfg"
    side-nav-area-title="Profile Mfg"
    :side-nav-expanded="false"
    :side-nav-fixed="false"
>
    <x-slot:sidebar>
        @include('profile-mfg-poc::partials.sidebar')
    </x-slot:sidebar>

    <div class="space-y-6">
        @include('profile-mfg-poc::partials.preview-banner')
        @include('profile-mfg-poc::partials.parts-table', [
            'parts' => $parts,
            'showToolbar' => true,
            'showImage' => true,
        ])
    </div>
</x-layouts.app>
