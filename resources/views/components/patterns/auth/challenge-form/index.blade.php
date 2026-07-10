{{-- ==========================================================================
    File: resources/views/components/patterns/auth/challenge-form/index.blade.php
    Purpose: Shared Auth Challenge Form pattern.

    Notes:
    - Owns repeated auth shell, panel, header, form, context, actions region,
      and help footer structure.
    - Emits native form behavior directly for auth challenge forms, including
      CSRF and Laravel method spoofing.
    - Uses auth::partials.alerts by default for auth feedback.
    - May compose x-patterns.forms.actions for submit/loading
      action behavior.
    - Does not own authentication logic, field values, validation rules, MFA
      behavior, controller state, or routes.
    ========================================================================== --}}

@props ([
    "title",
    "description" => null,
    "action",
    "method" => "POST",
    "csrf" => true,
    "formId" => null,
    "novalidate" => true,

    "marker" => "Login App 2.0",
    "titleId" => "auth-title",
    "context" => null,
    "contextLabel" => null,
    "changeHref" => null,
    "changeLabel" => "Change",

    "includeTimezone" => false,
    "showAlerts" => true,

    "wrapActions" => true,
    "actionsLabel" => null,
    "actionsAlignment" => "end",
    "actionsPlacement" => "inline",
    "actionsOrientation" => "horizontal",
    "actionsSize" => "md",
    "actionsFluid" => true,
    "actionsAutoStack" => true,
    "actionsWidth" => "half",
    "actionsState" => "idle",
    "actionsLoadingText" => null,
    "actionsSuccessText" => null,
    "actionsErrorText" => null,
    "actionsStatusAriaLive" => null,
    "actionsDisableDuringBusy" => true,
    "actionsReplaceSlotWithStatus" => true,

    "submitState" => true,

    "helpText" => "Need help?",
    "helpLinkText" => "Contact Support",
    "helpHref" => null,
    "helpCentered" => false,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Boolean Values
    |--------------------------------------------------------------------------
    */

    $usesCsrf = filter_var($csrf, FILTER_VALIDATE_BOOLEAN);
    $usesNoValidate = filter_var($novalidate, FILTER_VALIDATE_BOOLEAN);
    $usesTimezone = filter_var($includeTimezone, FILTER_VALIDATE_BOOLEAN);
    $showsAlerts = filter_var($showAlerts, FILTER_VALIDATE_BOOLEAN);
    $wrapsActions = filter_var($wrapActions, FILTER_VALIDATE_BOOLEAN);
    $usesActionsFluid = filter_var($actionsFluid, FILTER_VALIDATE_BOOLEAN);
    $usesActionsAutoStack = filter_var($actionsAutoStack, FILTER_VALIDATE_BOOLEAN);
    $disablesDuringBusy = filter_var($actionsDisableDuringBusy, FILTER_VALIDATE_BOOLEAN);
    $replacesSlotWithStatus = filter_var($actionsReplaceSlotWithStatus, FILTER_VALIDATE_BOOLEAN);
    $usesSubmitState = filter_var($submitState, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | Method Values
    |--------------------------------------------------------------------------
    */

    $resolvedMethod = strtoupper((string) $method);
    $nativeMethod = in_array($resolvedMethod, ['GET', 'POST'], true)
        ? $resolvedMethod
        : 'POST';

    $usesMethodSpoofing = ! in_array($resolvedMethod, ['GET', 'POST'], true);

    /*
    |--------------------------------------------------------------------------
    | Slot State
    |--------------------------------------------------------------------------
    */

    $hasAlertsSlot = isset($alerts) && trim((string) $alerts) !== '';
    $hasActionsSlot = isset($actions) && trim((string) $actions) !== '';

    /*
    |--------------------------------------------------------------------------
    | Action Defaults
    |--------------------------------------------------------------------------
    */

    $resolvedActionsLabel = $actionsLabel ?? "{$title} actions";

    /*
    |--------------------------------------------------------------------------
    | Form Attributes
    |--------------------------------------------------------------------------
    */

    $formAttributes = $attributes
        ->class([
            'ui-form',
            'ui-form--fluid',
        ])
        ->merge([
            'data-auth-form' => true,
            'data-auth-form-method' => $resolvedMethod,
            'data-ui-form-submit-state' => $usesSubmitState ? 'true' : 'false',
            'data-ui-form-submit-state-loading-text' => $actionsLoadingText,
            'data-ui-form-submit-state-success-text' => $actionsSuccessText,
            'data-ui-form-submit-state-error-text' => $actionsErrorText,
        ]);

    if (filled($formId)) {
        $formAttributes = $formAttributes->merge([
            'id' => $formId,
        ]);
    }

    if ($usesNoValidate) {
        $formAttributes = $formAttributes->merge([
            'novalidate' => true,
        ]);
    }
@endphp

<section
    class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center py-8"
    aria-labelledby="{{ $titleId }}"
    data-auth-shell
>
    <div
        style="
            background-color: var(--ui-background);
            color: var(--ui-text-primary);
        "
        data-auth-panel
    >
        <form
            method="{{ $nativeMethod }}"
            action="{{ $action }}"
            {{ $formAttributes }}
        >
            @if ($usesCsrf && $nativeMethod !== "GET")
                @csrf
            @endif

            @if ($usesMethodSpoofing)
                @method ($resolvedMethod)
            @endif

            @if ($usesTimezone)
                <input
                    id="timezone"
                    name="timezone"
                    type="hidden"
                    data-auth-timezone-field
                />
            @endif

            {{-- --------------------------------------------------------------
                Auth header
                -------------------------------------------------------------- --}}
            <div class="px-4 py-8">
                <header class="space-y-5" data-auth-shell-header>
                    <div class="space-y-2">
                        @if (filled($marker))
                            <p class="ui-platform-text-muted text-sm font-medium">
                                {{ $marker }}
                            </p>
                        @endif

                        <div class="space-y-1">
                            <h1
                                id="{{ $titleId }}"
                                class="ui-platform-text-strong text-2xl font-semibold tracking-normal"
                            >
                                {{ $title }}
                            </h1>

                            @if (filled($description))
                                <p class="ui-platform-text-muted text-sm leading-6">
                                    {{ $description }}
                                </p>
                            @endif
                        </div>
                    </div>

                    @if (filled($context))
                        <div
                            class="ui-platform-border flex items-center justify-between gap-4 border-y py-3 text-sm"
                            data-auth-context
                        >
                            <div class="min-w-0">
                                @if (filled($contextLabel))
                                    <p class="ui-platform-text-muted text-xs font-medium uppercase tracking-normal">
                                        {{ $contextLabel }}
                                    </p>
                                @endif

                                <p class="ui-platform-text-strong truncate font-medium">
                                    {{ $context }}
                                </p>
                            </div>

                            @if (filled($changeHref))
                                <x-ui.link
                                    :href="$changeHref"
                                    :text="$changeLabel"
                                    variant="standalone"
                                    size="sm"
                                />
                            @endif
                        </div>
                    @endif

                    @if ($hasAlertsSlot)
                        {{ $alerts }}
                    @elseif ($showsAlerts)
                        @include ("auth::partials.alerts")
                    @endif
                </header>
            </div>

            {{-- --------------------------------------------------------------
                Auth challenge body
                -------------------------------------------------------------- --}}
            {{ $slot }}

            {{-- --------------------------------------------------------------
                Auth challenge actions
                --------------------------------------------------------------
                Wrapped mode centralizes submit/loading/success/error behavior
                in x-patterns.forms.actions.

                The action wrapper intentionally has no padding so fluid Button Set
                actions can align flush with the auth panel edge.
                -------------------------------------------------------------- --}}
            @if ($hasActionsSlot)
                @if ($wrapsActions)
                    <x-patterns.forms.actions
                        :label="$resolvedActionsLabel"
                        :alignment="$actionsAlignment"
                        :placement="$actionsPlacement"
                        :orientation="$actionsOrientation"
                        :size="$actionsSize"
                        :fluid="$usesActionsFluid"
                        :auto-stack="$usesActionsAutoStack"
                        :width="$actionsWidth"
                        :state="$actionsState"
                        :loading-text="$actionsLoadingText"
                        :success-text="$actionsSuccessText"
                        :error-text="$actionsErrorText"
                        :status-aria-live="$actionsStatusAriaLive"
                        :disable-during-busy="$disablesDuringBusy"
                        :replace-slot-with-status="$replacesSlotWithStatus"
                        data-auth-actions
                        data-auth-actions-wrapper
                    >
                        {{ $actions }}
                    </x-patterns.forms.actions>
                @else
                    {{ $actions }}
                @endif
            @endif
        </form>
    </div>

    @if (filled($helpText) || filled($helpLinkText))
        <p
            @class ([
                "ui-platform-text-muted mt-5 text-sm",
                "text-center" => $helpCentered
            ])
        >
            {{ $helpText }}

            @if (filled($helpHref))
                <x-ui.link
                    :href="$helpHref"
                    :text="$helpLinkText"
                    variant="inline"
                />
            @else
                <x-ui.link :text="$helpLinkText" variant="inline" unavailable />
            @endif
        </p>
    @endif
</section>

@if ($usesTimezone)
    {{-- ----------------------------------------------------------------------
        Temporary timezone initializer

        Final implementation should move this into a shared auth JS initializer.
        ---------------------------------------------------------------------- --}}
    <script>
        (() => {
            const timezoneField = document.querySelector(
                "[data-auth-timezone-field]",
            );

            if (timezoneField) {
                timezoneField.value =
                    Intl.DateTimeFormat().resolvedOptions().timeZone || "";
            }
        })();
    </script>
@endif
