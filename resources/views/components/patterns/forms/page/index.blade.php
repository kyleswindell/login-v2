{{-- ==========================================================================
    File: resources/views/components/patterns/forms/page/index.blade.php
    Purpose: Dedicated page form pattern.

    Notes:
    - Owns dedicated-page form composition: heading region, description,
      optional status region, body region, actions region, and optional footer.
    - Composes x-ui.form so native form rendering, CSRF, and Laravel method
      spoofing remain owned by the Form component.
    - Does not own field APIs, field labels, helper text, validation text,
      persistence, authorization, dirty-state detection, or submit/cancel
      business semantics.
    - Field components, x-ui.form-item, x-ui.form-label, and x-ui.form-group own
      field-level semantics and ARIA relationships.
    - Form actions should usually be supplied through the actions slot using
      x-patterns.forms.actions or explicit action controls.
    - Caller attributes are intentionally routed to the inner x-ui.form because
      form attributes such as enctype, data markers, and wire handlers belong
      on the native form element.
    ========================================================================== --}}

@props ([
    "title",
    "description" => null,
    "action" => null,
    "method" => "POST",
    "csrf" => true,
    "titleId" => null,
    "width" => "lg",
    "fluid" => true,
    "novalidate" => true,
    "showHeader" => true,
    "submitState" => false,
    "loadingText" => null,
    "successText" => null,
    "errorText" => null,
])

@php
    use Illuminate\Support\Str;

    /*
    |--------------------------------------------------------------------------
    | Width
    |--------------------------------------------------------------------------
    */

    $allowedWidths = [
        'sm',
        'md',
        'lg',
        'xl',
        'full',
    ];

    $resolvedWidth = is_string($width) && in_array($width, $allowedWidths, true)
        ? $width
        : 'lg';

    $widthClasses = [
        'sm' => 'max-w-xl',
        'md' => 'max-w-2xl',
        'lg' => 'max-w-4xl',
        'xl' => 'max-w-6xl',
        'full' => 'max-w-none',
    ];

    /*
    |--------------------------------------------------------------------------
    | State
    |--------------------------------------------------------------------------
    */

    $isFluid = filter_var($fluid, FILTER_VALIDATE_BOOLEAN);
    $usesNoValidate = filter_var($novalidate, FILTER_VALIDATE_BOOLEAN);
    $showsHeader = filter_var($showHeader, FILTER_VALIDATE_BOOLEAN);
    $usesSubmitState = filter_var($submitState, FILTER_VALIDATE_BOOLEAN);

    $hasStatus = isset($status) && trim($status->toHtml()) !== '';
    $hasActions = isset($actions) && trim($actions->toHtml()) !== '';
    $hasFooter = isset($footer) && trim($footer->toHtml()) !== '';

    /*
    |--------------------------------------------------------------------------
    | Accessible Naming
    |--------------------------------------------------------------------------
    */

    $resolvedTitleId = filled($titleId)
        ? $titleId
        : ($showsHeader ? 'ui-form-page-title-'.Str::uuid() : null);

    $resolvedDescriptionId = filled($description) && $showsHeader
        ? $resolvedTitleId.'-description'
        : null;

    /*
    |--------------------------------------------------------------------------
    | Class Contract
    |--------------------------------------------------------------------------
    */

    $rootClasses = [
        'ui-form-page',
        'ui-form-page--width-'.$resolvedWidth,
        'flex',
        'w-full',
        'flex-col',
        'gap-8',
        'mx-auto' => $resolvedWidth !== 'full',
        $widthClasses[$resolvedWidth],
    ];

    $headerClasses = [
        'ui-form-page__header',
        'flex',
        'flex-col',
        'gap-5',
    ];

    $headingClasses = [
        'ui-form-page__heading',
        'flex',
        'flex-col',
        'gap-2',
    ];

    $titleClasses = [
        'ui-form-page__title',
        'ui-card-title',
    ];

    $descriptionClasses = [
        'ui-form-page__description',
        'ui-card-copy',
    ];

    $formClasses = [
        'ui-form-page__form',
        'flex',
        'flex-col',
        'gap-8',
        'ui-form--fluid' => $isFluid,
    ];

    $bodyClasses = [
        'ui-form-page__body',
        'flex',
        'flex-col',
        'gap-6',
    ];

    $statusClasses = [
        'ui-form-page__status',
    ];

    $actionsClasses = [
        'ui-form-page__actions',
    ];

    $footerClasses = [
        'ui-form-page__footer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Root Attributes
    |--------------------------------------------------------------------------
    */

    $rootAttributes = [
        'data-ui-pattern' => 'forms.page',
        'data-ui-form-page' => true,
        'data-ui-form-page-width' => $resolvedWidth,
        'data-ui-form-page-fluid' => $isFluid ? 'true' : 'false',
        'data-ui-form-page-header' => $showsHeader ? 'true' : 'false',
    ];

    if (filled($resolvedTitleId)) {
        $rootAttributes['aria-labelledby'] = $resolvedTitleId;
    }

    if (filled($resolvedDescriptionId)) {
        $rootAttributes['aria-describedby'] = $resolvedDescriptionId;
    }

    /*
    |--------------------------------------------------------------------------
    | Form Attributes
    |--------------------------------------------------------------------------
    */

    $formAttributes = [
        'data-ui-form-page-form' => true,
        'novalidate' => $usesNoValidate ? true : null,
        'data-ui-form-submit-state' => $usesSubmitState ? 'true' : null,
        'data-ui-form-submit-state-loading-text' => filled($loadingText) ? $loadingText : null,
        'data-ui-form-submit-state-success-text' => filled($successText) ? $successText : null,
        'data-ui-form-submit-state-error-text' => filled($errorText) ? $errorText : null,
    ];
@endphp

<section
    @class ($rootClasses)
    @foreach ($rootAttributes as $attribute => $value)
        @if (!is_null($value))
            {{ $attribute }}="{{ $value === true ? $attribute : $value }}"
        @endif
    @endforeach
>
    @if ($showsHeader)
        {{-- ------------------------------------------------------------------
            Page Header
            ------------------------------------------------------------------ --}}

        <header @class ($headerClasses) data-ui-form-page-header-region>
            <div @class ($headingClasses) data-ui-form-page-heading>
                <h1 id="{{ $resolvedTitleId }}" @class ($titleClasses)>
                    {{ $title }}
                </h1>

                @if (filled($description))
                    <p
                        id="{{ $resolvedDescriptionId }}"
                        @class ($descriptionClasses)
                    >
                        {{ $description }}
                    </p>
                @endif
            </div>

            @if ($hasStatus)
                <div @class ($statusClasses) data-ui-form-page-status>
                    {{ $status }}
                </div>
            @endif
        </header>
    @endif

    @if (!$showsHeader && $hasStatus)
        {{-- ------------------------------------------------------------------
            External Header Status
            ------------------------------------------------------------------ --}}

        <div @class ($statusClasses) data-ui-form-page-status>
            {{ $status }}
        </div>
    @endif

    {{-- ----------------------------------------------------------------------
        Native Form Wrapper
        ---------------------------------------------------------------------- --}}

    <x-ui.form
        :method="$method"
        :action="$action"
        :csrf="$csrf"
        {{
            $attributes
                ->class($formClasses)
                ->merge($formAttributes)
        }}
    >
        <div @class ($bodyClasses) data-ui-form-page-body>{{ $slot }}</div>

        @if ($hasActions)
            <footer @class ($actionsClasses) data-ui-form-page-actions>
                {{ $actions }}
            </footer>
        @endif
    </x-ui.form>

    @if ($hasFooter)
        {{-- ------------------------------------------------------------------
            Footer / Help Region
            ------------------------------------------------------------------ --}}

        <footer @class ($footerClasses) data-ui-form-page-footer>
            {{ $footer }}
        </footer>
    @endif
</section>
