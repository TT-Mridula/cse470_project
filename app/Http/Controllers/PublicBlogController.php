<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PublicBlogController extends Controller
{
    public function index(Request $request) {
        $filters = [
            'q'   => $request->get('q'),
            'cat' => $request->get('cat'),
        ];

        $posts = Post::with('category')
            ->where('is_published', true)
            ->when($filters['q'], fn($qq)=>$qq->where('title','like','%'.$filters['q'].'%'))
            ->when($filters['cat'], fn($qq)=>$qq->whereHas('category', fn($c)=>$c->where('slug',$filters['cat'])))
            ->latest('published_at')->latest('id')
            ->paginate(9)->withQueryString();

        $categories = PostCategory::orderBy('name')->get();

        return view('public.blog.index', compact('posts','categories','filters'));
    }

    public function show($slug) {
        $post = Post::with('category')
            ->where('slug',$slug)->where('is_published', true)->firstOrFail();

        $related = Post::where('is_published', true)
            ->where('id','!=',$post->id)
            ->latest('published_at')->take(3)->get();

        return view('public.blog.show', compact('post','related'));
    }
}
