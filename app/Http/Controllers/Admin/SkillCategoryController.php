<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkillCategoryRequest;
use App\Http\Requests\UpdateSkillCategoryRequest;
use App\Models\SkillCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SkillCategoryController extends Controller
{
    public function index(Request $request) {
        $q = $request->get('q');
        $cats = SkillCategory::when($q, fn($query)=>$query->where('name','like',"%{$q}%"))
            ->orderBy('sort_order')->orderBy('name')->paginate(20)->withQueryString();
        return view('Pages.skills.categories.list', compact('cats','q'));
    }

    public function create() {
        return view('Pages.skills.categories.create');
    }

    public function store(StoreSkillCategoryRequest $request) {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        SkillCategory::create($data);
        return redirect()->route('admin.skill_categories.index')->with('success','Category created');
    }

    public function edit(SkillCategory $skill_category) {
        return view('Pages.skills.categories.edit', ['cat'=>$skill_category]);
    }

    public function update(UpdateSkillCategoryRequest $request, SkillCategory $skill_category) {
        $data = $request->validated();
        if (empty($data['slug'])) $data['slug'] = Str::slug($data['name']);
        $skill_category->update($data);
        return redirect()->route('admin.skill_categories.index')->with('success','Category updated');
    }

    public function destroy(SkillCategory $skill_category) {
        $skill_category->delete();
        return back()->with('success','Category deleted');
    }
}
