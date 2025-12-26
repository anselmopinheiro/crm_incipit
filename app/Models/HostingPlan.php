<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HostingPlan extends Model
{
    use UsesUuid;

    protected $fillable = [
        'name',
        'capacity_gb',
        'email_count',
        'public_description',
        'active',
        'observations',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function prices(): HasMany
    {
        return $this->hasMany(HostingPlanPrice::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(HostingService::class);
    }
}
