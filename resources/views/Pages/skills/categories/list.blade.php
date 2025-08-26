@extends('layouts.admin')

@section('content')
<h1 class="mb-3">Skill Categories</h1>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<form class="mb-3" method="get">
  <div class="input-group">
    <input type="text" name="q" class="form-control" placeholder="Search by name" value="{{ $q }}">
    <button class="btn btn-primary">Search</button>
    <a href="{{ route('admin.skill_categories.create') }}" class="btn btn-success ms-2">Create</a>
  </div>
</form>

<table class="table table-striped align-middle">
  <thead><tr>
    <th style="width:70px">Order</th>
    <th>Name</th>
    <th style="width:220px">Slug</th>
    <th style="width:150px">Action</th>
  </tr></thead>
  <tbody>
  @forelse($cats as $c)
    <tr>
      <td>{{ $c->sort_order }}</td>
      <td>{{ $c->name }}</td>
      <td><code>{{ $c->slug }}</code></td>
      <td>
        <a class="btn btn-sm btn-primary" href="{{ route('admin.skill_categories.edit',$c) }}">Edit</a>
        <form class="d-inline" method="post" action="{{ route('admin.skill_categories.destroy',$c) }}" onsubmit="return confirm('Delete this category?')">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      </td>
    </tr>
  @empty
    <tr><td colspan="4" class="text-center text-muted">No categories</td></tr>
  @endforelse
  </tbody>
</table>

{{ $cats->links() }}
@endsection
