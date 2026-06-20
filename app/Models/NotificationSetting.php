<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $primaryKey = 'event_key';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'event_key',
        'label',
        'description',
        'in_app_enabled',
        'email_enabled',
    ];

    protected $casts = [
        'in_app_enabled' => 'boolean',
        'email_enabled' => 'boolean',
    ];

    public static function isEnabled(string $eventKey, string $type = 'in_app'): bool
    {
        $setting = static::find($eventKey);

        if (! $setting) {
            return true;
        }

        return $type === 'email' ? $setting->email_enabled : $setting->in_app_enabled;
    }
}
