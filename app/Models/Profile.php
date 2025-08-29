<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'email',
        'phone',
        'avatar_path',
        'socials',
    ];

    protected $casts = [
        'socials' => 'array',
    ];

    // Convenient URL for the avatar with a fallback
    public function getAvatarUrlAttribute(): string
    {
        if (!empty($this->avatar_path) && Storage::disk('public')->exists($this->avatar_path)) {
            // Use Storage::url() to avoid static analysis warnings
            return Storage::url($this->avatar_path);
        }

        return asset('images/avatar-placeholder.png');
    }
}

