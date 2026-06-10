@extends('admin.layout')
@section('title', $item->exists ? 'Edit Experience' : 'Add Experience')
@section('content')
<div class="page-head"><h2>{{ $item->exists ? 'Edit Experience' : 'Add Experience' }}</h2></div>
<form class="card" method="POST" action="{{ $item->exists ? route('admin.experiences.update', $item) : route('admin.experiences.store') }}">@csrf @if($item->exists) @method('PUT') @endif
<div class="form-grid">
<label>Role<input name="role" value="{{ old('role', $item->role) }}" required></label><label>Company<input name="company" value="{{ old('company', $item->company) }}" required></label>
<label>Location<input name="location" value="{{ old('location', $item->location) }}"></label><label>Sort order<input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" required></label>
<label>Start date<input type="date" name="start_date" value="{{ old('start_date', $item->start_date?->format('Y-m-d')) }}"></label><label>End date<input type="date" name="end_date" value="{{ old('end_date', $item->end_date?->format('Y-m-d')) }}"></label>
<label class="check"><input type="checkbox" name="is_current" value="1" @checked(old('is_current', $item->is_current))> Current position</label><label class="wide">Description<textarea name="description" required>{{ old('description', $item->description) }}</textarea></label>
</div><div class="form-actions"><button class="btn">Save</button><a class="btn secondary" href="{{ route('admin.experiences.index') }}">Cancel</a></div></form>
@endsection
