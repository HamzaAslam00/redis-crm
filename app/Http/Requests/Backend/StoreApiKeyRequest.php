<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreApiKeyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('apikey.create');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'provider_name' => ['required', 'string', 'max:255'],
            'key_label' => ['required', 'string', 'max:255'],
            'key_value' => ['required', 'string'],
            'key_type' => ['required', 'string', 'in:api_key,secret_key,access_token,refresh_token,webhook_secret,private_key,public_key,other'],
            'environment' => ['required', 'string', 'in:production,staging,development'],
            'expires_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}
