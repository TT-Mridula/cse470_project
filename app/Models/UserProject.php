<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProject extends Model
{
    protected $fillable = [
        'user_id', 'title', 'slug', 'url', 'description',
        'tech_stack', 'started_at', 'ended_at', 'is_current',
    ];

    protected $casts = [
        'is_current' => 'boolean',
        'started_at' => 'date',
        'ended_at'   => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
