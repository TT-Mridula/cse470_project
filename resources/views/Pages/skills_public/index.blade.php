@extends('layouts.app')

@section('content')
<style>
  :root{
    --bg:#0f1221; --ink:#eef2ff; --muted:#a7b0d8;
    --surface:#121632; --surface-2:#161a3e; --brand:#7c5cff;
  }
  .skills-wrap{max-width:1100px; margin:0 auto; padding:24px 8px}
  .skills-hero{margin-bottom:18px}
  .skills-hero h1{font-size:42px; margin:0}
  .skills-hero p{color:var(--muted); margin:6px 0 0}

  .cat{margin:18px 0; background:linear-gradient(180deg,var(--surface),var(--surface-2)); border-radius:14px; padding:16px 16px 6px}
  .cat h2{font-size:18px; margin:0 0 8px 0; color:#cfd5ff}
  .grid{display:grid; grid-template-columns:repeat(2,1fr); gap:12px}
  @media (max-width:700px){ .grid{grid-template-columns:1fr} }

  .item{background:rgba(255,255,255,.02); border-radius:12px; padding:12px}
  .top{display:flex; justify-content:space-between; align-items:center; gap:8px}
  .name{font-weight:700}
  .level{color:#cbd2ff; font-size:12px}
  .bar{margin-top:8px; height:10px; border-radius:999px; background:#23285e; overflow:hidden}
  .fill{height:100%; border-radius:999px; background:linear-gradient(90deg,#6d5cff,#8f7bff)}
  .icon{opacity:.9; color:#aeb7ff}
</style>

<div class="skills-wrap">
  <div class="skills-hero">
    <h1>Skills</h1>
    <p>What I use most often, grouped by category.</p>
  </div>

  @foreach($categories as $cat)
    @if($cat->skills->count())
    <section class="cat">
      <h2>{{ $cat->name }}</h2>
      <div class="grid">
        @foreach($cat->skills as $s)
          <div class="item">
            <div class="top">
              <div class="name">
                @if($s->icon_class)
                  <i class="{{ $s->icon_class }} icon"></i>
                @endif
                {{ $s->name }}
              </div>
              <div class="level">{{ $s->level }}%</div>
            </div>
            <div class="bar"><div class="fill" style="width: {{ $s->level }}%"></div></div>
          </div>
        @endforeach
      </div>
    </section>
    @endif
  @endforeach
</div>
@endsection
