@extends('admin.layout')
@section('title', $item->exists ? 'Edit Project' : 'Add Project')
@section('content')
<div class="page-head"><h2>{{ $item->exists ? 'Edit Project' : 'Add Project' }}</h2></div>
<form class="card" method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.projects.update', $item) : route('admin.projects.store') }}">@csrf @if($item->exists) @method('PUT') @endif
<div class="form-grid">
<label>Title<input name="title" value="{{ old('title', $item->title) }}" required></label><label>Category<input name="category" value="{{ old('category', $item->category) }}" required></label>
<label>Project URL<input name="url" value="{{ old('url', $item->url) }}" placeholder="https://... or mailto:..."></label><label>Color<select name="color">@foreach(['blue','orange','green','purple'] as $color)<option value="{{ $color }}" @selected(old('color', $item->color ?? 'blue') === $color)>{{ ucfirst($color) }}</option>@endforeach</select></label>
<label>Sort order<input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" required></label><label>Project image<input type="file" name="image_upload" accept="image/*"></label>
<label class="check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $item->exists ? $item->is_published : true))> Published</label><label class="wide">Description<textarea name="description" required>{{ old('description', $item->description) }}</textarea></label>
</div><div class="form-actions"><button class="btn">Save</button><a class="btn secondary" href="{{ route('admin.projects.index') }}">Cancel</a></div></form>
@endsection
