{{-- ==========================================================================
    File: resources/views/components/patterns/common-actions/page-actions/index.blade.php
    Purpose: Page Actions pattern for page-scoped and section-scoped controls.

    Notes:
    - Composes x-patterns.common-actions.action-set for semantic grouping.
    - Composes x-ui.button, x-ui.icon-button, x-ui.button-set, and
      x-ui.overflow-menu.
    - Use for actions scoped to the current page, page section, or page-level
      toolbar.
    - Primary page action should remain visible when practical.
    - Lower-frequency and destructive actions should normally move to overflow.
    - Form submit actions belong to Form Actions.
    - Row-scoped actions belong to Row Actions.
    ========================================================================== --}}

@props([
    'actions' => [],
    'label' => 'Page actions',
    'labelledBy' => null,
    'pageId' => null,
    'pageTitle' => null,
    'placement' => 'header',
    'alignment' => 'end',
    'size' => 'md',
    'density' => 'comfortable',
    'overflow' => 'auto',
    'maxInlineActions' => 3,
    'overflowLabel' => null,
    'overflowPlacement' => 'bottom-end',
    'showLabels' => true,
    'fluid' => false,
    'autoStack' => true,
    'disabled' => false,
    'busy' => false,
])

@php
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedPlacements = [
        'header',
        'section-header',
        'toolbar',
        'sticky-header',
    ];

    $allowedAlignments = [
        'start',
        'end',
        'between',
        'stretch',
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

    $allowedOverflowModes = [
        'auto',
        'always',
        'never',
    ];

    $allowedOverflowPlacements = [
        'top',
        'top-start',
        'top-end',
        'bottom',
        'bottom-start',
        'bottom-end',
    ];

    $primaryRoles = [
        'primary',
        'create',
        'add',
        'new',
        'edit',
        'publish',
        'save',
    ];

    $destructiveRoles = [
        'danger',
        'destructive',
        'delete',
        'destroy',
        'remove',
        'archive',
        'deactivate',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedPlacement = in_array($placement, $allowedPlacements, true)
        ? $placement
        : 'header';

    $resolvedAlignment = in_array($alignment, $allowedAlignments, true)
        ? $alignment
        : 'end';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'md';

    $resolvedDensity = in_array($density, $allowedDensities, true)
        ? $density
        : 'comfortable';

    $resolvedOverflow = in_array($overflow, $allowedOverflowModes, true)
        ? $overflow
        : 'auto';

    $resolvedOverflowPlacement = in_array($overflowPlacement, $allowedOverflowPlacements, true)
        ? $overflowPlacement
        : 'bottom-end';

    $resolvedMaxInlineActions = is_numeric($maxInlineActions)
        ? max(0, min(5, (int) $maxInlineActions))
        : 3;

    $resolvedGroupLabel = filled($pageTitle) && $label === 'Page actions'
        ? 'Actions for '.$pageTitle
        : $label;

    $resolvedOverflowLabel = $overflowLabel
        ?? (filled($pageTitle) ? 'More actions for '.$pageTitle : 'More page actions');

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $showsLabels = filter_var($showLabels, FILTER_VALIDATE_BOOLEAN);
    $isFluid = filter_var($fluid, FILTER_VALIDATE_BOOLEAN);
    $usesAutoStack = filter_var($autoStack, FILTER_VALIDATE_BOOLEAN);
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isBusy = filter_var($busy, FILTER_VALIDATE_BOOLEAN);

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

    $normalizedActions = collect($actions)
        ->map(function ($action, int $index) use (
            $pageId,
            $pageTitle,
            $isDisabled,
            $isBusy,
            $primaryRoles,
            $destructiveRoles,
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

            $label = data_get($actionData, 'label', data_get($actionData, 'text', 'Action'));
            $labelText = $toPlainText($label);

            $href = data_get($actionData, 'href', data_get($actionData, 'url'));
            $icon = data_get($actionData, 'icon');

            $isPrimary = in_array($role, $primaryRoles, true)
                || filter_var(data_get($actionData, 'primary', false), FILTER_VALIDATE_BOOLEAN);

            $isDanger = in_array($role, $destructiveRoles, true)
                || filter_var(data_get($actionData, 'danger', false), FILTER_VALIDATE_BOOLEAN);

            $kind = data_get($actionData, 'kind') ?? match (true) {
                $isDanger => 'danger-ghost',
                $isPrimary => 'primary',
                $role === 'secondary' => 'secondary',
                default => 'ghost',
            };

            $itemDisabled = filter_var(data_get($actionData, 'disabled', false), FILTER_VALIDATE_BOOLEAN);

            $allowDuringBusy = filter_var(
                data_get($actionData, 'allowDuringBusy', in_array($role, ['refresh', 'view', 'preview'], true)),
                FILTER_VALIDATE_BOOLEAN
            );

            $actionDisabled = $isDisabled || $itemDisabled || ($isBusy && ! $allowDuringBusy);

            $actionLoading = filter_var(data_get($actionData, 'loading', false), FILTER_VALIDATE_BOOLEAN)
                || ($isBusy && $isPrimary);

            $ariaLabel = data_get($actionData, 'ariaLabel', data_get($actionData, 'aria-label'));

            if (blank($ariaLabel)) {
                $ariaLabel = filled($pageTitle) ? $labelText.' '.$pageTitle : $labelText;
            }

            return [
                'index' => $index,
                'role' => $role,
                'label' => $label,
                'label_text' => $labelText,
                'aria_label' => $ariaLabel,
                'href' => $href,
                'target' => data_get($actionData, 'target'),
                'rel' => data_get($actionData, 'rel'),
                'type' => data_get($actionData, 'type', 'button'),
                'kind' => $kind,
                'size' => data_get($actionData, 'size'),
                'name' => data_get($actionData, 'name'),
                'value' => data_get($actionData, 'value'),
                'form' => data_get($actionData, 'form'),
                'icon' => $icon,
                'class' => data_get($actionData, 'class'),
                'disabled' => $actionDisabled,
                'loading' => $actionLoading,
                'primary' => $isPrimary,
                'danger' => $isDanger,
                'inline' => filter_var(data_get($actionData, 'inline', false), FILTER_VALIDATE_BOOLEAN),
                'overflow' => filter_var(data_get($actionData, 'overflow', false), FILTER_VALIDATE_BOOLEAN),
                'page_id' => data_get($actionData, 'pageId', data_get($actionData, 'page_id', $pageId)),
            ];
        })
        ->filter()
        ->values();

    /*
    |--------------------------------------------------------------------------
    | Partition Inline and Overflow Actions
    |--------------------------------------------------------------------------
    |
    | In auto mode, primary actions stay inline when possible. Destructive
    | actions move to overflow unless forced inline by caller.
    |
    */

    $inlineActions = collect();
    $overflowActions = collect();

    foreach ($normalizedActions as $action) {
        $forceInline = (bool) $action['inline'];
        $forceOverflow = (bool) $action['overflow'];

        $shouldOverflow = match ($resolvedOverflow) {
            'always' => true,
            'never' => false,
            default => $forceOverflow
                || (! $forceInline && $action['danger'])
                || (! $forceInline && ! $action['primary'] && $inlineActions->count() >= $resolvedMaxInlineActions),
        };

        if ($shouldOverflow) {
            $overflowActions->push($action);
        } else {
            $inlineActions->push($action);
        }
    }

    $overflowMenuItems = $overflowActions
        ->map(fn ($action) => [
            'label' => $action['label_text'],
            'href' => $action['href'],
            'target' => $action['target'],
            'rel' => $action['rel'],
            'icon' => $action['icon'],
            'disabled' => $action['disabled'],
            'danger' => $action['danger'],
            'value' => $action['value'],
            'role' => $action['role'],
            'pageId' => $action['page_id'],
        ])
        ->values()
        ->all();

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-page-actions',
        'ui-page-actions--'.$resolvedPlacement,
        'ui-page-actions--align-'.$resolvedAlignment,
        'ui-page-actions--'.$resolvedDensity,
        'ui-page-actions--with-overflow' => $overflowActions->isNotEmpty(),
        'ui-page-actions--inline-only' => $inlineActions->isNotEmpty() && $overflowActions->isEmpty(),
        'ui-page-actions--overflow-only' => $inlineActions->isEmpty() && $overflowActions->isNotEmpty(),
        'ui-page-actions--fluid' => $isFluid,
        'ui-page-actions--busy' => $isBusy,
        'ui-page-actions--disabled' => $isDisabled,
    ];

    $hasSlotContent = trim($slot->toHtml()) !== '';
@endphp

<x-patterns.common-actions.action-set
    :label="$resolvedGroupLabel"
    :labelled-by="$labelledBy"
    orientation="horizontal"
    {{ $attributes->class($classes)->merge([
        'data-ui-pattern' => 'common-actions-page-actions',
        'data-ui-page-actions' => true,
        'data-ui-page-actions-page-id' => $pageId,
        'data-ui-page-actions-page-title' => $pageTitle,
        'data-ui-page-actions-placement' => $resolvedPlacement,
        'data-ui-page-actions-alignment' => $resolvedAlignment,
        'data-ui-page-actions-size' => $resolvedSize,
        'data-ui-page-actions-density' => $resolvedDensity,
        'data-ui-page-actions-overflow' => $resolvedOverflow,
        'data-ui-page-actions-inline-count' => $inlineActions->count(),
        'data-ui-page-actions-overflow-count' => $overflowActions->count(),
        'data-ui-page-actions-fluid' => $isFluid ? 'true' : 'false',
        'data-ui-page-actions-busy' => $isBusy ? 'true' : 'false',
        'data-ui-page-actions-disabled' => $isDisabled ? 'true' : 'false',
    ]) }}
>
    <x-ui.button-set
        :fluid="$isFluid"
        :auto-stack="$usesAutoStack"
        data-ui-page-actions-button-set
    >
        {{-- ------------------------------------------------------------------
            Inline Page Actions
            ------------------------------------------------------------------
            Primary page action should normally remain visible. Lower-frequency
            and destructive actions should move to overflow by default.
            ------------------------------------------------------------------ --}}

        @foreach ($inlineActions as $action)
            @php
                $actionClasses = [
                    'ui-page-actions__action',
                    'ui-page-actions__action--'.$action['role'],
                    'ui-page-actions__action--primary' => $action['primary'],
                    'ui-page-actions__action--danger' => $action['danger'],
                    $action['class'],
                ];
            @endphp

            @if (filled($action['icon']) && ! $showsLabels && ! $action['primary'])
                <x-ui.icon-button
                    :kind="$action['kind']"
                    :size="$action['size'] ?? $resolvedSize"
                    :label="$action['aria_label']"
                    :icon="$action['icon']"
                    :disabled="$action['disabled']"
                    :loading="$action['loading']"
                    @class($actionClasses)
                    @if (filled($action['href'])) href="{{ $action['href'] }}" @endif
                    @if (filled($action['target'])) target="{{ $action['target'] }}" @endif
                    @if (filled($action['rel'])) rel="{{ $action['rel'] }}" @endif
                    data-ui-page-action
                    data-ui-page-action-role="{{ $action['role'] }}"
                    data-ui-page-action-index="{{ $action['index'] }}"
                    data-ui-page-action-page-id="{{ $action['page_id'] }}"
                    data-ui-page-action-inline="true"
                    data-ui-page-action-primary="{{ $action['primary'] ? 'true' : 'false' }}"
                    data-ui-page-action-danger="{{ $action['danger'] ? 'true' : 'false' }}"
                />
            @else
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
                    data-ui-page-action
                    data-ui-page-action-role="{{ $action['role'] }}"
                    data-ui-page-action-index="{{ $action['index'] }}"
                    data-ui-page-action-page-id="{{ $action['page_id'] }}"
                    data-ui-page-action-inline="true"
                    data-ui-page-action-primary="{{ $action['primary'] ? 'true' : 'false' }}"
                    data-ui-page-action-danger="{{ $action['danger'] ? 'true' : 'false' }}"
                >
                    @if (filled($action['icon']))
                        <x-ui.icon :name="$action['icon']" class="ui-page-actions__action-icon" aria-hidden="true" />
                    @endif

                    {!! $renderTrustedContent($action['label']) !!}
                </x-ui.button>
            @endif
        @endforeach

        {{-- ------------------------------------------------------------------
            Overflow Page Actions
            ------------------------------------------------------------------
            Overflow contains lower-frequency and destructive actions by default.
            ------------------------------------------------------------------ --}}

        @if ($overflowActions->isNotEmpty())
            <x-ui.overflow-menu
                :items="$overflowMenuItems"
                :label="$resolvedOverflowLabel"
                :size="$resolvedSize"
                :placement="$resolvedOverflowPlacement"
                :disabled="$isDisabled"
                class="ui-page-actions__overflow"
                data-ui-page-actions-overflow-menu
            />
        @endif

        {{-- ------------------------------------------------------------------
            Slotted Page Actions
            ------------------------------------------------------------------
            Slot mode is preferred when callers need exact action markup,
            route bindings, confirmation triggers, or custom event handling.
            ------------------------------------------------------------------ --}}

        @if ($hasSlotContent)
            {{ $slot }}
        @endif
    </x-ui.button-set>
</x-patterns.common-actions.action-set>