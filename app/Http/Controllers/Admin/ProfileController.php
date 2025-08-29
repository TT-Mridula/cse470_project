<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // GET /admin/profile
    public function edit(Request $request)
    {
        $profile = $request->user(); // pass $profile to your Blade
        return view('admin.profile.edit', compact('profile'));
    }

    // PUT /admin/profile
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'   => ['required','string','max:255'],
            'bio'    => ['nullable','string'],
            'email'  => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'phone'  => ['nullable','string','max:30'],
            'avatar' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        // handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $data['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->fill($data)->save();

        return back()->with('success', 'Profile updated');
    }
}
