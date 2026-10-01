<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'event_date',
        'location',
        'cover_image',
        'photos',
        'image',
        'description',
    ];

    protected $casts = [
        'event_date' => 'date',
        'photos' => 'array',
    ];

    /**
     * Get the cover photo URL with fallbacks.
     */
    public function getCoverPhotoAttribute(): string
    {
        if (!empty($this->cover_image)) {
            return $this->cover_image;
        }

        if (!empty($this->image)) {
            return $this->image;
        }

        $photos = $this->photos_list;
        if (!empty($photos)) {
            return $photos[0];
        }

        return 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=800';
    }

    /**
     * Get array of all photos (including cover if none exists).
     */
    public function getPhotosListAttribute(): array
    {
        $list = [];

        if (is_array($this->photos)) {
            $list = array_values(array_filter($this->photos));
        } elseif (is_string($this->photos) && !empty($this->photos)) {
            $decoded = json_decode($this->photos, true);
            if (is_array($decoded)) {
                $list = array_values(array_filter($decoded));
            }
        }

        // If list is empty, fallback to cover or image
        if (empty($list)) {
            if (!empty($this->cover_image)) {
                $list[] = $this->cover_image;
            } elseif (!empty($this->image)) {
                $list[] = $this->image;
            }
        }

        return $list;
    }

    /**
     * Total number of photos.
     */
    public function getPhotosCountAttribute(): int
    {
        return count($this->photos_list);
    }
}
