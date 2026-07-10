{{-- ==========================================================================
    File: resources/views/components/ui/file-uploader-button/index.blade.php
    Purpose: File Uploader button and hidden native file input.

    Notes:
    - Emits the installed .ui-btn selector contract for the visible trigger.
    - Renders a hidden native input type="file".
    - Supports accepted file types, multiple files, disabled state, button kind,
      button size, and label text.
    - Input click and label updates are handled by installed File Uploader JavaScript.
    - Button styles are handled by resources/css/components/button.css.
    - File Uploader styles are handled by resources/css/components/file-uploader.css.
    ========================================================================== --}}

@props([
    'accept' => [],
    'buttonKind' => 'primary',
    'class' => null,
    'disabled' => false,
    'disableLabelChanges' => false,
    'id' => null,
    'labelText' => 'Add file',
    'multiple' => false,
    'name' => null,
    'size' => 'md',
])

@php
    use Illuminate\Support\Str;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedKinds = [
        'primary',
        'secondary',
        'danger',
        'ghost',
        'danger--primary',
        'danger--ghost',
        'danger--tertiary',
        'tertiary',
    ];

    $allowedSizes = [
        'sm',
        'small',
        'field',
        'md',
        'lg',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedId = $id ?? 'ui-file-uploader-input-'.Str::uuid();

    $resolvedKind = in_array($buttonKind, $allowedKinds, true)
        ? $buttonKind
        : 'primary';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'md';

    $buttonSize = match ($resolvedSize) {
        'small' => 'sm',
        'field' => 'md',
        default => $resolvedSize,
    };

    $acceptValue = is_array($accept)
        ? implode(',', $accept)
        : $accept;

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $allowsMultiple = filter_var($multiple, FILTER_VALIDATE_BOOLEAN);
    $labelChangesDisabled = filter_var($disableLabelChanges, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $buttonClasses = [
        'ui-btn',
        'ui-btn--'.$resolvedKind,
        'ui-btn--'.$buttonSize,
        'ui-layout--size-'.$resolvedSize,
        'ui-btn--disabled' => $isDisabled,
        $class,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    */

    $buttonAttributes = $attributes->except([
        'accept',
        'button-kind',
        'buttonKind',
        'disabled',
        'disable-label-changes',
        'disableLabelChanges',
        'id',
        'label-text',
        'labelText',
        'multiple',
        'name',
        'size',
    ]);
@endphp

{{-- ----------------------------------------------------------------------
    Visible Upload Trigger
    ----------------------------------------------------------------------
    JavaScript opens the paired hidden file input.
    ---------------------------------------------------------------------- --}}

<button
    type="button"
    @disabled($isDisabled)
    {{ $buttonAttributes->class($buttonClasses)->merge([
        'data-ui-component' => 'file-uploader-button',
        'data-ui-file-uploader-button' => true,
        'data-ui-file-uploader-input-target' => $resolvedId,
        'data-ui-file-uploader-button-kind' => $resolvedKind,
        'data-ui-file-uploader-button-size' => $resolvedSize,
        'data-ui-file-uploader-disabled' => $isDisabled ? 'true' : 'false',
        'data-ui-file-uploader-multiple' => $allowsMultiple ? 'true' : 'false',
        'data-ui-file-uploader-disable-label-changes' => $labelChangesDisabled ? 'true' : 'false',
    ]) }}
>
    <span data-ui-file-uploader-button-label>{{ $labelText }}</span>
</button>

{{-- ----------------------------------------------------------------------
    Hidden Label and Native File Input
    ---------------------------------------------------------------------- --}}

<label
    class="ui-visually-hidden"
    for="{{ $resolvedId }}"
>
    <span>{{ $labelText }}</span>
</label>

<input
    id="{{ $resolvedId }}"
    type="file"
    class="ui-visually-hidden"
    tabindex="-1"
    @disabled($isDisabled)
    @if (filled($acceptValue)) accept="{{ $acceptValue }}" @endif
    @if (filled($name)) name="{{ $name }}" @endif
    @if ($allowsMultiple) multiple @endif
    data-ui-file-uploader-input
    data-ui-file-uploader-input-accept="{{ $acceptValue }}"
    data-ui-file-uploader-input-multiple="{{ $allowsMultiple ? 'true' : 'false' }}"
>