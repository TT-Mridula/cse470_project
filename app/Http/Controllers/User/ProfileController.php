<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile;
        $projects = $user->projects()->latest()->get();
        $skills = $user->skills()->orderBy('level','desc')->get();
        $resume = $user->resume;
        return view('user.profile.show', compact('user','profile','projects','skills','resume'));
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile;
        return view('user.profile.edit', compact('user','profile'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'headline' => ['nullable','string','max:255'],
            'summary'  => ['nullable','string'],   // note: summary not bio
            'location' => ['nullable','string','max:255'],
            'website'  => ['nullable','url'],
            'github'   => ['nullable','url'],
            'linkedin' => ['nullable','url'],
        ]);

        $profile = $request->user()->profile ?? new UserProfile(['user_id' => $request->user()->id]);
        $profile->fill($data)->user()->associate($request->user());
        $profile->save();

        return redirect()->route('me.profile.show')->with('status','Profile updated');
    }
}
