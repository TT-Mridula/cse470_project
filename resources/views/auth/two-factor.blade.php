{{-- resources/views/auth/two-factor.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container" style="max-width:480px">
  <h3 class="mb-3">Enter verification code</h3>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('2fa.verify') }}">
    @csrf
    <div class="mb-3">
      <label class="form-label">6-digit code</label>
      <input name="code" class="form-control" maxlength="6" inputmode="numeric" autocomplete="one-time-code" required>
      @error('code') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <button class="btn btn-primary w-100">Continue</button>
  </form>

  <form class="mt-3" method="POST" action="{{ route('2fa.resend') }}">
    @csrf
    <button class="btn btn-link p-0">Resend code</button>
  </form>
</div>
@endsection
