<?php

namespace App\Models;

use Database\Factories\PortfolioItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PortfolioItem extends Model
{
    /** @use HasFactory<PortfolioItemFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'client_name',
        'category',
        'short_desc',
        'description',
        'tech_stack',
        'featured_image',
        'gallery_images',
        'project_url',
        'results',
        'is_featured',
        'status',
        'display_order',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'gallery_images' => 'array',
        'results' => 'array',
        'is_featured' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $item): void {
            if (empty($item->slug)) {
                $item->slug = Str::slug($item->title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public static function categoryLabel(string $category): string
    {
        return match ($category) {
            'web' => 'Web Development',
            'mobile' => 'Mobile App',
            'marketing' => 'Digital Marketing',
            'erp' => 'ERP Solution',
            'ai' => 'AI Application',
            'software' => 'Software Development',
            default => ucfirst($category),
        };
    }
}
