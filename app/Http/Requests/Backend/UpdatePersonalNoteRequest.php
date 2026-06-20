<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonalNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // user isolation enforced in controller via abort_unless
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'is_pinned' => ['boolean'],
            'color' => ['nullable', 'string', 'max:7'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
        ];
    }
}
