<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class DomainService extends Model
{
    use UsesUuid;

    protected $fillable = [
        'account_id',
        'domain_name',
        'tld_id',
        'start_date',
        'renewal_date',
        'status',
        'cancellation_requested_at',
        'cancellation_confirmed_at',
        'observations',
    ];

    protected $casts = [
        'start_date' => 'date',
        'renewal_date' => 'date',
        'cancellation_requested_at' => 'datetime',
        'cancellation_confirmed_at' => 'datetime',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function tld(): BelongsTo
    {
        return $this->belongsTo(Tld::class);
    }

    public function serviceTerms(): MorphMany
    {
        return $this->morphMany(ServiceTerm::class, 'service');
    }
}
