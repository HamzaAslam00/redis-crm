<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvestmentExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('investment.create');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'details' => ['required', 'string'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'spend_purpose' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'output' => ['nullable', 'string'],
        ];
    }
}
