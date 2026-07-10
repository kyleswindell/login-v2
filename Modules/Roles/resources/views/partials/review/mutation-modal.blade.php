{{-- ==========================================================================
    File: Modules/Roles/resources/views/partials/review/mutation-modal.blade.php
    Purpose: Role mutation modal review composition.

    Notes:
    - Composes the approved Modal Notification pattern for role create, update,
      and delete confirmations.
    - Review rows are prepared by RoleMutationPreview and rendered by the
      module-local review partials.
    - Does not own mutation authorization, persistence, form submission, or
      role guardrail enforcement.
    ========================================================================== --}}

@props ([
    "id",
    "review" => [],
    "variant" => null,
    "status" => null,
    "formId" => null,
    "title",
    "label" => "Review",
    "description" => null,
    "confirmLabel" => "Continue",
    "cancelLabel" => "Cancel",
    "busyLabel" => "Processing...",
])

@php
    /*
    |--------------------------------------------------------------------------
    | Modal State
    |--------------------------------------------------------------------------
    */

    $variant = is_string($variant)
        ? $variant
        : (string) data_get($review, "variant", "confirmation");

    $status = is_string($status)
        ? $status
        : (string) data_get($review, "status", "info");
    $subject = (string) data_get($review, "subject.label", "");
    $permissionRows = collect(data_get($review, "permissionChangeRows", []));
    $impactRows = collect(data_get($review, "impactRows", []));
    $blockerRows = collect(data_get($review, "blockerRows", []));
    $isDestructive = $variant === "destructive";
    $isBlocked = $variant === "blocked";
    $isWarning = in_array($status, ["warning", "error"], true);
@endphp

<x-patterns.notifications.modal
    :id="$id"
    :status="$status"
    :variant="$variant"
    :title="$title"
    :label="$label"
    :subject="$subject"
    :confirm-label="$confirmLabel"
    :cancel-label="$cancelLabel"
    :confirm-kind="$isDestructive ? 'danger' : 'primary'"
    confirm-type="submit"
    :form="$formId"
    :busy-label="$busyLabel"
    size="md"
    :danger="$isDestructive"
    :alert="$isWarning || $isBlocked"
    :close-on-backdrop="false"
    :has-scrolling-content="true"
    data-roles-action-review-modal
    data-roles-action-review-operation="{{ data_get($review, 'operation', 'unknown') }}"
>
    <x-ui.v-stack :gap="5">
        @if (filled($description))
            <p>{{ $description }}</p>
        @endif

        @if ($permissionRows->isNotEmpty())
            @include ("roles::partials.review.permission-change-table",
                [
                    "review" => $review,
                    "expanded" => false,
                ])
        @endif

        @if ($blockerRows->isNotEmpty())
            @include ("roles::partials.review.blocker-summary",
                [
                    "review" => $review,
                ])
        @endif

        @if ($impactRows->isNotEmpty())
            @include ("roles::partials.review.impact-summary",
                [
                    "review" => $review,
                ])
        @endif
    </x-ui.v-stack>
</x-patterns.notifications.modal>
