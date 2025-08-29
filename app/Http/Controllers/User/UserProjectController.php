<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserProject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = $request->user()->projects()->latest()->paginate(10);
        return view('user.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('user.projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required','string','max:255'],
            'url'         => ['nullable','url'],
            'description' => ['nullable','string'],
            'tech_stack'  => ['nullable','string','max:255'],
            'started_at'  => ['nullable','date'],
            'ended_at'    => ['nullable','date'],
            'is_current'  => ['nullable','boolean'],
        ]);

        $data['slug'] = Str::slug($data['title']).'-'.Str::random(4);
        $data['is_current'] = (bool) ($data['is_current'] ?? false);

        $request->user()->projects()->create($data);

        return redirect()->route('me.projects.index')->with('status','Project created');
    }

    public function edit(Request $request, UserProject $project)
    {
        abort_if($project->user_id !== $request->user()->id, 403);
        return view('user.projects.edit', compact('project'));
    }

    public function update(Request $request, UserProject $project)
    {
        abort_if($project->user_id !== $request->user()->id, 403);

        $data = $request->validate([
            'title'       => ['required','string','max:255'],
            'url'         => ['nullable','url'],
            'description' => ['nullable','string'],
            'tech_stack'  => ['nullable','string','max:255'],
            'started_at'  => ['nullable','date'],
            'ended_at'    => ['nullable','date'],
            'is_current'  => ['nullable','boolean'],
        ]);

        if ($project->title !== $data['title']) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['title']).'-'.\Illuminate\Support\Str::random(4);
        }
        $data['is_current'] = (bool) ($data['is_current'] ?? false);

        $project->update($data);

        return redirect()->route('me.projects.index')->with('status','Project updated');
    }

    public function destroy(Request $request, UserProject $project)
    {
        abort_if($project->user_id !== $request->user()->id, 403);
        $project->delete();
        return back()->with('status','Project deleted');
    }
}
