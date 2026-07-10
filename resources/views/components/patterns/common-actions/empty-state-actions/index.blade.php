{{-- ==========================================================================
    File: resources/views/components/patterns/common-actions/empty-state-actions/index.blade.php
    Purpose: Empty State Actions pattern for recovery, setup, retry, and next-step actions.

    Notes:
    - Composes x-patterns.common-actions.action-set for semantic grouping.
    - Composes x-ui.button-set and x-ui.button for action layout.
    - Use inside empty states, zero states, no-results states, error recovery
      states, onboarding states, and first-run setup states.
    - Primary action should represent the best next step or recovery path.
    - Secondary actions should remain supportive and low-friction.
    - Destructive actions do not belong in empty states.
    ========================================================================== --}}

@props([
    'actions' => [],
    'label' => 'Empty state actions',
    'labelledBy' => null,
    'emptyStateId' => null,
    'emptyStateLabel' => null,
    'context' => 'empty',
    'placement' => 'body',
    'alignment' => 'center',
    'orientation' => 'horizontal',
    'size' => 'md',
    'density' => 'comfortable',
    'fluid' => false,
    'autoStack' => true,
    'maxPrimaryActions' => 1,
    'busy' => false,
    'loading' => false,
    'disabled' => false,
])

@php
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedContexts = [
        'empty',
        'zero',
        'no-results',
        'error',
        'offline',
        'first-run',
        'permission',
        'filtered',
    ];

    $allowedPlacements = [
        'body',
        'card',
        'table',
        'section',
        'modal',
    ];

    $allowedAlignments = [
        'start',
        'center',
        'end',
        'stretch',
    ];

    $allowedOrientations = [
        'horizontal',
        'vertical',
    ];

    $allowedSizes = [
        'sm',
        'md',
        'lg',
    ];

    $allowedDensities = [
        'compact',
        'comfortable',
    ];

    $primaryRoles = [
        'primary',
        'create',
        'add',
        'retry',
        'refresh',
        'clear-filters',
        'reset-search',
        'setup',
        'import',
        'connect',
        'request-access',
    ];

    $secondaryRoles = [
        'secondary',
        'learn-more',
        'view-docs',
        'contact-support',
        'go-back',
        'browse',
        'cancel',
    ];

    $blockedDestructiveRoles = [
        'delete',
        'remove',
        'destroy',
        'discard',
        'revoke',
        'deactivate',
        'destructive',
        'danger',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedContext = in_array($context, $allowedContexts, true)
        ? $context
        : 'empty';

    $resolvedPlacement = in_array($placement, $allowedPlacements, true)
        ? $placement
        : 'body';

    $resolvedAlignment = in_array($alignment, $allowedAlignments, true)
        ? $alignment
        : 'center';

    $resolvedOrientation = in_array($orientation, $allowedOrientations, true)
        ? $orientation
        : 'horizontal';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'md';

    $resolvedDensity = in_array($density, $allowedDensities, true)
        ? $density
        : 'comfortable';

    $resolvedMaxPrimaryActions = is_numeric($maxPrimaryActions)
        ? max(1, min(2, (int) $maxPrimaryActions))
        : 1;

    $resolvedGroupLabel = filled($emptyStateLabel) && $label === 'Empty state actions'
        ? 'Actions for '.$emptyStateLabel
        : $label;

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isFluid = filter_var($fluid, FILTER_VALIDATE_BOOLEAN);
    $usesAutoStack = filter_var($autoStack, FILTER_VALIDATE_BOOLEAN);
    $isBusy = filter_var($busy, FILTER_VALIDATE_BOOLEAN) || filter_var($loading, FILTER_VALIDATE_BOOLEAN);
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);

    /*
    |--------------------------------------------------------------------------
    | Trusted Content Helpers
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

    $toPlainText = function ($content): string {
        if ($content instanceof HtmlString) {
            return trim(strip_tags($content->toHtml()));
        }

        if (is_object($content) && method_exists($content, 'toHtml')) {
            return trim(strip_tags($content->toHtml()));
        }

        return trim(strip_tags((string) $content));
    };

    /*
    |--------------------------------------------------------------------------
    | Normalize Actions
    |--------------------------------------------------------------------------
    */

    $primaryActionCount = 0;

    $normalizedActions = collect($actions)
        ->map(function ($action, int $index) use (
            $emptyStateId,
            $emptyStateLabel,
            $isDisabled,
            $isBusy,
            $primaryRoles,
            $secondaryRoles,
            $blockedDestructiveRoles,
            $resolvedMaxPrimaryActions,
            &$primaryActionCount,
            $toPlainText
        ) {
            $actionData = is_array($action)
                ? $action
                : [
                    'label' => $action,
                    'role' => $index === 0 ? 'primary' : 'secondary',
                ];

            $isVisible = ! array_key_exists('visible', $actionData)
                || filter_var(data_get($actionData, 'visible', true), FILTER_VALIDATE_BOOLEAN);

            if (! $isVisible) {
                return null;
            }

            $role = data_get($actionData, 'role', data_get($actionData, 'action', $index === 0 ? 'primary' : 'secondary'));
            $role = is_string($role) && $role !== ''
                ? strtolower(str_replace('_', '-', trim($role)))
                : 'secondary';

            $isBlockedDestructive = in_array($role, $blockedDestructiveRoles, true)
                || filter_var(data_get($actionData, 'danger', false), FILTER_VALIDATE_BOOLEAN)
                || filter_var(data_get($actionData, 'destructive', false), FILTER_VALIDATE_BOOLEAN);

            if ($isBlockedDestructive) {
                return null;
            }

            $label = data_get($actionData, 'label', data_get($actionData, 'text', 'Action'));
            $labelText = $toPlainText($label);

            $isPrimary = in_array($role, $primaryRoles, true)
                || filter_var(data_get($actionData, 'primary', false), FILTER_VALIDATE_BOOLEAN);

            if ($isPrimary) {
                $primaryActionCount++;
            }

            $primaryAllowed = ! $isPrimary || $primaryActionCount <= $resolvedMaxPrimaryActions;

            $kind = data_get($actionData, 'kind') ?? match (true) {
                $isPrimary && $primaryAllowed => 'primary',
                in_array($role, $secondaryRoles, true) => 'secondary',
                default => 'ghost',
            };

            $itemDisabled = filter_var(data_get($actionData, 'disabled', false), FILTER_VALIDATE_BOOLEAN);

            $allowDuringBusy = filter_var(
                data_get($actionData, 'allowDuringBusy', in_array($role, ['learn-more', 'view-docs', 'contact-support'], true)),
                FILTER_VALIDATE_BOOLEAN
            );

            $actionDisabled = $isDisabled || $itemDisabled || ($isBusy && ! $allowDuringBusy);

            $actionLoading = filter_var(data_get($actionData, 'loading', false), FILTER_VALIDATE_BOOLEAN)
                || ($isBusy && $isPrimary && $primaryAllowed);

            $ariaLabel = data_get($actionData, 'ariaLabel', data_get($actionData, 'aria-label'));

            if (blank($ariaLabel)) {
                $ariaLabel = filled($emptyStateLabel) ? $labelText.' '.$emptyStateLabel : $labelText;
            }

            return [
                'index' => $index,
                'role' => $role,
                'label' => $label,
                'label_text' => $labelText,
                'aria_label' => $ariaLabel,
                'href' => data_get($actionData, 'href', data_get($actionData, 'url')),
                'target' => data_get($actionData, 'target'),
                'rel' => data_get($actionData, 'rel'),
                'type' => data_get($actionData, 'type', 'button'),
                'kind' => $kind,
                'size' => data_get($actionData, 'size'),
                'name' => data_get($actionData, 'name'),
                'value' => data_get($actionData, 'value'),
                'form' => data_get($actionData, 'form'),
                'icon' => data_get($actionData, 'icon'),
                'class' => data_get($actionData, 'class'),
                'disabled' => $actionDisabled,
                'loading' => $actionLoading,
                'primary' => $isPrimary && $primaryAllowed,
                'empty_state_id' => data_get($actionData, 'emptyStateId', data_get($actionData, 'empty_state_id', $emptyStateId)),
            ];
        })
        ->filter()
        ->values();

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-empty-state-actions',
        'ui-empty-state-actions--context-'.$resolvedContext,
        'ui-empty-state-actions--'.$resolvedPlacement,
        'ui-empty-state-actions--'.$resolvedOrientation,
        'ui-empty-state-actions--align-'.$resolvedAlignment,
        'ui-empty-state-actions--'.$resolvedDensity,
        'ui-empty-state-actions--fluid' => $isFluid,
        'ui-empty-state-actions--busy' => $isBusy,
        'ui-empty-state-actions--disabled' => $isDisabled,
    ];

    $hasSlotContent = trim($slot->toHtml()) !== '';
@endphp

<x-patterns.common-actions.action-set
    :label="$resolvedGroupLabel"
    :labelled-by="$labelledBy"
    :orientation="$resolvedOrientation"
    {{ $attributes->class($classes)->merge([
        'data-ui-pattern' => 'common-actions-empty-state-actions',
        'data-ui-empty-state-actions' => true,
        'data-ui-empty-state-actions-empty-state-id' => $emptyStateId,
        'data-ui-empty-state-actions-empty-state-label' => $emptyStateLabel,
        'data-ui-empty-state-actions-context' => $resolvedContext,
        'data-ui-empty-state-actions-placement' => $resolvedPlacement,
        'data-ui-empty-state-actions-alignment' => $resolvedAlignment,
        'data-ui-empty-state-actions-orientation' => $resolvedOrientation,
        'data-ui-empty-state-actions-size' => $resolvedSize,
        'data-ui-empty-state-actions-density' => $resolvedDensity,
        'data-ui-empty-state-actions-fluid' => $isFluid ? 'true' : 'false',
        'data-ui-empty-state-actions-busy' => $isBusy ? 'true' : 'false',
        'data-ui-empty-state-actions-disabled' => $isDisabled ? 'true' : 'false',
    ]) }}
>
    <x-ui.button-set
        :stacked="$resolvedOrientation === 'vertical'"
        :fluid="$isFluid"
        :auto-stack="$usesAutoStack"
        data-ui-empty-state-actions-button-set
    >
        {{-- ------------------------------------------------------------------
            Array-driven Empty State Actions
            ------------------------------------------------------------------
            The primary action should represent the best recovery or next step.
            ------------------------------------------------------------------ --}}

        @foreach ($normalizedActions as $action)
            @php
                $actionClasses = [
                    'ui-empty-state-actions__action',
                    'ui-empty-state-actions__action--'.$action['role'],
                    'ui-empty-state-actions__action--primary' => $action['primary'],
                    $action['class'],
                ];
            @endphp

            <x-ui.button
                :type="$action['type']"
                :kind="$action['kind']"
                :size="$action['size'] ?? $resolvedSize"
                :disabled="$action['disabled']"
                :loading="$action['loading']"
                @class($actionClasses)
                @if (filled($action['href'])) href="{{ $action['href'] }}" @endif
                @if (filled($action['target'])) target="{{ $action['target'] }}" @endif
                @if (filled($action['rel'])) rel="{{ $action['rel'] }}" @endif
                @if (filled($action['name'])) name="{{ $action['name'] }}" @endif
                @if (filled($action['value'])) value="{{ $action['value'] }}" @endif
                @if (filled($action['form'])) form="{{ $action['form'] }}" @endif
                data-ui-empty-state-action
                data-ui-empty-state-action-role="{{ $action['role'] }}"
                data-ui-empty-state-action-index="{{ $action['index'] }}"
                data-ui-empty-state-action-empty-state-id="{{ $action['empty_state_id'] }}"
                data-ui-empty-state-action-primary="{{ $action['primary'] ? 'true' : 'false' }}"
                data-ui-empty-state-action-disabled="{{ $action['disabled'] ? 'true' : 'false' }}"
                data-ui-empty-state-action-loading="{{ $action['loading'] ? 'true' : 'false' }}"
            >
                @if (filled($action['icon']))
                    <x-ui.icon :name="$action['icon']" class="ui-empty-state-actions__action-icon" aria-hidden="true" />
                @endif

                {!! $renderTrustedContent($action['label']) !!}
            </x-ui.button>
        @endforeach

        {{-- ------------------------------------------------------------------
            Slotted Empty State Actions
            ------------------------------------------------------------------
            Slot mode is preferred when callers need exact links, route
            bindings, support/contact actions, or framework handlers.
            ------------------------------------------------------------------ --}}

        @if ($hasSlotContent)
            {{ $slot }}
        @endif
    </x-ui.button-set>
</x-patterns.common-actions.action-set>