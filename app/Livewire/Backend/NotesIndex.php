<?php

namespace App\Livewire\Backend;

use App\Models\NoteReminder;
use App\Models\PersonalNote;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class NotesIndex extends Component
{
    #[Url]
    public string $search = '';

    #[Url]
    public string $tagFilter = '';

    #[Url]
    public string $userFilter = '';

    // Reminder modal state
    public bool $showReminderModal = false;

    public ?int $reminderNoteId = null;

    public bool $reminderExists = false;

    public string $reminderDate = '';

    public string $reminderTime = '';

    public array $reminderChannels = ['system'];

    public string $reminderMessage = '';

    public function updatedSearch(): void {}

    public function updatedTagFilter(): void {}

    public function updatedUserFilter(): void {}

    public function openReminderModal(int $noteId): void
    {
        $this->reminderNoteId = $noteId;

        $existing = NoteReminder::where('note_id', $noteId)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            $this->reminderExists = true;
            $this->reminderDate = $existing->remind_at->format('Y-m-d');
            $this->reminderTime = $existing->remind_at->format('H:i');
            $this->reminderChannels = $existing->channels;
            $this->reminderMessage = $existing->custom_message ?? '';
        } else {
            $this->reminderExists = false;
            $this->reminderDate = now()->addDay()->format('Y-m-d');
            $this->reminderTime = '09:00';
            $this->reminderChannels = ['system'];
            $this->reminderMessage = '';
        }

        $this->showReminderModal = true;
    }

    public function saveReminder(): void
    {
        $this->validate([
            'reminderDate' => ['required', 'date', 'date_format:Y-m-d'],
            'reminderTime' => ['required', 'regex:/^\d{2}:\d{2}$/'],
            'reminderChannels' => ['required', 'array', 'min:1'],
        ]);

        $remindAt = Carbon::createFromFormat('Y-m-d H:i', $this->reminderDate.' '.$this->reminderTime);

        if ($remindAt->isPast()) {
            $this->addError('reminderTime', 'Please choose a future date and time.');

            return;
        }

        NoteReminder::updateOrCreate(
            ['note_id' => $this->reminderNoteId, 'user_id' => auth()->id(), 'status' => 'pending'],
            [
                'remind_at' => $remindAt,
                'channels' => $this->reminderChannels,
                'custom_message' => $this->reminderMessage ?: null,
            ]
        );

        $this->showReminderModal = false;
        $this->dispatch('toast', type: 'success', message: 'Reminder set for '.$remindAt->format('d M Y \a\t h:i A').'.');
    }

    public function removeReminder(int $noteId): void
    {
        NoteReminder::where('note_id', $noteId)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->delete();

        $this->reminderExists = false;
        $this->showReminderModal = false;
        $this->dispatch('toast', type: 'info', message: 'Reminder removed.');
    }

    public function closeReminderModal(): void
    {
        $this->showReminderModal = false;
    }

    private function isSuperAdmin(): bool
    {
        return auth()->user()->hasRole('super-admin');
    }

    public function togglePin(int $id): void
    {
        $query = PersonalNote::where('id', $id);

        if (! $this->isSuperAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $note = $query->firstOrFail();
        $note->update(['is_pinned' => ! $note->is_pinned]);

        $this->dispatch('toast', type: 'success', message: $note->is_pinned ? 'Note pinned.' : 'Note unpinned.');
    }

    #[On('delete')]
    public function delete(int $id): void
    {
        $query = PersonalNote::where('id', $id);

        if (! $this->isSuperAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $note = $query->firstOrFail();
        $note->delete();

        $this->dispatch('toast', type: 'success', message: 'Note deleted.');
    }

    private function getNotes()
    {
        $query = $this->isSuperAdmin()
            ? PersonalNote::with(['user', 'reminder'])
            : PersonalNote::with('reminder')->forCurrentUser();

        return $query
            ->when($this->isSuperAdmin() && $this->userFilter, fn ($q) => $q->where('user_id', $this->userFilter))
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                        ->orWhere('content', 'like', "%{$this->search}%");
                });
            })
            ->when($this->tagFilter, function ($q) {
                $q->whereJsonContains('tags', $this->tagFilter);
            })
            ->orderByDesc('is_pinned')
            ->orderByDesc('updated_at')
            ->get();
    }

    private function getAllTags(): array
    {
        $query = $this->isSuperAdmin()
            ? PersonalNote::query()
            : PersonalNote::forCurrentUser();

        return $query
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }

    public function render(): View
    {
        $isSuperAdmin = $this->isSuperAdmin();

        return view('livewire.backend.notes-index', [
            'notes' => $this->getNotes(),
            'allTags' => $this->getAllTags(),
            'colors' => PersonalNote::$colors,
            'isSuperAdmin' => $isSuperAdmin,
            'users' => $isSuperAdmin ? User::orderBy('name')->get(['id', 'name']) : collect(),
        ]);
    }
}
