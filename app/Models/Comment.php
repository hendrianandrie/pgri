<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id',
        'sakti_content_id',
        'name',
        'email',
        'comment',
        'is_approved',
        'ip_address',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }

    public function saktiContent(): BelongsTo
    {
        return $this->belongsTo(SaktiContent::class);
    }

    public function getTargetTitleAttribute(): string
    {
        if ($this->news) {
            return $this->news->title;
        }
        if ($this->saktiContent) {
            return $this->saktiContent->title;
        }

        return 'Konten telah dihapus';
    }

    public function getTargetUrlAttribute(): ?string
    {
        if ($this->news) {
            return route('news.show', $this->news->slug);
        }
        if ($this->saktiContent) {
            return route('sakti.show', $this->saktiContent->slug);
        }

        return null;
    }

    public function getSourceTypeLabelAttribute(): string
    {
        if ($this->news_id) {
            return 'Berita';
        }
        if ($this->sakti_content_id) {
            $cat = $this->saktiContent?->category;

            return match ($cat) {
                'pembelajaran_mendalam' => 'SAKTI: Pembelajaran Mendalam',
                'pid' => 'SAKTI: PID',
                'koding_kka' => 'SAKTI: Koding & AI',
                'rumah_pendidikan' => 'SAKTI: Rumah Pendidikan',
                default => 'SAKTI Modul',
            };
        }

        return 'Lainnya';
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }
}
