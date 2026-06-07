<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetIncome extends Model
{
    protected $fillable = ['source', 'amount', 'currency', 'date', 'note', 'proof'];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'amount' => 'decimal:2',
        ];
    }

    public static array $currencies = ['PKR', 'USD', 'SAR', 'AED', 'GBP'];
}
