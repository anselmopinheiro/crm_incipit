<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    use UsesUuid;

    protected $fillable = [
        'internal_notify_days_before',
        'customer_notify_days_before',
        'resend_every_days',
        'max_resends',
    ];
}
