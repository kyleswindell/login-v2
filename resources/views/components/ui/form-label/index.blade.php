{{-- ==========================================================================
    File: resources/views/components/ui/form-label/index.blade.php
    Purpose: Form Label component.

    Notes:
    - Emits the installed .ui-label selector contract.
    - Adds .ui-label--no-margin for standalone label usage.
    - Intended for custom form layouts where the field component does not own
      the label.
    - Does not render helper, validation, or field wrapper markup.
    - Form label styles are handled by shared form CSS.
    ========================================================================== --}}

@props([
    'for' => null,
    'id' => null,
    'disabled' => false,
    'hideLabel' => false,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Resolve Target Control
    |--------------------------------------------------------------------------
    |
    | `for` is canonical. `id` is retained as a compatibility alias because the
    | source API used id as the label target.
    |
    */

    $resolvedFor = $for ?? $id;

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isHidden = filter_var($hideLabel, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-label',
        'ui-label--no-margin',
        'ui-label--disabled' => $isDisabled,
        'ui-visually-hidden' => $isHidden,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | The label target is owned by this component. The id prop is not the label
    | element ID; it is retained as a compatibility alias for for.
    |
    */

    $labelAttributes = $attributes->except([
        'for',
        'id',
        'disabled',
        'hide-label',
        'hideLabel',
    ]);
@endphp

<label
    @if (filled($resolvedFor)) for="{{ $resolvedFor }}" @endif
    {{ $labelAttributes->class($classes)->merge([
        'data-ui-component' => 'form-label',
        'data-ui-form-label' => true,
        'data-ui-form-label-for' => $resolvedFor,
        'data-ui-form-label-disabled' => $isDisabled ? 'true' : 'false',
        'data-ui-form-label-hidden' => $isHidden ? 'true' : 'false',
    ]) }}
>
    {{ $slot }}
</label>