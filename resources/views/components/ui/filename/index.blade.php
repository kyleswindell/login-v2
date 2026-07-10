{{-- ==========================================================================
    File: resources/views/components/ui/filename/index.blade.php
    Purpose: File Uploader filename status renderer.

    Notes:
    - Emits the installed file status selector contract.
    - Supports uploading, edit, and complete states.
    - Edit state renders a remove button.
    - Uploading state renders a small loading indicator.
    - Complete and invalid states use the unified x-ui.icon component.
    - File Uploader styles are handled by resources/css/components/file-uploader.css.
    ========================================================================== --}}

@props([
    'uuid' => null,
    'name' => '',
    'status' => 'uploading',
    'iconDescription' => 'Uploading file',
    'invalid' => false,
    'disabled' => false,
    'tabIndex' => 0,
    'ariaDescribedby' => null,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedStatuses = [
        'uploading',
        'edit',
        'complete',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedStatus = in_array($status, $allowedStatuses, true)
        ? $status
        : 'uploading';

    $resolvedAriaDescribedBy = $ariaDescribedby ?? $attributes->get('aria-describedby');

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isInvalid = filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);

    $resolvedTabIndex = is_numeric($tabIndex)
        ? (int) $tabIndex
        : 0;

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    */

    $statusAttributes = $attributes->except([
        'aria-describedby',
        'uuid',
        'name',
        'status',
        'icon-description',
        'iconDescription',
        'invalid',
        'disabled',
        'tab-index',
        'tabIndex',
        'aria-describedby',
        'ariaDescribedby',
    ]);
@endphp

@if ($resolvedStatus === 'uploading')
    {{-- ----------------------------------------------------------------------
        Uploading Status
        ---------------------------------------------------------------------- --}}

    <span
        {{ $statusAttributes->class([
            'ui-file-loading',
            'ui-spinner',
        ])->merge([
            'role' => 'status',
            'aria-label' => $iconDescription,
            'data-ui-component' => 'filename',
            'data-ui-filename' => true,
            'data-ui-file-status' => 'uploading',
            'data-ui-file-invalid' => $isInvalid ? 'true' : 'false',
            'data-ui-file-disabled' => $isDisabled ? 'true' : 'false',
        ]) }}
    >
        <span class="ui-visually-hidden">{{ $iconDescription }}</span>
    </span>
@elseif ($resolvedStatus === 'edit')
    {{-- ----------------------------------------------------------------------
        Editable / Removable Status
        ---------------------------------------------------------------------- --}}

    @if ($isInvalid)
        <x-ui.icon
            name="warning--filled"
            class="ui-file-invalid"
            aria-hidden="true"
            data-ui-component="filename"
            data-ui-filename
            data-ui-file-status="invalid"
            data-ui-file-invalid="true"
            data-ui-file-disabled="{{ $isDisabled ? 'true' : 'false' }}"
        />
    @endif

    <button
        type="button"
        aria-label="{{ $iconDescription }} - {{ $name }}"
        @if ($isInvalid && filled($resolvedAriaDescribedBy)) aria-describedby="{{ $resolvedAriaDescribedBy }}" @endif
        @disabled($isDisabled)
        tabindex="{{ $isDisabled ? '-1' : $resolvedTabIndex }}"
        {{ $statusAttributes->class([
            'ui-file-close',
        ])->merge([
            'data-ui-component' => 'filename',
            'data-ui-filename' => true,
            'data-ui-file-status' => 'edit',
            'data-ui-file-invalid' => $isInvalid ? 'true' : 'false',
            'data-ui-file-disabled' => $isDisabled ? 'true' : 'false',
            'data-ui-file-remove' => true,
            'data-ui-file-remove-uuid' => filled($uuid) ? $uuid : null,
        ]) }}
    >
        <x-ui.icon name="close" aria-hidden="true" />
    </button>
@elseif ($resolvedStatus === 'complete')
    {{-- ----------------------------------------------------------------------
        Complete Status
        ---------------------------------------------------------------------- --}}

    <x-ui.icon
        name="checkmark--filled"
        class="ui-file-complete"
        label="{{ $iconDescription }}"
        tabindex="-1"
        data-ui-component="filename"
        data-ui-filename
        data-ui-file-status="complete"
        data-ui-file-invalid="{{ $isInvalid ? 'true' : 'false' }}"
        data-ui-file-disabled="{{ $isDisabled ? 'true' : 'false' }}"
    />
@endif