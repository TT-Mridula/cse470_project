<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index(Request $request) {
        $q = $request->get('q');
        $skills = Skill::with('category')
            ->when($q, fn($query)=>$query->where('name','like',"%{$q}%"))
            ->orderBy('sort_order')->latest('id')->paginate(20)->withQueryString();
        return view('Pages.skills.items.list', compact('skills','q'));
    }

    public function create() {
        $categories = SkillCategory::orderBy('sort_order')->orderBy('name')->get();
        return view('Pages.skills.items.create', compact('categories'));
    }

    public function store(StoreSkillRequest $request) {
        $data = $request->validated();
        $data['is_featured'] = (bool) ($data['is_featured'] ?? false);
        Skill::create($data);
        return redirect()->route('admin.skills.index')->with('success','Skill created');
    }

    public function edit(Skill $skill) {
        $categories = SkillCategory::orderBy('sort_order')->orderBy('name')->get();
        return view('Pages.skills.items.edit', compact('skill','categories'));
    }

    public function update(UpdateSkillRequest $request, Skill $skill) {
        $data = $request->validated();
        $data['is_featured'] = (bool) ($data['is_featured'] ?? false);
        $skill->update($data);
        return redirect()->route('admin.skills.index')->with('success','Skill updated');
    }

    public function destroy(Skill $skill) {
        $skill->delete();
        return back()->with('success','Skill deleted');
    }
}
