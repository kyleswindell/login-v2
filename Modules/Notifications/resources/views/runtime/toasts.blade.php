{{-- ==========================================================================
    File: Modules/Notifications/resources/views/runtime/toasts.blade.php
    Purpose: Notifications module transient toast runtime mount.

    Notes:
    - Renders toast templates through the installed x-ui.notification.toast API.
    - Hosts non-persistent action-feedback toasts independent of the bell panel.
    - Does not create notifications table records or inbox/panel entries.
    ========================================================================== --}}

@php
    $toasts = app(\App\Modules\Notifications\Services\TransientToasts::class)->sessionPayloads();
    $toastKinds = \App\Modules\Notifications\Services\TransientToasts::kinds();
@endphp

<div
    hidden
    data-transient-notifications="1"
></div>

<script
    type="application/json"
    data-transient-notification-payloads
>@json($toasts)</script>

<div
    class="pointer-events-none fixed right-6 top-24 z-[70] flex w-full max-w-sm flex-col gap-3"
    aria-live="polite"
    aria-atomic="true"
    data-notification-toast-container
></div>

<div hidden data-notification-toast-templates>
    @foreach ($toastKinds as $toastKind)
        <template data-notification-toast-template="{{ $toastKind }}">
            <x-ui.notification.toast
                :kind="$toastKind"
                title="Notification"
                subtitle="Notification body"
                close-label="Close notification"
                class="pointer-events-auto"
                data-notification-toast-template-root
            />
        </template>
    @endforeach
</div>
