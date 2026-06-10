@extends('admin.layout')
@section('title', $item->exists ? 'Edit Social Link' : 'Add Social Link')
@section('content')
<div class="page-head"><h2>{{ $item->exists ? 'Edit Social Link' : 'Add Social Link' }}</h2></div>
<form class="card" method="POST" action="{{ $item->exists ? route('admin.social-links.update', $item) : route('admin.social-links.store') }}">@csrf @if($item->exists) @method('PUT') @endif
<div class="form-grid"><label>Platform key<input name="platform" value="{{ old('platform', $item->platform) }}" required placeholder="github"></label><label>Display label<input name="label" value="{{ old('label', $item->label) }}" required></label><label class="wide">URL<input name="url" value="{{ old('url', $item->url) }}" required></label><label>Sort order<input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" required></label><label class="check"><input type="checkbox" name="is_visible" value="1" @checked(old('is_visible', $item->exists ? $item->is_visible : true))> Visible</label></div>
<div class="form-actions"><button class="btn">Save</button><a class="btn secondary" href="{{ route('admin.social-links.index') }}">Cancel</a></div></form>
@endsection
