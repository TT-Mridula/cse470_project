@extends('layouts.admin')

@section('content')
<h1 class="mb-3">Create Project</h1>

<form method="post" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
  @include('Pages.projects.form')
</form>
@endsection
