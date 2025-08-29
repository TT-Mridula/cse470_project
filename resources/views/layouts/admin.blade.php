<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>@yield('title', 'Dashboard')</title>

  <link href="{{ asset('css/dashboard_style.css') }}" rel="stylesheet" />
  @vite(['resources/css/app.css','resources/js/app.js'])
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="{{ route('admin.dashboard') }}">Skill Stacker</a>

    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">
      <i class="fas fa-bars"></i>
    </button>

    <form class="d-none d-md-inline-block ms-auto me-0 me-md-3 my-2 my-md-0">
      <div class="input-group">
        <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." />
        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
      </div>
    </form>

    <ul class="navbar-nav ms-3 me-3 me-lg-4">
      <li class="nav-item d-flex align-items-center text-white small me-2">
        {{ auth()->user()->email ?? '' }}
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-user fa-fw"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#!">Settings</a></li>
          <li><a class="dropdown-item" href="#!">Activity Log</a></li>
          <li><hr class="dropdown-divider" /></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item">Logout</button>
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </nav>

  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">

            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Dashboard
            </a>

            <a class="nav-link {{ request()->routeIs('admin.main*') ? 'active' : '' }}"
               href="{{ route('admin.main') }}">
              <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div> Resume
            </a>
            <a class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}"
   href="{{ route('admin.profile.edit') }}">
  <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
  Profile
</a>

            {{-- Services --}}
            @php $svcOpen = request()->routeIs('admin.services.*'); @endphp
            <a class="nav-link {{ $svcOpen ? '' : 'collapsed' }}" href="#"
               data-bs-toggle="collapse" data-bs-target="#collapseServices"
               aria-expanded="{{ $svcOpen ? 'true' : 'false' }}" aria-controls="collapseServices">
              <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
              Services
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse {{ $svcOpen ? 'show' : '' }}" id="collapseServices" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link {{ request()->routeIs('admin.services.create') ? 'active' : '' }}"
                   href="{{ route('admin.services.create') }}">Create</a>
                <a class="nav-link {{ request()->routeIs('admin.services.list') ? 'active' : '' }}"
                   href="{{ route('admin.services.list') }}">List</a>
              </nav>
            </div>

            {{-- Portfolio --}}
            @php $pfOpen = request()->routeIs('admin.portfolios.*'); @endphp
            <a class="nav-link {{ $pfOpen ? '' : 'collapsed' }}" href="#"
               data-bs-toggle="collapse" data-bs-target="#collapsePortfolio"
               aria-expanded="{{ $pfOpen ? 'true' : 'false' }}" aria-controls="collapsePortfolio">
              <div class="sb-nav-link-icon"><i class="fas fa-images"></i></div>
              Portfolio
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse {{ $pfOpen ? 'show' : '' }}" id="collapsePortfolio" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link {{ request()->routeIs('admin.portfolios.create') ? 'active' : '' }}"
                   href="{{ route('admin.portfolios.create') }}">Create</a>
                <a class="nav-link {{ request()->routeIs('admin.portfolios.list') ? 'active' : '' }}"
                   href="{{ route('admin.portfolios.list') }}">List</a>
              </nav>
            </div>

            {{-- Projects --}}
            @php $prOpen = request()->routeIs('admin.projects.*'); @endphp
            <a class="nav-link {{ $prOpen ? '' : 'collapsed' }}" href="#"
               data-bs-toggle="collapse" data-bs-target="#collapseProjects"
               aria-expanded="{{ $prOpen ? 'true' : 'false' }}" aria-controls="collapseProjects">
              <div class="sb-nav-link-icon"><i class="fas fa-briefcase"></i></div>
              Projects
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse {{ $prOpen ? 'show' : '' }}" id="collapseProjects" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link {{ request()->routeIs('admin.projects.create') ? 'active' : '' }}"
                   href="{{ route('admin.projects.create') }}">Create</a>
                <a class="nav-link {{ request()->routeIs('admin.projects.index') ? 'active' : '' }}"
                   href="{{ route('admin.projects.index') }}">List</a>
              </nav>
            </div>
             {{-- Blog --}}
            @php $blogOpen = request()->routeIs('admin.blog.*') || request()->routeIs('admin.blog.categories'); @endphp
<a class="nav-link {{ $blogOpen ? '' : 'collapsed' }}" href="#"
   data-bs-toggle="collapse" data-bs-target="#collapseBlog"
   aria-expanded="{{ $blogOpen ? 'true' : 'false' }}" aria-controls="collapseBlog">
  <div class="sb-nav-link-icon"><i class="fas fa-blog"></i></div>
  Blog
  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse {{ $blogOpen ? 'show' : '' }}" id="collapseBlog" data-bs-parent="#sidenavAccordion">
  <nav class="sb-sidenav-menu-nested nav">
    <a class="nav-link {{ request()->routeIs('admin.blog.index') ? 'active' : '' }}"
       href="{{ route('admin.blog.index') }}">Posts</a>
    <a class="nav-link {{ request()->routeIs('admin.blog.categories') ? 'active' : '' }}"
       href="{{ route('admin.blog.categories') }}">Categories</a>
  </nav>
</div>


            {{-- Skills --}}
            @php
              $skOpen = request()->routeIs('admin.skills.*') || request()->routeIs('admin.skill_categories.*');
            @endphp
            <a class="nav-link {{ $skOpen ? '' : 'collapsed' }}" href="#"
               data-bs-toggle="collapse" data-bs-target="#collapseSkills"
               aria-expanded="{{ $skOpen ? 'true' : 'false' }}" aria-controls="collapseSkills">
              <div class="sb-nav-link-icon"><i class="fas fa-screwdriver-wrench"></i></div>
              Skills
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse {{ $skOpen ? 'show' : '' }}" id="collapseSkills" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link {{ request()->routeIs('admin.skills.index') ? 'active' : '' }}"
                   href="{{ route('admin.skills.index') }}">All Skills</a>
                <a class="nav-link {{ request()->routeIs('admin.skill_categories.index') ? 'active' : '' }}"
                   href="{{ route('admin.skill_categories.index') }}">Categories</a>
              </nav>
            </div>

            {{-- Messages --}}
            <a class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}"
               href="{{ route('admin.messages.index') }}">
              <div class="sb-nav-link-icon"><i class="fas fa-inbox"></i></div>
              Messages
            </a>

            <a class="nav-link {{ request()->routeIs('admin.about') ? 'active' : '' }}"
               href="{{ route('admin.about') }}">
              <div class="sb-nav-link-icon"><i class="fas fa-info-circle"></i></div> About
            </a>

            <a class="nav-link {{ request()->routeIs('admin.contact') ? 'active' : '' }}"
               href="{{ route('admin.contact') }}">
              <div class="sb-nav-link-icon"><i class="fas fa-envelope"></i></div> Contact
            </a>
          </div>
        </div>

        <div class="sb-sidenav-footer">
          <div class="small">Logged in as:</div>
          {{ auth()->user()->name ?? 'Admin' }}
        </div>
      </nav>
    </div>

    <div id="layoutSidenav_content">
      @includeIf('alert.messages')

      @yield('content')

      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Your Website {{ date('Y') }}</div>
            <div>
              <a href="#">Privacy Policy</a>
              &middot;
              <a href="#">Terms &amp; Conditions</a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
