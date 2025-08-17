@extends('layouts.admin_layout')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Services</h1>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Services</li>
        </ol>

        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Web Development</h5>
                        <p class="card-text">Laravel, Vue/React, REST APIs, MySQL.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">UI/UX Design</h5>
                        <p class="card-text">Wireframes, prototypes, design systems.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Consulting</h5>
                        <p class="card-text">Architecture reviews, performance tuning.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
