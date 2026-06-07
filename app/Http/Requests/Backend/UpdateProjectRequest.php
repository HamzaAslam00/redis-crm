<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('project.edit');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'client_name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'requirements_note' => ['nullable', 'string'],
            'cost' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'in:PKR,USD,SAR,AED,GBP'],
            'deadline' => ['nullable', 'date'],
            'developer_name' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:pending,in_progress,in_review,testing,completed,on_hold,cancelled'],
            'live_url' => ['nullable', 'url', 'max:500'],
            'testing_url' => ['nullable', 'url', 'max:500'],
        ];
    }
}
