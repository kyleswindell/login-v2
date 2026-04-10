<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlatformAuditLog extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'occurred_at',
        'event_type',
        'action',
        'actor_user_id',
        'actor_type',
        'actor_id',
        'subject_type',
        'subject_id',
        'result',
        'severity',
        'request_id',
        'trace_id',
        'ip_address',
        'user_agent',
        'route',
        'method',
        'metadata',
        'is_system_event',
        'is_security_event',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'is_system_event' => 'boolean',
            'is_security_event' => 'boolean',
            'occurred_at' => 'datetime',
        ];
    }

    public function actorUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_user_id');
    }
}
