{{-- ==========================================================================
    File: resources/views/components/ui/data-table/head.blade.php
    Purpose: Data Table head section wrapper.

    Notes:
    - Provides a low-level composition point for header rows.
    - Keeps native table semantics intact.
    ========================================================================== --}}

<thead {{ $attributes }}>
    {{ $slot }}
</thead>
