@extends('layouts.admin')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Portfolio</h1>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Portfolio</li>
        </ol>

        <div class="row">
            @foreach (range(1,6) as $i)
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card h-100">
                    <img class="card-img-top" src="https://picsum.photos/seed/{{ $i }}/600/300" alt="Project {{ $i }}">
                    <div class="card-body">
                        <h5 class="card-title">Project {{ $i }}</h5>
                        <p class="card-text">Short description of the project goes here.</p>
                        <a href="#" class="btn btn-primary btn-sm">View</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>
@endsection
