<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Investment extends Model
{
    protected $fillable = [
        'person_name', 'amount', 'currency',
        'idea_details', 'start_date', 'expected_end_date', 'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'expected_end_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public static array $statuses = [
        'active' => 'Active',
        'completed' => 'Completed',
        'paused' => 'Paused',
        'cancelled' => 'Cancelled',
    ];

    public static array $currencies = ['PKR', 'USD', 'SAR', 'AED', 'GBP'];

    public function expenses(): HasMany
    {
        return $this->hasMany(InvestmentExpense::class);
    }

    public function getTotalSpentAttribute(): float
    {
        return (float) $this->expenses()->sum('amount');
    }

    public function getRemainingAttribute(): float
    {
        return (float) ($this->amount ?? 0) - $this->total_spent;
    }
}
