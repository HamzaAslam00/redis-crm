<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeoKeywordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'keyword' => ['required', 'string', 'max:200'],
            'target_url' => ['nullable', 'string', 'max:500'],
            'priority' => ['required', 'in:high,medium,low'],
            'current_position' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'monthly_volume' => ['nullable', 'integer', 'min:0'],
            'difficulty' => ['nullable', 'integer', 'min:0', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
