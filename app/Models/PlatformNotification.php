<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PlatformNotification extends Model
{
    // Reuse Laravel's conventional table name so future notification integrations do not
    // have to translate between a platform-specific alias and the framework default.
    protected $table = 'notifications';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'notifiable_type',
        'notifiable_id',
        'module_key',
        'severity',
        'title',
        'body',
        'action_url',
        'read_at',
        'dismissed_at',
        'delivery_channels',
        'metadata',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'delivery_channels' => 'array',
            'metadata' => 'array',
            'read_at' => 'datetime',
            'dismissed_at' => 'datetime',
        ];
    }

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
