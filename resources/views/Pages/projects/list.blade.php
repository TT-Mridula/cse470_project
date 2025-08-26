@extends('layouts.admin')

@section('content')
<h1 class="mb-3">Projects</h1>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form class="mb-3" method="get">
  <div class="input-group">
    <input type="text" name="q" class="form-control" placeholder="Search title or category" value="{{ $q }}">
    <button class="btn btn-primary">Search</button>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-success ms-2">Create</a>
  </div>
</form>

<table class="table table-striped align-middle">
  <thead>
    <tr>
      <th style="width:60px">#</th>
      <th style="width:90px">Image</th>
      <th>Title</th>
      <th style="width:160px">Category</th>
      <th style="width:100px">Published</th>
      <th style="width:180px">Action</th>
    </tr>
  </thead>
  <tbody>
    @forelse($projects as $p)
      <tr>
        <td>{{ $p->id }}</td>
        <td>
          @if($p->image_path)
            <img src="{{ asset('storage/'.$p->image_path) }}" alt="" style="height:48px;object-fit:cover">
          @endif
        </td>
        <td class="fw-semibold">{{ $p->title }}</td>
        <td>{{ $p->category }}</td>
        <td>{{ $p->is_published ? 'Yes' : 'No' }}</td>
        <td>
          <a class="btn btn-sm btn-primary" href="{{ route('admin.projects.edit',$p) }}">Edit</a>
          <form class="d-inline" method="post" action="{{ route('admin.projects.destroy',$p) }}"
                onsubmit="return confirm('Delete this project?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="6" class="text-center text-muted">No projects yet</td></tr>
    @endforelse
  </tbody>
</table>

<div class="mt-3">
  {{ $projects->links() }}
</div>
@endsection