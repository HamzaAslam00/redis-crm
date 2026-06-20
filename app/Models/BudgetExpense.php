<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class BudgetExpense extends Model
{
    use LogsActivity;

    protected $fillable = ['reason', 'type', 'amount', 'currency', 'date', 'note', 'receipt'];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'amount' => 'decimal:2',
        ];
    }

    public static array $types = [
        'personal' => 'Personal',
        'project' => 'Project',
        'assets' => 'Assets',
        'grocery' => 'Grocery',
        'utilities' => 'Utilities',
        'office' => 'Office',
        'marketing' => 'Marketing',
        'other' => 'Other',
    ];

    public static array $typeColors = [
        'personal' => '#A78BFA',
        'project' => '#60A5FA',
        'assets' => '#FB923C',
        'grocery' => '#34D399',
        'utilities' => '#FBBF24',
        'office' => '#22D3EE',
        'marketing' => '#F472B6',
        'other' => '#94A3B8',
    ];

    public static array $currencies = ['PKR', 'USD', 'SAR', 'AED', 'GBP'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['reason', 'type', 'amount', 'currency', 'date'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('budget');
    }
}
