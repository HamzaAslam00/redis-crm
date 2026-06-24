<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $source_url
 * @property string $source_domain
 * @property string $target_url
 * @property string|null $anchor_text
 * @property string $link_type
 * @property int|null $domain_authority
 * @property string $status
 * @property Carbon $discovered_at
 * @property Carbon|null $last_checked_at
 * @property string|null $notes
 */
class SeoBacklink extends Model
{
    protected $fillable = [
        'source_url', 'source_domain', 'target_url', 'anchor_text',
        'link_type', 'domain_authority', 'status',
        'discovered_at', 'last_checked_at', 'notes',
    ];

    protected $casts = [
        'discovered_at' => 'date',
        'last_checked_at' => 'date',
    ];

    public function statusColor(): string
    {
        return match ($this->status) {
            'active' => '#22c55e',
            'broken' => '#ef4444',
            'lost' => '#6b7280',
            default => '#f59e0b',
        };
    }

    public function statusLabel(): string
    {
        return ucfirst($this->status);
    }

    public function linkTypeColor(): string
    {
        return match ($this->link_type) {
            'dofollow' => '#22c55e',
            'nofollow' => '#6b7280',
            'sponsored' => '#f59e0b',
            default => '#a855f7',
        };
    }

    public static function extractDomain(string $url): string
    {
        $host = parse_url($url, PHP_URL_HOST) ?? $url;

        return preg_replace('/^www\./', '', $host);
    }
}
