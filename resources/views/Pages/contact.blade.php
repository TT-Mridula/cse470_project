@extends('layouts.admin')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Contact</h1>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Contact</li>
        </ol>

        <div class="row">
            <div class="col-xl-8 col-lg-9">
                <div class="card mb-4">
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" placeholder="Your name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="you@example.com">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Message</label>
                                <textarea class="form-control" rows="5" placeholder="Type your message..."></textarea>
                            </div>
                            <button type="button" class="btn btn-primary">Send</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Contact Info</h5>
                        <p class="mb-1"><i class="fas fa-envelope me-2"></i>you@domain.com</p>
                        <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>City, Country</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
