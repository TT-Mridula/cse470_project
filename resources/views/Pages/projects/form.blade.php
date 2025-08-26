@csrf
@php
  use Illuminate\Support\Arr;
  $project = $project ?? new \App\Models\Project;
  $selected = $selected ?? [];
@endphp

<div class="row g-3">
  <div class="col-md-8">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" required
           value="{{ old('title',$project->title) }}">

    <label class="form-label mt-3">Slug <small class="text-muted">(leave blank to auto generate)</small></label>
    <input type="text" name="slug" class="form-control"
           value="{{ old('slug',$project->slug) }}">

    <label class="form-label mt-3">Short description</label>
    <textarea name="short_description" rows="3" class="form-control">{{ old('short_description',$project->short_description) }}</textarea>

    <label class="form-label mt-3">Long description</label>
    <textarea name="long_description" rows="10" class="form-control">{{ old('long_description',$project->long_description) }}</textarea>
  </div>

  <div class="col-md-4">
    <label class="form-label">Category</label>
    <input type="text" name="category" class="form-control"
           value="{{ old('category',$project->category) }}" placeholder="eg. Web">

    <label class="form-label mt-3">Image</label>
    <input type="file" name="image" class="form-control">
    @if($project->image_path)
      <img class="img-fluid mt-2 rounded" style="max-height:140px"
           src="{{ asset('storage/'.$project->image_path) }}" alt="preview">
    @endif

    <label class="form-label mt-3">Tech tags</label>
    <input type="text" name="tech[]" class="form-control mb-1" placeholder="eg. Laravel"
           value="{{ old('tech.0', Arr::get($selected,0)) }}">
    <input type="text" name="tech[]" class="form-control mb-1" placeholder="eg. Bootstrap"
           value="{{ old('tech.1', Arr::get($selected,1)) }}">
    <input type="text" name="tech[]" class="form-control mb-1" placeholder="Add more as needed"
           value="{{ old('tech.2', Arr::get($selected,2)) }}">

    <label class="form-label mt-3">GitHub URL</label>
    <input type="url" name="github_url" class="form-control" value="{{ old('github_url',$project->github_url) }}">

    <label class="form-label mt-3">Live URL</label>
    <input type="url" name="live_url" class="form-control" value="{{ old('live_url',$project->live_url) }}">

    <div class="form-check form-switch mt-3">
      <input class="form-check-input" type="checkbox" name="is_published" value="1"
             {{ old('is_published', $project->is_published ?? true) ? 'checked' : '' }}>
      <label class="form-check-label">Published</label>
    </div>

    <button class="btn btn-primary w-100 mt-3">Save</button>
  </div>
</div>

@if ($errors->any())
  <div class="alert alert-danger mt-3">
    <div class="fw-semibold mb-1">Please fix the following</div>
    <ul class="mb-0">
      @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif
