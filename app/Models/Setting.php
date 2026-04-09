<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'scope_type',
        'scope_id',
        'module_key',
        'group_key',
        'key',
        'value_jsonb',
        'data_type',
        'is_encrypted',
        'is_public',
        'updated_by',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_encrypted' => 'boolean',
            'is_public' => 'boolean',
        ];
    }

    public function updatedBy(): BelongsTo
    {
        // Preserve who last changed a setting centrally so configuration changes stay
        // auditable even before a richer settings history model exists.
        return $this->belongsTo(User::class, 'updated_by');
    }
}
