<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tld extends Model
{
    use UsesUuid;

    protected $fillable = [
        'tld',
        'active',
        'observations',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function prices(): HasMany
    {
        return $this->hasMany(TldPrice::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(DomainService::class);
    }
}
