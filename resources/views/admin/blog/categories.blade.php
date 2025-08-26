@extends('layouts.admin')
@section('title','Blog - Categories')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Categories</h1>

  <form method="get" class="my-3 d-flex">
    <input name="q" value="{{ $q }}" class="form-control me-2" placeholder="Search name...">
    <button class="btn btn-outline-secondary">Search</button>
  </form>

  <form method="post" action="{{ route('admin.blog.categories.store') }}" class="card p-3 mb-3">
    @csrf
    <div class="row g-2">
      <div class="col-md-5"><input name="name" class="form-control" placeholder="Category name" required></div>
      <div class="col-md-5"><input name="slug" class="form-control" placeholder="slug (optional)"></div>
      <div class="col-md-2"><button class="btn btn-primary w-100">Add</button></div>
    </div>
  </form>

  <div class="card">
    <div class="table-responsive">
      <table class="table table-striped align-middle mb-0">
        <thead><tr><th>Name</th><th>Slug</th><th style="width:120px;"></th></tr></thead>
        <tbody>
          @forelse($cats as $c)
          <tr>
            <td>{{ $c->name }}</td>
            <td>{{ $c->slug }}</td>
            <td class="text-end">
              <form action="{{ route('admin.blog.categories.destroy',$c) }}" method="post"
                    onsubmit="return confirm('Delete this category?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="3" class="text-muted">No categories yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-3">{{ $cats->links() }}</div>
</div>
@endsection
