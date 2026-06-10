@extends('admin.layout')
@section('title', 'Experience')
@section('content')
<div class="page-head"><h2>Professional Experience</h2><a class="btn" href="{{ route('admin.experiences.create') }}">Add experience</a></div>
<div class="card table-wrap"><table class="data-table"><thead><tr><th>Role</th><th>Company</th><th>Dates</th><th></th></tr></thead><tbody>
@foreach($items as $item)<tr><td>{{ $item->role }}</td><td>{{ $item->company }}</td><td>{{ $item->date_range }}</td><td class="actions"><a class="btn secondary" href="{{ route('admin.experiences.edit', $item) }}">Edit</a><form method="POST" action="{{ route('admin.experiences.destroy', $item) }}" onsubmit="return confirm('Delete this experience?')">@csrf @method('DELETE')<button class="btn danger">Delete</button></form></td></tr>@endforeach
</tbody></table></div>
@endsection
