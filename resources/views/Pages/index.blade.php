{{-- resources/views/pages/index.blade.php --}}
@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    /**
     * Resolve a public URL for a file that may be stored as:
     *  - "img/…" (on disk)  -> Storage::url(...)
     *  - "storage/img/…" (already public) -> asset(...)
     *  - Full URL (http/https)             -> use as-is
     */
    function file_public_url(?string $path, string $fallback = ''): string {
        if (!$path) return $fallback;
        if (Str::startsWith($path, ['http://','https://'])) return $path;
        if (Str::startsWith($path, ['storage/','/storage/'])) return asset(ltrim($path, '/')); // already public
        return Storage::url($path); // assume "public" disk
    }

    // Background image + resume
    $bg        = file_public_url($main?->bc_img, asset('assets/img/bc_img.jpg'));
    $resumeUrl = $main?->resume ? file_public_url($main->resume) : null;

    // Profile avatar (uses accessor if you added it; falls back to placeholder)
    $avatarUrl = isset($profile)
        ? ($profile->avatar_url ?? asset('images/avatar-placeholder.png'))
        : asset('images/avatar-placeholder.png');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="SkillStacker - portfolio and services" />
    <meta name="author" content="SkillStacker" />
    <title>SkillStacker - Portfolio</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:300,300italic,400,400italic,700,700italic&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.14.2/simpleLightbox.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

    {{-- Dark glass navbar + sections styling --}}
    <style>
      :root { --nav-h: 64px; --ink:#eef2ff; --muted:#a7b0d8; --glass:#121632; --glass2:#161a3e; --chip:#23285e; }

      html { scroll-behavior: smooth; }
      /* keep anchors visible below fixed nav */
      section[id], #projects, #skills, #about, #services, #portfolio, #contact { scroll-margin-top: calc(var(--nav-h) + 16px); }

      /* dark glass navbar */
      .site-nav{
        --nav-bg1: rgba(18,22,50,.92);
        --nav-bg2: rgba(18,22,50,.72);
        --nav-border: rgba(255,255,255,.08);
        background: linear-gradient(180deg, var(--nav-bg1), var(--nav-bg2));
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-bottom: 1px solid var(--nav-border);
        z-index: 1030;
      }
      .site-nav.nav-solid{
        background: linear-gradient(180deg, rgba(18,22,50,.98), rgba(18,22,50,.95));
        box-shadow: 0 8px 24px rgba(0,0,0,.25);
      }
      .site-nav .navbar-brand{ color:#e6e9ff; font-weight:700; letter-spacing:.3px; }
      .site-nav .navbar-brand:hover{ color:#ffffff; }
      .site-nav .nav-link{
        color:#c5ccff; border-radius:12px; padding:.55rem .9rem; transition:.2s;
      }
      .site-nav .nav-link:hover{ color:#fff; background: rgba(255,255,255,.06); }
      .site-nav .nav-link.active{ color:#fff; background:#6956ff; }
      .site-nav .navbar-toggler{ border: 1px solid rgba(255,255,255,.35); }
      .site-nav .navbar-toggler-icon{ filter: invert(1) contrast(1.2); }

      /* hero spacing under fixed nav */
      .masthead{ margin-top: var(--nav-h); }

      /* projects + skills cards (your existing look) */
      .home-section{padding:40px 0}
      .section-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
      .section-head h2{margin:0;font-size:28px}
      .see-all{font-size:14px;opacity:.9;padding:6px 10px;border-radius:10px;background:rgba(0,0,0,.06)}
      .see-all:hover{opacity:1}
      .card-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
      @media (max-width: 980px){.card-grid{grid-template-columns:repeat(2,1fr)}}
      @media (max-width: 640px){.card-grid{grid-template-columns:1fr}}
      .card{background:linear-gradient(180deg,var(--glass),var(--glass2));border-radius:14px;overflow:hidden;display:flex;flex-direction:column;color:#e6e9ff;text-decoration:none}
      .thumb{aspect-ratio: 16/10;overflow:hidden}
      .thumb img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .4s}
      .card:hover .thumb img{transform:scale(1.05)}
      .card-body{padding:12px}
      .card-body h3{margin:0 0 6px 0;font-size:18px;color:#fff}
      .muted{color:var(--muted);margin:0 0 10px 0;font-size:14px}
      .tags{display:flex;gap:8px;flex-wrap:wrap}
      .tag{background:var(--chip);padding:4px 8px;border-radius:999px;font-size:12px;color:#cfd5ff}
      .cat{background:linear-gradient(180deg,var(--glass),var(--glass2));border-radius:14px;padding:16px;margin-bottom:12px;color:#e6e9ff}
      .cat h3{margin:0 0 8px 0;font-size:16px;color:#cfd5ff}
      .skills-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
      @media (max-width: 640px){.skills-grid{grid-template-columns:1fr}}
      .skill{background:rgba(255,255,255,.06);border-radius:10px;padding:10px}
      .skill-top{display:flex;align-items:center;justify-content:space-between}
      .skill .name i{margin-right:6px;color:#b8c0ff}
      .skill .lvl{color:#cbd2ff;font-size:12px}
      .bar{height:10px;background:#23285e;border-radius:999px;margin-top:8px;overflow:hidden}
      .fill{height:100%;background:linear-gradient(90deg,#6d5cff,#8f7bff)}

      /* profile (about) */
      .profile-wrap{
        display:flex;gap:18px;align-items:center;
        background:linear-gradient(180deg,var(--glass),var(--glass2));
        border-radius:16px;padding:18px;color:#e6e9ff
      }
      .profile-wrap .avatar{
        width:100px;height:100px;border-radius:999px;object-fit:cover;
        box-shadow:0 0 0 3px rgba(255,255,255,.06)
      }
      .profile-wrap .name{margin:0 0 6px;font-size:22px}
      .profile-wrap .bio{color:var(--muted);margin:0 0 10px;line-height:1.6;max-width:65ch}
      .profile-wrap .contacts{display:flex;flex-wrap:wrap;gap:8px}
      .profile-wrap .chip{
        display:inline-flex;align-items:center;gap:8px;
        background:var(--chip);padding:6px 10px;border-radius:999px;
        font-size:13px;color:#cfd5ff;text-decoration:none
      }
      .profile-wrap .chip:hover{opacity:1; filter:brightness(1.05)}
      .profile-wrap .chip i{color:#cbd2ff}
    </style>
</head>
<body id="page-top">
    {{-- === Dark glass Navigation (HOME) === --}}
<nav class="site-nav">
  <div class="nav-inner">
    <a class="brand" href="{{ route('home') }}">{{ config('app.name','Skill Stacker') }}</a>

    <nav class="links">
      {{-- jump to sections on the home page --}}
      <a href="{{ url('/#projects') }}">Projects</a>
      <a href="{{ url('/#skills') }}">Skills</a>
      <a href="{{ url('/#services') }}">Services</a>
      <a href="{{ url('/#portfolio') }}">Portfolio</a>
      <a href="{{ url('/#contact') }}">Contact</a>

      <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'active' : '' }}">All Projects</a>
      <a href="{{ route('skills.index') }}" class="{{ request()->routeIs('skills.*') ? 'active' : '' }}">Skills Directory</a>
      <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a>
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
</nav>

{{-- local styles for this nav (safe to keep on the page) --}}
<style>
  :root{
    --bg:#0f1221; --ink:#eef2ff; --muted:#a7b0d8;
    --glass:#121632cc; --brand:#7c5cff; --chip:#23285e; --ring:rgba(124,92,255,.35);
  }
  .site-nav{
    position:sticky; top:0; z-index:50;
    backdrop-filter:saturate(160%) blur(8px);
    background:linear-gradient(180deg,var(--glass),#10132a80);
    border-bottom:1px solid rgba(255,255,255,.06);
  }
  .nav-inner{max-width:1200px; margin:0 auto; padding:14px 20px; display:flex; align-items:center; gap:16px}
  .brand{font-weight:800; font-size:18px; letter-spacing:.3px; color:#fff}
  .links{margin-left:auto; display:flex; gap:18px}
  .links a{color:#e6e9ff; opacity:.85; padding:8px 10px; border-radius:10px; text-decoration:none}
  .links a:hover{opacity:1; background:rgba(255,255,255,.06)}
  .links a.active{background:rgba(124,92,255,.18); box-shadow:inset 0 0 0 1px var(--ring)}
  .auth{display:flex; align-items:center; gap:10px; margin-left:12px}
  .btn{background:var(--brand); color:#fff; padding:8px 12px; border-radius:10px; font-weight:700; text-decoration:none}
  .btn.ghost{background:#23285e}
  .avatar{width:28px; height:28px; border-radius:50%; background:#2a2e63; display:inline-flex; align-items:center; justify-content:center; font-weight:700; color:#fff}
  .user{display:flex; align-items:center; gap:8px; color:#e6e9ff}
  .logout button{background:transparent; color:#c8ccff; border:none; cursor:pointer; padding:6px 8px; border-radius:8px}
  .logout button:hover{background:rgba(255,255,255,.06)}
</style>

    {{-- Masthead (Hero) --}}
    <header class="masthead position-relative"
            style="background-image:url('{{ $bg }}'); background-size:cover; background-position:center;">
        <div class="position-absolute top-0 start-0 w-100 h-100"
             style="background:linear-gradient(180deg,rgba(0,0,0,.45),rgba(0,0,0,.25));"></div>

        <div class="container px-4 px-lg-5 h-100 position-relative">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white fw-bold">{{ $main?->sub_title }}</h1>
                    <hr class="divider" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 mb-5">{{ $main?->title }}</p>
                    @if ($resumeUrl)
                        <a class="btn btn-primary btn-xl" href="{{ $resumeUrl }}" target="_blank" rel="noopener">
                            Resume
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    {{-- About / Profile --}}
    <section class="home-section" id="about">
      <div class="container px-4 px-lg-5">
        @if(isset($profile) && ($profile->name || $profile->bio || $profile->email || $profile->phone || !empty($profile->socials)))
          <div class="profile-wrap">
            <img class="avatar" src="{{ $avatarUrl }}" alt="{{ $profile->name ?? 'Avatar' }}">
            <div class="meta">
              <h2 class="name">{{ $profile->name ?: 'Your Name' }}</h2>

              @if(!empty($profile->bio))
                <p class="bio">{{ $profile->bio }}</p>
              @endif

              <div class="contacts">
                @if(!empty($profile->email))
                  <a href="mailto:{{ $profile->email }}" class="chip">
                    <i class="fa-solid fa-envelope"></i><span>{{ $profile->email }}</span>
                  </a>
                @endif
                @if(!empty($profile->phone))
                  <span class="chip">
                    <i class="fa-solid fa-phone"></i><span>{{ $profile->phone }}</span>
                  </span>
                @endif

                @if(!empty($profile->socials) && is_array($profile->socials))
                  @foreach($profile->socials as $label => $url)
                    @if($url)
                      <a href="{{ $url }}" target="_blank" rel="noopener" class="chip">
                        <i class="fa-brands fa-{{ Str::slug($label) }}"></i>
                        <span>{{ is_string($label) ? ucfirst($label) : 'Social' }}</span>
                      </a>
                    @endif
                  @endforeach
                @endif
              </div>
            </div>
          </div>
        @else
          {{-- Fallback content (kept from your previous template) --}}
          <div class="page-section bg-primary rounded-3 p-4 text-center">
            <h2 class="text-white mt-0">We have what you need</h2>
            <p class="text-white-75 mb-3">
              Start Bootstrap has everything you need to get your new website up and running in no time.
            </p>
            <a class="btn btn-light btn-xl" href="#services">Get Started</a>
          </div>
        @endif
      </div>
    </section>

    {{-- Projects on home --}}
    <section id="projects" class="home-section">
        <div class="section-head container px-4 px-lg-5">
            <h2>Latest projects</h2>
            <a href="{{ route('projects.index') }}" class="see-all">See all</a>
        </div>

        <div class="container px-4 px-lg-5">
            @if(($projects ?? collect())->count())
                <div class="card-grid">
                    @foreach($projects as $p)
                        <a class="card" href="{{ route('projects.show', $p->slug) }}">
                            @php
                                $img = $p->image_path ? asset('storage/'.$p->image_path) : asset('images/placeholder-project.jpg');
                            @endphp
                            <div class="thumb">
                                <img src="{{ $img }}" alt="{{ $p->title }}">
                            </div>
                            <div class="card-body">
                                <h3>{{ $p->title }}</h3>
                                <p class="muted">{{ Str::limit($p->short_description, 90) }}</p>
                                <div class="tags">
                                    @foreach($p->techTags->take(3) as $t)
                                        <span class="tag">{{ $t->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="muted">No projects yet.</p>
            @endif
        </div>
    </section>

    {{-- Services --}}
    <section class="page-section" id="services">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Services</h2>
            </div>

            <div class="row text-center">
                @forelse ($services as $service)
                    <div class="col-md-4 mb-5">
                        <span class="fa-stack fa-4x">
                            <i class="{{ $service->icon }} fa-stack-2x"></i>
                        </span>
                        <h4 class="my-3">{{ $service->title }}</h4>
                        <p class="text-muted">{{ $service->description }}</p>
                    </div>
                @empty
                    <p class="text-muted">No services yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Skills on home --}}
    <section id="skills" class="home-section">
        <div class="section-head container px-4 px-lg-5">
            <h2>Skills</h2>
            <a href="{{ url('/skills') }}" class="see-all">View full list</a>
        </div>

        <div class="container px-4 px-lg-5">
            @foreach(($skillCategories ?? collect()) as $cat)
                @if($cat->skills->count())
                    <div class="cat">
                        <h3>{{ $cat->name }}</h3>
                        <div class="skills-grid">
                            @foreach($cat->skills as $s)
                                <div class="skill">
                                    <div class="skill-top">
                                        <span class="name">
                                            @if($s->icon_class)
                                                <i class="{{ $s->icon_class }}"></i>
                                            @endif
                                            {{ $s->name }}
                                        </span>
                                        <span class="lvl">{{ $s->level }}%</span>
                                    </div>
                                    <div class="bar"><div class="fill" style="width: {{ $s->level }}%"></div></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    {{-- Portfolio --}}
    <div id="portfolio">
        <div class="container-fluid p-0">
            <div class="row g-0">
                @foreach ($portfolios as $p)
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="{{ Storage::url($p->image) }}" title="{{ $p->title }}">
                            <img class="img-fluid" src="{{ Storage::url($p->image) }}" alt="{{ $p->title }}" />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">{{ $p->category }}</div>
                                <div class="project-name">{{ $p->title }}</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Call to action --}}
    <section class="page-section bg-dark text-white">
        <div class="container px-4 px-lg-5 text-center">
            <h2 class="mb-4">Free Download at Start Bootstrap</h2>
            <a class="btn btn-light btn-xl" href="https://startbootstrap.com/theme/creative/" target="_blank" rel="noopener">
                Download Now
            </a>
        </div>
    </section>

    {{-- Contact --}}
    <section class="page-section" id="contact">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 col-xl-6 text-center">
                    <h2 class="mt-0">Lets Get In Touch</h2>
                    <hr class="divider" />
                    <p class="text-muted mb-5">
                        Ready to start your next project with us? Send us a message and we will get back to you soon.
                    </p>
                </div>
            </div>

            <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
                <div class="col-lg-6">
                    <form id="contactForm" method="post" action="{{ route('contact.store') }}">
    @csrf

    {{-- honeypot - leave hidden --}}
    <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off">

    @if(session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="form-floating mb-3">
      <input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Enter your name..."/>
      <label for="name">Full name</label>
    </div>

    <div class="form-floating mb-3">
      <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com"/>
      <label for="email">Email address</label>
    </div>

    <div class="form-floating mb-3">
      <input class="form-control" id="phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="(123) 456-7890"/>
      <label for="phone">Phone number</label>
    </div>

    <div class="form-floating mb-3">
      <input class="form-control" id="subject" type="text" name="subject" value="{{ old('subject') }}" placeholder="Subject"/>
      <label for="subject">Subject</label>
    </div>

    <div class="form-floating mb-3">
      <textarea class="form-control" id="message" name="message" placeholder="Enter your message here..." style="height: 10rem">{{ old('message') }}</textarea>
      <label for="message">Message</label>
    </div>

    <div class="d-grid">
      <button class="btn btn-primary btn-xl" type="submit">Submit</button>
    </div>
</form>
                </div>
            </div>

            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-4 text-center mb-5 mb-lg-0">
                    <i class="bi-phone fs-2 mb-3 text-muted"></i>
                    <div>+1 (555) 123-4567</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-light py-5">
        <div class="container px-4 px-lg-5">
            <div class="small text-center text-muted">Copyright &copy; {{ date('Y') }} - SkillStacker</div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.14.2/simpleLightbox.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    {{-- navbar behavior: solid on scroll + active link highlight --}}
    <script>
      (function () {
        const nav = document.querySelector('.site-nav');
        const onScroll = () => {
          if (window.scrollY > 12) nav.classList.add('nav-solid');
          else nav.classList.remove('nav-solid');
        };
        onScroll();
        window.addEventListener('scroll', onScroll);
      })();

      (function () {
        const links = [...document.querySelectorAll('.site-nav .nav-link[href^="#"]')];
        const ids = links.map(a => a.getAttribute('href')).filter(h => h && h.length > 1);
        const sections = ids.map(id => document.querySelector(id)).filter(Boolean);

        const setActive = (id) => {
          links.forEach(a => a.classList.toggle('active', a.getAttribute('href') === id));
        };

        const io = new IntersectionObserver((entries) => {
          entries.forEach(e => { if (e.isIntersecting) setActive('#' + e.target.id); });
        }, {rootMargin: '-50% 0px -50% 0px', threshold: [0, .25, .5, .75, 1]});

        sections.forEach(s => io.observe(s));
        if (location.hash) setActive(location.hash);
      })();
    </script>
</body>
</html>
