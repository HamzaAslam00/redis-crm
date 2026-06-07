<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreHostingClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('hosting.create');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'client_name' => ['required', 'string', 'max:255'],
            'domain_name' => ['required', 'string', 'max:255'],
            'starting_date' => ['required', 'date'],
            'renew_duration' => ['required', 'string', 'in:monthly,quarterly,semi_annually,yearly,two_years'],
            'amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'in:PKR,USD,SAR,AED,GBP'],
            'server_usage' => ['required', 'string', 'in:hosting_only,hosting_and_domain,domain_only,vps,dedicated'],
            'hosting_provider' => ['nullable', 'string', 'max:255'],
            'server_ip' => ['nullable', 'string', 'max:45'],
            'auto_renew' => ['boolean'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}
