{{-- ==========================================================================
    File: resources/views/components/patterns/forms/actions/index.blade.php
    Purpose: Form Actions pattern for submit, cancel, reset, and form-flow controls.

    Notes:
    - Composes x-patterns.common-actions.action-set for semantic grouping.
    - Composes x-ui.button-set for local button layout.
    - Renders array-driven actions or caller-provided slot content.
    - Supports idle, loading, success, and error action states.
    - Uses x-ui.inline-loading for local submit/action processing status.
    - Loading state replaces the primary submit-like action with Inline Loading.
    - Loading state disables related actions by default unless an action opts
      into allowDuringBusy.
    - Detailed form-level success, warning, or error messages should use the
      Notification component/pattern outside this local action region.
    - Form-specific ordering and hierarchy rules are declared in contract.php.
    ========================================================================== --}}

@props ([
    "actions" => [],
    "label" => "Form actions",
    "labelledBy" => null,
    "alignment" => "start",
    "placement" => "inline",
    "orientation" => "horizontal",
    "size" => "md",
    "fluid" => false,
    "autoStack" => true,
    "width" => null,
    "state" => null,
    "busy" => false,
    "loading" => false,
    "disabled" => false,
    "form" => null,
    "loadingText" => null,
    "successText" => null,
    "errorText" => null,
    "statusAriaLive" => null,
    "disableDuringBusy" => true,
    "replaceSlotWithStatus" => true,
])

@php
    use Illuminate\Support\Arr;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedAlignments = ['start', 'end', 'between', 'stretch'];
    $allowedPlacements = ['inline', 'footer', 'sticky-footer'];
    $allowedOrientations = ['horizontal', 'vertical'];
    $allowedSizes = ['sm', 'md', 'lg'];
    $allowedWidths = ['half', 'full'];
    $allowedStates = ['idle', 'loading', 'success', 'error'];

    $stateAliases = [
        'active' => 'loading',
        'busy' => 'loading',
        'finished' => 'success',
        'complete' => 'success',
        'completed' => 'success',
        'failed' => 'error',
        'failure' => 'error',
    ];

    $submitLikeRoles = [
        'submit',
        'save',
        'create',
        'update',
        'continue',
        'send',
    ];

    $destructiveRoles = [
        'destructive',
        'delete',
        'remove',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Layout Values
    |--------------------------------------------------------------------------
    */

    $resolvedAlignment = in_array($alignment, $allowedAlignments, true)
        ? $alignment
        : 'start';

    $resolvedPlacement = in_array($placement, $allowedPlacements, true)
        ? $placement
        : 'inline';

    $resolvedOrientation = in_array($orientation, $allowedOrientations, true)
        ? $orientation
        : 'horizontal';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'md';

    $resolvedWidth = is_string($width) && in_array($width, $allowedWidths, true)
        ? $width
        : null;

    $buttonSetAlign = in_array($resolvedAlignment, ['start', 'end', 'stretch'], true)
        ? $resolvedAlignment
        : null;

    /*
    |--------------------------------------------------------------------------
    | Resolve State
    |--------------------------------------------------------------------------
    */

    $requestedState = is_string($state)
        ? ($stateAliases[$state] ?? $state)
        : null;

    if (! in_array($requestedState, $allowedStates, true)) {
        $requestedState = filter_var($busy, FILTER_VALIDATE_BOOLEAN) || filter_var($loading, FILTER_VALIDATE_BOOLEAN)
            ? 'loading'
            : 'idle';
    }

    $resolvedState = $requestedState;

    $isLoading = $resolvedState === 'loading';
    $isSuccess = $resolvedState === 'success';
    $isError = $resolvedState === 'error';
    $hasFormStatus = $isLoading || $isSuccess || $isError;

    $isFluid = filter_var($fluid, FILTER_VALIDATE_BOOLEAN);
    $usesAutoStack = filter_var($autoStack, FILTER_VALIDATE_BOOLEAN);
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $disablesDuringBusy = filter_var($disableDuringBusy, FILTER_VALIDATE_BOOLEAN);
    $replacesSlotWithStatus = filter_var($replaceSlotWithStatus, FILTER_VALIDATE_BOOLEAN);

    $isBusy = $isLoading;

    $inlineLoadingStatus = 'inactive';

    if ($isLoading) {
        $inlineLoadingStatus = 'active';
    } elseif ($isSuccess) {
        $inlineLoadingStatus = 'finished';
    } elseif ($isError) {
        $inlineLoadingStatus = 'error';
    }

    $statusDescription = null;

    if ($isLoading) {
        $statusDescription = $loadingText ?? 'Processing...';
    } elseif ($isSuccess) {
        $statusDescription = $successText ?? 'Success!';
    } elseif ($isError) {
        $statusDescription = $errorText ?? 'Action failed.';
    }

    $statusDescriptionText = $statusDescription instanceof HtmlString
        ? trim(strip_tags($statusDescription->toHtml()))
        : trim((string) $statusDescription);

    /*
    |--------------------------------------------------------------------------
    | Trusted Content Helper
    |--------------------------------------------------------------------------
    */

    $renderTrustedContent = function ($content): string {
        if ($content instanceof HtmlString) {
            return $content->toHtml();
        }

        if (is_object($content) && method_exists($content, 'toHtml')) {
            return $content->toHtml();
        }

        return e((string) $content);
    };

    /*
    |--------------------------------------------------------------------------
    | Action Data
    |--------------------------------------------------------------------------
    */

    $normalizedActions = is_iterable($actions)
        ? collect($actions)->values()->all()
        : [];

    $hasArrayActions = count($normalizedActions) > 0;
    $hasSlotContent = trim($slot->toHtml()) !== '';

    $shouldReplaceSlotWithStatus = $hasFormStatus
        && $hasSlotContent
        && ! $hasArrayActions
        && $replacesSlotWithStatus;

    $preparedActions = [];
    $statusActionRendered = $shouldReplaceSlotWithStatus;

    foreach ($normalizedActions as $index => $action) {
        $actionData = is_array($action)
            ? $action
            : [
                'label' => $action,
                'role' => $index === 0 ? 'submit' : 'cancel',
            ];

        $actionRole = (string) data_get(
            $actionData,
            'role',
            data_get($actionData, 'action', $index === 0 ? 'submit' : 'secondary')
        );

        $submitLikeAction = in_array($actionRole, $submitLikeRoles, true);

        if ($hasFormStatus && $submitLikeAction && ! $statusActionRendered) {
            $statusActionRendered = true;

            $preparedActions[] = [
                'render' => 'status',
                'role' => $actionRole,
            ];

            continue;
        }

        $actionType = data_get($actionData, 'type');

        if (! is_string($actionType) || $actionType === '') {
            if ($submitLikeAction) {
                $actionType = 'submit';
            } elseif ($actionRole === 'reset') {
                $actionType = 'reset';
            } else {
                $actionType = 'button';
            }
        }

        $actionKind = data_get($actionData, 'kind');

        if (! is_string($actionKind) || $actionKind === '') {
            if ($submitLikeAction) {
                $actionKind = 'primary';
            } elseif (in_array($actionRole, $destructiveRoles, true)) {
                $actionKind = 'danger';
            } else {
                $actionKind = 'secondary';
            }
        }

        $itemDisabled = filter_var(data_get($actionData, 'disabled', false), FILTER_VALIDATE_BOOLEAN);

        $allowDuringBusy = filter_var(
            data_get($actionData, 'allowDuringBusy', false),
            FILTER_VALIDATE_BOOLEAN
        );

        $actionDisabled = $isDisabled
            || $itemDisabled
            || ($isLoading && $disablesDuringBusy && ! $allowDuringBusy)
            || ($isSuccess && $submitLikeAction);

        $actionLoading = filter_var(data_get($actionData, 'loading', false), FILTER_VALIDATE_BOOLEAN);

        $actionClasses = [
            'ui-form-actions__action',
            'ui-form-actions__action--'.$actionRole,
            data_get($actionData, 'class'),
        ];

        $preparedActions[] = [
            'render' => 'button',
            'role' => $actionRole,
            'type' => $actionType,
            'kind' => $actionKind,
            'size' => data_get($actionData, 'size', $resolvedSize),
            'disabled' => $actionDisabled,
            'loading' => $actionLoading,
            'href' => data_get($actionData, 'href'),
            'target' => data_get($actionData, 'target'),
            'rel' => data_get($actionData, 'rel'),
            'name' => data_get($actionData, 'name'),
            'value' => data_get($actionData, 'value'),
            'form' => data_get($actionData, 'form', $form),
            'icon' => data_get($actionData, 'icon'),
            'labelHtml' => $renderTrustedContent(data_get($actionData, 'label', data_get($actionData, 'text', 'Action'))),
            'class' => Arr::toCssClasses($actionClasses),
            'index' => $index,
            'allowDuringBusy' => $allowDuringBusy,
        ];
    }

    $shouldRenderFallbackStatus = $hasFormStatus
        && ! $statusActionRendered
        && ! $hasSlotContent;

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-form-actions',
        'ui-form-actions--'.$resolvedPlacement,
        'ui-form-actions--'.$resolvedOrientation,
        'ui-form-actions--align-'.$resolvedAlignment,
        'ui-form-actions--state-'.$resolvedState,
        'ui-form-actions--fluid' => $isFluid,
        'ui-form-actions--busy' => $isBusy,
        'ui-form-actions--disabled' => $isDisabled,
        'ui-form-actions--has-status' => $hasFormStatus,
    ];
@endphp

<x-patterns.common-actions.action-set
    :label="$label"
    :labelled-by="$labelledBy"
    {{
        $attributes->class($classes)->merge([
            'data-ui-pattern' => 'common-actions-form-actions',
            'data-ui-form-actions' => true,
            'data-ui-form-actions-placement' => $resolvedPlacement,
            'data-ui-form-actions-orientation' => $resolvedOrientation,
            'data-ui-form-actions-alignment' => $resolvedAlignment,
            'data-ui-form-actions-size' => $resolvedSize,
            'data-ui-form-actions-fluid' => $isFluid ? 'true' : 'false',
            'data-ui-form-actions-width' => $resolvedWidth ?? 'auto',
            'data-ui-form-actions-state' => $resolvedState,
            'data-ui-form-actions-busy' => $isBusy ? 'true' : 'false',
            'data-ui-form-actions-disabled' => $isDisabled ? 'true' : 'false',
            'data-ui-form-actions-has-status' => $hasFormStatus ? 'true' : 'false',
            'data-ui-form-actions-loading-text' => $loadingText,
            'data-ui-form-actions-success-text' => $successText,
            'data-ui-form-actions-error-text' => $errorText,
            'data-ui-form-actions-disable-during-busy' => $disablesDuringBusy
                ? 'true'
                : 'false',
        ])
    }}
>
    <x-ui.button-set
        :stacked="$resolvedOrientation === 'vertical'"
        :fluid="$isFluid"
        :auto-stack="$usesAutoStack"
        :width="$resolvedWidth"
        :align="$buttonSetAlign"
        data-ui-form-actions-button-set="true"
    >
        <?php if ($shouldReplaceSlotWithStatus) : ?>
            <span
                class="ui-form-actions__status ui-form-actions__status--{{ $resolvedState }}"
                data-ui-form-actions-status
                data-ui-form-actions-status-state="{{ $resolvedState }}"
                data-ui-form-actions-status-text="{{ $statusDescriptionText }}"
            >
                <x-ui.inline-loading
                    :status="$inlineLoadingStatus"
                    :description="$statusDescription"
                    :live="$statusAriaLive"
                />
            </span>
        <?php else : ?>
            <?php foreach ($preparedActions as $actionItem) : ?>
                <?php if ($actionItem['render'] === 'status') : ?>
                    <span
                        class="ui-form-actions__status ui-form-actions__status--{{ $resolvedState }}"
                        data-ui-form-actions-status
                        data-ui-form-actions-status-role="{{ $actionItem['role'] }}"
                        data-ui-form-actions-status-state="{{ $resolvedState }}"
                        data-ui-form-actions-status-text="{{ $statusDescriptionText }}"
                    >
                        <x-ui.inline-loading
                            :status="$inlineLoadingStatus"
                            :description="$statusDescription"
                            :live="$statusAriaLive"
                        />
                    </span>
                <?php else : ?>
                    <x-ui.button
                        :type="$actionItem['type']"
                        :kind="$actionItem['kind']"
                        :size="$actionItem['size']"
                        :disabled="$actionItem['disabled']"
                        :loading="$actionItem['loading']"
                        :href="$actionItem['href']"
                        :target="$actionItem['target']"
                        :rel="$actionItem['rel']"
                        :name="$actionItem['name']"
                        :value="$actionItem['value']"
                        :form="$actionItem['form']"
                        class="{{ $actionItem['class'] }}"
                        data-ui-form-action
                        data-ui-form-action-role="{{ $actionItem['role'] }}"
                        data-ui-form-action-kind="{{ $actionItem['kind'] }}"
                        data-ui-form-action-type="{{ $actionItem['type'] }}"
                        data-ui-form-action-index="{{ $actionItem['index'] }}"
                        data-ui-form-action-disabled="{{ $actionItem['disabled'] ? 'true' : 'false' }}"
                        data-ui-form-action-loading="{{ $actionItem['loading'] ? 'true' : 'false' }}"
                        data-ui-form-action-allow-during-busy="{{ $actionItem['allowDuringBusy'] ? 'true' : 'false' }}"
                    >
                        <?php if (filled($actionItem['icon'])) : ?>
                            <x-ui.icon
                                :name="$actionItem['icon']"
                                class="ui-form-actions__action-icon"
                                aria-hidden="true"
                            />
                        <?php endif; ?>

                        {!!
                            $actionItem[
                                "labelHtml"
                            ]
                        !!}
                    </x-ui.button>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if ($shouldRenderFallbackStatus) : ?>
                <span
                    class="ui-form-actions__status ui-form-actions__status--{{ $resolvedState }}"
                    data-ui-form-actions-status
                    data-ui-form-actions-status-state="{{ $resolvedState }}"
                    data-ui-form-actions-status-text="{{ $statusDescriptionText }}"
                >
                    <x-ui.inline-loading
                        :status="$inlineLoadingStatus"
                        :description="$statusDescription"
                        :live="$statusAriaLive"
                    />
                </span>
            <?php endif; ?>

            <?php if ($hasSlotContent) : ?>
                {{ $slot }}
            <?php endif; ?>
        <?php endif; ?>
    </x-ui.button-set>
</x-patterns.common-actions.action-set>
