<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreBudgetExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('budget.create');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'reason' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:personal,project,assets,grocery,utilities,office,marketing,other'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency' => ['required', 'string', 'in:PKR,USD,SAR,AED,GBP'],
            'date' => ['required', 'date'],
            'note' => ['nullable', 'string', 'max:500'],
        ];
    }
}
