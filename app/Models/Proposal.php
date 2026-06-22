<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposal extends Model
{
    use SoftDeletes;

    /** @var list<string> */
    protected $fillable = [
        'proposal_number', 'client_name', 'client_email', 'client_phone', 'client_company',
        'platform', 'fiverr_username', 'project_title', 'project_description',
        'currency', 'subtotal', 'discount_type', 'discount_amount', 'total_amount',
        'timeline', 'revision_rounds', 'valid_until', 'status', 'sections_enabled',
        'terms_conditions', 'notes', 'rejection_reason', 'sent_at', 'viewed_at', 'created_by',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'valid_until' => 'date',
        'sent_at' => 'datetime',
        'viewed_at' => 'datetime',
        'sections_enabled' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Proposal $proposal): void {
            if (! $proposal->proposal_number) {
                $last = Proposal::withTrashed()
                    ->whereYear('created_at', now()->year)
                    ->orderByDesc('id')
                    ->first();

                $next = $last
                    ? ((int) substr($last->proposal_number, -3)) + 1
                    : 1;

                $proposal->proposal_number = 'RS-PROP-'.now()->year.'-'.str_pad((string) $next, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProposalItem::class)->orderBy('sort_order');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /** @return array<string, bool> */
    public function defaultSections(): array
    {
        return [
            'description' => true,
            'scope' => true,
            'details' => true,
            'pricing' => true,
            'terms' => true,
            'why_us' => true,
            'contact' => true,
        ];
    }

    public function isSectionEnabled(string $key): bool
    {
        $sections = $this->sections_enabled ?? $this->defaultSections();

        return (bool) ($sections[$key] ?? true);
    }

    public function discountValue(): float
    {
        if ($this->discount_type === 'percent') {
            return (float) $this->subtotal * ((float) $this->discount_amount / 100);
        }

        return (float) $this->discount_amount;
    }

    public function statusColor(): string
    {
        return match ($this->computedStatus()) {
            'draft' => '#6b7280',
            'sent' => '#3b82f6',
            'viewed' => '#8b5cf6',
            'accepted' => '#22c55e',
            'rejected' => '#ef4444',
            'expired' => '#f59e0b',
            default => '#6b7280',
        };
    }

    public function statusLabel(): string
    {
        return match ($this->computedStatus()) {
            'draft' => 'Draft',
            'sent' => 'Sent',
            'viewed' => 'Viewed',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
            'expired' => 'Expired',
            default => ucfirst($this->status),
        };
    }

    public function computedStatus(): string
    {
        if (
            $this->valid_until
            && $this->valid_until->isPast()
            && in_array($this->status, ['sent', 'viewed'])
        ) {
            return 'expired';
        }

        return $this->status;
    }

    /** @return array<string, string> */
    public static function platforms(): array
    {
        return [
            'direct' => 'Direct Client',
            'fiverr' => 'Fiverr',
            'upwork' => 'Upwork',
            'freelancer' => 'Freelancer',
            'linkedin' => 'LinkedIn',
            'whatsapp' => 'WhatsApp',
            'email' => 'Email',
            'other' => 'Other',
        ];
    }

    /** @return array<string, string> */
    public static function currencies(): array
    {
        return [
            'USD' => 'USD — US Dollar',
            'PKR' => 'PKR — Pakistani Rupee',
            'SAR' => 'SAR — Saudi Riyal',
            'AED' => 'AED — UAE Dirham',
            'GBP' => 'GBP — British Pound',
            'EUR' => 'EUR — Euro',
        ];
    }
}
