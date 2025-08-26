{{-- @extends('layouts.admin_layout')
@section("content")
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                       
                        </div>
                        
                    </div>
                </main>
@endsection --}}
@extends('layouts.admin')

@section('title','Dashboard')

@section('content')
  <h1 class="h4 mb-4">Dashboard</h1>

  <div class="row g-3">
    <div class="col-md-6">
      <div class="card p-3">
        <h6 class="mb-2">Quick Links</h6>
        <ul class="small mb-0">
          <li><a href="{{ route('admin.main') }}">Edit Main</a></li>
          <li><a href="{{ route('admin.services.list') }}">Manage Services</a></li>
          <li><a href="{{ route('admin.portfolios.list') }}">Manage Portfolios</a></li>
        </ul>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-3">
        <h6 class="mb-2">Status</h6>
        <p class="small mb-0">You are logged in as <strong>{{ auth()->user()->email }}</strong>.</p>
      </div>
    </div>
  </div>
@endsection

