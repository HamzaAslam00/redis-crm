<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreBudgetIncomeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('budget.create');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'source' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency' => ['required', 'string', 'in:PKR,USD,SAR,AED,GBP'],
            'date' => ['required', 'date'],
            'note' => ['nullable', 'string', 'max:500'],
        ];
    }
}
