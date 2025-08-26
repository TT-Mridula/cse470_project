@extends('layouts.app')

@section('content')
  <div class="container">
    <h1 class="mb-3">User Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name ?? auth()->user()->email }}!</p>
    <p>This is the user interface.</p>
  </div>
@endsection