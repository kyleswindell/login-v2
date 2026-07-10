{{-- ==========================================================================
    File: resources/views/components/ui/popover/content.blade.php
    Purpose: Popover content component.

    Source: Ported from Carbon React PopoverContent.

    Notes:
    - Mirrors Carbon's PopoverContent DOM structure.
    - Renders .ui-popover > .ui-popover-content.
    - Caret renders inside content for auto-align and outside content otherwise,
      matching the React PopoverContent branch behavior.
    ========================================================================== --}}

@props([
    'id' => null,
    'label' => null,
    'labelledby' => null,
    'role' => null,
    'caret' => true,
    'autoAlign' => false,
])

@php
    $resolvedId = $id ?? 'popover-content-'.str()->random(8);

    $contentAttributes = $attributes
        ->class('ui-popover-content')
        ->merge([
            'id' => $resolvedId,
            'data-ui-popover-content' => true,
            'data-ui-popover-panel' => true,
        ]);

    if ($role) {
        $contentAttributes = $contentAttributes->merge([
            'role' => $role,
        ]);
    }

    if ($label) {
        $contentAttributes = $contentAttributes->merge([
            'aria-label' => $label,
        ]);
    }

    if ($labelledby) {
        $contentAttributes = $contentAttributes->merge([
            'aria-labelledby' => $labelledby,
        ]);
    }
@endphp

<span class="ui-popover">
    <span {{ $contentAttributes }}>
        {{ $slot }}

        @if ($caret && $autoAlign)
            <span
                class="ui-popover-caret ui-popover--auto-align"
                aria-hidden="true"
                data-ui-popover-caret
            ></span>
        @endif
    </span>

    @if ($caret && ! $autoAlign)
        <span
            class="ui-popover-caret"
            aria-hidden="true"
            data-ui-popover-caret
        ></span>
    @endif
</span>