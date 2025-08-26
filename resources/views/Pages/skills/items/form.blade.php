@csrf
<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', optional($skill)->name) }}" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Level (0 - 100)</label>
    <input type="number" name="level" class="form-control" min="0" max="100" value="{{ old('level', optional($skill)->level ?? 80) }}" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Order</label>
    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', optional($skill)->sort_order ?? 0) }}">
  </div>

  <div class="col-md-6">
    <label class="form-label">Category</label>
    <select name="skill_category_id" class="form-select" required>
      <option value="">Select...</option>
      @foreach($categories as $c)
        <option value="{{ $c->id }}" @selected(old('skill_category_id', optional($skill)->skill_category_id) == $c->id)>{{ $c->name }}</option>
      @endforeach
    </select>
  </div>

  <div class="col-md-4">
    <label class="form-label">Font Awesome icon class</label>
    <input type="text" name="icon_class" class="form-control" placeholder="eg. fa-brands fa-laravel"
           value="{{ old('icon_class', optional($skill)->icon_class) }}">
  </div>

  <div class="col-md-2 d-flex align-items-end">
    <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" name="is_featured" value="1"
             {{ old('is_featured', optional($skill)->is_featured ?? true) ? 'checked' : '' }}>
      <label class="form-check-label">Featured</label>
    </div>
  </div>

  <div class="col-12">
    <button class="btn btn-primary">Save</button>
  </div>
</div>

@if ($errors->any())
  <div class="alert alert-danger mt-3">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
@endif
