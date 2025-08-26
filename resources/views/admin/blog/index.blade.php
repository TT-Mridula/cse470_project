@extends('layouts.admin')
@section('title','Blog - List')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Posts</h1>

  <div class="d-flex justify-content-between my-3">
    <form class="d-flex" method="get">
      <input name="q" value="{{ $q }}" class="form-control me-2" placeholder="Search title...">
      <button class="btn btn-outline-secondary">Search</button>
    </form>
    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">Create</a>
  </div>

  <div class="card">
    <div class="table-responsive">
      <table class="table table-striped align-middle mb-0">
        <thead>
          <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Published</th>
            <th style="width:160px;"></th>
          </tr>
        </thead>
        <tbody>
          @forelse($posts as $p)
          <tr>
            <td>{{ $p->title }}</td>
            <td>{{ $p->category?->name }}</td>
            <td>{{ $p->is_published ? 'Yes' : 'No' }}</td>
            <td class="text-end">
              <a href="{{ route('admin.blog.edit',$p) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
              <form action="{{ route('admin.blog.destroy',$p) }}" method="post" class="d-inline"
                    onsubmit="return confirm('Delete this post?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-muted">No posts yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-3">{{ $posts->links() }}</div>
</div>
@endsection
