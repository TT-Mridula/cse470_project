@extends('layouts.app')

@section('content')
<div class="container" style="max-width:420px;">
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">Verify your email</div>
        <div class="card-body">
            <form method="POST" action="{{ route('register.otp.verify') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">6 digit code</label>
                    <input type="text" name="code" maxlength="6" inputmode="numeric" class="form-control" autofocus required>
                </div>
                <button class="btn btn-primary w-100">Verify</button>
            </form>

            <form method="POST" action="{{ route('register.otp.resend') }}" class="mt-2">
                @csrf
                <button class="btn btn-outline-secondary w-100">Resend code</button>
            </form>
        </div>
    </div>
</div>
@endsection
