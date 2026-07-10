{{-- ==========================================================================
    File: resources/views/components/ui/dialog/body.blade.php
    Purpose: UI dialog body/content region.

    Source: Converted from the Carbon DialogBody React component.

    Notes:
    - Applies scroll-content classes when requested.
    - Automatic scroll detection belongs in JavaScript if needed.
    - Scroll-region labelling can be supplied with labelledby, ariaLabelledBy,
      aria-label, or ariaLabel.
    - Accepts extraAttributes for safe component-to-component attribute
      forwarding.
    ========================================================================== --}}

@props ([
    "hasScrollingContent" => false,
    "noFade" => false,
    "labelledby" => null,
    "ariaLabelledBy" => null,
    "ariaLabel" => null,
    "extraAttributes" => null,
])

@php
    use Illuminate\View\ComponentAttributeBag;

    /*
     *--------------------------------------------------------------------------
     * Attribute bag state
     *--------------------------------------------------------------------------
     */

    $extraAttributes = $extraAttributes instanceof ComponentAttributeBag
        ? $extraAttributes
        : new ComponentAttributeBag();

    /*
     *--------------------------------------------------------------------------
     * Render state
     *--------------------------------------------------------------------------
     */

    $hasScroll = filter_var($hasScrollingContent, FILTER_VALIDATE_BOOLEAN);
    $hasNoFade = $hasScroll && filter_var($noFade, FILTER_VALIDATE_BOOLEAN);

    /*
     *--------------------------------------------------------------------------
     * Resolve ARIA
     *--------------------------------------------------------------------------
     */

    $resolvedLabelledBy = $labelledby
        ?? $ariaLabelledBy
        ?? $attributes->get('aria-labelledby')
        ?? $extraAttributes->get('aria-labelledby');

    $resolvedAriaLabel = $ariaLabel
        ?? $attributes->get('aria-label')
        ?? $extraAttributes->get('aria-label');

    /*
     *--------------------------------------------------------------------------
     * CSS class contract
     *--------------------------------------------------------------------------
     */

    $classes = [
        'ui-dialog-content',
        'ui-dialog-scroll-content' => $hasScroll,
        'ui-dialog-scroll-content--no-fade' => $hasNoFade,
    ];

    /*
     *--------------------------------------------------------------------------
     * Attribute handling
     *--------------------------------------------------------------------------
     */

    $directAttributes = $attributes->except([
        'aria-label',
        'aria-labelledby',
    ]);

    $extraContentAttributes = $extraAttributes->except([
        'aria-label',
        'aria-labelledby',
    ]);

    $mergedAttributes = (new ComponentAttributeBag(
        array_merge(
            $extraContentAttributes->getAttributes(),
            $directAttributes->getAttributes()
        )
    ))
        ->class($classes)
        ->merge([
            'tabindex' => $hasScroll ? '0' : null,
            'role' => $hasScroll ? 'region' : null,
            'aria-labelledby' => $hasScroll && filled($resolvedLabelledBy)
                ? $resolvedLabelledBy
                : null,
            'aria-label' => $hasScroll && blank($resolvedLabelledBy) && filled($resolvedAriaLabel)
                ? $resolvedAriaLabel
                : null,
            'data-ui-component' => 'dialog-body',
            'data-ui-dialog-body' => 'true',
            'data-ui-dialog-body-scroll-content' => $hasScroll ? 'true' : 'false',
            'data-ui-dialog-body-no-fade' => $hasNoFade ? 'true' : 'false',
        ]);
@endphp

<div {{ $mergedAttributes }}>{{ $slot }}</div>
