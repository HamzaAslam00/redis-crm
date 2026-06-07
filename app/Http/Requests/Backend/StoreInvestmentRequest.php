<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvestmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('investment.create');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'person_name' => ['required', 'string', 'max:255'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'in:PKR,USD,SAR,AED,GBP'],
            'idea_details' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'expected_end_date' => ['nullable', 'date', 'after:start_date'],
            'status' => ['required', 'string', 'in:active,completed,paused,cancelled'],
        ];
    }
}
