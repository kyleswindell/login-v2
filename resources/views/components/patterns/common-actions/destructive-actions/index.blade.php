{{-- ==========================================================================
    File: resources/views/components/patterns/common-actions/destructive-actions/index.blade.php
    Purpose: Destructive Actions pattern for delete, remove, discard, revoke, and irreversible action flows.

    Notes:
    - Composes x-patterns.common-actions.action-set for semantic grouping.
    - Composes x-ui.button-set and x-ui.button for action layout.
    - Composes x-ui.text-input for typed-confirmation controls.
    - Owns typed-confirmation input rendering and generated destructive action
      lock metadata.
    - Does not own confirmation modal/dialog rendering, authorization,
      persistence, validation, form methods, or route decisions.
    - Destructive action rules are declared in contract.php.
    ========================================================================== --}}

@php
    /*
    |--------------------------------------------------------------------------
    | Component Setup
    |--------------------------------------------------------------------------
    */

    $componentPath = resource_path('views/components/patterns/common-actions/destructive-actions');
    $propDefaults = require $componentPath.'/props.php';
@endphp

@props ($propDefaults)

@php
    /*
    |--------------------------------------------------------------------------
    | View Model
    |--------------------------------------------------------------------------
    */

    $view = (require $componentPath.'/view-model.php')(
        [
            'id' => $id,
            'actions' => $actions,
            'label' => $label,
            'labelledBy' => $labelledBy,
            'mode' => $mode,
            'scope' => $scope,
            'placement' => $placement,
            'severity' => $severity,
            'alignment' => $alignment,
            'orientation' => $orientation,
            'size' => $size,
            'subject' => $subject,
            'subjectId' => $subjectId,
            'actionRole' => $actionRole,
            'actionLabel' => $actionLabel,
            'confirmLabel' => $confirmLabel,
            'cancelLabel' => $cancelLabel,
            'description' => $description,
            'consequence' => $consequence,
            'icon' => $icon,
            'dangerKind' => $dangerKind,
            'cancelKind' => $cancelKind,
            'requireConfirmation' => $requireConfirmation,
            'requireTypedConfirmation' => $requireTypedConfirmation,
            'typedConfirmationValue' => $typedConfirmationValue,
            'typedConfirmationInputId' => $typedConfirmationInputId,
            'typedConfirmationInputName' => $typedConfirmationInputName,
            'typedConfirmationLabel' => $typedConfirmationLabel,
            'typedConfirmationHelperText' => $typedConfirmationHelperText,
            'typedConfirmationPlaceholder' => $typedConfirmationPlaceholder,
            'busy' => $busy,
            'loading' => $loading,
            'disabled' => $disabled,
            'form' => $form,
        ],
        $attributes,
        $slot,
    );
@endphp

<div
    id="{{ $view['id'] }}"
    {{
        $view["rootAttributes"]
            ->class($view["rootClasses"])
            ->merge($view["rootAttributeMerge"])
    }}
>
    {{-- ----------------------------------------------------------------------
        Destructive context message
        ---------------------------------------------------------------------- --}}

    @if ($view["showsMessage"])
        <div
            id="{{ $view['messageId'] }}"
            @class ($view["messageClasses"])
            data-ui-destructive-actions-message
        >
            @if (filled($view["descriptionHtml"]))
                <p class="ui-destructive-actions__description">
                    {!!
                        $view[
                            "descriptionHtml"
                        ]
                    !!}
                </p>
            @endif

            @if (filled($view["consequenceHtml"]))
                <p class="ui-destructive-actions__consequence">
                    {!!
                        $view[
                            "consequenceHtml"
                        ]
                    !!}
                </p>
            @endif

            @if ($view["requiresTypedConfirmation"])
                <div
                    class="ui-destructive-actions__typed-confirmation"
                    data-ui-destructive-actions-typed-confirmation-control
                    data-ui-destructive-actions-typed-confirmation-expected="{{ $view['typedConfirmationExpectedValue'] }}"
                >
                    <x-ui.text-input
                        :id="$view['typedConfirmationInputId']"
                        :name="$view['typedConfirmationInputName']"
                        type="text"
                        :label-text="$view['typedConfirmationLabel']"
                        :helper-text="$view['typedConfirmationHelperText']"
                        :placeholder="$view['typedConfirmationPlaceholder']"
                        value=""
                        size="sm"
                        required
                        :disabled="$view['typedConfirmationDisabled']"
                        autocomplete="off"
                        spellcheck="false"
                    />
                </div>
            @endif
        </div>
    @endif

    {{-- ----------------------------------------------------------------------
        Destructive action set
        ---------------------------------------------------------------------- --}}

    <x-patterns.common-actions.action-set
        :label="$view['groupLabel']"
        :labelled-by="$view['labelledBy']"
        :orientation="$view['orientation']"
        @class($view["setClasses"])
        data-ui-destructive-actions-set
    >
        <x-ui.button-set
            :stacked="$view['buttonSetStacked']"
            :fluid="$view['buttonSetFluid']"
            :width="$view['buttonSetWidth']"
            :align="$view['buttonSetAlign']"
            :auto-stack="$view['buttonSetAutoStack']"
            data-ui-destructive-actions-button-set
        >
            {{-- ------------------------------------------------------------------
                Array-driven destructive actions
                ------------------------------------------------------------------ --}}

            @foreach ($view["actions"] as $action)
                <x-ui.button
                    :type="$action['type']"
                    :kind="$action['kind']"
                    :size="$action['size']"
                    :disabled="$action['disabled']"
                    :loading="$action['loading']"
                    :href="$action['href']"
                    :target="$action['target']"
                    :rel="$action['rel']"
                    :name="$action['name']"
                    :value="$action['value']"
                    :form="$action['form']"
                    :aria-describedby="
                        $action['destructive'] && filled($view['messageId'])
        ? $view['messageId']
        : null
                    "
                    @class($action["classes"])
                    data-ui-destructive-action
                    data-ui-destructive-action-role="{{ $action['role'] }}"
                    data-ui-destructive-action-kind="{{ $action['kind'] }}"
                    data-ui-destructive-action-type="{{ $action['type'] }}"
                    data-ui-destructive-action-index="{{ $action['index'] }}"
                    data-ui-destructive-action-subject-id="{{ $action['subject_id'] }}"
                    data-ui-destructive-action-destructive="{{ $action['destructive'] ? 'true' : 'false' }}"
                    data-ui-destructive-action-disabled="{{ $action['disabled'] ? 'true' : 'false' }}"
                    data-ui-destructive-action-loading="{{ $action['loading'] ? 'true' : 'false' }}"
                    data-ui-destructive-action-locked="{{ $action['locked'] ? 'true' : 'false' }}"
                    data-ui-destructive-action-requires-typed-confirmation="{{ $action['requires_typed_confirmation'] ? 'true' : 'false' }}"
                >
                    @if (filled($action["icon"]))
                        <x-ui.icon
                            :name="$action['icon']"
                            class="ui-destructive-actions__action-icon"
                            aria-hidden="true"
                        />
                    @endif

                    {!!
                        $action[
                            "label_html"
                        ]
                    !!}
                </x-ui.button>
            @endforeach

            {{-- ------------------------------------------------------------------
                Slotted destructive actions
                ------------------------------------------------------------------
                Slot mode is preferred when callers need exact route bindings,
                modal controls, or framework handlers. Slotted destructive
                controls must provide their own lock hooks when typed
                confirmation is required.
                ------------------------------------------------------------------ --}}

            @if ($view["hasSlotContent"])
                {{ $slot }}
            @endif
        </x-ui.button-set>
    </x-patterns.common-actions.action-set>
</div>
