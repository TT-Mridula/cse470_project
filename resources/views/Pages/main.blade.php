@extends('layouts.admin')

@section('content')
{{-- Local styles (move to app.css later if you prefer) --}}
<style>
  :root{
    --brand:#111827;          /* dark navy */
    --brand-2:#1f2937;        /* slightly lighter */
    --accent:#6366f1;         /* indigo */
    --muted:#6b7280;
    --ring:rgba(99,102,241,.35);
    --surface:#ffffff;
    --surface-2:#f8fafc;
    --border:#e5e7eb;
  }

  .page-head{
    display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem
  }
  .page-dot{width:.5rem;height:.5rem;border-radius:9999px;background:var(--accent)}
  .page-title{font-weight:700;letter-spacing:.2px;color:var(--brand)}
  .page-sub{color:var(--muted)}

  .grid-2{display:grid;grid-template-columns:1fr 1.15fr;gap:1.25rem}
  @media (max-width: 992px){.grid-2{grid-template-columns:1fr}}

  .cardx{
    background:var(--surface);border:1px solid var(--border);
    border-radius:18px;box-shadow:0 10px 24px rgba(17,24,39,.06);
  }
  .cardx .cardx-head{
    padding:1rem 1.25rem;border-bottom:1px solid var(--border);
    display:flex;align-items:center;gap:.75rem
  }
  .cardx .cardx-body{padding:1.25rem}

  /* hero preview + dropzone */
  .hero-wrap{position:relative;border-radius:16px;overflow:hidden;border:1px solid var(--border);background:var(--surface-2)}
  .hero-img{display:block;width:100%;height:320px;object-fit:cover;background:linear-gradient(180deg,#f9fafb,#eef2ff)}
  .hero-empty{
    display:grid;place-items:center;height:320px;color:var(--muted);font-weight:600;
    background:repeating-linear-gradient(-45deg,#fafafa,#fafafa 10px,#f3f4f6 10px,#f3f4f6 20px)
  }
  .hero-overlay{
    position:absolute;inset:auto 0 0 0;display:flex;gap:.5rem;justify-content:flex-end;
    padding:.5rem .5rem;background:linear-gradient(to top,rgba(0,0,0,.5),transparent);
  }
  .btn-ghost{
    color:#fff;border:1px solid rgba(255,255,255,.35);background:rgba(255,255,255,.08);
    padding:.35rem .65rem;border-radius:10px;font-weight:600;backdrop-filter:blur(4px)
  }
  .btn-ghost:hover{background:rgba(255,255,255,.18)}

  .dropzone{
    border:1.5px dashed var(--border);border-radius:14px;background:var(--surface-2);
    padding:1rem;display:flex;align-items:center;gap:.75rem;cursor:pointer;
    transition:all .15s ease;border-color:var(--border);
  }
  .dropzone:hover{border-color:var(--accent);box-shadow:0 0 0 4px var(--ring)}
  .dropzone.dragover{border-color:var(--accent);background:#eef2ff}
  .chip{
    display:inline-flex;align-items:center;gap:.4rem;
    background:#eef2ff;color:#3730a3;border:1px solid #c7d2fe;
    padding:.35rem .6rem;border-radius:9999px;font-weight:600
  }

  .form-floating>.form-control:focus{border-color:var(--accent);box-shadow:0 0 0 .2rem var(--ring)}
  .sticky-save{
    position:sticky;bottom:0;background:linear-gradient(180deg,transparent,rgba(255,255,255,.9) 30%, #fff);
    padding:1rem 0 .25rem;border-top:1px solid var(--border);margin-top:1rem
  }
  .btn-primary{
    background:var(--accent);border-color:var(--accent);font-weight:700;border-radius:12px;padding:.65rem 1.2rem
  }
  .btn-primary:hover{filter:brightness(.95)}
</style>

<div class="container-fluid px-4">

  {{-- Header --}}
  <div class="page-head">
    <span class="page-dot"></span>
    <div>
      <div class="page-title h3 m-0">Resume</div>
      <div class="page-sub">Hero background, headline, and resume</div>
    </div>
  </div>

  {{-- Breadcrumbs --}}
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Resume</li>
  </ol>

  {{-- Flash + errors --}}
  @if (session('success'))
    <div class="alert alert-success shadow-sm border-0">{{ session('success') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm">
      <strong>There were some problems with your submission.</strong>
      <ul class="mb-0 mt-1">
        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.main.update') }}" method="POST" enctype="multipart/form-data" id="mainForm">
    @csrf
    @method('PUT')

    <div class="grid-2">
      {{-- LEFT: Image --}}
      <section class="cardx">
        <div class="cardx-head">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" stroke="#111827" stroke-width="1.5"/><path d="M3 16.5 9 11l4 3 4-3 4 3.5" stroke="#111827" stroke-width="1.5" stroke-linecap="round"/></svg>
          <strong>Background Image</strong>
        </div>
        <div class="cardx-body">

          <div class="hero-wrap mb-3">
            @if (!empty($main?->bc_img))
              <img id="heroPreview" class="hero-img" src="{{ Storage::url($main->bc_img) }}" alt="Background Image">
            @else
              <div id="heroEmpty" class="hero-empty">No image uploaded</div>
              <img id="heroPreview" class="hero-img d-none" alt="Background Image">
            @endif

            <div class="hero-overlay">
              <button type="button" class="btn-ghost" id="selectHeroBtn">Replace</button>
              @if (!empty($main?->bc_img))
                <a class="btn-ghost" href="{{ Storage::url($main->bc_img) }}" target="_blank" rel="noopener">Open</a>
              @endif
            </div>
          </div>

          <input class="d-none" type="file" id="bc_img" name="bc_img" accept="image/*">

          <label for="bc_img" class="dropzone" id="heroDrop">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="#4f46e5" stroke-width="2" stroke-linecap="round"/></svg>
            <div>
              <div class="fw-semibold">Drag & drop an image, or click to browse</div>
              <div class="small text-muted">JPG, PNG, or WebP (max 4MB)</div>
            </div>
          </label>

        </div>
      </section>

      {{-- RIGHT: Text + resume --}}
      <section class="cardx">
        <div class="cardx-head">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M5 4h14a1 1 0 0 1 1 1v14l-4-3-4 3-4-3-4 3V5a1 1 0 0 1 1-1Z" stroke="#111827" stroke-width="1.5"/></svg>
          <strong>Headline & Resume</strong>
        </div>
        <div class="cardx-body">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label fw-semibold">Title</label>
              <input type="text" name="title" class="form-control" value="{{ old('title', $main->title ?? '') }}" placeholder="Build Your Career">
              @error('title') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Sub Title</label>
              <input type="text" name="sub_title" class="form-control" value="{{ old('sub_title', $main->sub_title ?? '') }}" placeholder="Learn. Grow. Achieve.">
              @error('sub_title') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Upload Resume (PDF)</label>
              <div class="d-flex align-items-center gap-2 flex-wrap">
                @if (!empty($main?->resume))
                  <a class="chip" href="{{ Storage::url($main->resume) }}" target="_blank" rel="noopener">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M6 21h12a1 1 0 0 0 1-1V9l-6-6H7a1 1 0 0 0-1 1v6" stroke="#3730a3" stroke-width="1.6"/><path d="M14 3v6h6" stroke="#3730a3" stroke-width="1.6"/></svg>
                    Download resume
                  </a>
                @endif

                <input class="form-control" type="file" id="resume" name="resume" accept="application/pdf" style="max-width:340px">
                <span id="resumeName" class="text-muted small"></span>
              </div>
              @error('resume') <small class="text-danger d-block">{{ $message }}</small> @enderror
            </div>
          </div>
        </div>
      </section>
    </div>

    <div class="sticky-save">
      <button type="submit" class="btn btn-primary shadow-sm">
        Save changes
      </button>
    </div>
  </form>
</div>

{{-- Lightweight JS for preview & drag/drop --}}
<script>
  const heroInput   = document.getElementById('bc_img');
  const heroPreview = document.getElementById('heroPreview');
  const heroEmpty   = document.getElementById('heroEmpty');
  const heroDrop    = document.getElementById('heroDrop');
  const selectHero  = document.getElementById('selectHeroBtn');
  const resumeInput = document.getElementById('resume');
  const resumeName  = document.getElementById('resumeName');

  // Click helpers
  selectHero?.addEventListener('click', () => heroInput.click());
  heroDrop?.addEventListener('click', () => heroInput.click());

  // Show selected resume name
  resumeInput?.addEventListener('change', () => {
    resumeName.textContent = resumeInput.files?.[0]?.name ?? '';
  });

  // Live hero preview
  heroInput?.addEventListener('change', () => {
    const file = heroInput.files?.[0];
    if(!file) return;
    const reader = new FileReader();
    reader.onload = e => {
      heroPreview.src = e.target.result;
      heroPreview.classList.remove('d-none');
      if(heroEmpty) heroEmpty.classList.add('d-none');
    };
    reader.readAsDataURL(file);
  });

  // Drag & drop for hero
  ['dragenter','dragover','dragleave','drop'].forEach(evt => {
    heroDrop?.addEventListener(evt, e => { e.preventDefault(); e.stopPropagation(); }, false);
  });
  ['dragenter','dragover'].forEach(evt => {
    heroDrop?.addEventListener(evt, () => heroDrop.classList.add('dragover'), false);
  });
  ['dragleave','drop'].forEach(evt => {
    heroDrop?.addEventListener(evt, () => heroDrop.classList.remove('dragover'), false);
  });
  heroDrop?.addEventListener('drop', e => {
    const dt = e.dataTransfer;
    if(!dt || !dt.files?.length) return;
    heroInput.files = dt.files;
    heroInput.dispatchEvent(new Event('change'));
  });
</script>
@endsection
