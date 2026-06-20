<?php

namespace App\Livewire\Backend;

use App\Models\EmailTemplate;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class EmailTemplatesEditor extends Component
{
    public string $selectedSlug = '';

    public string $subject = '';

    public string $body = '';

    /** @var array<int, array{key: string, desc: string}> */
    public array $currentVars = [];

    public bool $showPreview = false;

    public function mount(): void
    {
        $first = EmailTemplate::orderBy('id')->first();
        if ($first) {
            $this->applyTemplate($first);
        }
    }

    public function selectTemplate(string $slug): void
    {
        $template = EmailTemplate::findBySlug($slug);
        if (! $template) {
            return;
        }

        $this->applyTemplate($template);
        $this->dispatch('quill-load', body: $template->body);
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function save(): void
    {
        $this->validate([
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        EmailTemplate::where('slug', $this->selectedSlug)->update([
            'subject' => $this->subject,
            'body' => $this->body,
        ]);

        $this->dispatch('toast', type: 'success', message: 'Template saved.');
    }

    public function resetToDefault(): void
    {
        $template = EmailTemplate::findBySlug($this->selectedSlug);
        if (! $template) {
            return;
        }

        $template->update([
            'subject' => $template->default_subject,
            'body' => $template->default_body,
        ]);

        $this->subject = $template->default_subject ?? '';
        $this->body = $template->default_body ?? '';

        $this->dispatch('quill-load', body: $this->body);
        $this->dispatch('toast', type: 'success', message: 'Template reset to default.');
    }

    public function render(): View
    {
        return view('livewire.backend.email-templates-editor', [
            'templates' => EmailTemplate::orderBy('id')->get(),
        ]);
    }

    private function applyTemplate(EmailTemplate $template): void
    {
        $this->selectedSlug = $template->slug;
        $this->subject = $template->subject;
        $this->body = $template->body;
        $this->currentVars = $template->variables ?? [];
    }
}
