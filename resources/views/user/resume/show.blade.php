@extends('layouts.app')

@section('content')
<div class="resume-hero">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between gap-3">
      <div>
        <h1 class="h3 mb-1">{{ optional($resume)->title ?? 'My Resume' }}</h1>
        <div class="text-muted small">
          @if($resume)
            Updated {{ $resume->updated_at->diffForHumans() }}
          @else
            No resume saved yet
          @endif
        </div>
      </div>

      <div class="d-flex gap-2">
        <a href="{{ route('me.resume.edit') }}" class="btn btn-primary">
          <i class="bi bi-pencil"></i> Edit
        </a>
        <button class="btn btn-outline-light" id="btnPrint">
          <i class="bi bi-printer"></i> Print
        </button>
      </div>
    </div>
  </div>
</div>

<div class="container my-4">
  <div class="row justify-content-center">
    <div class="col-lg-9">

      @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
      @endif

      @if(!$resume)
        <div class="card shadow-sm border-0">
          <div class="card-body p-4">
            <p class="mb-3">You have not created a resume yet.</p>
            <a class="btn btn-primary" href="{{ route('me.resume.edit') }}">Create resume</a>
          </div>
        </div>
      @else
        <div class="card shadow-sm border-0">
          <div class="card-body p-4 resume-content">
            {!! nl2br(e($resume->content)) !!}
          </div>
        </div>
      @endif

    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .resume-hero{
    background: linear-gradient(135deg,#201f36 0%,#2c2950 50%,#1b1a2d 100%);
    color:#fff;
    padding: 18px 0;
    border-bottom: 1px solid rgba(255,255,255,.08);
  }
  .resume-content{
    white-space: pre-wrap;
    line-height: 1.65;
    font-size: 1.02rem;
  }
  /* print polish */
  @media print{
    nav, .resume-hero, .btn, .alert{ display:none !important; }
    .container{ max-width: 100% !important; }
    .card, .card-body{ border:0; box-shadow:none; padding:0; }
    .resume-content{ font-size: 12pt; }
  }
</style>
@endpush

@push('scripts')
<script>
  document.getElementById('btnPrint')?.addEventListener('click', ()=>window.print());
</script>
@endpush
