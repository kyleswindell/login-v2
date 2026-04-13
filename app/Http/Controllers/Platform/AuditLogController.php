<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\PlatformAuditLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-platform-audit-logs');

        $filters = [
            'event_type' => trim($request->string('event_type')->toString()),
            'result' => trim($request->string('result')->toString()),
            'severity' => trim($request->string('severity')->toString()),
            'actor' => trim($request->string('actor')->toString()),
        ];
        $perPage = (int) $request->integer('per_page', 25);
        $perPage = in_array($perPage, [10, 25, 50, 100], true) ? $perPage : 25;

        $logs = PlatformAuditLog::query()
            ->with('actorUser')
            ->when($filters['event_type'] !== '', fn ($query) => $query->where('event_type', 'like', '%'.$filters['event_type'].'%'))
            ->when($filters['result'] !== '', fn ($query) => $query->where('result', $filters['result']))
            ->when($filters['severity'] !== '', fn ($query) => $query->where('severity', $filters['severity']))
            ->when($filters['actor'] !== '', function ($query) use ($filters) {
                $query->whereHas('actorUser', function ($actorQuery) use ($filters): void {
                    $actorQuery
                        ->where('name', 'like', '%'.$filters['actor'].'%')
                        ->orWhere('email', 'like', '%'.$filters['actor'].'%');
                });
            })
            ->latest('occurred_at')
            ->paginate($perPage)
            ->withQueryString();

        return view('platform.audit-logs.index', [
            'logs' => $logs,
            'filters' => $filters,
            'perPage' => $perPage,
        ]);
    }
}
