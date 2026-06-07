<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class HostingClient extends Model
{
    protected $fillable = [
        'client_name', 'domain_name', 'starting_date', 'renew_duration',
        'amount', 'currency', 'server_usage', 'hosting_provider',
        'server_ip', 'auto_renew', 'notes', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'starting_date' => 'date',
            'amount' => 'decimal:2',
            'auto_renew' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public static array $renewDurations = [
        'monthly' => 'Monthly',
        'quarterly' => 'Quarterly',
        'semi_annually' => 'Semi-Annually',
        'yearly' => 'Yearly',
        'two_years' => '2 Years',
    ];

    public static array $renewalMonths = [
        'monthly' => 1,
        'quarterly' => 3,
        'semi_annually' => 6,
        'yearly' => 12,
        'two_years' => 24,
    ];

    public static array $serverUsages = [
        'hosting_only' => 'Hosting Only',
        'hosting_and_domain' => 'Hosting + Domain',
        'domain_only' => 'Domain Only',
        'vps' => 'VPS',
        'dedicated' => 'Dedicated',
    ];

    public static array $currencies = ['PKR', 'USD', 'SAR', 'AED', 'GBP'];

    public function getNextRenewalDateAttribute(): Carbon
    {
        $months = self::$renewalMonths[$this->renew_duration] ?? 12;
        $date = $this->starting_date->copy();

        while ($date->isPast()) {
            $date->addMonths($months);
        }

        return $date;
    }

    public function getDaysUntilRenewalAttribute(): int
    {
        return (int) now()->startOfDay()->diffInDays($this->next_renewal_date, false);
    }

    public function getRenewalStatusAttribute(): string
    {
        if (! $this->is_active) {
            return 'inactive';
        }

        $days = $this->days_until_renewal;

        if ($days < 0) {
            return 'overdue';
        }

        if ($days <= 30) {
            return 'due_soon';
        }

        return 'ok';
    }
}
