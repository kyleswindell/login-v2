{{-- ==========================================================================
    File: resources/views/components/patterns/account/action-row/index.blade.php
    Purpose: Account panel action row pattern.

    Notes:
    - Owns compact account panel header actions.
    - Uses x-ui.button-set for related button grouping.
    - Renders labeled x-ui.button controls only.
    - Does not render icon-only controls.
    - Does not pass button icons by default because x-ui.button only supports
      trailing decorative icons; use x-ui.icon-button for icon-only actions.
    - Does not own modal behavior, form submission, persistence, or business
      authorization.
    ========================================================================== --}}

@props ([
    "actions" => [],
    "label" => "Account actions",
    "align" => "end",
    "size" => "sm",
    "kind" => "ghost",
])

@php
    /*
     *--------------------------------------------------------------------------
     * Row state
     *--------------------------------------------------------------------------
     */

    $actionItems = collect(is_iterable($actions) ? $actions : [])
        ->filter(fn ($action) => is_array($action) || filled($action))
        ->values();

    $hasSlotContent = trim($slot->toHtml()) !== "";

    $allowedAlignments = ["start", "end", "stretch"];
    $allowedSizes = ["sm", "md", "lg"];

    $resolvedAlign = in_array($align, $allowedAlignments, true)
        ? $align
        : "end";

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : "sm";

    $classes = [
        "ui-account-action-row",
        "ui-account-action-row--align-".$resolvedAlign,
    ];
@endphp

@if ($hasSlotContent || $actionItems->isNotEmpty())
    <div
        {{
            $attributes->class($classes)->merge([
                "role" => "group",
                "aria-label" => $label,
                "data-ui-pattern" => "account.action-row",
                "data-account-action-row" => "true",
                "data-account-action-row-align" => $resolvedAlign,
            ])
        }}
    >
        <x-ui.button-set :align="$resolvedAlign">
            @if ($hasSlotContent)
                {{ $slot }}
            @else
                @foreach ($actionItems as $index => $action)
                    @php
                        /*
                         *------------------------------------------------------
                         * Action state
                         *------------------------------------------------------
                         */

                        $actionData = is_array($action)
                            ? $action
                            : ["label" => $action];

                        $actionLabel = data_get($actionData, "label", data_get($actionData, "text", "Action"));
                        $actionKind = data_get($actionData, "kind", $kind);
                        $actionSize = data_get($actionData, "size", $resolvedSize);
                        $actionType = data_get($actionData, "type", "button");
                        $actionHref = data_get($actionData, "href");
                        $actionDialog = data_get($actionData, "dialog", data_get($actionData, "dialogId"));
                        $actionDisabled = filter_var(data_get($actionData, "disabled", false), FILTER_VALIDATE_BOOLEAN);
                    @endphp

                    @if (filled($actionDialog))
                        <x-ui.button
                            type="button"
                            :kind="$actionKind"
                            :size="$actionSize"
                            :disabled="$actionDisabled"
                            aria-controls="{{ $actionDialog }}"
                            data-ui-dialog-trigger="{{ $actionDialog }}"
                            data-account-action-row-action="{{ $index }}"
                        >
                            {{ $actionLabel }}
                        </x-ui.button>
                    @elseif (filled($actionHref))
                        <x-ui.button
                            :href="$actionHref"
                            :kind="$actionKind"
                            :size="$actionSize"
                            :disabled="$actionDisabled"
                            data-account-action-row-action="{{ $index }}"
                        >
                            {{ $actionLabel }}
                        </x-ui.button>
                    @else
                        <x-ui.button
                            :type="$actionType"
                            :kind="$actionKind"
                            :size="$actionSize"
                            :disabled="$actionDisabled"
                            data-account-action-row-action="{{ $index }}"
                        >
                            {{ $actionLabel }}
                        </x-ui.button>
                    @endif
                @endforeach
            @endif
        </x-ui.button-set>
    </div>
@endif
