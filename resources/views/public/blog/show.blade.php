@extends('layouts.app')
@section('content')
<div class="container py-4">
  <div class="mb-3">
    <a href="{{ route('blog.index') }}" class="text-decoration-none">&larr; Back to blog</a>
  </div>

  <h1 class="mb-1">{{ $post->title }}</h1>
  <div class="text-muted mb-3">
    {{ $post->category?->name }} — {{ $post->published_at?->format('M d, Y') }}
  </div>

  @if($post->image_path)
    <img src="{{ asset('storage/'.$post->image_path) }}" class="img-fluid rounded mb-3" alt="">
  @endif

  <article class="fs-5">
    {!! $post->body !!}
  </article>

  @if($related->count())
  <hr>
  <h5 class="mt-4">Related</h5>
  <ul>
    @foreach($related as $r)
      <li><a href="{{ route('blog.show',$r->slug) }}">{{ $r->title }}</a></li>
    @endforeach
  </ul>
  @endif
</div>
@endsection
