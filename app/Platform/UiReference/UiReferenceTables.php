<?php

namespace App\Platform\UiReference;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UiReferenceTables
{
    public function __construct(
        private readonly UiReferenceSamples $samples,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function tablePagePayload(Request $request): array
    {
        $workspaceFilters = [
            'status' => trim($request->string('workspace_status')->toString()),
            'owner' => trim($request->string('workspace_owner')->toString()),
            'search' => trim($request->string('workspace_search')->toString()),
        ];
        $workspaceSort = $this->normalizeSort(
            trim($request->string('workspace_sort')->toString()),
            ['name', 'owner', 'policy_count', 'updated_at_timestamp'],
            'updated_at_timestamp'
        );
        $workspaceDirection = $this->normalizeDirection(
            trim($request->string('workspace_direction')->toString()),
            'desc'
        );
        $workspacePerPage = $this->normalizePerPage($request->integer('workspace_per_page', 25));
        $workspaceRows = collect($this->workspaceRows())
            ->when($workspaceFilters['status'] !== '', fn (Collection $rows): Collection => $rows->where('status', $workspaceFilters['status']))
            ->when($workspaceFilters['owner'] !== '', fn (Collection $rows): Collection => $rows->where('owner', $workspaceFilters['owner']))
            ->when($workspaceFilters['search'] !== '', function (Collection $rows) use ($workspaceFilters): Collection {
                $needle = mb_strtolower($workspaceFilters['search']);

                return $rows->filter(function (array $row) use ($needle): bool {
                    return str_contains(mb_strtolower($row['name']), $needle)
                        || str_contains(mb_strtolower($row['owner']), $needle);
                });
            });
        $workspaceRows = $this->sortRows($workspaceRows, $workspaceSort, $workspaceDirection, [
            'name' => fn (array $row): string => mb_strtolower((string) $row['name']),
            'owner' => fn (array $row): string => mb_strtolower((string) $row['owner']),
            'policy_count' => fn (array $row): int => (int) $row['policy_count'],
            'updated_at_timestamp' => fn (array $row): int => (int) $row['updated_at_timestamp'],
        ]);
        $workspacePaginator = $this->paginateCollection(
            $workspaceRows,
            $workspacePerPage,
            max(1, (int) $request->integer('workspace_page', 1)),
            'workspace_page',
            $request
        );

        $auditFilters = [
            'severity' => trim($request->string('audit_severity')->toString()),
            'result' => trim($request->string('audit_result')->toString()),
            'search' => trim($request->string('audit_search')->toString()),
        ];
        $auditSort = $this->normalizeSort(
            trim($request->string('audit_sort')->toString()),
            ['occurred_at_timestamp', 'event_type', 'actor_label', 'route'],
            'occurred_at_timestamp'
        );
        $auditDirection = $this->normalizeDirection(
            trim($request->string('audit_direction')->toString()),
            'desc'
        );
        $auditPerPage = $this->normalizePerPage($request->integer('audit_per_page', 10));
        $auditRows = collect($this->auditRows())
            ->when($auditFilters['severity'] !== '', fn (Collection $rows): Collection => $rows->where('severity', $auditFilters['severity']))
            ->when($auditFilters['result'] !== '', fn (Collection $rows): Collection => $rows->where('result', $auditFilters['result']))
            ->when($auditFilters['search'] !== '', function (Collection $rows) use ($auditFilters): Collection {
                $needle = mb_strtolower($auditFilters['search']);

                return $rows->filter(function (array $row) use ($needle): bool {
                    return str_contains(mb_strtolower($row['event_type']), $needle)
                        || str_contains(mb_strtolower($row['actor_label']), $needle)
                        || str_contains(mb_strtolower($row['route']), $needle);
                });
            });
        $auditRows = $this->sortRows($auditRows, $auditSort, $auditDirection, [
            'occurred_at_timestamp' => fn (array $row): int => (int) $row['occurred_at_timestamp'],
            'event_type' => fn (array $row): string => mb_strtolower((string) $row['event_type']),
            'actor_label' => fn (array $row): string => mb_strtolower((string) $row['actor_label']),
            'route' => fn (array $row): string => mb_strtolower((string) $row['route']),
        ]);
        $auditPaginator = $this->paginateCollection(
            $auditRows,
            $auditPerPage,
            max(1, (int) $request->integer('audit_page', 1)),
            'audit_page',
            $request
        );

        $errorFilters = [
            'severity' => trim($request->string('error_severity')->toString()),
            'environment' => trim($request->string('error_environment')->toString()),
            'search' => trim($request->string('error_search')->toString()),
        ];
        $errorSort = $this->normalizeSort(
            trim($request->string('error_sort')->toString()),
            ['occurred_at_timestamp', 'message', 'exception_class', 'request_id'],
            'occurred_at_timestamp'
        );
        $errorDirection = $this->normalizeDirection(
            trim($request->string('error_direction')->toString()),
            'desc'
        );
        $errorPerPage = $this->normalizePerPage($request->integer('error_per_page', 10));
        $errorRows = collect($this->errorRows())
            ->when($errorFilters['severity'] !== '', fn (Collection $rows): Collection => $rows->where('severity', $errorFilters['severity']))
            ->when($errorFilters['environment'] !== '', fn (Collection $rows): Collection => $rows->where('environment', $errorFilters['environment']))
            ->when($errorFilters['search'] !== '', function (Collection $rows) use ($errorFilters): Collection {
                $needle = mb_strtolower($errorFilters['search']);

                return $rows->filter(function (array $row) use ($needle): bool {
                    return str_contains(mb_strtolower($row['message']), $needle)
                        || str_contains(mb_strtolower($row['exception_class']), $needle)
                        || str_contains(mb_strtolower($row['route']), $needle);
                });
            });
        $errorRows = $this->sortRows($errorRows, $errorSort, $errorDirection, [
            'occurred_at_timestamp' => fn (array $row): int => (int) $row['occurred_at_timestamp'],
            'message' => fn (array $row): string => mb_strtolower((string) $row['message']),
            'exception_class' => fn (array $row): string => mb_strtolower((string) $row['exception_class']),
            'request_id' => fn (array $row): string => mb_strtolower((string) $row['request_id']),
        ]);
        $errorPaginator = $this->paginateCollection(
            $errorRows,
            $errorPerPage,
            max(1, (int) $request->integer('error_page', 1)),
            'error_page',
            $request
        );

        return [
            'workspaceFilters' => $workspaceFilters,
            'workspaceSort' => $workspaceSort,
            'workspaceDirection' => $workspaceDirection,
            'workspacePerPage' => $workspacePerPage,
            'workspaceRows' => $workspacePaginator,
            'auditFilters' => $auditFilters,
            'auditSort' => $auditSort,
            'auditDirection' => $auditDirection,
            'auditPerPage' => $auditPerPage,
            'auditSamples' => $auditPaginator,
            'errorFilters' => $errorFilters,
            'errorSort' => $errorSort,
            'errorDirection' => $errorDirection,
            'errorPerPage' => $errorPerPage,
            'errorSamples' => $errorPaginator,
        ];
    }

    private function normalizePerPage(int $perPage): int
    {
        return in_array($perPage, [10, 25, 50, 100], true) ? $perPage : 25;
    }

    /**
     * @param array<int, string> $allowed
     */
    private function normalizeSort(string $sort, array $allowed, string $default): string
    {
        return in_array($sort, $allowed, true) ? $sort : $default;
    }

    private function normalizeDirection(string $direction, string $default = 'asc'): string
    {
        if ($direction === 'asc' || $direction === 'desc') {
            return $direction;
        }

        return $default;
    }

    /**
     * @param array<string, \Closure(array<string, mixed>): mixed> $resolvers
     */
    private function sortRows(Collection $rows, string $sort, string $direction, array $resolvers): Collection
    {
        $resolver = $resolvers[$sort] ?? reset($resolvers);

        if (! $resolver instanceof \Closure) {
            return $rows->values();
        }

        $sorted = $rows->sortBy(
            fn (array $row): mixed => $resolver($row),
            options: SORT_NATURAL | SORT_FLAG_CASE
        )->values();

        return $direction === 'desc' ? $sorted->reverse()->values() : $sorted;
    }

    private function paginateCollection(
        Collection $rows,
        int $perPage,
        int $page,
        string $pageName,
        Request $request
    ): LengthAwarePaginator {
        $items = $rows->values();
        $total = $items->count();
        $lastPage = max(1, (int) ceil($total / $perPage));
        $resolvedPage = min($lastPage, max(1, $page));

        return new LengthAwarePaginator(
            $items->forPage($resolvedPage, $perPage)->values(),
            $total,
            $perPage,
            $resolvedPage,
            [
                'path' => $request->url(),
                'pageName' => $pageName,
                'query' => $request->query(),
            ]
        );
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function workspaceRows(): array
    {
        $statuses = ['active', 'review', 'disabled'];
        $owners = ['Platform Team', 'Security', 'Operations', 'Docs Team'];
        $names = [
            'Notification Rules',
            'Docs Access Policy',
            'Staff Onboarding Defaults',
            'Audit Retention Policy',
            'Error Alert Escalation',
            'Tenant Provisioning Guardrails',
            'Platform Maintenance Window',
            'Security Session Controls',
        ];

        $rows = [];
        for ($i = 1; $i <= 48; $i++) {
            $rows[] = [
                'name' => $names[$i % count($names)].' '.$i,
                'owner' => $owners[$i % count($owners)],
                'policy_count' => (string) (($i * 3) % 17 + 4),
                'status' => $statuses[$i % count($statuses)],
                'updated_at_label' => now()->subDays($i)->format('M j, Y'),
                'updated_at_timestamp' => (string) now()->subDays($i)->timestamp,
            ];
        }

        return $rows;
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function auditRows(): array
    {
        $base = $this->samples->auditSampleSummaries();
        $rows = [];

        for ($i = 1; $i <= 36; $i++) {
            $sample = $base[$i % count($base)];
            $rows[] = [
                'sample_key' => $sample['id'],
                'occurred_at_label' => now()->subMinutes($i * 13)->format('M j, Y g:i A T'),
                'occurred_at_timestamp' => (string) now()->subMinutes($i * 13)->timestamp,
                'event_type' => $sample['event_type'],
                'action' => $sample['action'],
                'actor_label' => $sample['actor_label'],
                'result' => $sample['result'],
                'severity' => $sample['severity'],
                'route' => $sample['route'],
                'request_id' => sprintf('req-demo-%04d', $i),
            ];
        }

        return $rows;
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function errorRows(): array
    {
        $base = $this->samples->errorSampleSummaries();
        $rows = [];

        for ($i = 1; $i <= 36; $i++) {
            $sample = $base[$i % count($base)];
            $rows[] = [
                'sample_key' => $sample['id'],
                'occurred_at_label' => now()->subMinutes($i * 17)->format('M j, Y g:i A T'),
                'occurred_at_timestamp' => (string) now()->subMinutes($i * 17)->timestamp,
                'message' => $sample['message'],
                'exception_class' => $sample['exception_class'],
                'severity' => $sample['severity'],
                'environment' => $sample['environment'],
                'request_id' => sprintf('req-error-demo-%04d', $i),
                'route' => $sample['route'],
            ];
        }

        return $rows;
    }
}
