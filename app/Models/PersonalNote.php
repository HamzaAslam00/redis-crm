<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonalNote extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'content', 'is_pinned', 'color', 'tags',
    ];

    protected function casts(): array
    {
        return [
            'is_pinned' => 'boolean',
            'tags' => 'array',
        ];
    }

    public static array $colors = [
        '#ffffff' => 'White',
        '#fef9c3' => 'Yellow',
        '#dcfce7' => 'Green',
        '#dbeafe' => 'Blue',
        '#fce7f3' => 'Pink',
        '#ede9fe' => 'Purple',
        '#ffedd5' => 'Orange',
        '#f1f5f9' => 'Slate',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reminder(): HasOne
    {
        return $this->hasOne(NoteReminder::class, 'note_id');
    }

    /** Scope: always only current user's notes. */
    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', auth()->id());
    }
}
