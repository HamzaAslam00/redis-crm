<?php

namespace App\Livewire\Backend;

use App\Models\NotificationSetting;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class NotificationSettingsMatrix extends Component
{
    /** @var array<string, array{in_app_enabled: bool, email_enabled: bool}> */
    public array $settings = [];

    public function mount(): void
    {
        $this->settings = NotificationSetting::all()
            ->keyBy('event_key')
            ->map(fn ($s) => [
                'in_app_enabled' => (bool) $s->in_app_enabled,
                'email_enabled' => (bool) $s->email_enabled,
            ])
            ->toArray();
    }

    public function toggle(string $eventKey, string $type): void
    {
        if (! isset($this->settings[$eventKey])) {
            return;
        }

        $this->settings[$eventKey][$type] = ! $this->settings[$eventKey][$type];

        NotificationSetting::where('event_key', $eventKey)->update([
            $type => $this->settings[$eventKey][$type],
        ]);

        $this->dispatch('toast', type: 'success', message: 'Notification setting updated.');
    }

    public function render(): View
    {
        return view('livewire.backend.notification-settings-matrix', [
            'events' => NotificationSetting::orderBy('event_key')->get(),
        ]);
    }
}
