{{-- ==========================================================================
    File: resources/views/components/ui/contained-list-item/index.blade.php
    Purpose: Contained List item component.

    Notes:
    - Emits the installed .ui-contained-list-item selector contract.
    - Intended for use inside x-ui.contained-list.
    - Supports icon/status leading visuals, title, description, meta,
      selected/current states, disabled state, full-row links, and row actions.
    - Uses x-ui.icon, x-ui.button, x-ui.icon-button, and x-ui.overflow-menu.
    ========================================================================== --}}

@props([
    'title' => null,
    'description' => null,
    'meta' => null,
    'href' => null,
    'icon' => null,
    'status' => null,
    'actionItems' => [],
    'selected' => false,
    'current' => false,
    'disabled' => false,
])

@php
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedStatuses = [
        'info',
        'success',
        'warning',
        'error',
    ];

    $statusIcons = [
        'info' => 'information--filled',
        'success' => 'checkmark--filled',
        'warning' => 'warning--alt--filled',
        'error' => 'error--filled',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedStatus = in_array($status, $allowedStatuses, true)
        ? $status
        : null;

    $resolvedStatusIcon = $resolvedStatus
        ? $statusIcons[$resolvedStatus]
        : null;

    $slotContent = trim($slot->toHtml());
    $resolvedTitle = $title ?? ($slotContent !== '' ? $slot : null);

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isSelected = filter_var($selected, FILTER_VALIDATE_BOOLEAN);
    $isCurrent = filter_var($current, FILTER_VALIDATE_BOOLEAN);
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);

    $hasActionSlot = isset($actions) && trim($actions->toHtml()) !== '';
    $actionItemsCollection = collect($actionItems);
    $hasActionItems = $actionItemsCollection->isNotEmpty();
    $hasActions = $hasActionSlot || $hasActionItems;
    $usesOverflowActions = $actionItemsCollection->count() > 1 && ! $hasActionSlot;

    $isInteractive = filled($href) && ! $isDisabled && ! $hasActions;

    /*
    |--------------------------------------------------------------------------
    | Action Normalization
    |--------------------------------------------------------------------------
    */

    $overflowActionItems = $actionItemsCollection
        ->map(function ($action): array {
            $actionSemantic = (string) data_get($action, 'semantic', 'neutral');
            $isDanger = str_contains($actionSemantic, 'danger');

            return [
                'label' => data_get($action, 'label', 'Row action'),
                'href' => data_get($action, 'href'),
                'disabled' => filter_var(data_get($action, 'disabled', false), FILTER_VALIDATE_BOOLEAN),
                'semantic' => $isDanger
                    ? 'danger'
                    : (in_array($actionSemantic, ['neutral', 'primary', 'success', 'warning', 'notice', 'info'], true) ? $actionSemantic : 'neutral'),
                'danger' => $isDanger,
            ];
        })
        ->all();

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $baseClasses = [
        'ui-contained-list-item',
        'ui-contained-list-item--clickable' => $isInteractive,
        'ui-contained-list-item-with-icon' => filled($icon) || filled($resolvedStatus),
        'ui-contained-list-item-with-actions' => $hasActions,
        'ui-contained-list-item-selected' => $isSelected,
        'ui-contained-list-item-current' => $isCurrent,
        'ui-contained-list-item-disabled' => $isDisabled,
        'ui-contained-list-status-'.$resolvedStatus => filled($resolvedStatus),
    ];
@endphp

<li
    {{ $attributes->class($baseClasses)->merge([
        'data-ui-component' => 'contained-list-item',
        'data-ui-contained-list-item' => true,
        'data-ui-contained-list-item-interactive' => $isInteractive || $hasActions ? 'true' : 'false',
        'data-ui-contained-list-item-status' => $resolvedStatus,
        'data-ui-contained-list-item-actions' => $hasActions ? 'true' : 'false',
        'data-ui-selected' => $isSelected ? 'true' : 'false',
        'data-ui-current' => $isCurrent ? 'true' : 'false',
        'data-ui-disabled' => $isDisabled ? 'true' : 'false',
        'aria-current' => $isCurrent ? 'page' : null,
        'aria-disabled' => $isDisabled ? 'true' : null,
    ]) }}
>
    @if ($isInteractive)
        <a href="{{ $href }}" class="ui-contained-list-item-content">
            @if ($icon || $resolvedStatusIcon)
                <span class="ui-contained-list-item-icon" aria-hidden="true">
                    <x-ui.icon
                        :name="$icon ?? $resolvedStatusIcon"
                        class="ui-contained-list-item-icon-svg"
                    />
                </span>
            @endif

            <span class="ui-contained-list-item-text">
                @if (filled($resolvedTitle))
                    <span class="ui-contained-list-item-title">
                        @if ($resolvedTitle instanceof HtmlString)
                            {!! $resolvedTitle !!}
                        @else
                            {{ $resolvedTitle }}
                        @endif
                    </span>
                @endif

                @if (filled($description))
                    <span class="ui-contained-list-item-description">
                        @if ($description instanceof HtmlString)
                            {!! $description !!}
                        @else
                            {{ $description }}
                        @endif
                    </span>
                @endif
            </span>

            @if (filled($meta))
                <span class="ui-contained-list-item-meta">
                    @if ($meta instanceof HtmlString)
                        {!! $meta !!}
                    @else
                        {{ $meta }}
                    @endif
                </span>
            @endif
        </a>
    @else
        <div class="ui-contained-list-item-content">
            @if ($icon || $resolvedStatusIcon)
                <span class="ui-contained-list-item-icon" aria-hidden="true">
                    <x-ui.icon
                        :name="$icon ?? $resolvedStatusIcon"
                        class="ui-contained-list-item-icon-svg"
                    />
                </span>
            @endif

            <span class="ui-contained-list-item-text">
                @if (filled($resolvedTitle))
                    <span class="ui-contained-list-item-title">
                        @if ($resolvedTitle instanceof HtmlString)
                            {!! $resolvedTitle !!}
                        @else
                            {{ $resolvedTitle }}
                        @endif
                    </span>
                @endif

                @if (filled($description))
                    <span class="ui-contained-list-item-description">
                        @if ($description instanceof HtmlString)
                            {!! $description !!}
                        @else
                            {{ $description }}
                        @endif
                    </span>
                @endif
            </span>

            @if (filled($meta))
                <span class="ui-contained-list-item-meta">
                    @if ($meta instanceof HtmlString)
                        {!! $meta !!}
                    @else
                        {{ $meta }}
                    @endif
                </span>
            @endif
        </div>

        @if ($hasActions)
            <span class="ui-contained-list-item-actions">
                @if ($usesOverflowActions)
                    <x-ui.overflow-menu
                        :items="$overflowActionItems"
                        label="Row actions"
                        aria-label="More row actions"
                        size="sm"
                    />
                @else
                    @foreach ($actionItemsCollection as $action)
                        @php
                            $actionLabel = data_get($action, 'label', 'Row action');
                            $actionIcon = data_get($action, 'icon');
                            $actionHref = data_get($action, 'href');
                            $actionSemantic = data_get($action, 'semantic', 'ghost');
                            $actionDisabled = filter_var(data_get($action, 'disabled', false), FILTER_VALIDATE_BOOLEAN);
                            $iconOnly = filter_var(data_get($action, 'icon_only', filled($actionIcon)), FILTER_VALIDATE_BOOLEAN);
                        @endphp

                        @if ($iconOnly && filled($actionIcon))
                            <x-ui.icon-button
                                :href="$actionHref"
                                :icon="$actionIcon"
                                :label="$actionLabel"
                                :tooltip="data_get($action, 'tooltip', $actionLabel)"
                                tooltip-placement="auto"
                                size="sm"
                                :semantic="$actionSemantic"
                                :disabled="$actionDisabled"
                            />
                        @else
                            <x-ui.button
                                :href="$actionHref"
                                size="sm"
                                :semantic="$actionSemantic"
                                :disabled="$actionDisabled"
                            >
                                {{ $actionLabel }}
                            </x-ui.button>
                        @endif
                    @endforeach
                @endif

                @if ($hasActionSlot)
                    {{ $actions }}
                @endif
            </span>
        @endif
    @endif
</li>