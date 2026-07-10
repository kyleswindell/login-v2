{{-- ==========================================================================
    File: Modules/Notifications/resources/views/header/partials/realtime.blade.php
    Purpose: Notifications header realtime boot markers and toast templates.

    Notes:
    - Renders the hidden realtime root consumed by the Notifications module JS.
    - The toast container/templates are mounted separately by
      notifications::runtime.toasts so transient toasts do not depend on the
      notification bell being visible.
    - This partial assumes notification state has been normalized by
      header/action.blade.php.
    ========================================================================== --}}

@if ($realtimeEnabled && $userId && $resolvedRealtimeAuthUrl)
    {{-- ------------------------------------------------------------------
        Realtime boot marker
        ------------------------------------------------------------------
        The Notifications module runtime uses this hidden marker to initialize
        the private realtime channel and endpoint configuration.
        ------------------------------------------------------------------ --}}

    <div
        hidden
        data-realtime-notifications="1"
        data-user-id="{{ $userId }}"
        data-notifications-index-url="{{ $resolvedIndexHref }}"
        data-notifications-realtime-auth-url="{{ $resolvedRealtimeAuthUrl }}"
    ></div>

@endif
