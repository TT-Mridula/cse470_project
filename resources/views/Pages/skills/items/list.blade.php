@extends('layouts.admin')

@section('content')
<h1 class="mb-3">Skills</h1>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<form class="mb-3" method="get">
  <div class="input-group">
    <input type="text" name="q" class="form-control" placeholder="Search by name" value="{{ $q }}">
    <button class="btn btn-primary">Search</button>
    <a href="{{ route('admin.skills.create') }}" class="btn btn-success ms-2">Create</a>
  </div>
</form>

<table class="table table-striped align-middle">
  <thead><tr>
    <th style="width:70px">Order</th>
    <th>Name</th>
    <th style="width:140px">Category</th>
    <th style="width:100px">Level</th>
    <th style="width:160px">Icon</th>
    <th style="width:120px">Featured</th>
    <th style="width:170px">Action</th>
  </tr></thead>
  <tbody>
  @forelse($skills as $s)
    <tr>
      <td>{{ $s->sort_order }}</td>
      <td class="fw-semibold">{{ $s->name }}</td>
      <td>{{ $s->category?->name }}</td>
      <td>{{ $s->level }}%</td>
      <td><code>{{ $s->icon_class }}</code></td>
      <td>{{ $s->is_featured ? 'Yes' : 'No' }}</td>
      <td>
        <a class="btn btn-sm btn-primary" href="{{ route('admin.skills.edit',$s) }}">Edit</a>
        <form class="d-inline" method="post" action="{{ route('admin.skills.destroy',$s) }}" onsubmit="return confirm('Delete this skill?')">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Delete</button>
        </form>
      </td>
    </tr>
  @empty
    <tr><td colspan="7" class="text-center text-muted">No skills</td></tr>
  @endforelse
  </tbody>
</table>

{{ $skills->links() }}
@endsection
