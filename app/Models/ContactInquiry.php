<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactInquiry extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'service', 'budget', 'website_url',
        'message', 'status', 'admin_notes', 'read_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ContactReply::class);
    }

    public function isNew(): bool
    {
        return $this->status === 'new';
    }

    public function isReplied(): bool
    {
        return $this->status === 'replied';
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('status', 'new');
    }
}
