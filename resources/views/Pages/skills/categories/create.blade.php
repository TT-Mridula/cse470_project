@extends('layouts.admin')
@section('content')
<h1 class="mb-3">Create Category</h1>
<form method="post" action="{{ route('admin.skill_categories.store') }}">
  @include('Pages.skills.categories.form', ['cat' => null])
</form>
@endsection
