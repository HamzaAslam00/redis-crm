<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'project_code', 'client_name', 'title', 'description',
        'requirements_note', 'requirements_doc', 'cost', 'currency',
        'deadline', 'developer_name', 'status', 'live_url', 'testing_url',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
            'cost' => 'decimal:2',
        ];
    }

    public static array $statuses = [
        'pending' => 'Pending',
        'in_progress' => 'In Progress',
        'in_review' => 'In Review',
        'testing' => 'Testing',
        'completed' => 'Completed',
        'on_hold' => 'On Hold',
        'cancelled' => 'Cancelled',
    ];

    public static array $currencies = ['PKR', 'USD', 'SAR', 'AED', 'GBP'];

    public function documents(): HasMany
    {
        return $this->hasMany(ProjectDocument::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ProjectMessage::class)->orderBy('created_at');
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->deadline !== null
            && $this->deadline->isPast()
            && ! in_array($this->status, ['completed', 'cancelled']);
    }

    public static function generateCode(): string
    {
        $year = now()->year;
        $last = static::whereYear('created_at', $year)->orderByDesc('id')->first();
        $seq = $last ? ((int) substr($last->project_code, -3)) + 1 : 1;

        return 'RS-'.$year.'-'.str_pad($seq, 3, '0', STR_PAD_LEFT);
    }
}
