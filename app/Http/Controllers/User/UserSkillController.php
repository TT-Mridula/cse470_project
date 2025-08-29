<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserSkill;
use Illuminate\Http\Request;

class UserSkillController extends Controller
{
    public function index(Request $request)
    {
        $skills = $request->user()->skills()->orderBy('level','desc')->get();
        return view('user.skills.index', compact('skills'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required','string','max:120'],
            'level' => ['nullable','integer','min:1','max:5'], // matches tinyint 1..5
        ]);
        $request->user()->skills()->create($data);
        return back()->with('status','Skill added');
    }

    public function edit(Request $request, UserSkill $skill)
    {
        abort_if($skill->user_id !== $request->user()->id, 403);
        return view('user.skills.edit', compact('skill'));
    }

    public function update(Request $request, UserSkill $skill)
    {
        abort_if($skill->user_id !== $request->user()->id, 403);
        $data = $request->validate([
            'name'  => ['required','string','max:120'],
            'level' => ['nullable','integer','min:1','max:5'],
        ]);
        $skill->update($data);
        return redirect()->route('me.skills.index')->with('status','Skill updated');
    }

    public function destroy(Request $request, UserSkill $skill)
    {
        abort_if($skill->user_id !== $request->user()->id, 403);
        $skill->delete();
        return back()->with('status','Skill removed');
    }
}

