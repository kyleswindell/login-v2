{{-- ==========================================================================
    File: resources/views/components/ui/select-item/index.blade.php
    Purpose: Native Select option component.

    Notes:
    - Emits the installed .ui-select-option selector contract.
    - Intended for use inside resources/views/components/ui/select/index.blade.php.
    - Renders a native <option> element.
    - Supports disabled, hidden, and selected option states.
    - Native select behavior is handled by the browser.
    - Select styles are handled by resources/css/components/select.css.
    ========================================================================== --}}

@props([
    'value' => '',
    'text' => '',
    'disabled' => false,
    'hidden' => false,
    'selected' => false,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isHidden = filter_var($hidden, FILTER_VALIDATE_BOOLEAN);
    $isSelected = filter_var($selected, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | Text Handling
    |--------------------------------------------------------------------------
    |
    | Native option content should be plain text. If text is omitted, strip any
    | accidental markup from the slot before rendering.
    |
    */

    $slotText = trim(strip_tags($slot->toHtml()));
    $resolvedText = $text !== '' ? $text : $slotText;

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-select-option',
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    */

    $optionAttributes = $attributes->except([
        'value',
        'text',
        'disabled',
        'hidden',
        'selected',
    ]);
@endphp

<option
    value="{{ $value }}"
    @disabled($isDisabled)
    @selected($isSelected)
    @if ($isHidden) hidden @endif
    {{ $optionAttributes->class($classes)->merge([
        'data-ui-component' => 'select-item',
        'data-ui-select-item' => true,
        'data-ui-select-option' => true,
        'data-ui-select-option-disabled' => $isDisabled ? 'true' : 'false',
        'data-ui-select-option-hidden' => $isHidden ? 'true' : 'false',
        'data-ui-select-option-selected' => $isSelected ? 'true' : 'false',
    ]) }}
>
    {{ $resolvedText }}
</option>