<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function show(Request $request)
    {
        $resume = $request->user()->resume;
        return view('user.resume.show', compact('resume'));
    }

    public function edit(Request $request)
    {
        $resume = $request->user()->resume;
        return view('user.resume.edit', compact('resume'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'title'   => ['required','string','max:255'],
            'content' => ['nullable','string'],
        ]);

        $user = $request->user();
        $resume = $user->resume ?: new Resume(['user_id' => $user->id]);

        $resume->fill($data)->user()->associate($user);
        $resume->save();

        return redirect()->route('me.resume.show')->with('status', 'Resume saved');
    }
}
