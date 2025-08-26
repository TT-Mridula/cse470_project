@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('content')
<style>
  :root{
    --bg:#0f1221; --ink:#eef2ff; --muted:#a7b0d8;
    --surface:#121632; --surface-2:#161a3e;
    --brand:#7c5cff; --chip:#23285e; --ring:rgba(124,92,255,.35);
    --shadow:0 18px 40px rgba(2,6,23,.45);
  }
  body{background:var(--bg); color:var(--ink);}

  .wrap{max-width:1200px; margin:0 auto; padding:48px 24px;}
  .hero{display:flex; flex-direction:column; align-items:center; text-align:center; gap:10px; margin-bottom:22px;}
  .hero h1{font-size:48px; line-height:1.05; margin:0; letter-spacing:.2px}
  .hero p{margin:0; color:var(--muted); font-size:18px}

  /* search bar */
  .searchbar{
    width:100%; max-width:1100px;
    display:grid; grid-template-columns: 1fr 200px 200px 130px; gap:12px;
    background:linear-gradient(135deg,var(--surface),var(--surface-2));
    padding:12px; border-radius:18px; align-items:center;
    box-shadow:inset 0 0 0 1px rgba(255,255,255,.04);
  }
  .searchbar input,.searchbar select{
    appearance:none; border:none; outline:none; width:100%;
    background:rgba(255,255,255,.02); color:var(--ink);
    padding:12px 14px; border-radius:12px;
    box-shadow:inset 0 0 0 1px rgba(255,255,255,.07);
  }
  .searchbar input::placeholder{color:#9aa3d6}
  .btn{
    border:none; border-radius:12px; padding:12px 14px; font-weight:700; cursor:pointer;
    background:var(--brand); color:white; transition:transform .15s ease, filter .15s ease;
  }
  .btn:hover{transform:translateY(-1px); filter:brightness(1.07)}
  .searchbar input:focus,.searchbar select:focus{box-shadow:inset 0 0 0 3px var(--ring)}

  /* grid */
  .grid{margin-top:26px; display:grid; grid-template-columns:repeat(4,1fr); gap:20px}
  @media (max-width:1100px){ .grid{grid-template-columns:repeat(3,1fr)} }
  @media (max-width:820px){ .grid{grid-template-columns:repeat(2,1fr)} }
  @media (max-width:540px){ .grid{grid-template-columns:1fr} .searchbar{grid-template-columns:1fr 1fr; } .searchbar .btn{grid-column:1/-1} }

  /* shot card */
  a.card{display:block; text-decoration:none; color:inherit}
  .shot{
    background:linear-gradient(180deg,var(--surface),var(--surface-2));
    border-radius:18px; overflow:hidden; box-shadow:var(--shadow);
    transition:transform .18s ease, box-shadow .18s ease;
  }
  .shot:hover{transform:translateY(-4px)}
  .shot-media{position:relative; aspect-ratio: 4/3; background:#172058;}
  .shot-media img{position:absolute; inset:0; width:100%; height:100%; object-fit:cover; display:block}
  .overlay{
    position:absolute; inset:auto 0 0 0; padding:12px 12px 10px; background:linear-gradient(180deg,transparent 0%,rgba(8,10,26,.55) 35%,rgba(8,10,26,.92) 100%);
    opacity:0; transform:translateY(10px); transition:all .18s ease;
  }
  .shot:hover .overlay{opacity:1; transform:translateY(0)}
  .overlay-title{font-weight:800; font-size:16px; margin:0 0 6px 0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis}
  .overlay-tags{display:flex; flex-wrap:wrap; gap:6px}
  .chip{background:var(--chip); color:#cfd5ff; font-size:12px; padding:6px 10px; border-radius:999px}
  .shot-foot{display:flex; align-items:center; justify-content:space-between; gap:8px; padding:12px 12px 14px}
  .title{font-weight:800; font-size:16px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis}
  .stats{display:flex; gap:14px; color:#b7bff2; font-size:12px}
  .stats svg{width:16px; height:16px; opacity:.9; vertical-align:-2px}

  /* pagination */
  .pager{display:flex; justify-content:center; margin:28px 0 6px; gap:8px}
  .pager .page-link{display:inline-block; padding:10px 14px; border-radius:12px; background:var(--surface); color:var(--ink); text-decoration:none}
  .pager .page-link.active{background:var(--brand)}
</style>

<div class="wrap">
  <div class="hero">
    <h1>Projects</h1>
    <p>Inspirational builds and experiments. Browse the shots below.</p>
  </div>

  <form class="searchbar">
    <input name="q" placeholder="Search title" value="{{ $filters['q'] }}">
    <select name="category">
      <option value="">All categories</option>
      @foreach($categories as $c)
        <option value="{{ $c }}" @selected($filters['category']===$c)>{{ $c }}</option>
      @endforeach
    </select>
    <select name="tech">
      <option value="">All tech</option>
      @foreach($tech as $t)
        <option value="{{ $t }}" @selected($filters['tech']===$t)>{{ $t }}</option>
      @endforeach
    </select>
    <button class="btn" type="submit">Filter</button>
  </form>

  <div class="grid">
    @forelse($projects as $p)
      @php $img = $p->image_path ? asset('storage/'.$p->image_path) : null; @endphp
      <a class="card" href="{{ route('projects.show',$p->slug) }}">
        <div class="shot">
          <div class="shot-media">
            @if($img)
              <img src="{{ $img }}" alt="{{ $p->title }}" loading="lazy">
            @endif
            <div class="overlay">
              <div class="overlay-title">{{ $p->title }}</div>
              <div class="overlay-tags">
                @foreach($p->techTags as $tag)
                  <span class="chip">{{ $tag->name }}</span>
                @endforeach
              </div>
            </div>
          </div>
          <div class="shot-foot">
            <div class="title">{{ $p->title }}</div>
            <div class="stats">
              <span title="Views">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 5c5.5 0 9.5 5.2 9.9 5.8a1 1 0 0 1 0 1.3C21.5 12.8 17.5 18 12 18s-9.5-5.2-9.9-5.8a1 1 0 0 1 0-1.3C2.5 10.2 6.5 5 12 5zm0 3a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/></svg> 1.2k
              </span>
              <span title="Likes">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.1 21.4 4.3 13.6a5.5 5.5 0 0 1 7.8-7.8l.9.9.9-.9a5.5 5.5 0 1 1 7.8 7.8l-7.8 7.8a1 1 0 0 1-1.4 0z"/></svg> 320
              </span>
            </div>
          </div>
        </div>
      </a>
    @empty
      <p style="color:var(--muted)">No projects found</p>
    @endforelse
  </div>

  @if ($projects->hasPages())
    <div class="pager">
      @if ($projects->onFirstPage())
        <span class="page-link" aria-disabled="true">Prev</span>
      @else
        <a class="page-link" href="{{ $projects->previousPageUrl() }}" rel="prev">Prev</a>
      @endif

      @php
        $start = max(1, $projects->currentPage() - 2);
        $end   = min($projects->lastPage(), $projects->currentPage() + 2);
      @endphp
      @for ($i = $start; $i <= $end; $i++)
        @if ($i === $projects->currentPage())
          <span class="page-link active">{{ $i }}</span>
        @else
          <a class="page-link" href="{{ $projects->url($i) }}">{{ $i }}</a>
        @endif
      @endfor

      @if ($projects->hasMorePages())
        <a class="page-link" href="{{ $projects->nextPageUrl() }}" rel="next">Next</a>
      @else
        <span class="page-link" aria-disabled="true">Next</span>
      @endif
    </div>
  @endif
</div>
@endsection
