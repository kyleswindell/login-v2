<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Models/Notification.php
| Purpose: Represents app-instance notification records.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Notifications\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class Notification extends Model
{
    protected $table = 'notifications';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'notifiable_type',
        'notifiable_id',
        'module_key',
        'type_key',
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

    public function scopeVisibleTo(Builder $query, Model $notifiable): Builder
    {
        return $query
            ->whereMorphedTo('notifiable', $notifiable)
            ->whereNull('dismissed_at');
    }
}
