<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreCredentialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('credential.create');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'system_name' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:500'],
            'username' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'password' => ['required', 'string'],
            'ip_address' => ['nullable', 'string', 'max:100'],
            'port' => ['nullable', 'string', 'max:10'],
            'command' => ['nullable', 'string'],
            'owner_type' => ['required', 'string', 'in:personal,client'],
            'owner_name' => ['nullable', 'string', 'max:255'],
            'cred_type' => ['required', 'string', 'in:web_panel,ssh,ftp,sftp,database,email,social_media,payment_gateway,cloud_console,vpn,other'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}
