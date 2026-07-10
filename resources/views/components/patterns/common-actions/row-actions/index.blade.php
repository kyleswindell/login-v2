{{-- ==========================================================================
    File: resources/views/components/patterns/common-actions/row-actions/index.blade.php
    Purpose: Row Actions pattern for compact row-scoped controls.

    Notes:
    - Composes x-patterns.common-actions.action-set for semantic grouping.
    - Composes x-ui.button, x-ui.icon-button, and x-ui.overflow-menu.
    - Use for actions scoped to one data table row, list row, tile row, or
      structured row.
    - Inline actions should be limited to the highest-frequency safe actions.
    - Destructive actions should normally be placed in overflow unless the
      caller explicitly forces them inline.
    - Bulk actions belong to the Bulk Actions pattern, not Row Actions.
    ========================================================================== --}}

@props([
    'actions' => [],
    'label' => 'Row actions',
    'labelledBy' => null,
    'rowId' => null,
    'rowLabel' => null,
    'alignment' => 'end',
    'size' => 'sm',
    'density' => 'compact',
    'overflow' => 'auto',
    'maxInlineActions' => 2,
    'overflowLabel' => null,
    'overflowPlacement' => 'bottom-end',
    'showLabels' => false,
    'disabled' => false,
    'busy' => false,
    'preventRowClick' => true,
])

@php
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedAlignments = [
        'start',
        'end',
        'between',
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

    $destructiveRoles = [
        'danger',
        'destructive',
        'delete',
        'destroy',
        'remove',
        'deactivate',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedAlignment = in_array($alignment, $allowedAlignments, true)
        ? $alignment
        : 'end';

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

    $resolvedMaxInlineActions = is_numeric($maxInlineActions)
        ? max(0, min(4, (int) $maxInlineActions))
        : 2;

    $resolvedGroupLabel = filled($rowLabel) && $label === 'Row actions'
        ? 'Actions for '.$rowLabel
        : $label;

    $resolvedOverflowLabel = $overflowLabel
        ?? (filled($rowLabel) ? 'More actions for '.$rowLabel : 'More row actions');

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $isBusy = filter_var($busy, FILTER_VALIDATE_BOOLEAN);
    $showsLabels = filter_var($showLabels, FILTER_VALIDATE_BOOLEAN);
    $preventsRowClick = filter_var($preventRowClick, FILTER_VALIDATE_BOOLEAN);

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
            $rowId,
            $rowLabel,
            $isDisabled,
            $isBusy,
            $destructiveRoles,
            $toPlainText
        ) {
            $actionData = is_array($action)
                ? $action
                : [
                    'label' => $action,
                    'role' => 'secondary',
                ];

            $isVisible = ! array_key_exists('visible', $actionData)
                || filter_var(data_get($actionData, 'visible', true), FILTER_VALIDATE_BOOLEAN);

            if (! $isVisible) {
                return null;
            }

            $role = data_get($actionData, 'role', data_get($actionData, 'action', 'secondary'));
            $role = is_string($role) && $role !== '' ? $role : 'secondary';

            $label = data_get($actionData, 'label', data_get($actionData, 'text', 'Action'));
            $labelText = $toPlainText($label);

            $href = data_get($actionData, 'href', data_get($actionData, 'url'));
            $icon = data_get($actionData, 'icon');

            $isDanger = in_array($role, $destructiveRoles, true)
                || filter_var(data_get($actionData, 'danger', false), FILTER_VALIDATE_BOOLEAN);

            $kind = data_get($actionData, 'kind') ?? ($isDanger ? 'danger-ghost' : 'ghost');

            $itemDisabled = filter_var(data_get($actionData, 'disabled', false), FILTER_VALIDATE_BOOLEAN);

            $allowDuringBusy = filter_var(
                data_get($actionData, 'allowDuringBusy', in_array($role, ['view', 'open'], true)),
                FILTER_VALIDATE_BOOLEAN
            );

            $actionDisabled = $isDisabled || $itemDisabled || ($isBusy && ! $allowDuringBusy);

            $actionLoading = filter_var(data_get($actionData, 'loading', false), FILTER_VALIDATE_BOOLEAN);

            $ariaLabel = data_get($actionData, 'ariaLabel', data_get($actionData, 'aria-label'));

            if (blank($ariaLabel)) {
                $ariaLabel = filled($rowLabel) ? $labelText.' '.$rowLabel : $labelText;
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
                'icon' => $icon,
                'class' => data_get($actionData, 'class'),
                'disabled' => $actionDisabled,
                'loading' => $actionLoading,
                'danger' => $isDanger,
                'inline' => filter_var(data_get($actionData, 'inline', false), FILTER_VALIDATE_BOOLEAN),
                'overflow' => filter_var(data_get($actionData, 'overflow', false), FILTER_VALIDATE_BOOLEAN),
                'row_id' => data_get($actionData, 'rowId', data_get($actionData, 'row_id', $rowId)),
            ];
        })
        ->filter()
        ->values();

    /*
    |--------------------------------------------------------------------------
    | Partition Inline and Overflow Actions
    |--------------------------------------------------------------------------
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
                || ($inlineActions->count() >= $resolvedMaxInlineActions),
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
            'rowId' => $action['row_id'],
        ])
        ->values()
        ->all();

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-row-actions',
        'ui-row-actions--align-'.$resolvedAlignment,
        'ui-row-actions--'.$resolvedDensity,
        'ui-row-actions--with-overflow' => $overflowActions->isNotEmpty(),
        'ui-row-actions--inline-only' => $inlineActions->isNotEmpty() && $overflowActions->isEmpty(),
        'ui-row-actions--overflow-only' => $inlineActions->isEmpty() && $overflowActions->isNotEmpty(),
        'ui-row-actions--busy' => $isBusy,
        'ui-row-actions--disabled' => $isDisabled,
    ];

    $hasSlotContent = trim($slot->toHtml()) !== '';
@endphp

<x-patterns.common-actions.action-set
    :label="$resolvedGroupLabel"
    :labelled-by="$labelledBy"
    orientation="horizontal"
    {{ $attributes->class($classes)->merge([
        'data-ui-pattern' => 'common-actions-row-actions',
        'data-ui-row-actions' => true,
        'data-ui-row-actions-row-id' => $rowId,
        'data-ui-row-actions-row-label' => $rowLabel,
        'data-ui-row-actions-alignment' => $resolvedAlignment,
        'data-ui-row-actions-size' => $resolvedSize,
        'data-ui-row-actions-density' => $resolvedDensity,
        'data-ui-row-actions-overflow' => $resolvedOverflow,
        'data-ui-row-actions-inline-count' => $inlineActions->count(),
        'data-ui-row-actions-overflow-count' => $overflowActions->count(),
        'data-ui-row-actions-busy' => $isBusy ? 'true' : 'false',
        'data-ui-row-actions-disabled' => $isDisabled ? 'true' : 'false',
        'data-ui-row-actions-prevent-row-click' => $preventsRowClick ? 'true' : 'false',
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Inline Row Actions
        ----------------------------------------------------------------------
        Keep inline actions limited. Prefer overflow for destructive or lower
        frequency actions.
        ---------------------------------------------------------------------- --}}

    @foreach ($inlineActions as $action)
        @php
            $actionClasses = [
                'ui-row-actions__action',
                'ui-row-actions__action--'.$action['role'],
                'ui-row-actions__action--danger' => $action['danger'],
                $action['class'],
            ];
        @endphp

        @if (filled($action['icon']) && ! $showsLabels)
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
                data-ui-row-action
                data-ui-row-action-role="{{ $action['role'] }}"
                data-ui-row-action-index="{{ $action['index'] }}"
                data-ui-row-action-row-id="{{ $action['row_id'] }}"
                data-ui-row-action-inline="true"
                data-ui-row-action-danger="{{ $action['danger'] ? 'true' : 'false' }}"
                data-ui-row-action-prevent-row-click="{{ $preventsRowClick ? 'true' : 'false' }}"
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
                data-ui-row-action
                data-ui-row-action-role="{{ $action['role'] }}"
                data-ui-row-action-index="{{ $action['index'] }}"
                data-ui-row-action-row-id="{{ $action['row_id'] }}"
                data-ui-row-action-inline="true"
                data-ui-row-action-danger="{{ $action['danger'] ? 'true' : 'false' }}"
                data-ui-row-action-prevent-row-click="{{ $preventsRowClick ? 'true' : 'false' }}"
            >
                @if (filled($action['icon']))
                    <x-ui.icon :name="$action['icon']" class="ui-row-actions__action-icon" aria-hidden="true" />
                @endif

                {!! $renderTrustedContent($action['label']) !!}
            </x-ui.button>
        @endif
    @endforeach

    {{-- ----------------------------------------------------------------------
        Overflow Row Actions
        ----------------------------------------------------------------------
        Overflow contains lower-frequency actions and destructive actions by
        default.
        ---------------------------------------------------------------------- --}}

    @if ($overflowActions->isNotEmpty())
        <x-ui.overflow-menu
            :items="$overflowMenuItems"
            :label="$resolvedOverflowLabel"
            :size="$resolvedSize"
            :placement="$resolvedOverflowPlacement"
            :disabled="$isDisabled"
            class="ui-row-actions__overflow"
            data-ui-row-actions-overflow-menu
            data-ui-row-action-prevent-row-click="{{ $preventsRowClick ? 'true' : 'false' }}"
        />
    @endif

    {{-- ----------------------------------------------------------------------
        Slotted Row Actions
        ----------------------------------------------------------------------
        Slot mode is preferred when callers need exact action markup, framework
        bindings, confirmation triggers, or custom event handling.
        ---------------------------------------------------------------------- --}}

    @if ($hasSlotContent)
        {{ $slot }}
    @endif
</x-patterns.common-actions.action-set>