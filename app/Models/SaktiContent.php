<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaktiContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'title',
        'slug',
        'summary',
        'content',
        'author',
        'school_origin',
        'image',
        'file_url',
        'badge',
        'views',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getFileUrlAttribute($value)
    {
        if ($value && !preg_match("~^(?:f|ht)tps?://~i", $value)) {
            return "https://" . $value;
        }
        return $value;
    }

    public function setFileUrlAttribute($value)
    {
        if ($value && !preg_match("~^(?:f|ht)tps?://~i", $value)) {
            $value = "https://" . $value;
        }
        $this->attributes['file_url'] = $value;
    }

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
