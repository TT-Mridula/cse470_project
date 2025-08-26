@extends('layouts.admin')
@section('content')
<h1 class="mb-3">Edit Skill</h1>
<form method="post" action="{{ route('admin.skills.update',$skill) }}">
  @method('PUT')
  @include('Pages.skills.items.form', ['skill' => $skill, 'categories' => $categories])
</form>
@endsection
