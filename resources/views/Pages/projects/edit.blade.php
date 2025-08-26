@extends('layouts.admin')

@section('content')
<h1 class="mb-3">Edit Project</h1>

<form method="post" action="{{ route('admin.projects.update',$project) }}" enctype="multipart/form-data">
  @method('PUT')
  @include('Pages.projects.form')
</form>
@endsection
