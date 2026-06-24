<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $route_name
 * @property string $page_label
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $og_title
 * @property string|null $og_description
 * @property string|null $og_image
 * @property string $og_type
 * @property string $twitter_card
 * @property string|null $twitter_title
 * @property string|null $twitter_description
 * @property string|null $canonical_url
 * @property bool $noindex
 * @property bool $nofollow
 * @property string|null $schema_json
 * @property bool $is_active
 */
class SeoPage extends Model
{
    protected $fillable = [
        'route_name', 'page_label',
        'meta_title', 'meta_description', 'meta_keywords',
        'og_title', 'og_description', 'og_image', 'og_type',
        'twitter_card', 'twitter_title', 'twitter_description',
        'canonical_url', 'noindex', 'nofollow',
        'schema_json', 'is_active',
    ];

    protected $casts = [
        'noindex' => 'boolean',
        'nofollow' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function healthScore(): int
    {
        $score = 0;
        $titleLen = mb_strlen($this->meta_title ?? '');
        $descLen = mb_strlen($this->meta_description ?? '');

        if ($titleLen >= 30 && $titleLen <= 60) {
            $score += 25;
        } elseif ($titleLen > 0) {
            $score += 10;
        }

        if ($descLen >= 120 && $descLen <= 160) {
            $score += 25;
        } elseif ($descLen > 0) {
            $score += 10;
        }

        if ($this->og_image) {
            $score += 20;
        }
        if ($this->og_title || $this->og_description) {
            $score += 10;
        }
        if ($this->meta_keywords) {
            $score += 10;
        }
        if ($this->schema_json) {
            $score += 10;
        }

        return min(100, $score);
    }

    public function healthColor(): string
    {
        return match (true) {
            $this->healthScore() >= 75 => '#22c55e',
            $this->healthScore() >= 40 => '#f59e0b',
            default => '#ef4444',
        };
    }

    public function issues(): array
    {
        $issues = [];
        $titleLen = mb_strlen($this->meta_title ?? '');
        $descLen = mb_strlen($this->meta_description ?? '');

        if (! $this->meta_title) {
            $issues[] = 'Meta title missing';
        } elseif ($titleLen < 30) {
            $issues[] = 'Meta title too short (< 30 chars)';
        } elseif ($titleLen > 60) {
            $issues[] = 'Meta title too long (> 60 chars)';
        }

        if (! $this->meta_description) {
            $issues[] = 'Meta description missing';
        } elseif ($descLen < 120) {
            $issues[] = 'Meta description too short (< 120 chars)';
        } elseif ($descLen > 160) {
            $issues[] = 'Meta description too long (> 160 chars)';
        }

        if (! $this->og_image) {
            $issues[] = 'OG image missing (affects social share previews)';
        }
        if (! $this->og_title && ! $this->og_description) {
            $issues[] = 'Open Graph tags not configured';
        }
        if ($this->noindex) {
            $issues[] = 'NOINDEX set — Google will not index this page';
        }

        return $issues;
    }

    public static function findByRoute(string $routeName): ?self
    {
        return static::where('route_name', $routeName)->where('is_active', true)->first();
    }
}
