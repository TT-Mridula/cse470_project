<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'title','sub_title','big_image','small_image','description','client','category'
    ];

}
