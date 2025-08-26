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
