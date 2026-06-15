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
    $resolvedStatus = in_array($status, ['info', 'success', 'warning', 'error'], true) ? $status : null;
    $hasActionSlot = isset($actions) && trim((string) $actions) !== '';
    $hasActionItems = ! empty($actionItems);
    $hasActions = $hasActionSlot || $hasActionItems;
    $isInteractive = filled($href) && ! $disabled && ! $hasActions;
    $baseClasses = [
        'ui-contained-list-item',
        'ui-contained-list-item-with-icon' => filled($icon) || filled($resolvedStatus),
        'ui-contained-list-item-with-actions' => $hasActions,
        'ui-contained-list-status-'.$resolvedStatus => filled($resolvedStatus),
    ];
@endphp

@if ($isInteractive)
    <a
        href="{{ $href }}"
        {{ $attributes->class($baseClasses) }}
        data-ui-component="contained-list-item"
        data-ui-contained-list-item
        data-ui-contained-list-item-interactive="true"
        data-ui-selected="{{ $selected ? 'true' : 'false' }}"
        @if($current) aria-current="page" @endif
        role="listitem"
    >
        @if ($icon || $resolvedStatus)
            <span class="ui-contained-list-item-icon" aria-hidden="true">
                @if ($icon)
                    <x-dynamic-component :component="$icon" class="ui-contained-list-item-icon-svg" />
                @else
                    <x-ui.status-icon :icon="$resolvedStatus === 'error' ? 'x-circle' : ($resolvedStatus === 'warning' ? 'exclamation-triangle' : ($resolvedStatus === 'success' ? 'check-circle' : 'information-circle'))" class="ui-contained-list-item-icon-svg" />
                @endif
            </span>
        @endif
        <span class="ui-contained-list-item-content">
            <span class="ui-contained-list-item-title">{{ $title ?? $slot }}</span>
            @if ($description)
                <span class="ui-contained-list-item-description">{{ $description }}</span>
            @endif
        </span>
        @if ($meta)
            <span class="ui-contained-list-item-meta">{{ $meta }}</span>
        @endif
    </a>
@else
    <div
        {{ $attributes->class($baseClasses) }}
        data-ui-component="contained-list-item"
        data-ui-contained-list-item
        data-ui-contained-list-item-interactive="{{ $hasActions ? 'true' : 'false' }}"
        data-ui-selected="{{ $selected ? 'true' : 'false' }}"
        @if($current) aria-current="page" @endif
        @if($disabled) aria-disabled="true" @endif
        role="listitem"
    >
        @if ($icon || $resolvedStatus)
            <span class="ui-contained-list-item-icon" aria-hidden="true">
                @if ($icon)
                    <x-dynamic-component :component="$icon" class="ui-contained-list-item-icon-svg" />
                @else
                    <x-ui.status-icon :icon="$resolvedStatus === 'error' ? 'x-circle' : ($resolvedStatus === 'warning' ? 'exclamation-triangle' : ($resolvedStatus === 'success' ? 'check-circle' : 'information-circle'))" class="ui-contained-list-item-icon-svg" />
                @endif
            </span>
        @endif
        <span class="ui-contained-list-item-content">
            <span class="ui-contained-list-item-title">{{ $title ?? $slot }}</span>
            @if ($description)
                <span class="ui-contained-list-item-description">{{ $description }}</span>
            @endif
        </span>
        @if ($meta)
            <span class="ui-contained-list-item-meta">{{ $meta }}</span>
        @endif
        @if ($hasActions)
            <span class="ui-contained-list-item-actions">
                @foreach ($actionItems as $action)
                    @php
                        $actionLabel = data_get($action, 'label', 'Row action');
                        $actionIcon = data_get($action, 'icon');
                        $actionHref = data_get($action, 'href');
                        $actionSemantic = data_get($action, 'semantic', 'ghost');
                        $actionDisabled = (bool) data_get($action, 'disabled', false);
                        $iconOnly = (bool) data_get($action, 'icon_only', filled($actionIcon));
                    @endphp
                    @if ($iconOnly && $actionIcon)
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
                        >{{ $actionLabel }}</x-ui.button>
                    @endif
                @endforeach
                @if ($hasActionSlot)
                    {{ $actions }}
                @endif
            </span>
        @endif
    </div>
@endif
