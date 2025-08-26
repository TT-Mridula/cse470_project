<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'title','slug','category','image_path','short_description',
        'long_description','github_url','live_url','extra_links','is_published'
    ];

    protected $casts = [
        'extra_links' => 'array',
        'is_published' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($project) {
            if (empty($project->slug)) $project->slug = Str::slug($project->title);
        });
        static::updating(function ($project) {
            if (empty($project->slug)) $project->slug = Str::slug($project->title);
        });
    }

    public function techTags() {
        return $this->belongsToMany(TechTag::class);
    }
}