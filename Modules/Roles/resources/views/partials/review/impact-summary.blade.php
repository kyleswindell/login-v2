{{-- ==========================================================================
    File: Modules/Roles/resources/views/partials/review/impact-summary.blade.php
    Purpose: Role impact summary review table.

    Notes:
    - Used inside confirmation-oriented modal notification bodies.
    - Owns RBAC-specific impact summary presentation.
    - Uses x-ui.data-table for compact review rows.
    - Keeps impact summary visible because this is decision-support content.
    - Does not own modal shell, footer actions, authorization, persistence, or
      save/delete behavior.
    ========================================================================== --}}

@props ([
    "review" => [],
    "rows" => null,
    "title" => "Impact summary",
    "description" => "Review affected records before continuing.",
    "emptyTitle" => "No impact items",
])

@php
    use Illuminate\Support\Str;

    /*
     *--------------------------------------------------------------------------
     * Impact rows
     *--------------------------------------------------------------------------
     */

    $impactRows = collect($rows ?? data_get($review, "impactRows", []))
        ->values();

    /*
     *--------------------------------------------------------------------------
     * Indicator mapping
     *--------------------------------------------------------------------------
     */

    $indicatorFor = function (?string $status): array {
        $resolvedStatus = strtolower((string) $status);

        return match ($resolvedStatus) {
            "blocked", "error", "failed" => [
                "variant" => "icon",
                "kind" => "failed",
                "label" => "Blocked",
            ],
            "review", "warning", "caution", "required" => [
                "variant" => "icon",
                "kind" => "caution-minor",
                "label" => filled($status) ? Str::headline($status) : "Review",
            ],
            "ok", "safe", "success", "succeeded" => [
                "variant" => "icon",
                "kind" => "succeeded",
                "label" => filled($status) ? Str::headline($status) : "OK",
            ],
            "processing", "busy", "in-progress" => [
                "variant" => "icon",
                "kind" => "in-progress",
                "label" => "Processing",
            ],
            default => [
                "variant" => "icon",
                "kind" => "informative",
                "label" => filled($status) ? Str::headline($status) : "Info",
            ],
        };
    };

    $formatCount = function ($count): string {
        if (is_null($count) || $count === "") {
            return "—";
        }

        return is_numeric($count)
            ? number_format((float) $count)
            : (string) $count;
    };
@endphp

<x-ui.data-table.container
    :title="$title"
    :description="$description"
    data-roles-review-impact-summary
>
    <x-ui.data-table.table size="sm" aria-label="Impact summary">
        <x-ui.data-table.head>
            <x-ui.data-table.row>
                <x-ui.data-table.header scope="col">
                    Impact
                </x-ui.data-table.header>

                <x-ui.data-table.header scope="col" align="end">
                    Count
                </x-ui.data-table.header>

                <x-ui.data-table.header scope="col">
                    Effect
                </x-ui.data-table.header>

                <x-ui.data-table.header scope="col">
                    Status
                </x-ui.data-table.header>
            </x-ui.data-table.row>
        </x-ui.data-table.head>

        <x-ui.data-table.body>
            @forelse ($impactRows as $row)
                @php
                    /*
                     *--------------------------------------------------------------------------
                     * Row state
                     *--------------------------------------------------------------------------
                     */

                    $rowData = is_array($row) ? $row : [];

                    $impact = data_get($rowData, "impact", "Impact");
                    $count = data_get($rowData, "count");
                    $effect = data_get($rowData, "effect", "No effect provided");
                    $status = data_get($rowData, "status", "Info");

                    $indicator = $indicatorFor($status);
                @endphp

                <x-ui.data-table.row>
                    <x-ui.data-table.cell> {{ $impact }} </x-ui.data-table.cell>

                    <x-ui.data-table.cell align="end">
                        {{
                            $formatCount(
                                $count,
                            )
                        }}
                    </x-ui.data-table.cell>

                    <x-ui.data-table.cell> {{ $effect }} </x-ui.data-table.cell>

                    <x-ui.data-table.cell>
                        <x-patterns.status-indicator
                            :variant="$indicator['variant']"
                            :kind="$indicator['kind']"
                            :label="$indicator['label']"
                            :hide-label="false"
                        />
                    </x-ui.data-table.cell>
                </x-ui.data-table.row>
            @empty
                <x-ui.data-table.row>
                    <x-ui.data-table.cell :colspan="4">
                        {{ $emptyTitle }}
                    </x-ui.data-table.cell>
                </x-ui.data-table.row>
            @endforelse
        </x-ui.data-table.body>
    </x-ui.data-table.table>
</x-ui.data-table.container>
