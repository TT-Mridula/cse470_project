@extends('layouts.admin_layout')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">About</h1>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">About</li>
        </ol>

        <div class="card mb-4">
            <div class="card-body">
                <p class="mb-2">
                    SkillStacker is a portfolio/admin dashboard built with Laravel & Bootstrap.
                    Use this page to describe yourself, your mission, tech stack, or team.
                </p>
                <ul class="mb-0">
                    <li>Laravel 12, PHP 8</li>
                    <li>Bootstrap 5, Font Awesome</li>
                    <li>MySQL (XAMPP)</li>
                </ul>
            </div>
        </div>
    </div>
</main>
@endsection
