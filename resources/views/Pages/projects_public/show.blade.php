@extends('layouts.app')

@section('content')
<style>
  :root{
    --bg:#0f1221; --ink:#eef2ff; --muted:#a7b0d8;
    --surface:#121632; --surface-2:#161a3e; --chip:#23285e;
    --brand:#7c5cff; --shadow:0 18px 40px rgba(2,6,23,.45);
  }
  body{background:var(--bg); color:var(--ink);}
  .wrap{max-width:1100px; margin:0 auto; padding:48px 24px;}

  /* header */
  .crumbs{display:flex; gap:8px; align-items:center; color:var(--muted); margin-bottom:12px; font-size:14px}
  .crumbs a{color:#cfd5ff; text-decoration:none}
  .crumbs .sep{opacity:.6}
  .title-row{display:flex; flex-wrap:wrap; align-items:center; gap:12px}
  .title{font-size:46px; font-weight:900; line-height:1.05; margin:0}
  .pill{background:var(--chip); color:#d8dbff; padding:6px 12px; border-radius:999px; font-size:13px}

  /* hero media */
  .hero{
    margin-top:18px; border-radius:18px; overflow:hidden;
    background:linear-gradient(180deg,var(--surface),var(--surface-2));
    box-shadow:var(--shadow);
  }
  .hero img{width:100%; height:auto; display:block; aspect-ratio:16/9; object-fit:cover}
  .hero .caption{padding:10px 14px; color:var(--muted); font-size:13px}

  /* content grid */
  .grid{display:grid; grid-template-columns:3fr 1.2fr; gap:22px; margin-top:22px}
  @media (max-width:900px){ .grid{grid-template-columns:1fr} }

  /* article body */
  .card{background:linear-gradient(180deg,var(--surface),var(--surface-2)); border-radius:18px; box-shadow:var(--shadow)}
  .article{padding:22px}
  .article p{margin:0 0 12px 0; color:#dfe4ff}
  .article .lead{font-size:18px; color:#e9ecff; margin-bottom:12px}
  .article h3{margin:14px 0 8px 0; font-size:20px}

  /* sidebar */
  .side{padding:18px}
  .row{display:flex; justify-content:space-between; align-items:center; margin-bottom:10px}
  .row .label{color:var(--muted); font-size:13px}
  .chips{display:flex; flex-wrap:wrap; gap:8px; margin-top:8px}
  .chip{background:var(--chip); color:#cfd5ff; padding:6px 10px; border-radius:999px; font-size:12px}
  .cta{display:flex; gap:10px; margin-top:12px}
  .btn{border:none; padding:12px 16px; border-radius:12px; font-weight:800; text-decoration:none; display:inline-block}
  .btn.primary{background:var(--brand); color:white}
  .btn.ghost{background:#23285e; color:#e6e8ff}

  /* related */
  .more{margin-top:30px}
  .more h3{margin:0 0 12px 0; font-size:22px}
  .grid-rel{display:grid; grid-template-columns:repeat(3,1fr); gap:16px}
  @media (max-width:900px){ .grid-rel{grid-template-columns:repeat(2,1fr)} }
  @media (max-width:600px){ .grid-rel{grid-template-columns:1fr} }
  .rel{background:linear-gradient(180deg,var(--surface),var(--surface-2)); border-radius:16px; overflow:hidden; text-decoration:none; color:inherit; box-shadow:var(--shadow)}
  .rel img{width:100%; height:180px; object-fit:cover; display:block}
  .rel h6{margin:10px 12px; font-weight:800}
</style>

<div class="wrap">

  {{-- Breadcrumbs --}}
  <div class="crumbs">
    <a href="{{ url('/') }}">Home</a><span class="sep">/</span>
    <a href="{{ route('projects.index') }}">Projects</a><span class="sep">/</span>
    <span>{{ $project->title }}</span>
  </div>

  {{-- Title row --}}
  <div class="title-row">
    <h1 class="title">{{ $project->title }}</h1>
    @if($project->category)
      <span class="pill">{{ $project->category }}</span>
    @endif>
  </div>

  {{-- Media --}}
  @if($project->image_path)
    <figure class="hero">
      <img src="{{ asset('storage/'.$project->image_path) }}" alt="{{ $project->title }}">
      <figcaption class="caption">Preview</figcaption>
    </figure>
  @endif

  {{-- Content + Sidebar --}}
  <div class="grid">
    <div class="card article">
      @if($project->short_description)
        <p class="lead">{{ $project->short_description }}</p>
      @endif

      @if($project->long_description)
        <div>{!! nl2br(e($project->long_description)) !!}</div>
      @else
        <p>Details coming soon.</p>
      @endif

      {{-- Optional sections to enrich content --}}
      {{-- <h3>What I built</h3>
      <p>...</p>
      <h3>Tech highlights</h3>
      <p>...</p> --}}
    </div>

    <aside class="card side">
      <div class="row">
        <span class="label">Published</span>
        <span>{{ optional($project->created_at)->format('M d, Y') }}</span>
      </div>
      @if($project->github_url || $project->live_url)
        <div class="cta">
          @if($project->github_url)
            <a class="btn ghost" target="_blank" rel="noopener" href="{{ $project->github_url }}">GitHub</a>
          @endif
          @if($project->live_url)
            <a class="btn primary" target="_blank" rel="noopener" href="{{ $project->live_url }}">Live demo</a>
          @endif
        </div>
      @endif

      <div style="margin-top:14px">
        <div class="label">Tech</div>
        <div class="chips">
          @foreach($project->techTags as $tag)
            <span class="chip">{{ $tag->name }}</span>
          @endforeach
          @if(! $project->techTags->count())
            <span class="chip">General</span>
          @endif
        </div>
      </div>
    </aside>
  </div>

  {{-- Related --}}
  @if($related->count())
    <div class="more">
      <h3>More projects</h3>
      <div class="grid-rel">
        @foreach($related as $p)
          <a class="rel" href="{{ route('projects.show',$p->slug) }}">
            @if($p->image_path)
              <img src="{{ asset('storage/'.$p->image_path) }}" alt="{{ $p->title }}">
            @endif
            <h6>{{ $p->title }}</h6>
          </a>
        @endforeach
      </div>
    </div>
  @endif
</div>
@endsection
