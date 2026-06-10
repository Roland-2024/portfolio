@extends('admin.layout')
@section('title', $item->exists ? 'Edit Skill' : 'Add Skill')
@section('content')
<div class="page-head"><h2>{{ $item->exists ? 'Edit Skill' : 'Add Skill' }}</h2></div>
<form class="card" method="POST" action="{{ $item->exists ? route('admin.skills.update', $item) : route('admin.skills.store') }}">@csrf @if($item->exists) @method('PUT') @endif
<div class="form-grid"><label>Category<input name="category" value="{{ old('category', $item->category) }}" required></label><label>Skill name<input name="name" value="{{ old('name', $item->name) }}" required></label><label>Sort order<input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" required></label></div>
<div class="form-actions"><button class="btn">Save</button><a class="btn secondary" href="{{ route('admin.skills.index') }}">Cancel</a></div></form>
@endsection
