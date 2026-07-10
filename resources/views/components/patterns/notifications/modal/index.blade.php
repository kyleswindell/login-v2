{{-- ==========================================================================
    File: resources/views/components/patterns/notifications/modal/index.blade.php
    Purpose: Modal Notification pattern.

    Notes:
    - Composes x-ui.modal for the blocking modal notification shell.
    - x-ui.modal is backed by x-ui.dialog.* and resources/js/ui-controls/dialog.js.
    - Provides status and decision-flow defaults for modal notifications.
    - Supports notice, confirmation, destructive, and blocked modal notification
      flows.
    - Leaves body content fully caller-owned through the default slot.
    - Uses x-ui.modal footer slot with dialog action hooks.
    - Does not own domain review tables, typed-confirmation controls,
      destructive action locking, authorization, persistence, validation,
      form methods, or route decisions.
    ========================================================================== --}}

@props ([
    /*
|--------------------------------------------------------------------------
| Identity / Notification Semantics
|--------------------------------------------------------------------------
*/

    "id" => null,
    "status" => "auto",
    "variant" => "notice",
    "title" => null,
    "label" => null,
    "description" => null,
    "subject" => null,
    "subjectId" => null,

    /*
|--------------------------------------------------------------------------
| Modal Behavior
|--------------------------------------------------------------------------
*/

    "size" => "md",
    "open" => false,
    "passiveModal" => false,
    "danger" => null,
    "alert" => null,
    "closeOnBackdrop" => null,
    "preventCloseOnClickOutside" => null,
    "hasScrollingContent" => false,
    "isFullWidth" => false,
    "shouldSubmitOnEnter" => false,
    "shouldCloseAfterSubmit" => false,
    "selectorPrimaryFocus" => "[data-ui-dialog-primary-focus]",
    "closeButtonLabel" => "Close",

    /*
|--------------------------------------------------------------------------
| Default Footer Actions
|--------------------------------------------------------------------------
*/

    "confirmLabel" => null,
    "cancelLabel" => "Cancel",
    "closeLabel" => "Close",
    "busyLabel" => "Processing...",

    "confirmKind" => null,
    "cancelKind" => "secondary",
    "closeKind" => null,

    "confirmType" => null,
    "confirmHref" => null,
    "form" => null,
    "confirmName" => null,
    "confirmValue" => null,

    "busy" => false,
    "disabled" => false,
    "confirmDisabled" => false,
])

@php
    use Illuminate\Support\Str;

    /*
    |--------------------------------------------------------------------------
    | Supported Values
    |--------------------------------------------------------------------------
    */

    $allowedStatuses = [
        'auto',
        'info',
        'informational',
        'success',
        'warning',
        'error',
    ];

    $allowedVariants = [
        'notice',
        'confirmation',
        'destructive',
        'blocked',
    ];

    $allowedSizes = [
        'xs',
        'sm',
        'md',
        'lg',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolved Pattern State
    |--------------------------------------------------------------------------
    */

    $resolvedId = $id
        ?? $attributes->get('id')
        ?? 'notification-modal-' . Str::uuid();

    $rawStatus = is_string($status) && in_array($status, $allowedStatuses, true)
        ? $status
        : 'auto';

    $resolvedVariant = is_string($variant) && in_array($variant, $allowedVariants, true)
        ? $variant
        : 'notice';

    $resolvedStatus = match ($rawStatus) {
        'informational' => 'info',
        'auto' => match ($resolvedVariant) {
            'destructive', 'blocked' => 'error',
            default => 'info',
        },
        default => $rawStatus,
    };

    $resolvedSize = is_string($size) && in_array($size, $allowedSizes, true)
        ? $size
        : 'md';

    $statusLabels = [
        'info' => 'Information',
        'success' => 'Success',
        'warning' => 'Warning',
        'error' => 'Error',
    ];

    $variantLabels = [
        'notice' => $statusLabels[$resolvedStatus],
        'confirmation' => 'Confirmation required',
        'destructive' => 'Destructive action',
        'blocked' => 'Action unavailable',
    ];

    $resolvedLabel = filled($label)
        ? $label
        : $variantLabels[$resolvedVariant];

    $resolvedTitle = filled($title)
        ? $title
        : match ($resolvedVariant) {
            'confirmation' => 'Confirm action',
            'destructive' => 'Confirm destructive action',
            'blocked' => 'Action unavailable',
            default => $statusLabels[$resolvedStatus],
        };

    /*
    |--------------------------------------------------------------------------
    | Modal State
    |--------------------------------------------------------------------------
    */

    $isBusy = filter_var($busy, FILTER_VALIDATE_BOOLEAN);
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isConfirmDisabled = filter_var($confirmDisabled, FILTER_VALIDATE_BOOLEAN);
    $isPassive = filter_var($passiveModal, FILTER_VALIDATE_BOOLEAN);

    $resolvedDanger = is_null($danger)
        ? $resolvedVariant === 'destructive'
        : filter_var($danger, FILTER_VALIDATE_BOOLEAN);

    $resolvedAlert = is_null($alert)
        ? in_array($resolvedStatus, ['warning', 'error'], true)
        : filter_var($alert, FILTER_VALIDATE_BOOLEAN);

    if (! is_null($preventCloseOnClickOutside)) {
        $resolvedCloseOnBackdrop = ! filter_var(
            $preventCloseOnClickOutside,
            FILTER_VALIDATE_BOOLEAN
        );
    } elseif (! is_null($closeOnBackdrop)) {
        $resolvedCloseOnBackdrop = filter_var($closeOnBackdrop, FILTER_VALIDATE_BOOLEAN);
    } else {
        $resolvedCloseOnBackdrop = false;
    }

    $resolvedHasScrollingContent = filter_var($hasScrollingContent, FILTER_VALIDATE_BOOLEAN);
    $resolvedFullWidth = filter_var($isFullWidth, FILTER_VALIDATE_BOOLEAN);
    $resolvedSubmitOnEnter = filter_var($shouldSubmitOnEnter, FILTER_VALIDATE_BOOLEAN);
    $resolvedCloseAfterSubmit = filter_var($shouldCloseAfterSubmit, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | Footer Action State
    |--------------------------------------------------------------------------
    */

    $hasFooterSlot = isset($footer) && trim($footer->toHtml()) !== '';
    $hasActionsSlot = isset($actions) && trim($actions->toHtml()) !== '';
    $hasDefaultSlot = trim($slot->toHtml()) !== '';

    $resolvedConfirmLabel = filled($confirmLabel)
        ? $confirmLabel
        : match ($resolvedVariant) {
            'destructive' => 'Delete',
            'blocked' => null,
            default => 'Continue',
        };

    $resolvedConfirmKind = filled($confirmKind)
        ? $confirmKind
        : ($resolvedVariant === 'destructive' ? 'danger' : 'primary');

    $resolvedCancelKind = filled($cancelKind)
        ? $cancelKind
        : 'secondary';

    $resolvedCloseKind = filled($closeKind)
        ? $closeKind
        : ($resolvedVariant === 'blocked' ? 'primary' : 'secondary');

    $resolvedConfirmType = filled($confirmType)
        ? $confirmType
        : (filled($form) ? 'submit' : 'button');

    $resolvedButtonLabel = $isBusy
        ? $busyLabel
        : $resolvedConfirmLabel;

    $confirmActionDisabled = $isBusy || $isDisabled || $isConfirmDisabled;

    $rendersCloseOnlyFooter = in_array($resolvedVariant, ['notice', 'blocked'], true);

    $closeReceivesFocus = $rendersCloseOnlyFooter;
    $cancelReceivesFocus = $resolvedVariant === 'destructive';
    $confirmReceivesFocus = $resolvedVariant === 'confirmation';

    /*
    |--------------------------------------------------------------------------
    | Pattern Attributes
    |--------------------------------------------------------------------------
    */

    $patternDataAttributes = collect([
        'data-pattern' => 'notifications.modal',
        'data-ui-pattern' => 'notifications.modal',
        'data-ui-notification-modal' => 'true',
        'data-ui-notification-modal-id' => $resolvedId,
        'data-ui-notification-modal-status' => $resolvedStatus,
        'data-ui-notification-modal-variant' => $resolvedVariant,
        'data-ui-notification-modal-subject' => filled($subject) ? $subject : null,
        'data-ui-notification-modal-subject-id' => filled($subjectId) ? $subjectId : null,
        'data-ui-notification-modal-busy' => $isBusy ? 'true' : 'false',
        'data-ui-notification-modal-disabled' => $isDisabled ? 'true' : 'false',
    ])->filter(fn ($value) => ! is_null($value))->all();

    $patternAttributes = $attributes
        ->except(['id'])
        ->merge($patternDataAttributes);
@endphp

<div {{ $patternAttributes }}>
    <x-ui.modal
        :id="$resolvedId"
        :title="$resolvedTitle"
        :label="$resolvedLabel"
        :description="$description"
        :size="$resolvedSize"
        variant="transactional"
        :open="$open"
        :passive-modal="$isPassive"
        :danger="$resolvedDanger"
        :alert="$resolvedAlert"
        :close-on-backdrop="$resolvedCloseOnBackdrop"
        :has-scrolling-content="$resolvedHasScrollingContent"
        :is-full-width="$resolvedFullWidth"
        :should-submit-on-enter="$resolvedSubmitOnEnter"
        :should-close-after-submit="$resolvedCloseAfterSubmit"
        :selector-primary-focus="$selectorPrimaryFocus"
        :close-button-label="$closeButtonLabel"
        data-ui-notification-modal-dialog="true"
    >
        {{-- ------------------------------------------------------------------
            Caller-owned notification content
            ------------------------------------------------------------------ --}}

        @if ($hasDefaultSlot)
            <div data-ui-notification-modal-content>{{ $slot }}</div>
        @endif

        {{-- ------------------------------------------------------------------
            Modal notification footer
            ------------------------------------------------------------------
            Direct buttons are used so x-ui.modal owns the modal shell while this
            pattern owns notification-specific action semantics.
            ------------------------------------------------------------------ --}}

        <x-slot:footer>
            @if ($hasFooterSlot)
                {{ $footer }}
            @elseif ($hasActionsSlot)
                {{ $actions }}
            @elseif ($rendersCloseOnlyFooter)
                <x-ui.button
                    type="button"
                    :kind="$resolvedCloseKind"
                    data-ui-dialog-secondary="true"
                    data-ui-dialog-close="true"
                    data-ui-dialog-primary-focus="{{ $closeReceivesFocus ? 'true' : 'false' }}"
                    data-ui-form-action="true"
                    data-ui-form-action-role="close"
                    data-ui-form-action-allow-during-busy="false"
                    data-ui-notification-modal-close
                >
                    {{ $closeLabel }}
                </x-ui.button>
            @else
                <x-ui.button
                    type="button"
                    :kind="$resolvedCancelKind"
                    :disabled="$isDisabled"
                    data-ui-dialog-secondary="true"
                    data-ui-dialog-close="true"
                    data-ui-dialog-primary-focus="{{ $cancelReceivesFocus ? 'true' : 'false' }}"
                    data-ui-form-action="true"
                    data-ui-form-action-role="cancel"
                    data-ui-form-action-allow-during-busy="false"
                    data-ui-notification-modal-cancel
                >
                    {{ $cancelLabel }}
                </x-ui.button>

                <x-ui.button
                    :href="$confirmHref"
                    :type="$resolvedConfirmType"
                    :kind="$resolvedConfirmKind"
                    :disabled="$confirmActionDisabled"
                    :form="$form"
                    :name="$confirmName"
                    :value="$confirmValue"
                    data-ui-dialog-primary="true"
                    data-ui-dialog-primary-focus="{{ $confirmReceivesFocus ? 'true' : 'false' }}"
                    data-ui-form-action="true"
                    data-ui-form-action-role="submit"
                    data-ui-form-action-allow-during-busy="false"
                    data-ui-notification-modal-confirm
                    data-ui-notification-modal-confirm-locked="{{ $isConfirmDisabled ? 'true' : 'false' }}"
                >
                    {{ $resolvedButtonLabel }}
                </x-ui.button>
            @endif
        </x-slot:footer>
    </x-ui.modal>
</div>
