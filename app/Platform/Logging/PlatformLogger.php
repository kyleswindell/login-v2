<?php

namespace App\Platform\Logging;

use App\Models\CentralErrorLog;
use App\Models\PlatformAuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class PlatformLogger
{
    /**
     * @param  array<string, mixed>  $metadata
     */
    public function recordEvent(
        string $event,
        array $metadata = [],
        ?int $actorUserId = null,
        ?string $subjectType = null,
        ?string $subjectId = null,
        string $result = 'success',
        string $severity = 'info',
        bool $isSecurityEvent = false,
        bool $isSystemEvent = false,
    ): void {
        try {
            $resolvedActorId = $actorUserId ?? Auth::id();

            PlatformAuditLog::query()->create([
                'occurred_at' => now(),
                'event_type' => $event,
                'action' => Str::afterLast($event, '.'),
                'actor_user_id' => $resolvedActorId,
                'actor_type' => $resolvedActorId ? 'user' : null,
                'actor_id' => $resolvedActorId ? (string) $resolvedActorId : null,
                'subject_type' => $subjectType,
                'subject_id' => $subjectId,
                'result' => $result,
                'severity' => $severity,
                'request_id' => $this->requestId(),
                'trace_id' => $this->traceId(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'route' => request()->route()?->getName(),
                'method' => request()->method(),
                'metadata' => $metadata,
                'is_system_event' => $isSystemEvent,
                'is_security_event' => $isSecurityEvent,
            ]);
        } catch (Throwable $exception) {
            Log::warning('Unable to write platform audit log.', [
                'event' => $event,
                'logging_exception' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * @param  array<string, mixed>  $context
     */
    public function recordError(
        string $message,
        array $context = [],
        string $level = 'error',
        ?Throwable $exception = null,
        ?int $statusCode = null,
        bool $handled = true,
    ): void {
        try {
            CentralErrorLog::query()->create([
                'tenant_key' => $context['tenant_key'] ?? null,
                'occurred_at' => now(),
                'environment' => app()->environment(),
                'service_name' => config('app.service_name'),
                'severity' => $level,
                'request_id' => $this->requestId(),
                'trace_id' => $this->traceId(),
                'span_id' => $context['span_id'] ?? null,
                'route' => request()->route()?->getName(),
                'method' => request()->method(),
                'status_code' => $statusCode,
                'message' => $message,
                'exception_class' => $exception ? $exception::class : null,
                'error_code' => $exception?->getCode() ? (string) $exception->getCode() : null,
                'file_path' => $exception?->getFile(),
                'line_number' => $exception?->getLine(),
                'stack_trace' => $exception?->getTraceAsString(),
                'context' => $context,
                'fingerprint' => $this->fingerprint($message, $exception),
                'handled' => $handled,
                'release_version' => config('app.version'),
                'hostname' => gethostname() ?: null,
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (Throwable $loggingException) {
            Log::error('Unable to write application error log.', [
                'message' => $message,
                'logging_exception' => $loggingException->getMessage(),
            ]);
        }
    }

    public function recordException(Throwable $exception): void
    {
        $this->recordError(
            message: $exception->getMessage(),
            context: ['exception_object_id' => spl_object_id($exception)],
            exception: $exception,
            handled: false,
        );
    }

    private function requestId(): ?string
    {
        return request()->attributes->get('request_id');
    }

    private function traceId(): ?string
    {
        return request()->attributes->get('trace_id');
    }

    private function fingerprint(string $message, ?Throwable $exception = null): string
    {
        return hash('sha256', implode('|', [
            $exception ? $exception::class : 'no-exception',
            $exception?->getFile(),
            $exception?->getLine(),
            $message,
        ]));
    }
}
