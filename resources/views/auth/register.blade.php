@extends('layouts.app')

@section('title', 'Sign up')

@section('content')
<style>
  :root{
    --bg:#0f1221; --card:#ffffff; --ink:#101320; --muted:#6b7280;
    --ring:#e5e7eb; --brand:#111827; --brandText:#fff; --brandHover:#0b0f1a;
    --field:#f3f4f6; --fieldText:#111827;
  }
  .auth-page{
    min-height: calc(100vh - 80px);
    display:flex; align-items:center; justify-content:center;
    padding:28px 16px;
  }
  .auth-card{
    width:min(520px, 100%);
    background:var(--card);
    color:var(--ink);
    border-radius:16px;
    box-shadow:0 24px 80px rgba(0,0,0,.35);
    padding:28px 26px;
  }
  .auth-card h1{margin:0 0 4px; font-size:24px; text-align:center;}
  .auth-card .sub{margin:0 0 14px; font-size:14px; color:var(--muted); text-align:center;}

  .gbtn{
    display:flex; align-items:center; justify-content:center; gap:.6rem;
    width:100%; background:#fff; color:#111827; border:1px solid var(--ring);
    border-radius:999px; padding:12px; font-weight:600; text-decoration:none;
  }
  .gbtn:hover{background:#fafafa}
  .google-icon{width:18px;height:18px}

  .or{display:grid; grid-template-columns:1fr auto 1fr; gap:10px; align-items:center;
      margin:14px 0; color:var(--muted); font-size:13px}
  .or::before,.or::after{content:""; height:1px; background:var(--ring)}

  form{display:grid; gap:12px; margin-top:8px}
  label{font-size:13px; color:var(--muted); margin-bottom:4px; display:block}
  .field{display:flex; flex-direction:column}
  input[type="text"], input[type="email"], input[type="password"]{
    width:100%; border:1px solid var(--ring); background:var(--field);
    color:var(--fieldText); border-radius:12px; padding:12px 14px; font-size:14px;
    outline:none; transition:.15s;
  }
  input:focus{border-color:#c7cde2; box-shadow:0 0 0 4px rgba(124,92,255,.12)}
  .hint{font-size:12px; color:var(--muted); margin-top:4px}

  .errors{background:#fff1f2; border:1px solid #fecdd3; color:#9f1239; font-size:13px;
    border-radius:12px; padding:10px 12px; }
  .errors ul{margin:0 0 0 18px; padding:0}

  .btn-auth{
    width:100%; border:none; background:var(--brand); color:var(--brandText);
    padding:12px 16px; border-radius:999px; font-weight:700; cursor:pointer; transition:.15s;
  }
  .btn-auth:hover{background:var(--brandHover)}
  .switch{
    text-align:center; margin-top:14px; color:#cfd3f7; font-size:14px;
  }
  .switch a{color:#fff; text-decoration:none; border-bottom:1px dashed rgba(255,255,255,.5)}
  .switch a:hover{border-bottom-color:#fff}
</style>

<div class="auth-page">
  <div class="auth-card">
    <h1>Create your account</h1>
    <p class="sub">It’s quick and easy.</p>

    {{-- Optional: Google sign in (only if you have the route) --}}
    @php
      if (!function_exists('route_exists')) {
        function route_exists($name){ try { route($name); return true; } catch (\Throwable $e) { return false; } }
      }
    @endphp
    @if(route_exists('login.google'))
      <a class="gbtn" href="{{ route('login.google') }}">
        <img class="google-icon" src="https://www.vectorlogo.zone/logos/google/google-icon.svg" alt="">
        Continue with Google
      </a>
      <div class="or">or</div>
    @endif

    {{-- Errors --}}
    @if ($errors->any())
      <div class="errors">
        <ul>
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="field">
        <label for="name">Name</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name">
      </div>

      <div class="field">
        <label for="email">Email address</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">
      </div>

      <div class="field">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required autocomplete="new-password">
        <div class="hint">Use 8+ characters with a mix of letters & numbers.</div>
      </div>

      <div class="field">
        <label for="password_confirmation">Confirm password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password">
      </div>

      <button class="btn-auth" type="submit">Create account</button>
    </form>
  </div>
</div>

<div class="switch">
  Already have an account?
  <a href="{{ route('login') }}">Log in</a>
</div>
@endsection
