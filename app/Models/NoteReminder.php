<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NoteReminder extends Model
{
    protected $fillable = [
        'note_id', 'user_id', 'remind_at', 'channels', 'custom_message', 'status',
    ];

    protected function casts(): array
    {
        return [
            'remind_at' => 'datetime',
            'channels' => 'array',
        ];
    }

    public function note(): BelongsTo
    {
        return $this->belongsTo(PersonalNote::class, 'note_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
