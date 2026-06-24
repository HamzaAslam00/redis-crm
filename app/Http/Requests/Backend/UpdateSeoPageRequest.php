<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSeoPageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:170'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'og_title' => ['nullable', 'string', 'max:100'],
            'og_description' => ['nullable', 'string', 'max:200'],
            'og_image' => ['nullable', 'string', 'max:500'],
            'og_type' => ['nullable', 'string', 'max:30'],
            'twitter_card' => ['nullable', 'string', 'max:50'],
            'twitter_title' => ['nullable', 'string', 'max:100'],
            'twitter_description' => ['nullable', 'string', 'max:200'],
            'canonical_url' => ['nullable', 'url', 'max:500'],
            'noindex' => ['boolean'],
            'nofollow' => ['boolean'],
            'schema_json' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'noindex' => $this->boolean('noindex'),
            'nofollow' => $this->boolean('nofollow'),
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
