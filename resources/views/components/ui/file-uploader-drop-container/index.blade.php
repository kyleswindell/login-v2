{{-- ==========================================================================
    File: resources/views/components/ui/file-uploader-drop-container/index.blade.php
    Purpose: Drag-and-drop File Uploader container component.

    Notes:
    - Emits the installed .ui-file__drop-container selector contract.
    - Renders a button-like drop target and hidden native file input.
    - Supports accepted file types, multiple files, max file size metadata,
      disabled state, and label text.
    - Drag/drop, input click, validation, and file list updates are handled by
      installed File Uploader JavaScript.
    - File Uploader styles are handled by resources/css/components/file-uploader.css.
    ========================================================================== --}}

@props([
    'accept' => [],
    'disabled' => false,
    'id' => null,
    'labelText' => 'Add file',
    'maxFileSize' => null,
    'multiple' => false,
    'name' => null,
    'pattern' => '.[0-9a-z]+$',
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedId = $id ?? 'ui-file-drop-input-'.Str::uuid();

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

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $fileClasses = [
        'ui-file',
        'ui-file--drop-disabled' => $isDisabled,
    ];

    $dropClasses = [
        'ui-file__drop-container',
        'ui-file-browse-btn',
        'ui-file-browse-btn--disabled' => $isDisabled,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | Caller attributes apply to the root component. The trigger owns only the
    | installed drop target and input target data hooks.
    |
    */

    $rootAttributes = $attributes;
@endphp

<div
    {{ $rootAttributes->class($fileClasses)->merge([
        'data-ui-component' => 'file-uploader-drop-container',
        'data-ui-file-drop' => true,
        'data-ui-file-drop-input-target' => $resolvedId,
        'data-ui-file-drop-disabled' => $isDisabled ? 'true' : 'false',
        'data-ui-file-drop-multiple' => $allowsMultiple ? 'true' : 'false',
        'data-ui-file-drop-accept' => $acceptValue,
        'data-ui-file-drop-pattern' => $pattern,
        'data-ui-file-drop-max-file-size' => $maxFileSize,
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Drop Target
        ----------------------------------------------------------------------
        JavaScript handles drag-over, drag-leave, drop, keyboard, and click.
        ---------------------------------------------------------------------- --}}

    <button
        type="button"
        @class($dropClasses)
        @disabled($isDisabled)
        data-ui-file-drop-trigger
        data-ui-file-uploader-input-target="{{ $resolvedId }}"
    >
        @if ($labelText instanceof HtmlString)
            {!! $labelText !!}
        @else
            {{ $labelText }}
        @endif
    </button>

    {{-- ----------------------------------------------------------------------
        Hidden Label and Native File Input
        ---------------------------------------------------------------------- --}}

    <label
        for="{{ $resolvedId }}"
        class="ui-visually-hidden"
    >
        @if ($labelText instanceof HtmlString)
            {!! $labelText !!}
        @else
            {{ $labelText }}
        @endif
    </label>

    <input
        id="{{ $resolvedId }}"
        type="file"
        class="ui-file-input"
        tabindex="-1"
        @disabled($isDisabled)
        @if (filled($acceptValue)) accept="{{ $acceptValue }}" @endif
        @if (filled($name)) name="{{ $name }}" @endif
        @if ($allowsMultiple) multiple @endif
        data-ui-file-uploader-input
        data-ui-file-drop-input
        data-ui-file-drop-input-accept="{{ $acceptValue }}"
        data-ui-file-drop-input-multiple="{{ $allowsMultiple ? 'true' : 'false' }}"
    >
</div>