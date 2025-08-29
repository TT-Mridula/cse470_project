@extends('layouts.app')

@section('content')
<div class="resume-hero">
  <div class="container d-flex align-items-center justify-content-between">
    <h1 class="h3 mb-0">Edit resume</h1>
    <a href="{{ route('me.resume.show') }}" class="btn btn-outline-light">Back</a>
  </div>
</div>

<div class="container my-4">
  <div class="row justify-content-center">
    <div class="col-lg-10">

      <form method="POST" action="{{ route('me.resume.update') }}">
        @csrf
        @method('PUT')

        @if($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
          </div>
        @endif

        <div class="card border-0 shadow-sm mb-3">
          <div class="card-body p-4">
            <div class="mb-3">
              <label class="form-label">Title</label>
              <input name="title" class="form-control form-control-lg"
                     value="{{ old('title', optional($resume)->title ?? 'My Resume') }}" required>
            </div>

            <div class="d-flex align-items-center justify-content-between">
              <label class="form-label mb-2">Content</label>
              <div class="text-muted small">
                <span id="charCount">0</span> chars
              </div>
            </div>

            <div class="row g-3">
              <div class="col-lg-6">
                <textarea id="resumeText" name="content" rows="18" class="form-control"
                          placeholder="Paste or type your resume here...">{{ old('content', optional($resume)->content) }}</textarea>
                <div class="form-text">
                  Plain text works great. New lines are preserved.
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card h-100 border">
                  <div class="card-header py-2 bg-light">
                    <strong>Preview</strong>
                  </div>
                  <div class="card-body">
                    <div id="preview" class="resume-content small"></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="mt-4 d-flex gap-2">
              <button class="btn btn-primary">Save</button>
              <button type="button" class="btn btn-outline-secondary" id="btnPrintEdit">Print</button>
            </div>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .resume-hero{
    background: linear-gradient(135deg,#201f36 0%,#2c2950 50%,#1b1a2d 100%);
    color:#fff; padding:18px 0; border-bottom:1px solid rgba(255,255,255,.08);
  }
  .resume-content{ white-space: pre-wrap; line-height:1.65; }
  textarea#resumeText{ font-family: ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace; }
  @media print{
    .resume-hero, nav, .btn, .form-text{ display:none!important; }
  }
</style>
@endpush

@push('scripts')
<script>
  const textarea = document.getElementById('resumeText');
  const preview  = document.getElementById('preview');
  const counter  = document.getElementById('charCount');

  function render(){
    preview.textContent = textarea.value;
    counter.textContent = textarea.value.length;
    // auto-grow
    textarea.style.height = 'auto';
    textarea.style.height = Math.min(textarea.scrollHeight, 1200) + 'px';
  }
  textarea?.addEventListener('input', render);
  window.addEventListener('load', render);

  document.getElementById('btnPrintEdit')?.addEventListener('click', ()=>window.print());
</script>
@endpush
