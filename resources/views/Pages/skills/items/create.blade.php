@extends('layouts.admin')
@section('content')
<h1 class="mb-3">Create Skill</h1>
<form method="post" action="{{ route('admin.skills.store') }}">
  @include('Pages.skills.items.form', ['skill' => null, 'categories' => $categories])
</form>
@endsection
