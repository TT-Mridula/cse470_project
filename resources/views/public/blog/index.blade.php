@extends('layouts.app')
@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 m-0">Blog</h1>
    <form class="d-flex" method="get">
      <input name="q" value="{{ $filters['q'] }}" class="form-control me-2" placeholder="Search title...">
      <select name="cat" class="form-select me-2" style="max-width:220px">
        <option value="">All categories</option>
        @foreach($categories as $c)
          <option value="{{ $c->slug }}" @selected($filters['cat']==$c->slug)>{{ $c->name }}</option>
        @endforeach
      </select>
      <button class="btn btn-primary">Filter</button>
    </form>
  </div>

  <div class="row g-3">
    @forelse($posts as $p)
      <div class="col-md-4">
        <a class="card h-100 text-decoration-none text-dark" href="{{ route('blog.show',$p->slug) }}">
          @if($p->image_path)
            <img src="{{ asset('storage/'.$p->image_path) }}" class="card-img-top" alt="">
          @endif
          <div class="card-body">
            <div class="small text-muted mb-1">{{ $p->category?->name }} {{ $p->published_at?->format('M d, Y') }}</div>
            <h5 class="card-title">{{ $p->title }}</h5>
            <p class="card-text text-muted">{{ $p->excerpt }}</p>
          </div>
        </a>
      </div>
    @empty
      <p class="text-muted">No posts yet.</p>
    @endforelse
  </div>

  <div class="mt-3">{{ $posts->links() }}</div>
</div>
@endsection
