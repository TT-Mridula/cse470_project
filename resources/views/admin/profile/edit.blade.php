@extends('layouts.admin')

@section('title','Edit Profile')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Profile</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $profile->name) }}" required>
          @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Bio</label>
          <textarea name="bio" class="form-control" rows="4">{{ old('bio', $profile->bio) }}</textarea>
          @error('bio') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $profile->email) }}">
            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile->phone) }}">
            @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label d-block">Avatar</label>
          <input type="file" name="avatar" class="form-control" accept="image/*">
          @error('avatar') <div class="text-danger small">{{ $message }}</div> @enderror

          @if($profile->avatar_url ?? false)
            <img src="{{ $profile->avatar_url }}" alt="avatar" class="mt-2 rounded" style="height:90px;">
          @endif
        </div>

        <button class="btn btn-primary">Save</button>
      </form>
    </div>
  </div>
</div>
@endsection
