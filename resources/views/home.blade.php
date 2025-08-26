@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('content')
<section id="projects" class="home-section">
  <div class="section-head">
    <h2>Latest projects</h2>
    <a href="{{ route('projects.index') }}" class="see-all">See all</a>
  </div>

  @if(($projects ?? collect())->count())
    <div class="card-grid">
      @foreach($projects as $p)
        <a class="card" href="{{ route('projects.show', $p->slug) }}">
          @php $img = $p->image_path ? asset('storage/'.$p->image_path) : asset('images/placeholder-project.jpg'); @endphp
          <div class="thumb"><img src="{{ $img }}" alt="{{ $p->title }}"></div>
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
</section>

<section id="skills" class="home-section">
  <div class="section-head">
    <h2>Skills</h2>
    <a href="{{ url('/skills') }}" class="see-all">View full list</a>
  </div>

  @foreach(($skillCategories ?? collect()) as $cat)
    @if($cat->skills->count())
      <div class="cat">
        <h3>{{ $cat->name }}</h3>
        <div class="skills-grid">
          @foreach($cat->skills as $s)
            <div class="skill">
              <div class="skill-top">
                <span class="name">
                  @if($s->icon_class)<i class="{{ $s->icon_class }}"></i>@endif
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
</section>

<style>
  :root{--ink:#eef2ff;--muted:#a7b0d8;--glass:#121632;--glass2:#161a3e;--chip:#23285e;--brand:#7c5cff}
  .home-section{max-width:1100px;margin:40px auto 0;padding:0 16px}
  .section-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
  .section-head h2{margin:0;font-size:28px}
  .see-all{font-size:14px;opacity:.9;padding:6px 10px;border-radius:10px;background:rgba(255,255,255,.06)}
  .see-all:hover{opacity:1}

  .card-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
  @media (max-width:980px){.card-grid{grid-template-columns:repeat(2,1fr)}}
  @media (max-width:640px){.card-grid{grid-template-columns:1fr}}
  .card{background:linear-gradient(180deg,var(--glass),var(--glass2));border-radius:14px;overflow:hidden;display:flex;flex-direction:column}
  .thumb{aspect-ratio:16/10;overflow:hidden}
  .thumb img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .4s}
  .card:hover .thumb img{transform:scale(1.05)}
  .card-body{padding:12px}
  .card-body h3{margin:0 0 6px;font-size:18px}
  .muted{color:var(--muted);margin:0 0 10px;font-size:14px}
  .tags{display:flex;gap:8px;flex-wrap:wrap}
  .tag{background:var(--chip);padding:4px 8px;border-radius:999px;font-size:12px}

  .cat{background:linear-gradient(180deg,var(--glass),var(--glass2));border-radius:14px;padding:14px;margin-bottom:12px}
  .cat h3{margin:0 0 8px;font-size:16px;color:#cfd5ff}
  .skills-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
  @media (max-width:640px){.skills-grid{grid-template-columns:1fr}}
  .skill{background:rgba(255,255,255,.03);border-radius:10px;padding:10px}
  .skill-top{display:flex;align-items:center;justify-content:space-between}
  .skill .name i{margin-right:6px;color:#b8c0ff}
  .skill .lvl{color:#cbd2ff;font-size:12px}
  .bar{height:10px;background:#23285e;border-radius:999px;margin-top:8px;overflow:hidden}
  .fill{height:100%;background:linear-gradient(90deg,#6d5cff,#8f7bff)}
</style>
@endsection
