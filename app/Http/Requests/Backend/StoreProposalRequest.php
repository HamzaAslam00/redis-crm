<?php

namespace App\Http\Requests\Backend;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProposalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'client_name' => ['required', 'string', 'max:200'],
            'client_email' => ['nullable', 'email', 'max:200'],
            'client_phone' => ['nullable', 'string', 'max:50'],
            'client_company' => ['nullable', 'string', 'max:200'],
            'platform' => ['nullable', 'string', 'max:50'],
            'fiverr_username' => ['nullable', 'string', 'max:100'],
            'project_title' => ['required', 'string', 'max:255'],
            'project_description' => ['nullable', 'string'],
            'currency' => ['required', 'string', 'max:10'],
            'discount_type' => ['required', 'in:fixed,percent'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'timeline' => ['nullable', 'string', 'max:100'],
            'revision_rounds' => ['nullable', 'integer', 'min:0'],
            'valid_until' => ['nullable', 'date'],
            'terms_conditions' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'sections_enabled' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.title' => ['required', 'string', 'max:255'],
            'items.*.description' => ['nullable', 'string'],
            'items.*.unit_price' => ['nullable', 'numeric', 'min:0'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
