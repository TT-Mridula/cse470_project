<?php

namespace App\Http\Controllers;

use App\Models\SkillCategory;

class PublicSkillController extends Controller
{
    public function index() {
        // eager load skills grouped by category
        $categories = SkillCategory::with(['skills' => function($q){
            $q->orderBy('sort_order')->orderBy('name');
        }])->orderBy('sort_order')->orderBy('name')->get();

        return view('Pages.skills_public.index', compact('categories'));
    }
}
