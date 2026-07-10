{{-- ==========================================================================
    File: resources/views/components/patterns/key-value-display/index.blade.php
    Purpose: Key/value display pattern.

    Notes:
    - Owns compact read-only key/value fact presentation.
    - Uses semantic dl/dt/dd markup.
    - Intended for profile facts, settings summaries, security states, and
      small read-only metadata groups.
    - Use x-ui.structured-list for row/column comparison.
    - Use x-ui.contained-list for repeated resource/settings rows with actions.
    - Does not own editing, actions, forms, persistence, or validation.
    ========================================================================== --}}

@props ([
    "items" => [],
    "columns" => 2,
    "emptyText" => "No details available.",
    "emptyValue" => "—",
    "compact" => false,
])

@php
    /*
     *--------------------------------------------------------------------------
     * Helpers
     *--------------------------------------------------------------------------
     */

    $contentIsFilled = function ($value): bool {
        if ($value instanceof \Illuminate\Support\HtmlString) {
            return trim(strip_tags($value->toHtml())) !== "";
        }

        if (is_object($value) && method_exists($value, "toHtml")) {
            return trim(strip_tags($value->toHtml())) !== "";
        }

        if (is_null($value)) {
            return false;
        }

        if (is_string($value)) {
            return trim($value) !== "";
        }

        if (is_array($value)) {
            return count(array_filter($value, fn ($item) => $item !== null && $item !== "")) > 0;
        }

        return true;
    };

    $renderContent = function ($content) use ($emptyValue, $contentIsFilled): string {
        if (! $contentIsFilled($content)) {
            return e($emptyValue);
        }

        if ($content instanceof \Illuminate\Support\HtmlString) {
            return $content->toHtml();
        }

        if (is_object($content) && method_exists($content, "toHtml")) {
            return $content->toHtml();
        }

        if ($content instanceof \DateTimeInterface) {
            return e($content->format("M j, Y"));
        }

        if (is_bool($content)) {
            return e($content ? "Yes" : "No");
        }

        if (is_array($content)) {
            return e(collect($content)->filter()->join(", "));
        }

        return e((string) $content);
    };

    /*
     *--------------------------------------------------------------------------
     * Resolve items
     *--------------------------------------------------------------------------
     */

    $displayItems = collect(is_iterable($items) ? $items : [])
        ->map(function ($item) {
            if (is_array($item)) {
                return $item;
            }

            return [
                "label" => "Detail",
                "value" => $item,
            ];
        })
        ->filter(function (array $item) {
            return ! array_key_exists("visible", $item)
                || filter_var(data_get($item, "visible", true), FILTER_VALIDATE_BOOLEAN);
        })
        ->values();

    /*
     *--------------------------------------------------------------------------
     * Resolve columns and density
     *--------------------------------------------------------------------------
     */

    $allowedColumns = [1, 2, 3, 4];

    $resolvedColumns = in_array((int) $columns, $allowedColumns, true)
        ? (int) $columns
        : 2;

    $isCompact = filter_var($compact, FILTER_VALIDATE_BOOLEAN);

    /*
     *--------------------------------------------------------------------------
     * CSS class contract
     *--------------------------------------------------------------------------
     */

    $rootClasses = [
        "ui-pattern-key-value-display",
        "ui-pattern-key-value-display--compact" => $isCompact,
        "grid",
        "grid-cols-1",
        "gap-4" => $isCompact,
        "gap-5" => ! $isCompact,
        "sm:grid-cols-2" => $resolvedColumns >= 2,
        "lg:grid-cols-3" => $resolvedColumns === 3,
        "lg:grid-cols-4" => $resolvedColumns === 4,
    ];
@endphp

@if ($displayItems->isEmpty())
    <p
        {{
            $attributes
                ->class([
                    "ui-pattern-key-value-display-empty",
                    "ui-platform-text-muted",
                    "text-sm",
                ])
                ->merge([
                    "data-ui-pattern" => "key-value-display",
                    "data-ui-key-value-display" => "true",
                    "data-ui-key-value-display-empty" => "true",
                ])
        }}
    >
        {{ $emptyText }}
    </p>
@else
    <dl
        {{
            $attributes->class($rootClasses)->merge([
                "data-ui-pattern" => "key-value-display",
                "data-ui-key-value-display" => "true",
                "data-ui-key-value-display-columns" => (string) $resolvedColumns,
                "data-ui-key-value-display-compact" => $isCompact ? "true" : "false",
                "data-ui-key-value-display-item-count" => (string) $displayItems->count(),
            ])
        }}
    >
        @foreach ($displayItems as $item)
            @php
                /*
                 *--------------------------------------------------------------
                 * Item state
                 *--------------------------------------------------------------
                 */

                $label = data_get($item, "label", data_get($item, "title", "Detail"));
                $value = data_get($item, "value");
                $description = data_get($item, "description", data_get($item, "helperText"));
                $meta = data_get($item, "meta");
                $status = data_get($item, "status");
                $statusType = data_get($item, "statusType", data_get($item, "status_type", "cool-gray"));

                $requestedSpan = data_get($item, "span", 1);

                $itemSpan = $requestedSpan === "full"
                    ? $resolvedColumns
                    : (is_numeric($requestedSpan) ? (int) $requestedSpan : 1);

                $itemSpan = max(1, min($itemSpan, $resolvedColumns));

                $itemClasses = [
                    "ui-pattern-key-value-item",
                    "min-w-0",
                    "sm:col-span-2" => $itemSpan >= 2,
                    "lg:col-span-3" => $itemSpan === 3 && $resolvedColumns >= 3,
                    "lg:col-span-4" => $itemSpan === 4 && $resolvedColumns >= 4,
                ];
            @endphp

            <div
                @class ($itemClasses)
                data-ui-key-value-display-item
                data-ui-key-value-display-item-span="{{ $itemSpan }}"
            >
                <dt
                    class="ui-pattern-key-value-label text-xs font-semibold uppercase tracking-widest ui-platform-text-muted"
                >
                    {!!
                        $renderContent(
                            $label,
                        )
                    !!}
                </dt>

                <dd
                    class="ui-pattern-key-value-value mt-2 text-sm ui-platform-text-strong"
                >
                    <span class="ui-pattern-key-value-value-text">
                        {!!
                            $renderContent(
                                $value,
                            )
                        !!}
                    </span>

                    @if ($contentIsFilled($status))
                        <span class="ui-pattern-key-value-status ms-2">
                            <x-ui.tag
                                :type="$statusType"
                                size="sm"
                                variant="read-only"
                            >
                                {!!
                                    $renderContent(
                                        $status,
                                    )
                                !!}
                            </x-ui.tag>
                        </span>
                    @endif
                </dd>

                @if ($contentIsFilled($meta))
                    <dd
                        class="ui-pattern-key-value-meta mt-1 text-xs ui-platform-text-muted"
                    >
                        {!!
                            $renderContent(
                                $meta,
                            )
                        !!}
                    </dd>
                @endif

                @if ($contentIsFilled($description))
                    <dd
                        class="ui-pattern-key-value-description mt-1 text-xs ui-platform-text-muted"
                    >
                        {!!
                            $renderContent(
                                $description,
                            )
                        !!}
                    </dd>
                @endif
            </div>
        @endforeach
    </dl>
@endif
