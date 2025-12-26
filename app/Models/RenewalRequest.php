<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RenewalRequest extends Model
{
    use UsesUuid;

    protected $fillable = [
        'service_term_id',
        'recipient_type',
        'recipient_account_id',
        'token',
        'status',
        'first_sent_at',
        'last_sent_at',
        'next_send_at',
        'resend_count',
        'response',
        'response_notes',
        'responded_at',
        'observations',
    ];

    protected $casts = [
        'first_sent_at' => 'datetime',
        'last_sent_at' => 'datetime',
        'next_send_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    public function serviceTerm(): BelongsTo
    {
        return $this->belongsTo(ServiceTerm::class);
    }

    public function recipientAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'recipient_account_id');
    }
}
