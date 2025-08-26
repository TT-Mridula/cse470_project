@csrf
<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', optional($cat)->name) }}" required>
  </div>
  <div class="col-md-4">
    <label class="form-label">Slug <small class="text-muted">(auto if blank)</small></label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug', optional($cat)->slug) }}">
  </div>
  <div class="col-md-2">
    <label class="form-label">Order</label>
    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', optional($cat)->sort_order ?? 0) }}">
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
