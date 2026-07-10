{{-- ==========================================================================
    File: resources/views/components/ui/select-item-group/index.blade.php
    Purpose: Native Select option group component.

    Notes:
    - Emits the installed .ui-select-optgroup selector contract.
    - Intended for use inside resources/views/components/ui/select/index.blade.php.
    - Renders a native <optgroup> element.
    - Supports disabled option group state.
    - Native select behavior is handled by the browser.
    - Select styles are handled by resources/css/components/select.css.
    ========================================================================== --}}

@props([
    'label',
    'disabled' => false,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-select-optgroup',
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    */

    $groupAttributes = $attributes->except([
        'label',
        'disabled',
    ]);
@endphp

<optgroup
    label="{{ $label }}"
    @disabled($isDisabled)
    {{ $groupAttributes->class($classes)->merge([
        'data-ui-component' => 'select-item-group',
        'data-ui-select-item-group' => true,
        'data-ui-select-optgroup' => true,
        'data-ui-select-optgroup-disabled' => $isDisabled ? 'true' : 'false',
    ]) }}
>
    {{ $slot }}
</optgroup>