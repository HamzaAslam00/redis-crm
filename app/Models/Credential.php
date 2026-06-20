<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Credential extends Model
{
    use LogsActivity, SoftDeletes;

    protected $fillable = [
        'system_name', 'url', 'username', 'email', 'password',
        'ip_address', 'port', 'command', 'owner_type', 'owner_name',
        'cred_type', 'notes', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public static array $credTypes = [
        'web_panel' => 'Web Panel / cPanel',
        'ssh' => 'SSH',
        'ftp' => 'FTP',
        'sftp' => 'SFTP',
        'database' => 'Database',
        'email' => 'Email',
        'social_media' => 'Social Media',
        'payment_gateway' => 'Payment Gateway',
        'cloud_console' => 'Cloud Console',
        'vpn' => 'VPN',
        'other' => 'Other',
    ];

    public static array $ownerTypes = [
        'personal' => 'Personal',
        'client' => 'Client',
    ];

    public static array $credTypeIcons = [
        'web_panel' => 'ri-global-line',
        'ssh' => 'ri-terminal-line',
        'ftp' => 'ri-folder-transfer-line',
        'sftp' => 'ri-secure-payment-line',
        'database' => 'ri-database-2-line',
        'email' => 'ri-mail-line',
        'social_media' => 'ri-share-circle-line',
        'payment_gateway' => 'ri-bank-card-line',
        'cloud_console' => 'ri-cloud-line',
        'vpn' => 'ri-shield-keyhole-line',
        'other' => 'ri-more-line',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['system_name', 'cred_type', 'owner_type', 'owner_name', 'is_active'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('credentials');
    }
}
