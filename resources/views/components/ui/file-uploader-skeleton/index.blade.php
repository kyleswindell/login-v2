{{-- ==========================================================================
    File: resources/views/components/ui/file-uploader-skeleton/index.blade.php
    Purpose: File Uploader skeleton/loading placeholder component.

    Notes:
    - Emits the installed File Uploader skeleton selector contract.
    - Uses skeleton animation styles from resources/css/base/skeleton.css.
    - Uses Button skeleton support from resources/css/components/button.css.
    - Uses File Uploader styles from resources/css/components/file-uploader.css.
    - Does not render an interactive file input.
    ========================================================================== --}}

@props([])

<div
    aria-hidden="true"
    {{ $attributes->class('ui-form-item')->merge(['data-ui-component' => 'file-uploader-skeleton']) }}
>
    {{-- ----------------------------------------------------------------------
        Title and description placeholders
        ---------------------------------------------------------------------- --}}

    <div
        class="ui-skeleton ui-skeleton-text ui-skeleton-text--heading"
        style="inline-size: 100px;"
    ></div>

    <div
        class="ui-skeleton ui-skeleton-text ui-label-description"
        style="inline-size: 225px;"
    ></div>

    {{-- ----------------------------------------------------------------------
        Upload button placeholder
        ---------------------------------------------------------------------- --}}

    <x-ui.button-skeleton />
</div>