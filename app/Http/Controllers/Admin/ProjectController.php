<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Project;
use App\Models\TechTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProjectRequest;
class ProjectController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $q = $request->get('q');
        $projects = Project::when($q, function($query) use ($q) {
                $query->where('title','like',"%{$q}%")
                      ->orWhere('category','like',"%{$q}%");
            })
            ->latest()->paginate(12)->withQueryString();

        // Pages/projects/list.blade.php
        return view('Pages.projects.list', compact('projects','q'));
    }

    public function create() {
        $tags = TechTag::orderBy('name')->pluck('name')->toArray();
        // Pages/projects/create.blade.php
        return view('Pages.projects.create', compact('tags'));
    }

    public function store(StoreProjectRequest $request) {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('projects','public');
        }

        $data['extra_links'] = $data['extra_links'] ?? [];
        $project = Project::create($data);

        $tagIds = collect($request->input('tech', []))
            ->map(fn($name) => TechTag::firstOrCreate(['name' => trim($name)])->id)
            ->all();
        $project->techTags()->sync($tagIds);

        return redirect()->route('admin.projects.index')->with('success','Project created');
    }

    public function edit(Project $project) {
        $tags = TechTag::orderBy('name')->pluck('name')->toArray();
        $selected = $project->techTags()->pluck('name')->toArray();
        // Pages/projects/edit.blade.php
        return view('Pages.projects.edit', compact('project','tags','selected'));
    }

    public function update(UpdateProjectRequest $request, Project $project) {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($project->image_path) {
                Storage::disk('public')->delete($project->image_path);
            }
            $data['image_path'] = $request->file('image')->store('projects','public');
        }

        $data['extra_links'] = $data['extra_links'] ?? [];
        $project->update($data);

        $tagIds = collect($request->input('tech', []))
            ->map(fn($name) => TechTag::firstOrCreate(['name' => trim($name)])->id)
            ->all();
        $project->techTags()->sync($tagIds);

        return redirect()->route('admin.projects.index')->with('success','Project updated');
    }

    public function destroy(Project $project) {
        if ($project->image_path) {
            Storage::disk('public')->delete($project->image_path);
        }
        $project->delete();
        return back()->with('success','Project deleted');
    }
}
