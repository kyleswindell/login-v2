{{-- ==========================================================================
    File: resources/views/components/ui/dialog/root.blade.php
    Purpose: UI dialog root.

    Source: Converted from the Carbon Dialog React component.

    Notes:
    - Renders the native dialog element.
    - Wraps contents in ui-dialog-container.
    - Supports modal, open, role, aria-label, aria-labelledby, and
      aria-describedby.
    - Dialog show/showModal/close behavior should be handled by installed JS.
    ========================================================================== --}}

@props ([
    "modal" => false,
    "open" => false,
    "role" => null,
    "label" => null,
    "labelledby" => null,
    "describedby" => null,
    "ariaLabel" => null,
    "ariaLabelledBy" => null,
    "ariaDescribedBy" => null,
    "extraAttributes" => null,
    "containerAttributes" => null,
])

@php
    use Illuminate\View\ComponentAttributeBag;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedRoles = [
        'dialog',
        'alertdialog',
    ];

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isModal = filter_var($modal, FILTER_VALIDATE_BOOLEAN);
    $isOpen = filter_var($open, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | Attribute Bag State
    |--------------------------------------------------------------------------
    */

    $extraAttributes = $extraAttributes instanceof ComponentAttributeBag
        ? $extraAttributes
        : new ComponentAttributeBag();

    $containerAttributes = $containerAttributes instanceof ComponentAttributeBag
        ? $containerAttributes
        : new ComponentAttributeBag();

    /*
    |--------------------------------------------------------------------------
    | Resolve ARIA
    |--------------------------------------------------------------------------
    */

    $resolvedRole = in_array($role, $allowedRoles, true)
        ? $role
        : null;

    $resolvedAriaLabel = $label
        ?? $ariaLabel
        ?? $attributes->get('aria-label')
        ?? $extraAttributes->get('aria-label');

    $resolvedAriaLabelledby = $labelledby
        ?? $ariaLabelledBy
        ?? $attributes->get('aria-labelledby')
        ?? $extraAttributes->get('aria-labelledby');

    $resolvedAriaDescribedby = $describedby
        ?? $ariaDescribedBy
        ?? $attributes->get('aria-describedby')
        ?? $extraAttributes->get('aria-describedby');

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-dialog',
        'ui-dialog--modal' => $isModal,
        'ui-dialog--open' => $isOpen,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    */

    $directAttributes = $attributes->except([
        'aria-label',
        'aria-labelledby',
        'aria-describedby',
        'role',
        'open',
    ]);

    $extraDialogAttributes = $extraAttributes->except([
        'aria-label',
        'aria-labelledby',
        'aria-describedby',
        'role',
        'open',
    ]);

    $dialogAttributes = (new ComponentAttributeBag(
        array_merge(
            $extraDialogAttributes->getAttributes(),
            $directAttributes->getAttributes()
        )
    ))
        ->except([
            'aria-label',
            'aria-labelledby',
            'aria-describedby',
            'role',
            'open',
        ])
        ->class($classes)
        ->merge([
            'open' => $isOpen ? true : null,
            'role' => filled($resolvedRole) ? $resolvedRole : null,
            'aria-label' => filled($resolvedAriaLabel) ? $resolvedAriaLabel : null,
            'aria-labelledby' => filled($resolvedAriaLabelledby) && blank($resolvedAriaLabel)
                ? $resolvedAriaLabelledby
                : null,
            'aria-describedby' => filled($resolvedAriaDescribedby) ? $resolvedAriaDescribedby : null,
            'data-ui-component' => 'dialog',
            'data-ui-dialog' => true,
            'data-ui-dialog-modal' => $isModal ? 'true' : 'false',
            'data-ui-dialog-open' => $isOpen ? 'true' : 'false',
        ]);

    $dialogContainerAttributes = $containerAttributes
        ->class('ui-dialog-container')
        ->merge([
            'data-ui-dialog-container' => true,
        ]);
@endphp

<dialog {{ $dialogAttributes }}>
    <div {{ $dialogContainerAttributes }}>{{ $slot }}</div>
</dialog>
