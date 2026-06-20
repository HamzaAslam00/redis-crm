<?php

namespace App\Console\Commands;

use App\Mail\NoteReminderMail;
use App\Models\NoteReminder;
use App\Models\SystemNotification;
use App\Services\WhatsAppService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

#[Signature('notes:send-reminders')]
#[Description('Send due note reminders via system notification, email, and/or WhatsApp')]
class SendNoteReminders extends Command
{
    public function handle(WhatsAppService $whatsApp): int
    {
        $due = NoteReminder::with(['note', 'user'])
            ->where('status', 'pending')
            ->where('remind_at', '<=', now())
            ->get();

        if ($due->isEmpty()) {
            $this->info('No due reminders.');

            return self::SUCCESS;
        }

        $this->info("Processing {$due->count()} reminder(s)…");

        foreach ($due as $reminder) {
            $failed = false;

            try {
                $channels = $reminder->channels ?? [];
                $note = $reminder->note;
                $user = $reminder->user;
                $noteTitle = $note?->title ?: 'Personal Note';

                // System notification
                if (in_array('system', $channels) && $user) {
                    SystemNotification::create([
                        'user_id' => $user->id,
                        'type' => 'info',
                        'title' => '🔔 Note Reminder: '.$noteTitle,
                        'message' => $reminder->custom_message ?: 'You have a pending note reminder.',
                        'url' => route('admin.notes.edit', $reminder->note_id),
                    ]);
                }

                // Email
                if (in_array('email', $channels) && $user?->email) {
                    Mail::to($user->email)->send(new NoteReminderMail($reminder));
                }

                // WhatsApp via Callmebot
                if (in_array('whatsapp', $channels) && $user?->phone && $user?->callmebot_key) {
                    $text = "🔔 *Note Reminder* — Redis Solution CRM\n\n";
                    $text .= "*{$noteTitle}*\n";
                    if ($reminder->custom_message) {
                        $text .= "\n{$reminder->custom_message}\n";
                    }
                    $text .= "\nTime: ".$reminder->remind_at->format('d M Y, h:i A');

                    $sent = $whatsApp->send($user->phone, $user->callmebot_key, $text);

                    if (! $sent) {
                        $failed = true;
                    }
                }

                $reminder->update(['status' => $failed ? 'failed' : 'sent']);
                $this->line("  ✓ Reminder #{$reminder->id} → ".implode(', ', $channels));
            } catch (\Throwable $e) {
                $reminder->update(['status' => 'failed']);
                Log::error("Note reminder #{$reminder->id} failed", ['error' => $e->getMessage()]);
                $this->error("  ✗ Reminder #{$reminder->id} failed: ".$e->getMessage());
            }
        }

        $this->info('Done.');

        return self::SUCCESS;
    }
}
