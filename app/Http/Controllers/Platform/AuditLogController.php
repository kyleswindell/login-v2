<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\PlatformAuditLog;
use App\Models\User;
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
            'actor_id' => trim($request->string('actor_id')->toString()),
        ];
        $perPage = (int) $request->integer('per_page', 25);
        $perPage = in_array($perPage, [10, 25, 50, 100], true) ? $perPage : 25;

        $logsQuery = PlatformAuditLog::query()
            ->with('actorUser')
            ->when($filters['event_type'] !== '', fn ($query) => $query->where('event_type', $filters['event_type']))
            ->when($filters['result'] !== '', fn ($query) => $query->where('result', $filters['result']))
            ->when($filters['severity'] !== '', fn ($query) => $query->where('severity', $filters['severity']))
            ->when($filters['actor_id'] !== '', function ($query) use ($filters) {
                if ($filters['actor_id'] === 'system') {
                    $query->whereNull('actor_user_id');

                    return;
                }

                $query->where('actor_user_id', $filters['actor_id']);
            })
            ->latest('occurred_at');

        $logs = $logsQuery
            ->paginate($perPage)
            ->withQueryString();

        $eventTypes = PlatformAuditLog::query()
            ->select('event_type')
            ->whereNotNull('event_type')
            ->distinct()
            ->orderBy('event_type')
            ->limit(200)
            ->pluck('event_type')
            ->all();

        $actorIds = PlatformAuditLog::query()
            ->select('actor_user_id')
            ->whereNotNull('actor_user_id')
            ->distinct()
            ->pluck('actor_user_id')
            ->all();

        $actorUsers = User::query()
            ->whereIn('id', $actorIds)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('platform.audit-logs.index', [
            'logs' => $logs,
            'filters' => $filters,
            'perPage' => $perPage,
            'eventTypes' => $eventTypes,
            'actorUsers' => $actorUsers,
        ]);
    }
}
