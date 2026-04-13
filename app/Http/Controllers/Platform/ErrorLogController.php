<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\CentralErrorLog;
use Illuminate\Contracts\View\View;
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

    public function show(CentralErrorLog $log): View
    {
        $this->authorize('view-platform-error-logs');

        return view('platform.error-logs.show', [
            'log' => $log,
        ]);
    }
}
