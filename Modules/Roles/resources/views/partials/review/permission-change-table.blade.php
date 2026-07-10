{{-- ==========================================================================
    File: Modules/Roles/resources/views/partials/review/permission-change-table.blade.php
    Purpose: Role permission change review table.

    Notes:
    - Used inside confirmation-oriented modal notification bodies.
    - Owns RBAC-specific permission change presentation.
    - Uses expandable x-ui.data-table rows so the visible row stays concise.
    - Uses a compact horizontal definition layout inside expanded rows.
    - Keeps result, permission key, source metadata, description, and flags out
      of the visible decision-scan row.
    - Does not own modal shell, footer actions, authorization, persistence, or
      save/delete behavior.
    ========================================================================== --}}

@props ([
    "review" => [],
    "rows" => null,
    "title" => "Permission changes",
    "description" => null,
    "emptyTitle" => "No permission changes",
    "expanded" => false,
])

@php
    use Illuminate\Support\Str;

    /*
     *--------------------------------------------------------------------------
     * Permission rows
     *--------------------------------------------------------------------------
     */

    $permissionRows = collect($rows ?? data_get($review, "permissionChangeRows", []))
        ->values();

    $defaultExpanded = filter_var($expanded, FILTER_VALIDATE_BOOLEAN);

    /*
     *--------------------------------------------------------------------------
     * Indicator mapping
     *--------------------------------------------------------------------------
     */

    $changeIndicatorFor = function (?string $change): array {
        $resolvedChange = strtolower((string) $change);

        return match ($resolvedChange) {
            "enabled", "added", "granted", "created" => [
                "variant" => "differential",
                "direction" => "enabled",
                "kind" => null,
                "label" => "Enabled",
            ],
            "disabled", "removed", "revoked", "deleted" => [
                "variant" => "differential",
                "direction" => "disabled",
                "kind" => null,
                "label" => "Disabled",
            ],
            "changed", "updated" => [
                "variant" => "differential",
                "direction" => "neutral",
                "kind" => null,
                "label" => "Changed",
            ],
            "preserved" => [
                "variant" => "icon",
                "direction" => null,
                "kind" => "succeeded",
                "label" => "Preserved",
            ],
            "stale" => [
                "variant" => "icon",
                "direction" => null,
                "kind" => "caution-minor",
                "label" => "Stale",
            ],
            default => [
                "variant" => "icon",
                "direction" => null,
                "kind" => "informative",
                "label" => filled($change) ? Str::headline($change) : "Unknown",
            ],
        };
    };

    $accessLabelFor = function (array $row): string {
        $accessLevel = data_get($row, "accessLevel");

        if (filled($accessLevel)) {
            return (string) $accessLevel;
        }

        return match (true) {
            (bool) data_get($row, "isStale", false) => "Stale",
            (bool) data_get($row, "isDestructive", false) => "Destructive",
            (bool) data_get($row, "isElevated", false) => "Elevated",
            default => "Standard",
        };
    };

    $accessIndicatorFor = function (string $accessLevel): ?array {
        $resolvedAccessLevel = strtolower($accessLevel);

        return match ($resolvedAccessLevel) {
            "elevated" => [
                "variant" => "shape",
                "kind" => "high",
                "direction" => null,
                "label" => "Elevated",
                "textSize" => 14,
            ],
            "destructive", "critical" => [
                "variant" => "shape",
                "kind" => "critical",
                "direction" => null,
                "label" => "Destructive",
                "textSize" => 14,
            ],
            "stale" => [
                "variant" => "icon",
                "kind" => "caution-minor",
                "direction" => null,
                "label" => "Stale",
                "textSize" => 12,
            ],
            default => null,
        };
    };
@endphp

<x-ui.data-table.container
    :title="$title"
    :description="$description"
    data-roles-review-permission-change-table
>
    <x-ui.data-table.table size="sm" aria-label="Permission changes">
        <x-ui.data-table.head>
            <x-ui.data-table.row>
                <x-ui.data-table.expand-header
                    aria-label="Permission detail controls"
                    expand-icon-description="Expand permission details"
                />

                <x-ui.data-table.header scope="col">
                    Change
                </x-ui.data-table.header>

                <x-ui.data-table.header scope="col">
                    Permission
                </x-ui.data-table.header>

                <x-ui.data-table.header scope="col">
                    Area
                </x-ui.data-table.header>

                <x-ui.data-table.header scope="col">
                    Access
                </x-ui.data-table.header>
            </x-ui.data-table.row>
        </x-ui.data-table.head>

        <x-ui.data-table.body>
            @forelse ($permissionRows as $index => $row)
                @php
                    /*
                     *--------------------------------------------------------------------------
                     * Row state
                     *--------------------------------------------------------------------------
                     */

                    $rowData = is_array($row) ? $row : [];

                    $permission = data_get($rowData, "permission", "Unknown permission");
                    $area = data_get($rowData, "area", data_get($rowData, "moduleKey", "Unassigned"));
                    $result = data_get($rowData, "result", "No result provided");

                    $permissionKey = data_get($rowData, "key");
                    $moduleKey = data_get($rowData, "moduleKey");
                    $groupKey = data_get($rowData, "groupKey");
                    $descriptionText = data_get($rowData, "description");
                    $action = data_get($rowData, "action");

                    $isElevated = (bool) data_get($rowData, "isElevated", false);
                    $isDestructive = (bool) data_get($rowData, "isDestructive", false);
                    $isStale = (bool) data_get($rowData, "isStale", false);

                    $isExpanded = filter_var(
                        data_get($rowData, "expanded", data_get($rowData, "isExpanded", $defaultExpanded)),
                        FILTER_VALIDATE_BOOLEAN
                    );

                    $rowKey = Str::slug((string) ($permissionKey ?: $permission ?: "permission"));
                    $detailId = "role-permission-change-{$rowKey}-{$index}-details";
                    $expandLabel = "Toggle details for {$permission}";

                    $changeIndicator = $changeIndicatorFor(data_get($rowData, "change"));

                    $accessLabel = $accessLabelFor($rowData);
                    $accessIndicator = $accessIndicatorFor($accessLabel);

                    $sourceText = collect([
                        filled($moduleKey) ? "Module: {$moduleKey}" : null,
                        filled($groupKey) ? "Group: {$groupKey}" : null,
                        filled($action) ? "Action: {$action}" : null,
                    ])->filter()->join(" · ");

                    $flagText = collect([
                        $isElevated ? "Elevated" : null,
                        $isDestructive ? "Destructive" : null,
                        $isStale ? "Stale" : null,
                    ])->filter()->join(" · ");

                    $detailItems = [
                        [
                            "label" => "Result",
                            "value" => $result,
                            "span" => "1",
                        ],
                        [
                            "label" => "Permission key",
                            "value" => $permissionKey ?: "—",
                            "span" => "1",
                        ],
                        [
                            "label" => "Source",
                            "value" => $sourceText ?: "—",
                            "span" => "2",
                        ],
                        [
                            "label" => "Description",
                            "value" => $descriptionText ?: "—",
                            "span" => "3",
                        ],
                        [
                            "label" => "Flags",
                            "value" => $flagText ?: "None",
                            "span" => "1",
                        ],
                    ];
                @endphp

                <x-ui.data-table.expand-row
                    :aria-controls="$detailId"
                    :aria-label="$expandLabel"
                    :expanded="$isExpanded"
                    expand-icon-description="Expand permission details"
                >
                    <x-ui.data-table.cell>
                        <x-patterns.status-indicator
                            :variant="$changeIndicator['variant']"
                            :kind="$changeIndicator['kind']"
                            :direction="$changeIndicator['direction']"
                            :label="$changeIndicator['label']"
                            :hide-label="false"
                        />
                    </x-ui.data-table.cell>

                    <x-ui.data-table.cell>
                        <strong>{{ $permission }}</strong>
                    </x-ui.data-table.cell>

                    <x-ui.data-table.cell>
                        {{
                            $area ?:
                                "Unassigned"
                        }}
                    </x-ui.data-table.cell>

                    <x-ui.data-table.cell>
                        @if (is_array($accessIndicator))
                            <x-patterns.status-indicator
                                :variant="$accessIndicator['variant']"
                                :kind="$accessIndicator['kind']"
                                :direction="$accessIndicator['direction']"
                                :label="$accessIndicator['label']"
                                :text-size="$accessIndicator['textSize']"
                                :hide-label="false"
                            />
                        @else
                            {{ $accessLabel }}
                        @endif
                    </x-ui.data-table.cell>
                </x-ui.data-table.expand-row>

                <x-ui.data-table.expanded-row
                    :id="$detailId"
                    :colspan="5"
                    :expanded="$isExpanded"
                >
                    <div
                        class="grid grid-cols-1 gap-x-6 gap-y-3 py-3 text-sm md:grid-cols-4"
                        data-roles-review-permission-change-detail
                    >
                        @foreach ($detailItems as $item)
                            <div
                                @class ([
                                    "min-w-0",
                                    "md:col-span-2" => data_get($item, "span") === "2",
                                    "md:col-span-3" => data_get($item, "span") === "3",
                                    "md:col-span-4" => data_get($item, "span") === "4"
                                ])
                            >
                                <dt
                                    class="text-xs font-semibold ui-platform-text-muted"
                                >
                                    {{
                                        data_get(
                                            $item,
                                            "label",
                                        )
                                    }}
                                </dt>

                                <dd
                                    class="mt-1 break-words ui-platform-text-strong"
                                >
                                    {{
                                        data_get(
                                            $item,
                                            "value",
                                        )
                                    }}
                                </dd>
                            </div>
                        @endforeach
                    </div>
                </x-ui.data-table.expanded-row>
            @empty
                <x-ui.data-table.row>
                    <x-ui.data-table.cell :colspan="5">
                        {{ $emptyTitle }}
                    </x-ui.data-table.cell>
                </x-ui.data-table.row>
            @endforelse
        </x-ui.data-table.body>
    </x-ui.data-table.table>
</x-ui.data-table.container>
