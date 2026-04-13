<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\CentralErrorLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ErrorLogController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-platform-error-logs');

        $handledFilter = $request->query('handled');
        $handledFilter = in_array($handledFilter, ['0', '1'], true) ? $handledFilter : '';

        $filters = [
            'severity' => trim($request->string('severity')->toString()),
            'handled' => $handledFilter,
            'environment' => trim($request->string('environment')->toString()),
            'exception_class' => trim($request->string('exception_class')->toString()),
            'date_from' => trim($request->string('date_from')->toString()),
            'date_to' => trim($request->string('date_to')->toString()),
        ];
        $perPage = (int) $request->integer('per_page', 25);
        $perPage = in_array($perPage, [10, 25, 50, 100], true) ? $perPage : 25;

        $logs = CentralErrorLog::query()
            ->when($filters['severity'] !== '', fn ($q) => $q->where('severity', $filters['severity']))
            ->when($filters['handled'] !== '', fn ($q) => $q->where('handled', $filters['handled'] === '1'))
            ->when($filters['environment'] !== '', fn ($q) => $q->where('environment', $filters['environment']))
            ->when($filters['exception_class'] !== '', fn ($q) => $q->where('exception_class', $filters['exception_class']))
            ->when($filters['date_from'] !== '', fn ($q) => $q->whereDate('occurred_at', '>=', $filters['date_from']))
            ->when($filters['date_to'] !== '', fn ($q) => $q->whereDate('occurred_at', '<=', $filters['date_to']))
            ->latest('occurred_at')
            ->paginate($perPage)
            ->withQueryString();

        $environments = CentralErrorLog::query()
            ->select('environment')
            ->whereNotNull('environment')
            ->distinct()
            ->orderBy('environment')
            ->limit(50)
            ->pluck('environment')
            ->all();

        $exceptionClasses = CentralErrorLog::query()
            ->select('exception_class')
            ->whereNotNull('exception_class')
            ->distinct()
            ->orderBy('exception_class')
            ->limit(100)
            ->pluck('exception_class')
            ->all();

        return view('platform.error-logs.index', [
            'logs' => $logs,
            'filters' => $filters,
            'perPage' => $perPage,
            'environments' => $environments,
            'exceptionClasses' => $exceptionClasses,
        ]);
    }

    public function show(Request $request, CentralErrorLog $log): View|JsonResponse
    {
        $this->authorize('view-platform-error-logs');

        if ($request->expectsJson()) {
            $viewerTimezone = $request->user()?->timezone ?: config('app.timezone');
            $rawContext = $log->getRawOriginal('context');
            $contextPayload = $rawContext;

            if (is_string($rawContext)) {
                $decodedContext = json_decode($rawContext, true);
                $contextPayload = $decodedContext === null && $rawContext !== 'null'
                    ? $rawContext
                    : $decodedContext;
            }

            $payload = [
                'occurred_at' => $log->occurredAtForTimezone($viewerTimezone)?->format('M j, Y g:i A T'),
                'severity' => $log->severity,
                'handled' => $log->handled,
                'environment' => $log->environment,
                'message' => $log->message,
                'exception_class' => $log->exception_class,
                'error_code' => $log->error_code,
                'file_path' => $log->file_path,
                'line_number' => $log->line_number,
                'route' => $log->route,
                'method' => $log->method,
                'status_code' => $log->status_code,
                'request_id' => $log->request_id,
                'trace_id' => $log->trace_id,
                'user_id' => $log->user_id,
                'ip_address' => $log->ip_address,
                'hostname' => $log->hostname,
                'stack_trace' => $log->stack_trace,
                'context' => $contextPayload,
            ];

            return response()
                ->json($payload)
                ->setEncodingOptions(JSON_PARTIAL_OUTPUT_ON_ERROR | JSON_INVALID_UTF8_SUBSTITUTE);
        }

        return view('platform.error-logs.show', [
            'log' => $log,
        ]);
    }
}
