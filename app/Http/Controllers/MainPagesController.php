<?php

namespace App\Http\Controllers;

use App\Models\Main;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MainPagesController extends Controller
{
    public function index()
    {
        // Ensure a row exists so the form always has something to edit
        $main = Main::firstOrCreate([], [
            'title'     => 'SkillStacker',
            'sub_title' => 'Learn. Grow. Achieve.',
            'bc_img'    => null,
            'resume'    => null,
        ]);

        // Adjust the view path to match your folder: 'pages.main' or 'Pages.main'
        return view('pages.main', compact('main'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'title'     => ['required','string','max:150'],
            'sub_title' => ['required','string','max:255'],
            'bc_img'    => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'resume'    => ['nullable','mimes:pdf','max:8192'], // up to ~8MB
        ]);

        $main = Main::firstOrFail();

        // Background image
        if ($request->hasFile('bc_img')) {
            if ($main->bc_img && Storage::disk('public')->exists($main->bc_img)) {
                Storage::disk('public')->delete($main->bc_img);
            }
            // Store in storage/app/public/img/...  => keep only "img/xxx.jpg" in DB
            $data['bc_img'] = $request->file('bc_img')->store('img', 'public');
        }

        // Resume (PDF)
        if ($request->hasFile('resume')) {
            if ($main->resume && Storage::disk('public')->exists($main->resume)) {
                Storage::disk('public')->delete($main->resume);
            }
            // Store in storage/app/public/docs/... => keep only "docs/xxx.pdf" in DB
            $data['resume'] = $request->file('resume')->store('docs', 'public');
        }

        $main->update($data);

        return back()->with('success', 'Main Page data has been updated successfully!');
    }
}

