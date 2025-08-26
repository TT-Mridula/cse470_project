<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Main;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Project;
use App\Models\SkillCategory;

class PagesController extends Controller
{
    public function index()
    {
        $main       = Main::first();
        $services   = Service::all();
        $portfolios = Portfolio::latest()->take(6)->get(); // preview on home

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

        // one return - pass everything to pages.index
        return view('pages.index', compact(
            'main',
            'services',
            'portfolios',
            'projects',
            'skillCategories'
        ));
    }

    public function dashboard()   { return view('pages.dashboard'); }
    public function services()    { return view('pages.services'); }
    public function portfolio()   { $items = Portfolio::latest()->paginate(12); return view('pages.portfolio', compact('items')); }
    public function about()       { return view('pages.about'); }
    public function contact()     { return view('pages.contact'); }
}
