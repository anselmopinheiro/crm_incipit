<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use UsesUuid;

    protected $fillable = [
        'key',
        'subject',
        'body',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
