@extends('layouts.admin')
@section('title','Message')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Message</h1>

  <div class="mb-3">
    <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>

    @if($message->is_read)
      <form class="d-inline" method="post" action="{{ route('admin.messages.unread',$message) }}">
        @csrf
        <button class="btn btn-sm btn-outline-warning">Mark unread</button>
      </form>
    @else
      <form class="d-inline" method="post" action="{{ route('admin.messages.read',$message) }}">
        @csrf
        <button class="btn btn-sm btn-outline-success">Mark read</button>
      </form>
    @endif

    <form class="d-inline" method="post" action="{{ route('admin.messages.destroy',$message) }}"
          onsubmit="return confirm('Delete this message?')">
      @csrf @method('DELETE')
      <button class="btn btn-sm btn-outline-danger">Delete</button>
    </form>
  </div>

  <div class="card">
    <div class="card-body">
      <dl class="row">
        <dt class="col-sm-3">From</dt>
        <dd class="col-sm-9">{{ $message->name }} &lt;{{ $message->email }}&gt;</dd>

        @if($message->phone)
          <dt class="col-sm-3">Phone</dt>
          <dd class="col-sm-9">{{ $message->phone }}</dd>
        @endif

        @if($message->subject)
          <dt class="col-sm-3">Subject</dt>
          <dd class="col-sm-9">{{ $message->subject }}</dd>
        @endif

        <dt class="col-sm-3">Received</dt>
        <dd class="col-sm-9">{{ $message->created_at->format('Y-m-d H:i') }}</dd>

        <dt class="col-sm-3">IP / Agent</dt>
        <dd class="col-sm-9">{{ $message->meta_ip }} / {{ $message->meta_ua }}</dd>

        <dt class="col-sm-3">Message</dt>
        <dd class="col-sm-9"><pre class="mb-0" style="white-space:pre-wrap">{{ $message->message }}</pre></dd>
      </dl>
    </div>
  </div>
</div>
@endsection
