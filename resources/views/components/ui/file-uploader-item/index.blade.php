{{-- ==========================================================================
    File: resources/views/components/ui/file-uploader-item/index.blade.php
    Purpose: File Uploader selected file item component.

    Notes:
    - Emits the installed .ui-file__selected-file selector contract.
    - Supports uploading, edit, complete, invalid, disabled, and error states.
    - Filename status icon/button is rendered by resources/views/components/ui/filename/index.blade.php.
    - File deletion behavior is handled by installed File Uploader JavaScript.
    - File Uploader styles are handled by resources/css/components/file-uploader.css.
    ========================================================================== --}}

@props([
    'uuid' => null,
    'name' => '',
    'status' => 'uploading',
    'iconDescription' => 'Remove uploaded file',
    'invalid' => false,
    'errorSubject' => null,
    'errorBody' => null,
    'size' => 'md',
    'disabled' => false,
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

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

    $allowedSizes = [
        'sm',
        'small',
        'md',
        'field',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedUuid = $uuid ?? 'ui-file-item-'.Str::uuid();

    $resolvedStatus = in_array($status, $allowedStatuses, true)
        ? $status
        : 'uploading';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'md';

    $filenameId = Str::slug('ui-file-filename-'.$resolvedUuid, '-');
    $errorId = $filenameId.'-error';

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isInvalid = filter_var($invalid, FILTER_VALIDATE_BOOLEAN);
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $hasErrorMessage = $isInvalid && (filled($errorSubject) || filled($errorBody));

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-file__selected-file',
        'ui-file__selected-file--invalid' => $isInvalid,
        'ui-file__selected-file--md' => $resolvedSize === 'md' || $resolvedSize === 'field',
        'ui-file__selected-file--sm' => $resolvedSize === 'sm' || $resolvedSize === 'small',
        'ui-file__selected-file--disabled' => $isDisabled,
    ];

    $filenameContainerClasses = [
        $isInvalid ? 'ui-file-filename-container-wrap-invalid' : 'ui-file-filename-container-wrap',
    ];
@endphp

<span
    {{ $attributes->class($classes)->merge([
        'data-ui-component' => 'file-uploader-item',
        'data-ui-file-uploader-item' => true,
        'data-ui-file-uploader-item-uuid' => $resolvedUuid,
        'data-ui-file-uploader-item-name' => $name,
        'data-ui-file-uploader-item-status' => $resolvedStatus,
        'data-ui-file-uploader-item-size' => $resolvedSize,
        'data-ui-file-uploader-item-invalid' => $isInvalid ? 'true' : 'false',
        'data-ui-file-uploader-item-disabled' => $isDisabled ? 'true' : 'false',
        'data-ui-file-uploader-item-error' => $hasErrorMessage ? 'true' : 'false',
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Filename
        ---------------------------------------------------------------------- --}}

    <span @class($filenameContainerClasses)>
        <p
            id="{{ $filenameId }}"
            class="ui-file-filename"
            title="{{ $name }}"
            data-ui-file-uploader-item-filename
        >
            {{ $name }}
        </p>
    </span>

    {{-- ----------------------------------------------------------------------
        Status and Delete Control
        ----------------------------------------------------------------------
        x-ui.filename owns the status icon/button affordance.
        ---------------------------------------------------------------------- --}}

    <span class="ui-file-container-item" data-ui-file-uploader-item-status-container>
        <span class="ui-file__state-container">
            <x-ui.filename
                :name="$name"
                :status="$resolvedStatus"
                :invalid="$isInvalid"
                :disabled="$isDisabled"
                :icon-description="$iconDescription"
                :aria-describedby="$hasErrorMessage ? $errorId : null"
                :uuid="$resolvedUuid"
            />
        </span>
    </span>

    {{-- ----------------------------------------------------------------------
        Invalid File Message
        ---------------------------------------------------------------------- --}}

    @if ($hasErrorMessage)
        <div
            id="{{ $errorId }}"
            class="ui-form-requirement"
            role="alert"
            data-ui-file-uploader-item-error-message
        >
            @if (filled($errorSubject))
                <div class="ui-form-requirement__title">
                    @if ($errorSubject instanceof HtmlString)
                        {!! $errorSubject !!}
                    @else
                        {{ $errorSubject }}
                    @endif
                </div>
            @endif

            @if (filled($errorBody))
                <p class="ui-form-requirement__supplement">
                    @if ($errorBody instanceof HtmlString)
                        {!! $errorBody !!}
                    @else
                        {{ $errorBody }}
                    @endif
                </p>
            @endif
        </div>
    @endif
</span>