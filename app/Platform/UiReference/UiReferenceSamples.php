<?php

namespace App\Platform\UiReference;

class UiReferenceSamples
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

    public function hasAuditSample(string $sample): bool
    {
        return array_key_exists($sample, self::AUDIT_SAMPLES);
    }

    public function hasErrorSample(string $sample): bool
    {
        return array_key_exists($sample, self::ERROR_SAMPLES);
    }

    /**
     * @return array<string, mixed>
     */
    public function auditSamplePayload(string $sample): array
    {
        $row = self::AUDIT_SAMPLES[$sample];

        return [
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
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function errorSamplePayload(string $sample): array
    {
        $row = self::ERROR_SAMPLES[$sample];

        return [
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
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function auditSampleSummaries(): array
    {
        return array_values(self::AUDIT_SAMPLES);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function errorSampleSummaries(): array
    {
        return array_values(self::ERROR_SAMPLES);
    }
}
