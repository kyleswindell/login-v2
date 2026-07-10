{{-- ==========================================================================
    File: resources/views/components/ui/checkbox-group/index.blade.php
    Purpose: Checkbox Group fieldset component.

    Notes:
    - Emits the installed .ui-checkbox-group selector contract.
    - Supports item-array rendering and slot-based checkbox content.
    - Uses native fieldset/legend structure for grouped checkbox semantics.
    - Invalid state takes precedence over warning state.
    - Helper, invalid, and warning messages are associated through aria-describedby.
    - Uses x-ui.checkbox for item-array rendering.
    - Uses the unified x-ui.icon component for validation icons.
    - Checkbox Group styles are handled by resources/css/components/checkbox.css.
    ========================================================================== --}}

@props([
    'items' => [],
    'id' => null,
    'name' => null,
    'legendText',
    'legendId' => null,
    'helperText' => null,
    'invalid' => false,
    'invalidText' => null,
    'warn' => false,
    'warnText' => null,
    'orientation' => 'vertical',
    'disabled' => false,
    'readOnly' => false,
    'decorator' => null,
    'slug' => null,
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedOrientations = [
        'horizontal',
        'vertical',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    |
    | `slug` is retained as a legacy alias for `decorator`.
    |
    */

    $resolvedId = $id ?? 'ui-checkbox-group-'.Str::uuid();
    $resolvedLegendId = $legendId ?? $resolvedId.'-legend';

    $resolvedOrientation = in_array($orientation, $allowedOrientations, true)
        ? $orientation
        : 'vertical';

    $resolvedDecorator = $decorator ?? $slug;

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

    $isInvalid = ! $isDisabled && filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
    $isWarning = ! $isDisabled && ! $isInvalid && filter_var($warn, FILTER_VALIDATE_BOOLEAN);

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

    $hasDecorator = isset($resolvedDecorator) && filled($resolvedDecorator);

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

    $fieldsetClasses = [
        'ui-checkbox-group',
        'ui-checkbox-group--horizontal' => $resolvedOrientation === 'horizontal',
        'ui-checkbox-group--vertical' => $resolvedOrientation === 'vertical',
        'ui-checkbox-group--readonly' => $isReadOnly,
        'ui-checkbox-group--invalid' => $isInvalid,
        'ui-checkbox-group--warning' => $isWarning,
        'ui-checkbox-group--decorator' => $hasDecorator,
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
    | aria-describedby and aria-labelledby are rebuilt so generated IDs can be
    | merged safely with caller-provided attributes.
    |
    */

    $fieldsetAttributes = $attributes->except([
        'aria-describedby',
        'aria-errormessage',
        'aria-labelledby',
        'disabled',
        'readonly',
    ]);
@endphp

<fieldset
    id="{{ $resolvedId }}"
    @disabled($isDisabled)
    @if ($isInvalid) data-invalid="true" aria-invalid="true" @endif
    @if ($isReadOnly) data-readonly="true" @endif
    @if ($isDisabled) aria-disabled="true" @endif
    aria-labelledby="{{ $resolvedLegendId }}"
    @if (filled($invalidId)) aria-errormessage="{{ $invalidId }}" @endif
    @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
    {{ $fieldsetAttributes->class($fieldsetClasses)->merge([
        'data-ui-component' => 'checkbox-group',
        'data-ui-checkbox-group' => true,
        'data-ui-checkbox-group-orientation' => $resolvedOrientation,
        'data-ui-checkbox-group-disabled' => $isDisabled ? 'true' : 'false',
        'data-ui-checkbox-group-readonly' => $isReadOnly ? 'true' : 'false',
        'data-ui-checkbox-group-state' => $stateValue,
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Legend
        ----------------------------------------------------------------------
        The legend labels the grouped checkbox controls.
        ---------------------------------------------------------------------- --}}

    <legend id="{{ $resolvedLegendId }}" class="ui-label">
        @if ($legendText instanceof HtmlString)
            {!! $legendText !!}
        @else
            {{ $legendText }}
        @endif

        @if ($hasDecorator)
            <span class="ui-checkbox-group-inner--decorator">
                @if ($resolvedDecorator instanceof HtmlString)
                    {!! $resolvedDecorator !!}
                @else
                    {{ $resolvedDecorator }}
                @endif
            </span>
        @endif
    </legend>

    {{-- ----------------------------------------------------------------------
        Item-array Checkboxes
        ----------------------------------------------------------------------
        When items are provided, this group applies group-level disabled and
        read-only state. Individual item validation is only applied when the
        item explicitly provides invalid/warn values.
        ---------------------------------------------------------------------- --}}

    @foreach ($items as $index => $item)
        @php
            $itemData = is_array($item)
                ? $item
                : [
                    'value' => $item,
                    'label' => $item,
                ];

            $itemId = data_get($itemData, 'id', $resolvedId.'-item-'.$index);
            $itemName = data_get($itemData, 'name', $name);

            $itemDisabled = $isDisabled
                || filter_var(data_get($itemData, 'disabled', false), FILTER_VALIDATE_BOOLEAN);

            $itemReadOnly = $isReadOnly
                || filter_var(data_get($itemData, 'readOnly', data_get($itemData, 'read_only', false)), FILTER_VALIDATE_BOOLEAN);

            $itemChecked = filter_var(data_get($itemData, 'checked', false), FILTER_VALIDATE_BOOLEAN);
            $itemDefaultChecked = filter_var(data_get($itemData, 'defaultChecked', data_get($itemData, 'default_checked', false)), FILTER_VALIDATE_BOOLEAN);
            $itemRequired = filter_var(data_get($itemData, 'required', false), FILTER_VALIDATE_BOOLEAN);
            $itemHideLabel = filter_var(data_get($itemData, 'hideLabel', data_get($itemData, 'hide_label', false)), FILTER_VALIDATE_BOOLEAN);
            $itemIndeterminate = filter_var(data_get($itemData, 'indeterminate', false), FILTER_VALIDATE_BOOLEAN);

            $itemInvalid = array_key_exists('invalid', $itemData)
                ? filter_var(data_get($itemData, 'invalid', false), FILTER_VALIDATE_BOOLEAN)
                : false;

            $itemWarn = array_key_exists('warn', $itemData)
                ? filter_var(data_get($itemData, 'warn', false), FILTER_VALIDATE_BOOLEAN)
                : false;
        @endphp

        <x-ui.checkbox
            :id="$itemId"
            :name="$itemName"
            :value="data_get($itemData, 'value', 'on')"
            :label-text="data_get($itemData, 'labelText', data_get($itemData, 'label', ''))"
            :checked="$itemChecked"
            :default-checked="$itemDefaultChecked"
            :disabled="$itemDisabled"
            :read-only="$itemReadOnly"
            :required="$itemRequired"
            :helper-text="data_get($itemData, 'helperText', data_get($itemData, 'helper_text'))"
            :hide-label="$itemHideLabel"
            :indeterminate="$itemIndeterminate"
            :invalid="$itemInvalid"
            :invalid-text="data_get($itemData, 'invalidText', data_get($itemData, 'invalid_text'))"
            :warn="$itemWarn"
            :warn-text="data_get($itemData, 'warnText', data_get($itemData, 'warn_text'))"
            :title="data_get($itemData, 'title', '')"
            :decorator="data_get($itemData, 'decorator')"
        />
    @endforeach

    {{-- ----------------------------------------------------------------------
        Slot Checkboxes
        ----------------------------------------------------------------------
        Slot mode is manual. The caller controls child checkbox state.
        ---------------------------------------------------------------------- --}}

    @if ($hasSlotContent)
        {{ $slot }}
    @endif

    {{-- ----------------------------------------------------------------------
        Validation and Warning Message
        ----------------------------------------------------------------------
        Invalid text takes precedence over warning text.
        ---------------------------------------------------------------------- --}}

    @if ($showInvalid || $showWarning)
        <div class="ui-checkbox-group__validation-msg">
            @if ($showInvalid)
                <x-ui.icon
                    name="warning--filled"
                    class="ui-checkbox__invalid-icon"
                    aria-hidden="true"
                />

                <div id="{{ $invalidId }}" class="ui-form-requirement" role="alert">
                    {{ $invalidText }}
                </div>
            @elseif ($showWarning)
                <x-ui.icon
                    name="warning--alt"
                    class="ui-checkbox__invalid-icon ui-checkbox__invalid-icon--warning"
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
</fieldset>