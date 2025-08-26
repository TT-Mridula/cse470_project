<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class PublicProjectController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'q' => $request->get('q'),
            'category' => $request->get('category'),
            'tech' => $request->get('tech'),
        ];

        $projects = Project::where('is_published', true)
            ->when($filters['q'], fn($q) => $q->where('title', 'like', '%'.$filters['q'].'%'))
            ->when($filters['category'], fn($q) => $q->where('category', $filters['category']))
            ->when($filters['tech'], fn($q) => $q->whereHas('techTags', fn($t) => $t->where('name', $filters['tech'])))
            ->latest()->paginate(9)->withQueryString();

        $categories = Project::select('category')->distinct()->pluck('category')->filter();
        $tech = \App\Models\TechTag::orderBy('name')->pluck('name');

        // resources/views/Pages/projects_public/index.blade.php
        return view('Pages.projects_public.index', compact('projects', 'categories', 'tech', 'filters'));
    }

    public function show($slug)
    {
        $project = Project::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $related = Project::where('is_published', true)
            ->where('id', '!=', $project->id)
            ->latest()->take(3)->get();

        // resources/views/Pages/projects_public/show.blade.php
        return view('Pages.projects_public.show', compact('project', 'related'));
    }
}