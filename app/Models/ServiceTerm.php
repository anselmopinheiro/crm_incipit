<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Relation;

class ServiceTerm extends Model
{
    use UsesUuid;

    protected static function booted()
    {
        static::creating(function (self $term) {
            $modelClass = Relation::getMorphedModel($term->service_type) ?? $term->service_type;

            if (class_exists($modelClass)) {
                $service = $modelClass::find($term->service_id);
                if ($service && in_array($service->status, ['cancelled', 'expired'], true)) {
                    throw new \RuntimeException('Serviços cancelados ou expirados não permitem novos termos.');
                }
            }
        });
    }

    protected $fillable = [
        'service_type',
        'service_id',
        'period_start',
        'period_end',
        'purchase_price_applied',
        'sale_price_applied',
        'discount_applied',
        'status',
        'invoice_number',
        'invoice_date',
        'receipt_number',
        'receipt_date',
        'paid_at',
        'observations',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'invoice_date' => 'date',
        'receipt_date' => 'date',
        'paid_at' => 'datetime',
    ];

    public function service(): MorphTo
    {
        return $this->morphTo();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function renewalRequests()
    {
        return $this->hasMany(RenewalRequest::class);
    }

    public function serviceLabel(): string
    {
        if ($this->service_type === 'hosting' && $this->service && $this->service->plan) {
            return 'Hosting: ' . $this->service->plan->name;
        }

        if ($this->service_type === 'domain' && $this->service) {
            return 'Domínio: ' . $this->service->domain_name;
        }

        return 'Serviço';
    }
}
