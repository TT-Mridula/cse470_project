@extends('layouts.admin')
@section('title','Blog - Edit')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Edit Post</h1>

  <form method="post" action="{{ route('admin.blog.update',$post) }}" enctype="multipart/form-data" class="card p-3">
    @csrf @method('PUT')
    <div class="row g-3">
      <div class="col-md-8">
        <label class="form-label">Title</label>
        <input name="title" class="form-control" value="{{ old('title',$post->title) }}" required>

        <label class="form-label mt-3">Slug (optional)</label>
        <input name="slug" class="form-control" value="{{ old('slug',$post->slug) }}">

        <label class="form-label mt-3">Excerpt</label>
        <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt',$post->excerpt) }}</textarea>

        <label class="form-label mt-3">Body</label>
        <textarea id="editor" name="body" class="form-control" rows="12">{{ old('body',$post->body) }}</textarea>
      </div>

      <div class="col-md-4">
        <label class="form-label">Category</label>
        <select name="post_category_id" class="form-select">
          <option value="">None</option>
          @foreach($cats as $id => $name)
            <option value="{{ $id }}" @selected($post->post_category_id==$id)>{{ $name }}</option>
          @endforeach
        </select>

        <label class="form-label mt-3">Image</label>
        <input type="file" name="image" class="form-control">
        @if($post->image_path)
          <img src="{{ asset('storage/'.$post->image_path) }}" class="img-fluid mt-2 rounded">
        @endif

        <div class="form-check form-switch mt-3">
          <input class="form-check-input" type="checkbox" name="is_published" value="1" id="pub" @checked($post->is_published)>
          <label class="form-check-label" for="pub">Published</label>
        </div>

        <button class="btn btn-primary w-100 mt-3">Save</button>
      </div>
    </div>
  </form>
</div>

@if (config('services.tiny.key'))
  <script src="https://cdn.tiny.cloud/1/{{ config('services.tiny.key') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: '#body',     // the textarea id
      height: 450,
      menubar: false,
      plugins: 'link lists code image table autoresize',
      toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | code'
    });
  </script>
@endif

@endsection
