{{-- ==========================================================================
    File: Modules/ProfileMfgPoc/resources/views/unavailable.blade.php
    Purpose: Safe authenticated failure state for an unavailable POC snapshot.
    ========================================================================== --}}

<x-layouts.app
    header-variant="workspace"
    :grid="false"
    :reserve-page-tabs="false"
    title="POC data unavailable"
    page-title="POC data unavailable"
    page-subtitle="The presentation snapshot could not be loaded safely."
    brand-name="Profile Mfg"
    header-label="Profile Mfg"
    side-nav-area-title="Profile Mfg"
    :side-nav-expanded="false"
    :side-nav-fixed="false"
>
    <x-slot:sidebar>
        @include('profile-mfg-poc::partials.sidebar')
    </x-slot:sidebar>

    <x-ui.notification.inline
        kind="error"
        title="The static workspace is temporarily unavailable"
        subtitle="Ask the presentation administrator to verify the private snapshot. No file paths or record contents are shown here."
        hide-close-button
    />
</x-layouts.app>
