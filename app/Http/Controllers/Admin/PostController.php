<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct() { $this->middleware(['auth','admin']); }

    public function index(Request $request) {
        $q = $request->get('q');
        $posts = Post::with('category')
            ->when($q, fn($qq)=>$qq->where('title','like',"%{$q}%"))
            ->latest('published_at')->latest('id')
            ->paginate(12)->withQueryString();
        return view('admin.blog.index', compact('posts','q'));
    }

    public function create() {
        $cats = PostCategory::orderBy('name')->pluck('name','id');
        return view('admin.blog.create', compact('cats'));
    }

    public function store(StorePostRequest $request) {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('blog','public');
        }
        $post = Post::create($data);
        return redirect()->route('admin.blog.index')->with('success','Post created');
    }

    public function edit(Post $post) {
        $cats = PostCategory::orderBy('name')->pluck('name','id');
        return view('admin.blog.edit', compact('post','cats'));
    }

    public function update(UpdatePostRequest $request, Post $post) {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($post->image_path) Storage::disk('public')->delete($post->image_path);
            $data['image_path'] = $request->file('image')->store('blog','public');
        }
        $post->update($data);
        return redirect()->route('admin.blog.index')->with('success','Post updated');
    }

    public function destroy(Post $post) {
        if ($post->image_path) Storage::disk('public')->delete($post->image_path);
        $post->delete();
        return back()->with('success','Post deleted');
    }
}
