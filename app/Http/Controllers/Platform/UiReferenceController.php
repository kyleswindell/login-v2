<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UiReferenceController extends Controller
{
    /**
     * @var array<string, array<string, mixed>>
     */
    private const AUDIT_SAMPLES = [
        'user-update' => [
            'id' => 'user-update',
            'occurred_at_label' => 'Apr 14, 2026 09:41 AM EDT',
            'event_type' => 'platform.user.updated',
            'action' => 'updated',
            'actor_label' => 'Kyle Swindell',
            'result' => 'success',
            'severity' => 'notice',
            'route' => 'platform.users.update',
            'request_id' => 'req-2f3fcd0d84d34ad8a4f5b1cb7e9010e6',
        ],
        'settings-change' => [
            'id' => 'settings-change',
            'occurred_at_label' => 'Apr 14, 2026 09:18 AM EDT',
            'event_type' => 'settings.notifications.updated',
            'action' => 'updated',
            'actor_label' => 'System',
            'result' => 'success',
            'severity' => 'info',
            'route' => 'platform.settings.notifications.update',
            'request_id' => 'req-b68dbf0cf9244f88bae2d34de745fa86',
        ],
    ];

    /**
     * @var array<string, array<string, mixed>>
     */
    private const ERROR_SAMPLES = [
        'queue-timeout' => [
            'id' => 'queue-timeout',
            'occurred_at_label' => 'Apr 14, 2026 08:57 AM EDT',
            'message' => 'Queue worker timed out while processing notifications dispatch.',
            'exception_class' => 'RuntimeException',
            'severity' => 'error',
            'handled_label' => 'Handled',
            'environment' => 'staging',
            'route' => 'queue:work',
            'request_id' => 'req-b2b7a5c2a2f949ea985dbb7182c9a1f9',
        ],
        'api-rate-limit' => [
            'id' => 'api-rate-limit',
            'occurred_at_label' => 'Apr 14, 2026 08:42 AM EDT',
            'message' => 'Provider API returned rate-limit response for webhook replay.',
            'exception_class' => 'HttpException',
            'severity' => 'warning',
            'handled_label' => 'Uncaught',
            'environment' => 'production',
            'route' => 'platform.notifications.replay',
            'request_id' => 'req-9f0d346ef53a406d9f2b0ef5f65f92b7',
        ],
    ];

    public function index(Request $request): View
    {
        $this->authorizeSuperAdmin($request);

        return $this->renderSection('overview');
    }

    public function actions(Request $request): View
    {
        $this->authorizeSuperAdmin($request);

        return $this->renderSection('components.actions');
    }

    public function status(Request $request): View
    {
        $this->authorizeSuperAdmin($request);

        return $this->renderSection('components.status');
    }

    public function forms(Request $request): View
    {
        $this->authorizeSuperAdmin($request);

        return $this->renderSection('components.forms');
    }

    public function tables(Request $request): View
    {
        $this->authorizeSuperAdmin($request);

        return $this->renderSection('patterns.tables', $this->tablePagePayload($request));
    }

    public function formsPatterns(Request $request): View
    {
        $this->authorizeSuperAdmin($request);

        return $this->renderSection('patterns.forms');
    }

    public function dataContent(Request $request): View
    {
        $this->authorizeSuperAdmin($request);

        return $this->renderSection('patterns.data-content');
    }

    public function overlays(Request $request): View
    {
        $this->authorizeSuperAdmin($request);

        return $this->renderSection('patterns.overlays');
    }

    public function navigation(Request $request): View
    {
        $this->authorizeSuperAdmin($request);

        return $this->renderSection('patterns.navigation');
    }

    public function layout(Request $request): View
    {
        $this->authorizeSuperAdmin($request);

        return $this->renderSection('patterns.layout');
    }

    public function archetypes(Request $request): View
    {
        $this->authorizeSuperAdmin($request);

        return $this->renderSection('patterns.archetypes');
    }

    public function showAuditSample(Request $request, string $sample): JsonResponse
    {
        $this->authorizeSuperAdmin($request);

        abort_unless(array_key_exists($sample, self::AUDIT_SAMPLES), 404);

        $row = self::AUDIT_SAMPLES[$sample];

        return response()->json([
            'occurred_at' => $row['occurred_at_label'],
            'event_type' => $row['event_type'],
            'action' => $row['action'],
            'actor_name' => $row['actor_label'] === 'System' ? null : $row['actor_label'],
            'actor_email' => $row['actor_label'] === 'System' ? null : 'kyle@parasolutions.com',
            'actor_label' => $row['actor_label'],
            'result' => $row['result'],
            'severity' => $row['severity'],
            'route' => $row['route'],
            'method' => 'POST',
            'request_id' => $row['request_id'],
            'trace_id' => 'trace-demo-7ac57b95a1664d95a8d8f98f79827eca',
            'ip_address' => '127.0.0.1',
            'subject_type' => 'App\\Models\\User',
            'subject_id' => 42,
            'metadata' => [
                'changes' => [
                    'timezone' => 'America/New_York',
                    'theme_preference' => 'system',
                ],
                'source' => 'ui-reference-workspace',
            ],
        ]);
    }

    public function showErrorSample(Request $request, string $sample): JsonResponse
    {
        $this->authorizeSuperAdmin($request);

        abort_unless(array_key_exists($sample, self::ERROR_SAMPLES), 404);

        $row = self::ERROR_SAMPLES[$sample];

        return response()->json([
            'occurred_at' => $row['occurred_at_label'],
            'message' => $row['message'],
            'exception_class' => $row['exception_class'],
            'severity' => $row['severity'],
            'handled' => $row['handled_label'] === 'Handled',
            'environment' => $row['environment'],
            'error_code' => 'ERR-DEMO-1024',
            'file_path' => '/var/www/platform/current/app/Services/Notifications/SendDigestAction.php',
            'line_number' => 284,
            'route' => $row['route'],
            'method' => 'POST',
            'status_code' => 429,
            'user_id' => 1,
            'request_id' => $row['request_id'],
            'trace_id' => 'trace-demo-20e8e05e36f0422bbd4b2a2eb14dc184',
            'ip_address' => '127.0.0.1',
            'hostname' => 'platform-staging-app-01',
            'stack_trace' => [
                'App\\Services\\Notifications\\SendDigestAction::execute()',
                'App\\Jobs\\DispatchDigestNotifications::handle()',
                'Illuminate\\Queue\\CallQueuedHandler::call()',
            ],
            'context' => [
                'module_key' => 'notifications',
                'retry_after_seconds' => 30,
                'source' => 'ui-reference-workspace',
            ],
        ]);
    }

    private function authorizeSuperAdmin(Request $request): void
    {
        abort_unless($request->user()?->hasRole('platform_super_admin') === true, 403);
    }

    /**
     * @param array<string, mixed> $data
     */
    private function renderSection(string $section, array $data = []): View
    {
        return view('platform.ui-reference.'.$section, [
            'currentSection' => $section,
            ...$data,
        ]);
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
     * @return array<string, mixed>
     */
    private function tablePagePayload(Request $request): array
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
        $base = array_values(self::AUDIT_SAMPLES);
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
        $base = array_values(self::ERROR_SAMPLES);
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
