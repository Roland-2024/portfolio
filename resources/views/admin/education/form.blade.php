@extends('admin.layout')
@section('title', $item->exists ? 'Edit Education' : 'Add Education')
@section('content')
<div class="page-head"><h2>{{ $item->exists ? 'Edit Education' : 'Add Education' }}</h2></div>
<form class="card" method="POST" action="{{ $item->exists ? route('admin.education.update', $item) : route('admin.education.store') }}">@csrf @if($item->exists) @method('PUT') @endif
<div class="form-grid"><label>Qualification<input name="qualification" value="{{ old('qualification', $item->qualification) }}" required></label><label>Institution<input name="institution" value="{{ old('institution', $item->institution) }}" required></label><label>Start year<input type="number" name="start_year" value="{{ old('start_year', $item->start_year) }}"></label><label>End year<input type="number" name="end_year" value="{{ old('end_year', $item->end_year) }}"></label><label>Sort order<input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" required></label><label class="wide">Description<textarea name="description">{{ old('description', $item->description) }}</textarea></label></div>
<div class="form-actions"><button class="btn">Save</button><a class="btn secondary" href="{{ route('admin.education.index') }}">Cancel</a></div></form>
@endsection
