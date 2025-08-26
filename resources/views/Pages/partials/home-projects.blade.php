@php use Illuminate\Support\Str; @endphp

<section id="projects" class="home-section">
  <div class="section-head">
    <h2>Latest projects</h2>
    <a href="{{ route('projects.index') }}" class="see-all">See all</a>
  </div>

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
</section>
