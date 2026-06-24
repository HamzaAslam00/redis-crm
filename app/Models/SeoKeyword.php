<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $keyword
 * @property string|null $target_url
 * @property string $priority
 * @property int|null $current_position
 * @property int|null $monthly_volume
 * @property int|null $difficulty
 * @property string|null $notes
 * @property Carbon|null $last_checked_at
 */
class SeoKeyword extends Model
{
    protected $fillable = [
        'keyword', 'target_url', 'priority',
        'current_position', 'monthly_volume', 'difficulty',
        'notes', 'last_checked_at',
    ];

    protected $casts = [
        'last_checked_at' => 'datetime',
    ];

    public function priorityColor(): string
    {
        return match ($this->priority) {
            'high' => '#ef4444',
            'medium' => '#f59e0b',
            default => '#6b7280',
        };
    }

    public function positionLabel(): string
    {
        if (! $this->current_position) {
            return 'Not tracked';
        }

        return '#'.$this->current_position;
    }

    public function difficultyLabel(): string
    {
        if ($this->difficulty === null) {
            return '—';
        }

        return match (true) {
            $this->difficulty <= 30 => 'Easy',
            $this->difficulty <= 60 => 'Medium',
            default => 'Hard',
        };
    }

    public function difficultyColor(): string
    {
        if ($this->difficulty === null) {
            return 'var(--crm-text-muted)';
        }

        return match (true) {
            $this->difficulty <= 30 => '#22c55e',
            $this->difficulty <= 60 => '#f59e0b',
            default => '#ef4444',
        };
    }
}
