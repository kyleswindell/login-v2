{{-- ==========================================================================
    File: resources/views/components/ui/file-uploader/index.blade.php
    Purpose: File Uploader form control component.

    Notes:
    - Emits the installed .ui-file selector contract.
    - Renders optional title, description, upload button, and selected file list.
    - Supports multiple files, accepted file types, max file size metadata,
      disabled state, and file status rendering.
    - File selection, validation, list updates, and deletion behavior are handled
      by installed File Uploader JavaScript.
    - Uses x-ui.file-uploader-button for the upload trigger.
    - Uses x-ui.file-uploader-item for selected file rows.
    - File Uploader styles are handled by resources/css/components/file-uploader.css.
    ========================================================================== --}}

@props([
    'files' => [],
    'accept' => [],
    'buttonKind' => 'primary',
    'buttonLabel' => 'Add file',
    'disabled' => false,
    'filenameStatus' => 'edit',
    'iconDescription' => 'Remove uploaded file',
    'labelDescription' => null,
    'labelTitle' => null,
    'maxFileSize' => null,
    'multiple' => false,
    'name' => null,
    'size' => 'md',
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
        'lg',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedId = 'ui-file-uploader-'.Str::uuid();

    $resolvedFilenameStatus = in_array($filenameStatus, $allowedStatuses, true)
        ? $filenameStatus
        : 'edit';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'md';

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
    | File Normalization
    |--------------------------------------------------------------------------
    |
    | Files may be strings or arrays. Arrays support name, uuid, status, invalid,
    | disabled, errorSubject/error_subject, and errorBody/error_body.
    |
    */

    $visibleFiles = collect($files)->map(function ($file, int $index) use ($resolvedFilenameStatus) {
        if (is_string($file)) {
            return [
                'name' => $file,
                'uuid' => 'file-'.$index,
                'status' => $resolvedFilenameStatus,
                'invalid' => false,
                'disabled' => false,
                'errorSubject' => null,
                'errorBody' => null,
            ];
        }

        return [
            'name' => $file['name'] ?? '',
            'uuid' => $file['uuid'] ?? 'file-'.$index,
            'status' => $file['status'] ?? $resolvedFilenameStatus,
            'invalid' => filter_var($file['invalid'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'disabled' => filter_var($file['disabled'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'errorSubject' => $file['errorSubject'] ?? $file['error_subject'] ?? null,
            'errorBody' => $file['errorBody'] ?? $file['error_body'] ?? null,
        ];
    })->filter(fn ($file) => filled($file['name']))->values();

    $fileCount = $visibleFiles->count();

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-form-item',
        'ui-file',
        'ui-file--disabled' => $isDisabled,
        'ui-file--has-files' => $fileCount > 0,
    ];

    $labelTitleClasses = [
        'ui-file--label',
        'ui-label-description--disabled' => $isDisabled,
    ];

    $labelDescriptionClasses = [
        'ui-label-description',
        'ui-label-description--disabled' => $isDisabled,
    ];
@endphp

<div
    {{ $attributes->class($classes)->merge([
        'data-ui-component' => 'file-uploader',
        'data-ui-file-uploader' => true,
        'data-ui-file-uploader-id' => $resolvedId,
        'data-ui-file-uploader-multiple' => $allowsMultiple ? 'true' : 'false',
        'data-ui-file-uploader-accept' => $acceptValue,
        'data-ui-file-uploader-disabled' => $isDisabled ? 'true' : 'false',
        'data-ui-file-uploader-size' => $resolvedSize,
        'data-ui-file-uploader-filename-status' => $resolvedFilenameStatus,
        'data-ui-file-uploader-icon-description' => $iconDescription,
        'data-ui-file-uploader-max-file-size' => $maxFileSize,
        'data-ui-file-uploader-file-count' => $fileCount,
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Label Title
        ---------------------------------------------------------------------- --}}

    @if (filled($labelTitle))
        <h3 @class($labelTitleClasses)>
            @if ($labelTitle instanceof HtmlString)
                {!! $labelTitle !!}
            @else
                {{ $labelTitle }}
            @endif
        </h3>
    @endif

    {{-- ----------------------------------------------------------------------
        Label Description
        ---------------------------------------------------------------------- --}}

    @if (filled($labelDescription))
        <p id="{{ $resolvedId }}-description" @class($labelDescriptionClasses)>
            @if ($labelDescription instanceof HtmlString)
                {!! $labelDescription !!}
            @else
                {{ $labelDescription }}
            @endif
        </p>
    @endif

    {{-- ----------------------------------------------------------------------
        Upload Button
        ----------------------------------------------------------------------
        The visible button delegates to a hidden native file input.
        ---------------------------------------------------------------------- --}}

    <x-ui.file-uploader-button
        :id="$resolvedId.'-input'"
        :accept="$accept"
        :button-kind="$buttonKind"
        :label-text="$buttonLabel"
        :disabled="$isDisabled"
        :multiple="$allowsMultiple"
        :name="$name"
        :size="$resolvedSize"
        :aria-describedby="filled($labelDescription) ? $resolvedId.'-description' : null"
        data-ui-file-uploader-button-control
    />

    {{-- ----------------------------------------------------------------------
        Selected File List
        ----------------------------------------------------------------------
        JavaScript adds/removes items here after file selection.
        ---------------------------------------------------------------------- --}}

    <div
        class="ui-file-container"
        data-ui-file-container
        data-ui-file-uploader-file-list
        data-ui-file-uploader-file-count="{{ $fileCount }}"
    >
        @foreach ($visibleFiles as $file)
            <x-ui.file-uploader-item
                :uuid="$file['uuid']"
                :name="$file['name']"
                :status="$file['status']"
                :icon-description="$iconDescription"
                :invalid="$file['invalid']"
                :disabled="$file['disabled']"
                :error-subject="$file['errorSubject']"
                :error-body="$file['errorBody']"
                :size="$resolvedSize"
            />
        @endforeach
    </div>
</div>