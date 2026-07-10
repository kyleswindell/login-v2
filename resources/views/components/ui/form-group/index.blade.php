{{-- ==========================================================================
    File: resources/views/components/ui/form-group/index.blade.php
    Purpose: Form Group fieldset component.

    Notes:
    - Emits the installed .ui-fieldset selector contract.
    - Provides a native fieldset and legend wrapper for grouped form controls.
    - Supports disabled, invalid, and optional group message states.
    - Does not manage individual child control validation.
    - Form group styles are handled by shared form CSS.
    ========================================================================== --}}

@props([
    'id' => null,
    'legendId' => null,
    'legendText',
    'disabled' => false,
    'invalid' => false,
    'message' => false,
    'messageText' => '',
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Resolve IDs
    |--------------------------------------------------------------------------
    |
    | The legend ID is used as the fieldset accessible name through
    | aria-labelledby.
    |
    */

    $resolvedId = $id;

    $resolvedLegendId = $legendId
        ?? $attributes->get('aria-labelledby')
        ?? 'ui-form-group-legend-'.Str::uuid();

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isInvalid = ! $isDisabled && filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
    $showsMessage = filter_var($message, FILTER_VALIDATE_BOOLEAN) && filled($messageText);

    $stateValue = $isInvalid ? 'invalid' : 'default';

    /*
    |--------------------------------------------------------------------------
    | Message IDs and ARIA Wiring
    |--------------------------------------------------------------------------
    */

    $messageId = $showsMessage
        ? $resolvedLegendId.'-message'
        : null;

    $existingDescribedBy = $attributes->get('aria-describedby');

    $ariaDescribedBy = collect([
        $existingDescribedBy,
        $messageId,
    ])->filter()->implode(' ');

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-fieldset',
        'ui-fieldset--disabled' => $isDisabled,
        'ui-fieldset--invalid' => $isInvalid,
        'ui-fieldset--message' => $showsMessage,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | aria-labelledby and aria-describedby are rebuilt so generated IDs can be
    | merged safely with caller-provided attributes.
    |
    */

    $fieldsetAttributes = $attributes->except([
        'id',
        'aria-labelledby',
        'aria-describedby',
        'aria-errormessage',
        'disabled',
    ]);
@endphp

<fieldset
    @if (filled($resolvedId)) id="{{ $resolvedId }}" @endif
    @disabled($isDisabled)
    @if ($isInvalid) data-invalid="true" aria-invalid="true" @endif
    aria-labelledby="{{ $resolvedLegendId }}"
    @if (filled($messageId) && $isInvalid) aria-errormessage="{{ $messageId }}" @endif
    @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
    {{ $fieldsetAttributes->class($classes)->merge([
        'data-ui-component' => 'form-group',
        'data-ui-form-group' => true,
        'data-ui-form-group-state' => $stateValue,
        'data-ui-form-group-disabled' => $isDisabled ? 'true' : 'false',
        'data-ui-form-group-message' => $showsMessage ? 'true' : 'false',
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Legend
        ----------------------------------------------------------------------
        The legend labels the grouped form controls.
        ---------------------------------------------------------------------- --}}

    <legend id="{{ $resolvedLegendId }}" class="ui-label">
        @if ($legendText instanceof HtmlString)
            {!! $legendText !!}
        @else
            {{ $legendText }}
        @endif
    </legend>

    {{-- ----------------------------------------------------------------------
        Group Content
        ----------------------------------------------------------------------
        Child controls own their individual input semantics.
        ---------------------------------------------------------------------- --}}

    {{ $slot }}

    {{-- ----------------------------------------------------------------------
        Group Message
        ----------------------------------------------------------------------
        Optional group-level requirement or validation message.
        ---------------------------------------------------------------------- --}}

    @if ($showsMessage)
        <div
            id="{{ $messageId }}"
            class="ui-form__requirements"
            @if ($isInvalid) role="alert" @endif
            data-ui-form-group-message-content
        >
            {{ $messageText }}
        </div>
    @endif
</fieldset>