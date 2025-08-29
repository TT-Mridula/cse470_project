<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Main;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Project;
use App\Models\SkillCategory;
use App\Models\Profile;

class PagesController extends Controller
{
    public function index()
{
    $main       = Main::first();
    $services   = Service::all();
    $portfolios = Portfolio::latest()->take(6)->get(); // preview on home

    // load profile (or create an empty object so blade can read properties safely)
    $profile = Profile::first() ?? new Profile([
        'name'        => '',
        'bio'         => '',
        'email'       => '',
        'phone'       => '',
        'avatar_path' => null,
        'socials'     => [],
    ]);

    // add projects + skills for the home sections
    $projects = Project::where('is_published', true)
        ->with('techTags')
        ->latest()
        ->take(6)
        ->get();

    $skillCategories = SkillCategory::with(['skills' => function ($q) {
            $q->where('is_featured', true)
              ->orderBy('sort_order')
              ->orderBy('name');
        }])
        ->orderBy('sort_order')
        ->get();

    // pass EVERYTHING to the view (now includes $profile)
    return view('pages.index', [
        'main'           => $main,
        'services'       => $services,
        'portfolios'     => $portfolios,
        'projects'       => $projects,
        'skillCategories'=> $skillCategories,
        'profile'        => $profile,
    ]);
}

    public function dashboard()   { return view('pages.dashboard'); }
    public function services()    { return view('pages.services'); }
    public function portfolio()   { $items = Portfolio::latest()->paginate(12); return view('pages.portfolio', compact('items')); }
    public function about()       { return view('pages.about'); }
    public function contact()     { return view('pages.contact'); }
}
