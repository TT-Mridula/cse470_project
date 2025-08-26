<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PostCategory extends Model
{
    protected $fillable = ['name', 'slug'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    protected static function booted()
    {
        static::saving(function (self $cat) {
            if (!$cat->slug) {
                $cat->slug = Str::slug($cat->name);
            }
        });
    }
}
