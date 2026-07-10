{{-- ==========================================================================
    File: resources/views/components/ui/data-table/toolbar/content.blade.php
    Purpose: Data Table toolbar trailing content region.

    Notes:
    - Groups toolbar actions after search or batch action regions.
    - Uses the installed ui-toolbar-content selector contract.
    ========================================================================== --}}

<div
    {{ $attributes->class('ui-toolbar-content')->merge([
        'data-ui-table-toolbar-content' => true,
    ]) }}
>
    {{ $slot }}
</div>
