{{-- ==========================================================================
    File: Modules/Roles/resources/views/partials/review/blocker-summary.blade.php
    Purpose: Role blocker summary review list.

    Notes:
    - Used inside blocked/destructive modal notification bodies.
    - Owns RBAC-specific blocker summary presentation.
    - Uses x-ui.contained-list because blockers are explanatory rows, not
      comparison data.
    - Uses x-patterns.status-indicator for blocked, review, required, and
      informational status treatment.
    - Does not own modal shell, footer actions, authorization, persistence, or
      delete behavior.
    ========================================================================== --}}

@props ([
    "review" => [],
    "rows" => null,
    "title" => "Blockers",
    "description" => "Review why this action cannot continue.",
    "emptyTitle" => "No blockers",
])

@php
    use Illuminate\Support\Str;

    /*
     *--------------------------------------------------------------------------
     * Blocker rows
     *--------------------------------------------------------------------------
     */

    $blockerRows = collect($rows ?? data_get($review, "blockerRows", []))
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
            "review", "warning", "required", "caution" => [
                "variant" => "icon",
                "kind" => "caution-minor",
                "label" => filled($status) ? Str::headline($status) : "Review",
            ],
            "ok", "safe", "success", "succeeded" => [
                "variant" => "icon",
                "kind" => "succeeded",
                "label" => filled($status) ? Str::headline($status) : "OK",
            ],
            default => [
                "variant" => "icon",
                "kind" => "informative",
                "label" => filled($status) ? Str::headline($status) : "Info",
            ],
        };
    };
@endphp

<x-ui.contained-list
    :title="$title"
    :description="$description"
    aria-label="Role action blockers"
    variant="disclosed"
    size="sm"
    data-roles-review-blocker-summary
>
    @forelse ($blockerRows as $row)
        @php
            /*
             *--------------------------------------------------------------------------
             * Row state
             *--------------------------------------------------------------------------
             */

            $rowData = is_array($row) ? $row : [];

            $blocker = data_get($rowData, "blocker", "Blocker");
            $effect = data_get($rowData, "effect", "No effect provided");
            $status = data_get($rowData, "status", "Blocked");

            $indicator = $indicatorFor($status);
        @endphp

        <x-ui.contained-list-item
            :description="$effect"
            :meta="$indicator['label']"
        >
            <x-ui.h-stack as="span" :gap="2">
                <x-patterns.status-indicator
                    :variant="$indicator['variant']"
                    :kind="$indicator['kind']"
                    :label="$indicator['label']"
                    :hide-label="true"
                />

                <span>{{ $blocker }}</span>
            </x-ui.h-stack>
        </x-ui.contained-list-item>
    @empty
        <x-ui.contained-list-item
            :title="$emptyTitle"
            description="No blocking conditions were provided."
            disabled
        />
    @endforelse
</x-ui.contained-list>
