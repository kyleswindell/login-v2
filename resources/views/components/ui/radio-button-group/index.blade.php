{{-- ==========================================================================
    File: resources/views/components/ui/radio-button-group/index.blade.php
    Purpose: Radio Button Group fieldset component.

    Notes:
    - Emits the installed .ui-radio-button-group selector contract.
    - Supports item-array rendering and slot-based radio button content.
    - Uses native fieldset/legend structure for grouped radio semantics.
    - Invalid state takes precedence over warning state.
    - Helper, invalid, and warning messages are associated through aria-describedby.
    - Uses x-ui.radio-button for item-array rendering.
    - Uses the unified x-ui.icon component for validation icons.
    - Radio Button styles are handled by resources/css/components/radio-button.css.
    ========================================================================== --}}

@props([
    'items' => [],
    'name' => null,
    'id' => null,
    'legendText' => null,
    'legend' => null,
    'helperText' => null,
    'invalid' => false,
    'invalidText' => null,
    'warn' => false,
    'warnText' => null,
    'disabled' => false,
    'readOnly' => false,
    'required' => false,
    'labelPosition' => 'right',
    'orientation' => 'horizontal',
    'defaultSelected' => null,
    'valueSelected' => null,
    'decorator' => null,
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedLabelPositions = [
        'left',
        'right',
    ];

    $allowedOrientations = [
        'horizontal',
        'vertical',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    |
    | `legend` is retained as a shorter alias for `legendText`.
    |
    */

    $resolvedId = $id ?? 'ui-radio-button-group-'.Str::uuid();

    $resolvedLegend = $legendText ?? $legend;

    $resolvedLabelPosition = in_array($labelPosition, $allowedLabelPositions, true)
        ? $labelPosition
        : 'right';

    $resolvedOrientation = in_array($orientation, $allowedOrientations, true)
        ? $orientation
        : 'horizontal';

    $selectedValue = $valueSelected ?? $defaultSelected;

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    |
    | Invalid state takes precedence over warning state. Helper text is hidden
    | when invalid or warning text is active.
    |
    */

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isReadOnly = filter_var($readOnly, FILTER_VALIDATE_BOOLEAN);
    $isRequired = filter_var($required, FILTER_VALIDATE_BOOLEAN);

    $isInvalid = ! $isReadOnly && ! $isDisabled && filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
    $isWarning = ! $isReadOnly && ! $isDisabled && ! $isInvalid && filter_var($warn, FILTER_VALIDATE_BOOLEAN);

    $stateValue = $isInvalid ? 'invalid' : ($isWarning ? 'warning' : 'default');

    $showHelper = ! $isInvalid && ! $isWarning && filled($helperText);
    $showInvalid = $isInvalid && filled($invalidText);
    $showWarning = $isWarning && filled($warnText);

    /*
    |--------------------------------------------------------------------------
    | Message IDs and ARIA Wiring
    |--------------------------------------------------------------------------
    */

    $helperId = $showHelper ? $resolvedId.'-helper-text' : null;
    $invalidId = $showInvalid ? $resolvedId.'-invalid-text' : null;
    $warningId = $showWarning ? $resolvedId.'-warning-text' : null;

    $existingDescribedBy = $attributes->get('aria-describedby');

    $ariaDescribedBy = collect([
        $existingDescribedBy,
        $helperId,
        $invalidId,
        $warningId,
    ])->filter()->implode(' ');

    /*
    |--------------------------------------------------------------------------
    | Decorator Handling
    |--------------------------------------------------------------------------
    */

    $hasDecorator = isset($decorator) && filled($decorator);

    /*
    |--------------------------------------------------------------------------
    | Slot Detection
    |--------------------------------------------------------------------------
    */

    $hasSlotContent = trim($slot->toHtml()) !== '';

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $wrapperClasses = [
        'ui-form-item',
    ];

    $fieldsetClasses = [
        'ui-radio-button-group',
        'ui-radio-button-group--vertical' => $resolvedOrientation === 'vertical',
        'ui-radio-button-group--label-'.$resolvedLabelPosition,
        'ui-radio-button-group--readonly' => $isReadOnly,
        'ui-radio-button-group--invalid' => $isInvalid,
        'ui-radio-button-group--warning' => $isWarning,
        'ui-radio-button-group--decorator' => $hasDecorator,
    ];

    $helperClasses = [
        'ui-form__helper-text',
        'ui-form__helper-text--disabled' => $isDisabled,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | Caller layout/data attributes apply to the wrapper. Accessible group
    | labelling attributes apply to the fieldset.
    |
    */

    $wrapperAttributes = $attributes->except([
        'aria-describedby',
        'aria-errormessage',
        'aria-label',
        'aria-labelledby',
        'role',
    ]);

    $fieldsetAttributes = $attributes->only([
        'aria-label',
        'aria-labelledby',
        'role',
    ]);
@endphp

<div
    {{ $wrapperAttributes->class($wrapperClasses)->merge([
        'data-ui-component' => 'radio-button-group',
        'data-ui-radio-button-group-wrapper' => true,
        'data-ui-radio-button-group-state' => $stateValue,
    ]) }}
>
    <fieldset
        id="{{ $resolvedId }}"
        @class($fieldsetClasses)
        @disabled($isDisabled)
        @if ($isInvalid) data-invalid="true" aria-invalid="true" @endif
        @if (filled($invalidId)) aria-errormessage="{{ $invalidId }}" @endif
        @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
        {{ $fieldsetAttributes->merge([
            'data-ui-radio-button-group' => true,
            'data-ui-radio-button-group-orientation' => $resolvedOrientation,
            'data-ui-radio-button-group-label-position' => $resolvedLabelPosition,
            'data-ui-radio-button-group-disabled' => $isDisabled ? 'true' : 'false',
            'data-ui-radio-button-group-readonly' => $isReadOnly ? 'true' : 'false',
            'data-ui-radio-button-group-required' => $isRequired ? 'true' : 'false',
            'data-ui-radio-button-group-state' => $stateValue,
        ]) }}
    >
        {{-- ------------------------------------------------------------------
            Legend
            ------------------------------------------------------------------
            The legend labels the grouped radio controls.
            ------------------------------------------------------------------ --}}

        @if (filled($resolvedLegend) || $hasDecorator)
            <legend class="ui-label">
                @if ($resolvedLegend instanceof HtmlString)
                    {!! $resolvedLegend !!}
                @else
                    {{ $resolvedLegend }}
                @endif

                @if ($hasDecorator)
                    <span class="ui-radio-button-group-inner--decorator">
                        @if ($decorator instanceof HtmlString)
                            {!! $decorator !!}
                        @else
                            {{ $decorator }}
                        @endif
                    </span>
                @endif
            </legend>
        @endif

        {{-- ------------------------------------------------------------------
            Item-array Radio Buttons
            ------------------------------------------------------------------
            When items are provided, this group owns checked/default state.
            ------------------------------------------------------------------ --}}

        @foreach ($items as $index => $item)
            @php
                $itemData = is_array($item)
                    ? $item
                    : [
                        'value' => $item,
                        'label' => $item,
                    ];

                $itemValue = data_get($itemData, 'value', $index);
                $itemId = data_get($itemData, 'id', $resolvedId.'-item-'.$index);

                $itemChecked = ! is_null($selectedValue)
                    ? (string) $itemValue === (string) $selectedValue
                    : filter_var(data_get($itemData, 'checked', false), FILTER_VALIDATE_BOOLEAN);

                $itemDisabled = $isDisabled
                    || filter_var(data_get($itemData, 'disabled', false), FILTER_VALIDATE_BOOLEAN);

                $itemHideLabel = filter_var(data_get($itemData, 'hideLabel', false), FILTER_VALIDATE_BOOLEAN);
            @endphp

            <x-ui.radio-button
                :id="$itemId"
                :name="$name"
                :value="$itemValue"
                :label-text="data_get($itemData, 'labelText', data_get($itemData, 'label', ''))"
                :checked="$itemChecked"
                :disabled="$itemDisabled"
                :read-only="$isReadOnly"
                :required="$isRequired"
                :hide-label="$itemHideLabel"
                :label-position="$resolvedLabelPosition"
                :decorator="data_get($itemData, 'decorator')"
            />
        @endforeach

        {{-- ------------------------------------------------------------------
            Slot Radio Buttons
            ------------------------------------------------------------------
            Slot mode is manual. The caller controls child radio checked state.
            ------------------------------------------------------------------ --}}

        @if ($hasSlotContent)
            {{ $slot }}
        @endif
    </fieldset>

    {{-- ----------------------------------------------------------------------
        Validation and Warning Message
        ----------------------------------------------------------------------
        Invalid text takes precedence over warning text.
        ---------------------------------------------------------------------- --}}

    @if ($showInvalid || $showWarning)
        <div class="ui-radio-button__validation-msg">
            @if ($showInvalid)
                <x-ui.icon
                    name="warning--filled"
                    class="ui-radio-button__invalid-icon"
                    aria-hidden="true"
                />

                <div id="{{ $invalidId }}" class="ui-form-requirement" role="alert">
                    {{ $invalidText }}
                </div>
            @elseif ($showWarning)
                <x-ui.icon
                    name="warning--alt"
                    class="ui-radio-button__invalid-icon ui-radio-button__invalid-icon--warning"
                    aria-hidden="true"
                />

                <div id="{{ $warningId }}" class="ui-form-requirement" role="alert">
                    {{ $warnText }}
                </div>
            @endif
        </div>
    @endif

    {{-- ----------------------------------------------------------------------
        Helper Text
        ----------------------------------------------------------------------
        Helper text is shown only when invalid/warning text is not active.
        ---------------------------------------------------------------------- --}}

    @if ($showHelper)
        <div id="{{ $helperId }}" @class($helperClasses)>
            {{ $helperText }}
        </div>
    @endif
</div>