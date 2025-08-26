<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillCategory extends Model
{
    protected $fillable = ['name','slug','sort_order'];

    public function skills() {
        return $this->hasMany(Skill::class)->orderBy('sort_order');
    }
}
