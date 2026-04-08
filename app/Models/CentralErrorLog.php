<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentralErrorLog extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'tenant_key',
        'occurred_at',
        'environment',
        'service_name',
        'severity',
        'request_id',
        'trace_id',
        'span_id',
        'route',
        'method',
        'status_code',
        'message',
        'exception_class',
        'error_code',
        'file_path',
        'line_number',
        'stack_trace',
        'context',
        'fingerprint',
        'handled',
        'release_version',
        'hostname',
        'user_id',
        'ip_address',
        'user_agent',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'context' => 'array',
            'handled' => 'boolean',
            'occurred_at' => 'datetime',
        ];
    }
}
