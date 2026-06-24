<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoAuditLog extends Model
{
    protected $fillable = [
        'url',
        'ip_address',
        'country',
        'city',
        'region',
        'isp',
        'user_agent',
        'referer',
    ];
}
