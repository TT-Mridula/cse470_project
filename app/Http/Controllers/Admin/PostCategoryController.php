<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    public function __construct() { $this->middleware(['auth','admin']); }

    public function index(Request $request) {
        $q = $request->get('q');
        $cats = PostCategory::when($q, fn($qq)=>$qq->where('name','like',"%{$q}%"))
            ->orderBy('name')->paginate(20)->withQueryString();
        return view('admin.blog.categories', compact('cats','q'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => ['required','string','max:120'],
            'slug' => ['nullable','alpha_dash','max:140','unique:post_categories,slug'],
        ]);
        if (empty($data['slug'])) $data['slug'] = Str::slug($data['name']);
        PostCategory::create($data);
        return back()->with('success','Category created');
    }

    public function destroy(PostCategory $category) {
        $category->delete();
        return back()->with('success','Category deleted');
    }
}
