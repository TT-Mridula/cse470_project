@extends('layouts.admin')
@section('content')
<h1 class="mb-3">Edit Category</h1>
<form method="post" action="{{ route('admin.skill_categories.update',$cat) }}">
  @method('PUT')
  @include('Pages.skills.categories.form', ['cat' => $cat])
</form>
@endsection
