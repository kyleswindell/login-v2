{{-- ==========================================================================
    File: resources/views/components/patterns/common-actions/bulk-actions/index.blade.php
    Purpose: Bulk Actions pattern for selected-record action groups.

    Notes:
    - Composes x-patterns.common-actions.action-set for semantic grouping.
    - Composes x-ui.button, x-ui.button-set, and x-ui.overflow-menu.
    - Use for actions scoped to a selected set of records.
    - Does not own row selection, batch selection, or table state.
    - Destructive bulk actions should normally move to overflow unless caller
      explicitly forces them inline.
    - Row-scoped actions belong to Row Actions.
    - Page-scoped actions belong to Page Actions.
    ========================================================================== --}}

@props([
    'actions' => [],
    'label' => 'Bulk actions',
    'labelledBy' => null,
    'selectionId' => null,
    'selectedCount' => 0,
    'totalCount' => null,
    'itemLabel' => 'item',
    'itemLabelPlural' => 'items',
    'selectionText' => null,
    'showSelectionCount' => true,
    'clearSelection' => true,
    'clearLabel' => 'Clear selection',
    'clearHref' => null,
    'scope' => 'table',
    'placement' => 'batch-bar',
    'alignment' => 'between',
    'size' => 'sm',
    'density' => 'compact',
    'overflow' => 'auto',
    'maxInlineActions' => 2,
    'overflowLabel' => null,
    'overflowPlacement' => 'bottom-end',
    'showLabels' => true,
    'hiddenWhenEmpty' => true,
    'disabled' => false,
    'busy' => false,
    'form' => null,
])

@php
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedScopes = [
        'table',
        'list',
        'collection',
        'search-results',
        'custom',
    ];

    $allowedPlacements = [
        'batch-bar',
        'table-toolbar',
        'sticky-toolbar',
        'inline',
    ];

    $allowedAlignments = [
        'start',
        'end',
        'between',
        'stretch',
    ];

    $allowedSizes = [
        'xs',
        'sm',
        'md',
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
        'apply',
        'assign',
        'export',
        'move',
        'archive',
    ];

    $destructiveRoles = [
        'danger',
        'destructive',
        'delete',
        'destroy',
        'remove',
        'discard',
        'revoke',
        'deactivate',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedScope = in_array($scope, $allowedScopes, true)
        ? $scope
        : 'table';

    $resolvedPlacement = in_array($placement, $allowedPlacements, true)
        ? $placement
        : 'batch-bar';

    $resolvedAlignment = in_array($alignment, $allowedAlignments, true)
        ? $alignment
        : 'between';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'sm';

    $resolvedDensity = in_array($density, $allowedDensities, true)
        ? $density
        : 'compact';

    $resolvedOverflow = in_array($overflow, $allowedOverflowModes, true)
        ? $overflow
        : 'auto';

    $resolvedOverflowPlacement = in_array($overflowPlacement, $allowedOverflowPlacements, true)
        ? $overflowPlacement
        : 'bottom-end';

    $resolvedSelectedCount = is_numeric($selectedCount)
        ? max(0, (int) $selectedCount)
        : 0;

    $resolvedTotalCount = is_numeric($totalCount)
        ? max(0, (int) $totalCount)
        : null;

    $resolvedMaxInlineActions = is_numeric($maxInlineActions)
        ? max(0, min(5, (int) $maxInlineActions))
        : 2;

    $resolvedItemLabel = $resolvedSelectedCount === 1
        ? $itemLabel
        : $itemLabelPlural;

    $resolvedSelectionText = $selectionText
        ?? $resolvedSelectedCount.' '.$resolvedItemLabel.' selected';

    $resolvedGroupLabel = $label;

    $resolvedOverflowLabel = $overflowLabel
        ?? 'More bulk actions';

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $showsSelectionCount = filter_var($showSelectionCount, FILTER_VALIDATE_BOOLEAN);
    $showsClearSelection = filter_var($clearSelection, FILTER_VALIDATE_BOOLEAN);
    $hidesWhenEmpty = filter_var($hiddenWhenEmpty, FILTER_VALIDATE_BOOLEAN);
    $showsLabels = filter_var($showLabels, FILTER_VALIDATE_BOOLEAN);
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isBusy = filter_var($busy, FILTER_VALIDATE_BOOLEAN);

    $isEmpty = $resolvedSelectedCount === 0;
    $isHidden = $hidesWhenEmpty && $isEmpty;

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
            $selectionId,
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
                || filter_var(data_get($actionData, 'danger', false), FILTER_VALIDATE_BOOLEAN)
                || filter_var(data_get($actionData, 'destructive', false), FILTER_VALIDATE_BOOLEAN);

            $kind = data_get($actionData, 'kind') ?? match (true) {
                $isDanger => 'danger-ghost',
                $isPrimary => 'primary',
                $role === 'secondary' => 'secondary',
                default => 'ghost',
            };

            $itemDisabled = filter_var(data_get($actionData, 'disabled', false), FILTER_VALIDATE_BOOLEAN);

            $allowDuringBusy = filter_var(
                data_get($actionData, 'allowDuringBusy', in_array($role, ['view', 'preview', 'export'], true)),
                FILTER_VALIDATE_BOOLEAN
            );

            $actionDisabled = $isDisabled || $itemDisabled || ($isBusy && ! $allowDuringBusy);

            $actionLoading = filter_var(data_get($actionData, 'loading', false), FILTER_VALIDATE_BOOLEAN)
                || ($isBusy && $isPrimary);

            $ariaLabel = data_get($actionData, 'ariaLabel', data_get($actionData, 'aria-label', $labelText));

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
                'selection_id' => data_get($actionData, 'selectionId', data_get($actionData, 'selection_id', $selectionId)),
            ];
        })
        ->filter()
        ->values();

    /*
    |--------------------------------------------------------------------------
    | Partition Inline and Overflow Actions
    |--------------------------------------------------------------------------
    |
    | In auto mode, primary actions stay inline when practical. Destructive
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
            'selectionId' => $action['selection_id'],
        ])
        ->values()
        ->all();

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-bulk-actions',
        'ui-bulk-actions--'.$resolvedPlacement,
        'ui-bulk-actions--scope-'.$resolvedScope,
        'ui-bulk-actions--align-'.$resolvedAlignment,
        'ui-bulk-actions--'.$resolvedDensity,
        'ui-bulk-actions--with-overflow' => $overflowActions->isNotEmpty(),
        'ui-bulk-actions--inline-only' => $inlineActions->isNotEmpty() && $overflowActions->isEmpty(),
        'ui-bulk-actions--overflow-only' => $inlineActions->isEmpty() && $overflowActions->isNotEmpty(),
        'ui-bulk-actions--empty' => $isEmpty,
        'ui-bulk-actions--busy' => $isBusy,
        'ui-bulk-actions--disabled' => $isDisabled,
    ];

    $hasSlotContent = trim($slot->toHtml()) !== '';
@endphp

<div
    {{ $attributes->class($classes)->merge([
        'data-ui-pattern' => 'common-actions-bulk-actions',
        'data-ui-bulk-actions' => true,
        'data-ui-bulk-actions-selection-id' => $selectionId,
        'data-ui-bulk-actions-selected-count' => $resolvedSelectedCount,
        'data-ui-bulk-actions-total-count' => $resolvedTotalCount,
        'data-ui-bulk-actions-scope' => $resolvedScope,
        'data-ui-bulk-actions-placement' => $resolvedPlacement,
        'data-ui-bulk-actions-alignment' => $resolvedAlignment,
        'data-ui-bulk-actions-size' => $resolvedSize,
        'data-ui-bulk-actions-density' => $resolvedDensity,
        'data-ui-bulk-actions-overflow' => $resolvedOverflow,
        'data-ui-bulk-actions-inline-count' => $inlineActions->count(),
        'data-ui-bulk-actions-overflow-count' => $overflowActions->count(),
        'data-ui-bulk-actions-empty' => $isEmpty ? 'true' : 'false',
        'data-ui-bulk-actions-busy' => $isBusy ? 'true' : 'false',
        'data-ui-bulk-actions-disabled' => $isDisabled ? 'true' : 'false',
    ]) }}
    @if ($isHidden) hidden @endif
>
    {{-- ----------------------------------------------------------------------
        Selection Summary
        ----------------------------------------------------------------------
        Announces current selected count and provides optional clear selection.
        ---------------------------------------------------------------------- --}}

    @if ($showsSelectionCount || $showsClearSelection)
        <div class="ui-bulk-actions__selection" data-ui-bulk-actions-selection>
            @if ($showsSelectionCount)
                <span
                    class="ui-bulk-actions__selection-count"
                    aria-live="polite"
                    aria-atomic="true"
                    data-ui-bulk-actions-selection-count
                >
                    {{ $resolvedSelectionText }}
                </span>
            @endif

            @if ($showsClearSelection)
                <x-ui.button
                    kind="ghost"
                    :size="$resolvedSize"
                    :disabled="$isDisabled || $isBusy || $isEmpty"
                    class="ui-bulk-actions__clear"
                    @if (filled($clearHref)) href="{{ $clearHref }}" @endif
                    data-ui-bulk-actions-clear
                    data-ui-bulk-actions-clear-selection-id="{{ $selectionId }}"
                >
                    {{ $clearLabel }}
                </x-ui.button>
            @endif
        </div>
    @endif

    <x-patterns.common-actions.action-set
        :label="$resolvedGroupLabel"
        :labelled-by="$labelledBy"
        orientation="horizontal"
        class="ui-bulk-actions__actions"
        data-ui-bulk-actions-set
    >
        <x-ui.button-set
            :fluid="$resolvedAlignment === 'stretch'"
            data-ui-bulk-actions-button-set
        >
            {{-- ------------------------------------------------------------------
                Inline Bulk Actions
                ------------------------------------------------------------------
                Primary bulk action may remain visible. Destructive actions move
                to overflow by default in auto mode.
                ------------------------------------------------------------------ --}}

            @foreach ($inlineActions as $action)
                @php
                    $actionClasses = [
                        'ui-bulk-actions__action',
                        'ui-bulk-actions__action--'.$action['role'],
                        'ui-bulk-actions__action--primary' => $action['primary'],
                        'ui-bulk-actions__action--danger' => $action['danger'],
                        $action['class'],
                    ];
                @endphp

                @if (filled($action['icon']) && ! $showsLabels && ! $action['primary'])
                    <x-ui.icon-button
                        :kind="$action['kind']"
                        :size="$action['size'] ?? $resolvedSize"
                        :label="$action['aria_label']"
                        :icon="$action['icon']"
                        :disabled="$action['disabled'] || $isEmpty"
                        :loading="$action['loading']"
                        @class($actionClasses)
                        @if (filled($action['href'])) href="{{ $action['href'] }}" @endif
                        @if (filled($action['target'])) target="{{ $action['target'] }}" @endif
                        @if (filled($action['rel'])) rel="{{ $action['rel'] }}" @endif
                        data-ui-bulk-action
                        data-ui-bulk-action-role="{{ $action['role'] }}"
                        data-ui-bulk-action-index="{{ $action['index'] }}"
                        data-ui-bulk-action-selection-id="{{ $action['selection_id'] }}"
                        data-ui-bulk-action-inline="true"
                        data-ui-bulk-action-primary="{{ $action['primary'] ? 'true' : 'false' }}"
                        data-ui-bulk-action-danger="{{ $action['danger'] ? 'true' : 'false' }}"
                    />
                @else
                    <x-ui.button
                        :type="$action['type']"
                        :kind="$action['kind']"
                        :size="$action['size'] ?? $resolvedSize"
                        :disabled="$action['disabled'] || $isEmpty"
                        :loading="$action['loading']"
                        @class($actionClasses)
                        @if (filled($action['href'])) href="{{ $action['href'] }}" @endif
                        @if (filled($action['target'])) target="{{ $action['target'] }}" @endif
                        @if (filled($action['rel'])) rel="{{ $action['rel'] }}" @endif
                        @if (filled($action['name'])) name="{{ $action['name'] }}" @endif
                        @if (filled($action['value'])) value="{{ $action['value'] }}" @endif
                        @if (filled($action['form'] ?? $form)) form="{{ $action['form'] ?? $form }}" @endif
                        data-ui-bulk-action
                        data-ui-bulk-action-role="{{ $action['role'] }}"
                        data-ui-bulk-action-index="{{ $action['index'] }}"
                        data-ui-bulk-action-selection-id="{{ $action['selection_id'] }}"
                        data-ui-bulk-action-inline="true"
                        data-ui-bulk-action-primary="{{ $action['primary'] ? 'true' : 'false' }}"
                        data-ui-bulk-action-danger="{{ $action['danger'] ? 'true' : 'false' }}"
                    >
                        @if (filled($action['icon']))
                            <x-ui.icon :name="$action['icon']" class="ui-bulk-actions__action-icon" aria-hidden="true" />
                        @endif

                        {!! $renderTrustedContent($action['label']) !!}
                    </x-ui.button>
                @endif
            @endforeach

            {{-- ------------------------------------------------------------------
                Overflow Bulk Actions
                ------------------------------------------------------------------
                Overflow contains lower-frequency and destructive bulk actions
                by default.
                ------------------------------------------------------------------ --}}

            @if ($overflowActions->isNotEmpty())
                <x-ui.overflow-menu
                    :items="$overflowMenuItems"
                    :label="$resolvedOverflowLabel"
                    :size="$resolvedSize"
                    :placement="$resolvedOverflowPlacement"
                    :disabled="$isDisabled || $isBusy || $isEmpty"
                    class="ui-bulk-actions__overflow"
                    data-ui-bulk-actions-overflow-menu
                />
            @endif

            {{-- ------------------------------------------------------------------
                Slotted Bulk Actions
                ------------------------------------------------------------------
                Slot mode is preferred when callers need exact selection-state
                bindings, framework events, confirmation flows, or custom markup.
                ------------------------------------------------------------------ --}}

            @if ($hasSlotContent)
                {{ $slot }}
            @endif
        </x-ui.button-set>
    </x-patterns.common-actions.action-set>
</div>