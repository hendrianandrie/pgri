<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'sakti_category',
        'badge',
        'title',
        'summary',
        'content',
        'author_name',
        'author_email',
        'author_phone',
        'school_origin',
        'image',
        'file_url',
        'event_date',
        'status',
        'admin_notes',
        'published_news_id',
        'published_sakti_id',
        'ip_address',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function publishedNews(): BelongsTo
    {
        return $this->belongsTo(News::class, 'published_news_id');
    }

    public function publishedSakti(): BelongsTo
    {
        return $this->belongsTo(SaktiContent::class, 'published_sakti_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'news' => 'Berita & Kegiatan',
            'sakti' => 'Modul SAKTI',
            default => ucfirst($this->type),
        };
    }

    public function getCategoryLabelAttribute(): string
    {
        if ($this->type === 'news') {
            return 'Reportase Kegiatan';
        }

        return match ($this->sakti_category) {
            'pembelajaran_mendalam' => 'Pembelajaran Mendalam',
            'rumah_pendidikan' => 'Rumah Pendidikan',
            'pid' => 'Papan Interaktif Digital (PID)',
            'koding_kka' => 'Koding & AI (KKA)',
            default => 'Modul SAKTI',
        };
    }

    public function getWhatsAppUrlAttribute(): ?string
    {
        if (! $this->author_phone) {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', $this->author_phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62'.substr($phone, 1);
        }

        $msg = rawurlencode("Halo Bapak/Ibu {$this->author_name}, kami dari Tim Redaksi PGRI terkait kiriman konten Anda: \"{$this->title}\".");

        return "https://api.whatsapp.com/send?phone={$phone}&text={$msg}";
    }
}
