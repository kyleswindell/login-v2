{{-- ==========================================================================
    File: resources/views/components/ui/code-snippet/index.blade.php
    Purpose: Code snippet component.

    Source: Ported from Carbon CodeSnippet React component.

    Notes:
    - Supports inline, single-line, and multi-line snippets.
    - Uses Carbon-like DOM structure:
      shell > snippet-container > pre > code.
    - Copy and expansion behavior is handled by
      resources/js/ui-controls/code-snippet.js.
    - The language prop is preserved for metadata but is not rendered as a
      visible header, matching Carbon's visual pattern.
    - Slot content may contain trusted syntax token markup.
    ========================================================================== --}}

@props([
    'variant' => 'single',
    'type' => null,

    'ariaLabel' => null,
    'copyable' => true,
    'hideCopyButton' => null,
    'copyText' => null,
    'copyButtonDescription' => 'Copy to clipboard',
    'feedback' => 'Copied to clipboard',
    'feedbackTimeout' => 2000,
    'copyState' => 'idle',

    'language' => null,
    'light' => false,
    'disabled' => false,
    'wrapText' => false,

    'expandable' => true,
    'showMoreText' => 'Show more',
    'showLessText' => 'Show less',
    'showMoreLabel' => null,
    'showLessLabel' => null,
    'maxCollapsedNumberOfRows' => 15,
    'maxExpandedNumberOfRows' => 0,
    'minCollapsedNumberOfRows' => 3,
    'minExpandedNumberOfRows' => 16,

    'align' => 'bottom',
    'autoAlign' => false,
])

@php
    use Illuminate\Support\Str;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedVariants = ['inline', 'single', 'multi'];
    $allowedCopyStates = ['idle', 'copied'];
    $allowedTooltipPlacements = [
        'auto',
        'top',
        'top-start',
        'top-end',
        'right',
        'right-start',
        'right-end',
        'bottom',
        'bottom-start',
        'bottom-end',
        'left',
        'left-start',
        'left-end',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Variant
    |--------------------------------------------------------------------------
    */

    $requestedVariant = $type ?? $variant;

    $resolvedVariant = in_array($requestedVariant, $allowedVariants, true)
        ? $requestedVariant
        : 'single';

    /*
    |--------------------------------------------------------------------------
    | Resolve Booleans and Copy State
    |--------------------------------------------------------------------------
    */

    $resolvedCopyState = in_array($copyState, $allowedCopyStates, true)
        ? $copyState
        : 'idle';

    $resolvedDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $resolvedLight = filter_var($light, FILTER_VALIDATE_BOOLEAN);
    $resolvedWrapText = filter_var($wrapText, FILTER_VALIDATE_BOOLEAN);
    $resolvedExpandable = filter_var($expandable, FILTER_VALIDATE_BOOLEAN);
    $resolvedAutoAlign = filter_var($autoAlign, FILTER_VALIDATE_BOOLEAN);

    $resolvedHideCopyButton = ! is_null($hideCopyButton)
        ? filter_var($hideCopyButton, FILTER_VALIDATE_BOOLEAN)
        : ! filter_var($copyable, FILTER_VALIDATE_BOOLEAN);

    $resolvedAlign = in_array($align, $allowedTooltipPlacements, true)
        ? $align
        : 'bottom';

    /*
    |--------------------------------------------------------------------------
    | Resolve Labels / IDs
    |--------------------------------------------------------------------------
    */

    $snippetId = 'ui-code-snippet-'.Str::uuid();
    $codeId = $snippetId.'-code';
    $feedbackId = $snippetId.'-feedback';

    $resolvedAriaLabel = $ariaLabel
        ?? $copyButtonDescription
        ?? 'Copy to clipboard';

    $resolvedShowMoreText = $showMoreLabel ?? $showMoreText;
    $resolvedShowLessText = $showLessLabel ?? $showLessText;

    /*
    |--------------------------------------------------------------------------
    | Resolve Row Counts
    |--------------------------------------------------------------------------
    */

    $rowHeight = 16;

    $maxCollapsedRows = max(0, (int) $maxCollapsedNumberOfRows);
    $maxExpandedRows = max(0, (int) $maxExpandedNumberOfRows);
    $minCollapsedRows = max(0, (int) $minCollapsedNumberOfRows);
    $minExpandedRows = max(0, (int) $minExpandedNumberOfRows);

    $collapsedMaxHeight = $maxCollapsedRows > 0 ? $maxCollapsedRows * $rowHeight : null;
    $collapsedMinHeight = $minCollapsedRows > 0 ? $minCollapsedRows * $rowHeight : null;
    $expandedMaxHeight = $maxExpandedRows > 0 ? $maxExpandedRows * $rowHeight : null;
    $expandedMinHeight = $minExpandedRows > 0 ? $minExpandedRows * $rowHeight : null;

    $canExpand = $resolvedVariant === 'multi' && $resolvedExpandable;

    /*
    |--------------------------------------------------------------------------
    | Resolve Code Content
    |--------------------------------------------------------------------------
    |
    | Preserve trusted slot HTML so syntax-token spans render. Plain code should
    | be escaped before being passed into the slot.
    |
    */

    $codeHtml = trim($slot->toHtml());

    $styleValue = '--ui-code-snippet-collapsed-max-height: '.($collapsedMaxHeight ?? 0).'px; '
        .'--ui-code-snippet-collapsed-min-height: '.($collapsedMinHeight ?? 0).'px; '
        .'--ui-code-snippet-expanded-max-height: '.($expandedMaxHeight ?? 0).'px; '
        .'--ui-code-snippet-expanded-min-height: '.($expandedMinHeight ?? 0).'px;';
@endphp

@if ($resolvedVariant === 'inline')
    @if ($resolvedHideCopyButton)
        <span
            {{ $attributes->class([
                'ui-code-snippet-shell',
                'ui-code-snippet-shell-inline',
                'ui-code-snippet-shell-light' => $resolvedLight,
                'ui-code-snippet-shell-disabled' => $resolvedDisabled,
                'ui-code-snippet-shell-wraptext' => $resolvedWrapText,
            ])->merge([
                'data-ui-component' => 'code-snippet',
                'data-ui-code-snippet' => true,
                'data-ui-code-snippet-variant' => 'inline',
                'data-ui-code-snippet-language' => $language,
                'data-ui-code-snippet-light' => $resolvedLight ? 'true' : 'false',
                'data-ui-code-snippet-disabled' => $resolvedDisabled ? 'true' : 'false',
                'data-ui-code-snippet-wrap-text' => $resolvedWrapText ? 'true' : 'false',
            ]) }}
        ><code
            id="{{ $codeId }}"
            data-ui-code-copy-source
            @if (filled($copyText)) data-ui-code-copy-text="{{ $copyText }}" @endif
        >{!! $codeHtml !!}</code></span>
    @else
        <button
            type="button"
            {{ $attributes->class([
                'ui-code-snippet-shell',
                'ui-code-snippet-shell-inline',
                'ui-code-snippet-shell-inline-copyable',
                'ui-code-snippet-shell-light' => $resolvedLight,
                'ui-code-snippet-shell-disabled' => $resolvedDisabled,
                'ui-code-snippet-shell-wraptext' => $resolvedWrapText,
            ])->merge([
                'aria-label' => $resolvedAriaLabel,
                'aria-describedby' => $feedbackId,
                'data-ui-component' => 'code-snippet',
                'data-ui-code-snippet' => true,
                'data-ui-code-snippet-variant' => 'inline',
                'data-ui-code-snippet-language' => $language,
                'data-ui-code-snippet-light' => $resolvedLight ? 'true' : 'false',
                'data-ui-code-snippet-disabled' => $resolvedDisabled ? 'true' : 'false',
                'data-ui-code-snippet-wrap-text' => $resolvedWrapText ? 'true' : 'false',
                'data-ui-code-copy-button' => true,
                'data-ui-code-copy-state' => $resolvedCopyState,
                'data-ui-code-copy-feedback' => $feedback,
                'data-ui-code-copy-feedback-timeout' => $feedbackTimeout,
            ]) }}
            @disabled($resolvedDisabled)
        ><code
            id="{{ $codeId }}"
            data-ui-code-copy-source
            @if (filled($copyText)) data-ui-code-copy-text="{{ $copyText }}" @endif
        >{!! $codeHtml !!}</code><span
            id="{{ $feedbackId }}"
            class="sr-only"
            data-ui-code-copy-feedback
            aria-live="polite"
        >{{ $resolvedCopyState === 'copied' ? $feedback : $resolvedAriaLabel }}</span></button>
    @endif
@else
    <div
        {{ $attributes->class([
            'ui-code-snippet-shell',
            'ui-code-snippet-shell-single' => $resolvedVariant === 'single',
            'ui-code-snippet-shell-multi' => $resolvedVariant === 'multi',
            'ui-code-snippet-shell-disabled' => $resolvedDisabled,
            'ui-code-snippet-shell-light' => $resolvedLight,
            'ui-code-snippet-shell-no-copy' => $resolvedHideCopyButton,
            'ui-code-snippet-shell-wraptext' => $resolvedWrapText,
            'ui-code-snippet-shell-expandable' => $canExpand,
        ])->merge([
            'data-ui-component' => 'code-snippet',
            'data-ui-code-snippet' => true,
            'data-ui-code-snippet-variant' => $resolvedVariant,
            'data-ui-code-snippet-language' => $language,
            'data-ui-code-snippet-light' => $resolvedLight ? 'true' : 'false',
            'data-ui-code-snippet-disabled' => $resolvedDisabled ? 'true' : 'false',
            'data-ui-code-snippet-wrap-text' => $resolvedWrapText ? 'true' : 'false',
            'data-ui-code-snippet-auto-align' => $resolvedAutoAlign ? 'true' : 'false',
            'data-ui-code-copy-state' => $resolvedCopyState,
            'data-ui-code-snippet-expandable' => $canExpand ? 'true' : null,
            'data-ui-code-snippet-expanded' => $canExpand ? 'false' : null,
            'data-ui-code-snippet-max-collapsed-rows' => $maxCollapsedRows,
            'data-ui-code-snippet-max-expanded-rows' => $maxExpandedRows,
            'data-ui-code-snippet-min-collapsed-rows' => $minCollapsedRows,
            'data-ui-code-snippet-min-expanded-rows' => $minExpandedRows,
            'data-ui-code-copy-feedback' => $feedback,
            'data-ui-code-copy-feedback-timeout' => $feedbackTimeout,
            'style' => $styleValue,
        ]) }}
        @if ($resolvedDisabled) aria-disabled="true" @endif
    >
        <div
            role="textbox"
            tabindex="{{ $resolvedDisabled ? '-1' : '0' }}"
            class="ui-code-snippet-container"
            aria-label="{{ $resolvedAriaLabel }}"
            aria-readonly="true"
            @if ($resolvedVariant === 'multi') aria-multiline="true" @endif
            data-ui-code-snippet-container
        >
            <pre
                id="{{ $codeId }}"
                class="ui-code-snippet"
                data-ui-code-snippet-code
            ><code
                data-ui-code-copy-source
                @if (filled($copyText)) data-ui-code-copy-text="{{ $copyText }}" @endif
            >{!! $codeHtml !!}</code></pre>
        </div>

        @unless ($resolvedHideCopyButton)
            <span
                class="ui-code-snippet-copy-control"
                data-ui-code-snippet-copy-control
            >
                <x-ui.copy-button
                    :copy="filled($copyText) ? $copyText : null"
                    :target="filled($copyText) ? null : '#'.$codeId"
                    label="{{ $copyButtonDescription }}"
                    feedback="{{ $feedback }}"
                    :feedback-timeout="$feedbackTimeout"
                    :copy-state="$resolvedCopyState"
                    size="{{ $resolvedVariant === 'multi' ? 'sm' : 'md' }}"
                    :disabled="$resolvedDisabled"
                    :align="$resolvedAlign"
                    data-ui-code-copy-button
                />
            </span>
        @endunless

        @if ($canExpand)
            <button
                type="button"
                class="ui-code-snippet-expand-button"
                aria-expanded="false"
                aria-controls="{{ $codeId }}"
                @disabled($resolvedDisabled)
                hidden
                data-ui-code-snippet-expand
                data-ui-code-snippet-show-more-text="{{ $resolvedShowMoreText }}"
                data-ui-code-snippet-show-less-text="{{ $resolvedShowLessText }}"
            >
                <span data-ui-code-snippet-expand-text>
                    {{ $resolvedShowMoreText }}
                </span>

                <x-ui.icon
                    name="chevron--down"
                    class="ui-code-snippet-expand-icon"
                    aria-hidden="true"
                    focusable="false"
                />
            </button>
        @endif

        @unless ($resolvedHideCopyButton)
            <span
                id="{{ $feedbackId }}"
                class="sr-only"
                data-ui-code-copy-feedback
                aria-live="polite"
            >
                {{ $resolvedCopyState === 'copied' ? $feedback : $resolvedAriaLabel }}
            </span>
        @endunless
    </div>
@endif