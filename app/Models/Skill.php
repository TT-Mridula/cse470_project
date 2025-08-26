<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'skill_category_id','name','level','icon_class','is_featured','sort_order'
    ];

    public function category() {
        return $this->belongsTo(SkillCategory::class,'skill_category_id');
    }
}
