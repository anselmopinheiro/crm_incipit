<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TldPrice extends Model
{
    use UsesUuid;

    protected $fillable = [
        'tld_id',
        'purchase_price',
        'sale_price',
        'valid_from',
        'valid_to',
        'created_by',
        'observations',
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_to' => 'date',
    ];

    public function tld(): BelongsTo
    {
        return $this->belongsTo(Tld::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
