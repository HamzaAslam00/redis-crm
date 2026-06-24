<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeoBacklinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'source_url' => ['required', 'url', 'max:1000'],
            'target_url' => ['required', 'string', 'max:500'],
            'anchor_text' => ['nullable', 'string', 'max:300'],
            'link_type' => ['required', 'in:dofollow,nofollow,sponsored,ugc'],
            'domain_authority' => ['nullable', 'integer', 'min:0', 'max:100'],
            'status' => ['required', 'in:active,broken,pending,lost'],
            'discovered_at' => ['required', 'date'],
            'last_checked_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
