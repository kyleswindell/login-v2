<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Throwable;

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

    public function occurredAtForTimezone(?string $timezone = null): ?CarbonInterface
    {
        if (! $this->occurred_at) {
            return null;
        }

        $targetTimezone = $timezone ?: config('app.timezone', 'UTC');

        try {
            return CarbonImmutable::parse(
                $this->occurred_at->format('Y-m-d H:i:s.u'),
                'UTC',
            )->timezone($targetTimezone);
        } catch (Throwable) {
            return $this->occurred_at->timezone(config('app.timezone', 'UTC'));
        }
    }
}
