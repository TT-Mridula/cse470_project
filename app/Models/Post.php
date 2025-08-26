<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'post_category_id', 'title', 'slug', 'excerpt', 'body',
        'image_path', 'is_published', 'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    protected static function booted()
    {
        static::saving(function (self $post) {
            if (!$post->slug) {
                $post->slug = Str::slug($post->title);
            }

            // ensure slug is unique
            $base = $post->slug;
            $i = 2;
            while (
                static::where('slug', $post->slug)
                    ->where('id', '!=', $post->id)
                    ->exists()
            ) {
                $post->slug = $base . '-' . $i++;
            }

            if ($post->is_published && !$post->published_at) {
                $post->published_at = now();
            }
        });
    }
}

