@extends('layouts.admin')
@section('title','Messages')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Messages</h1>

  <form class="row g-2 mb-3" method="get">
    <div class="col-md-4">
      <input type="text" name="q" class="form-control" placeholder="Search name, email, subject, text"
             value="{{ $q }}">
    </div>
    <div class="col-md-3">
      <select name="only" class="form-select">
        <option value="">All</option>
        <option value="unread" @selected($only==='unread')>Unread</option>
        <option value="read" @selected($only==='read')>Read</option>
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary w-100">Filter</button>
    </div>
  </form>

  <div class="card">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>When</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Preview</th>
            <th>Status</th>
            <th style="width:140px;">Action</th>
          </tr>
        </thead>
        <tbody>
        @forelse($messages as $m)
          <tr>
            <td>{{ $m->created_at->format('Y-m-d H:i') }}</td>
            <td>{{ $m->name }}</td>
            <td>{{ $m->email }}</td>
            <td>{{ $m->subject }}</td>
            <td>{{ Str::limit($m->message, 60) }}</td>
            <td>
              @if($m->is_read)
                <span class="badge bg-secondary">Read</span>
              @else
                <span class="badge bg-success">New</span>
              @endif
            </td>
            <td class="d-flex gap-2">
              <a href="{{ route('admin.messages.show',$m) }}" class="btn btn-sm btn-outline-primary">Open</a>
              <form method="post" action="{{ route('admin.messages.destroy',$m) }}"
                    onsubmit="return confirm('Delete this message?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center text-muted p-4">No messages yet.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      {{ $messages->links() }}
    </div>
  </div>
</div>
@endsection
