<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class ApiKey extends Model
{
    use LogsActivity, SoftDeletes;

    protected $fillable = [
        'provider_name', 'key_label', 'key_value', 'key_type',
        'environment', 'expires_at', 'last_used_at', 'notes', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'date',
            'last_used_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public static array $keyTypes = [
        'api_key' => 'API Key',
        'secret_key' => 'Secret Key',
        'access_token' => 'Access Token',
        'refresh_token' => 'Refresh Token',
        'webhook_secret' => 'Webhook Secret',
        'private_key' => 'Private Key',
        'public_key' => 'Public Key',
        'other' => 'Other',
    ];

    public static array $environments = [
        'production' => 'Production',
        'staging' => 'Staging',
        'development' => 'Development',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['provider_name', 'key_label', 'key_type', 'environment', 'is_active'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('api_keys');
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }
}
