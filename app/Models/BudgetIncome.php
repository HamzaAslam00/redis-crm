<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class BudgetIncome extends Model
{
    use LogsActivity;

    protected $fillable = ['source', 'amount', 'currency', 'date', 'note', 'proof'];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'amount' => 'decimal:2',
        ];
    }

    public static array $currencies = ['PKR', 'USD', 'SAR', 'AED', 'GBP'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['source', 'amount', 'currency', 'date'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->useLogName('budget');
    }
}
