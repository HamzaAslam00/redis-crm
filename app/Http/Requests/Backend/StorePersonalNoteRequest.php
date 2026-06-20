<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonalNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('note.create');
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
