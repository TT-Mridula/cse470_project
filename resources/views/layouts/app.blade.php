@vite(['resources/css/app.css', 'resources/js/app.js'])
<!doctype html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Skill Stacker') }}</title>
  <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  @vite(['resources/sass/app.scss', 'resources/js/app.js'])

  <style>
    :root{
      --bg:#0f1221; --ink:#eef2ff; --muted:#a7b0d8;
      --glass:#121632cc; --brand:#7c5cff; --chip:#23285e;
      --ring:rgba(124,92,255,.35);
    }
    html,body{height:100%}
    body{margin:0; font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial; background:var(--bg); color:var(--ink);}
    a{color:inherit; text-decoration:none}

    /* NAVBAR */
    .site-nav{
      position:sticky; top:0; z-index:50;
      backdrop-filter:saturate(160%) blur(8px);
      background:linear-gradient(180deg,var(--glass),#10132a80);
      border-bottom:1px solid rgba(255,255,255,.06);
    }
    .nav-inner{
      max-width:1200px; margin:0 auto; padding:14px 20px;
      display:flex; align-items:center; gap:16px;
    }
    .brand{font-weight:800; font-size:18px; letter-spacing:.3px}
    .links{margin-left:auto; display:flex; gap:18px}
    .links a{opacity:.85; padding:8px 10px; border-radius:10px}
    .links a:hover{opacity:1; background:rgba(255,255,255,.06)}
    .links a.active{background:rgba(124,92,255,.18); box-shadow:inset 0 0 0 1px var(--ring)}
    .auth{display:flex; align-items:center; gap:10px; margin-left:12px}
    .btn{background:var(--brand); color:#fff; padding:8px 12px; border-radius:10px; font-weight:700}
    .btn.ghost{background:#23285e}
    .avatar{
      width:28px; height:28px; border-radius:50%; background:#2a2e63;
      display:inline-flex; align-items:center; justify-content:center; font-weight:700; margin-right:6px
    }
    .user{display:flex; align-items:center; gap:8px}
    .logout button{
      background:transparent; color:#c8ccff; border:none; cursor:pointer; padding:6px 8px; border-radius:8px;
    }
    .logout button:hover{background:rgba(255,255,255,.06)}

    /* PAGE WRAP */
    .page-wrap{max-width:1200px; margin:0 auto; padding:24px 20px}

    /* FOOTER */
    .site-foot{max-width:1200px; margin:40px auto 20px; padding:10px 20px; color:var(--muted); font-size:13px}
  </style>
  @stack('head')
</head>
<body>
  <div id="app">
    <header class="site-nav">
      <div class="nav-inner">
        <a class="brand" href="{{ url('/') }}">{{ config('app.name','Skill Stacker') }}</a>

        <nav class="links">
  <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>

  {{-- Home sections on / --}}
  <a href="{{ url('/#projects') }}">Projects</a>
  <a href="{{ url('/#skills') }}">Skills</a>
  <a href="{{ url('/#services') }}">Services</a>
  <a href="{{ url('/#portfolio') }}">Portfolio</a>
  <a href="{{ url('/#contact') }}">Contact</a>

  
  <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a> 
</nav>


  
        </nav>

        <div class="auth">
          @guest
            @if (Route::has('login'))
              <a class="btn ghost" href="{{ route('login') }}">Login</a>
            @endif
            @if (Route::has('register'))
              <a class="btn" href="{{ route('register') }}">Sign up</a>
            @endif
          @else
            <div class="user">
              <span class="avatar">{{ strtoupper(substr(Auth::user()->name ?? Auth::user()->email,0,1)) }}</span>
              <span>{{ Auth::user()->name ?? Auth::user()->email }}</span>
              <form class="logout" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
              </form>
            </div>
          @endguest
        </div>
      </div>
    </header>

    <main class="page-wrap">
      @yield('content')
    </main>

    <footer class="site-foot">
      © {{ date('Y') }} {{ config('app.name','Skill Stacker') }}
    </footer>
  </div>

  @stack('scripts')
</body>
</html>
