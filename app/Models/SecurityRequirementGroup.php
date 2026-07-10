<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SecurityRequirementGroup extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'slug',
        'title',
        'summary',
        'asvs_family',
        'risk_level',
        'sort_order',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    /**
     * @return HasMany<SecurityRequirement, $this>
     */
    public function requirements(): HasMany
    {
        return $this->hasMany(SecurityRequirement::class, 'group_id');
    }
}
