<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use UsesUuid;

    protected $fillable = [
        'name',
        'vat',
        'email_billing',
        'phone',
        'address',
        'reseller_account_id',
        'status',
        'observations',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function resellerAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'reseller_account_id');
    }

    public function resellerAccounts(): HasMany
    {
        return $this->hasMany(Account::class, 'reseller_account_id');
    }

    public function hostingServices(): HasMany
    {
        return $this->hasMany(HostingService::class);
    }

    public function domainServices(): HasMany
    {
        return $this->hasMany(DomainService::class);
    }
}
