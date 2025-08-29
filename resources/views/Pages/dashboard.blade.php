
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@php
    use App\Models\Profile;
    $p = Profile::first();                         // admin profile (name/bio/email/avatar)
    $name = $p->name ?? (Auth::user()->name ?? 'Admin');
    // Prefer stored avatar; otherwise show an initial
    $avatarUrl = $p?->avatar_url ?? null;          // provided by your getAvatarUrlAttribute()
    $initial   = strtoupper(mb_substr($name, 0, 1));
@endphp

<div class="dash-wrap">

  {{-- Welcome Strip --}}
  <div class="welcome card border-0 mb-4 overflow-hidden">
    <div class="welcome-bg"></div>
    <div class="card-body d-flex align-items-center gap-3 position-relative">
      <div class="avatar-xl">
        @if($avatarUrl)
          <img src="{{ $avatarUrl }}" alt="{{ $name }}" class="rounded-circle ring" />
        @else
          <div class="avatar-fallback ring">{{ $initial }}</div>
        @endif
      </div>
      <div class="grow">
        <h4 class="mb-1">Welcome back, {{ $name }}!</h4>
        <p class="text-muted mb-0">Manage your portfolio content from this admin panel.</p>
      </div>
      <div class="d-none d-md-flex align-items-center gap-2">
        <a href="{{ route('home') }}" class="btn btn-light btn-sm border"><i class="bi bi-globe2 me-1"></i> View site</a>
        <a href="{{ url('/admin/profile') }}" class="btn btn-brand btn-sm"><i class="bi bi-pencil-square me-1"></i> Edit profile</a>
      </div>
    </div>
  </div>

  {{-- Top Tiles --}}
  <div class="row g-3">

    <div class="col-md-4">
      <div class="tile card h-100">
        <div class="card-body">
          <div class="tile-head">
            <span class="ico bg-pale-purple"><i class="bi bi-person-badge"></i></span>
            <div class="text">
              <div class="title">Personal Info</div>
              <small class="muted">Update your profile, bio & contact details</small>
            </div>
          </div>
          <div class="tile-actions">
            <a href="{{ url('/admin/profile') }}" class="btn btn-soft"><i class="bi bi-pencil me-1"></i> Edit Profile</a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="tile card h-100">
        <div class="card-body">
          <div class="tile-head">
            <span class="ico bg-pale-green"><i class="bi bi-stars"></i></span>
            <div class="text">
              <div class="title">Skills</div>
              <small class="muted">Manage your technical & soft skills</small>
            </div>
          </div>
          <div class="tile-actions gap-2">
            <a href="{{ route('admin.skills.index') }}" class="btn btn-soft"><i class="bi bi-list-ul me-1"></i> View All</a>
            <a href="{{ route('admin.skills.create') }}" class="btn btn-brand"><i class="bi bi-plus-lg me-1"></i> Add New</a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="tile card h-100">
        <div class="card-body">
          <div class="tile-head">
            <span class="ico bg-pale-blue"><i class="bi bi-eye"></i></span>
            <div class="text">
              <div class="title">Quick Actions</div>
              <small class="muted">Jump to public pages</small>
            </div>
          </div>
          <div class="tile-actions d-grid gap-2">
            <a href="{{ route('home') }}" class="btn btn-soft w-100"><i class="bi bi-house me-1"></i> View Homepage</a>
            <a href="{{ route('skills.index') }}" class="btn btn-soft w-100"><i class="bi bi-card-checklist me-1"></i> View Skills</a>
          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- Section Label --}}
  <div class="label-row"><span>Coming Soon</span></div>

  {{-- Ghost Cards --}}
  <div class="row g-3">
    <div class="col-md-3">
      <a class="ghost card h-100 text-decoration-none" href="{{ url('/admin/projects') }}">
        <div class="card-body text-center">
          <i class="bi bi-box-seam"></i>
          <div class="label">Projects</div>
        </div>
      </a>
    </div>
    <div class="col-md-3">
      <a class="ghost card h-100 text-decoration-none" href="{{ url('/admin/blog') }}">
        <div class="card-body text-center">
          <i class="bi bi-journal-text"></i>
          <div class="label">Blog Posts</div>
        </div>
      </a>
    </div>
    <div class="col-md-3">
      <a class="ghost card h-100 text-decoration-none" href="{{ url('/admin/messages') }}">
        <div class="card-body text-center">
          <i class="bi bi-chat-dots"></i>
          <div class="label">Messages</div>
        </div>
      </a>
    </div>
    <div class="col-md-3">
      <a class="ghost card h-100 text-decoration-none" href="{{ url('/admin/main') }}">
        <div class="card-body text-center">
          <i class="bi bi-file-earmark-text"></i>
          <div class="label">Resume</div>
        </div>
      </a>
    </div>
  </div>

</div>

{{-- Page-scoped styles --}}
<style>
  :root{
    --brand:#6f42c1;
    --ink:#212529;
    --muted:#6c757d;
    --card:#ffffff;
    --ring:rgba(111,66,193,.28);
  }
  .dash-wrap{max-width:1100px}

  /* Welcome */
  .welcome{border-radius:16px}
  .welcome-bg{
    position:absolute; inset:0; z-index:0;
    background:
      radial-gradient(1200px 500px at -10% -10%, rgba(111,66,193,.10), rgba(111,66,193,0) 60%),
      linear-gradient(90deg, rgba(111,66,193,.06), transparent 40%),
      linear-gradient(180deg, #fff, #fff);
  }
  .welcome .card-body{position:relative}
  .avatar-xl{width:56px;height:56px;flex:0 0 auto}
  .avatar-xl img{width:56px;height:56px;object-fit:cover}
  .ring{box-shadow: 0 0 0 3px var(--ring)}
  .avatar-fallback{
    width:56px;height:56px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    background:#efe9ff;color:#4e2fa1;font-weight:800;font-size:1.15rem;
  }

  /* Tiles */
  .tile{
    background:var(--card);
    border:1px solid rgba(0,0,0,.05);
    border-radius:16px;
    box-shadow:0 10px 30px rgba(17,24,39,.04);
    transition:transform .15s ease, box-shadow .2s ease, border-color .2s ease;
  }
  .tile:hover{ transform: translateY(-2px); box-shadow:0 16px 40px rgba(17,24,39,.08); border-color: rgba(111,66,193,.18); }
  .tile .tile-head{display:flex; gap:12px; align-items:flex-start; margin-bottom:.35rem}
  .tile .ico{
    width:44px; height:44px; border-radius:12px;
    display:inline-flex; align-items:center; justify-content:center;
    color:#3b3b3b; font-size:1.25rem; box-shadow: inset 0 0 0 1px rgba(0,0,0,.06);
  }
  .bg-pale-purple{background:linear-gradient(180deg,#f1eafe,#e8dcff)}
  .bg-pale-green{background:linear-gradient(180deg,#e9f9f1,#dff4ea)}
  .bg-pale-blue{background:linear-gradient(180deg,#e9f1ff,#e2ecff)}
  .tile .text .title{font-weight:600}
  .tile .text .muted{color:var(--muted)}
  .tile .tile-actions{margin-top:.75rem; display:flex; gap:.5rem; flex-wrap:wrap}

  .btn-brand{
    --bs-btn-bg:var(--brand);
    --bs-btn-border-color:var(--brand);
    --bs-btn-hover-bg:#5b34a5;
    --bs-btn-hover-border-color:#5b34a5;
    --bs-btn-color:#fff;
  }
  .btn-soft{ background:#fff; border:1px solid rgba(0,0,0,.10); }
  .btn-soft:hover{ border-color:var(--brand); box-shadow:0 0 0 3px var(--ring) }

  /* Section label */
  .label-row{display:flex; align-items:center; gap:10px; margin:20px 0 8px}
  .label-row span{font-weight:600; color:#6b7280}
  .label-row::after{
    content:''; height:1px; background:linear-gradient(90deg, rgba(0,0,0,.08), transparent);
    flex:1;
  }

  /* Ghost cards */
  .ghost{
    border:1px dashed rgba(0,0,0,.12);
    border-radius:14px;
    transition: all .2s ease; background:rgba(255,255,255,.9);
  }
  .ghost .card-body{min-height:120px; display:flex; flex-direction:column; align-items:center; justify-content:center}
  .ghost i{font-size:1.6rem; color:var(--brand); margin-bottom:.35rem}
  .ghost .label{color:#4b5563}
  .ghost:hover{ border-style:solid; border-color: var(--brand); box-shadow:0 12px 28px rgba(111,66,193,.15); transform: translateY(-2px); }
</style>
@endsection