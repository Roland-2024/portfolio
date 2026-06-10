@extends('admin.layout')
@section('title', 'Education')
@section('content')
<div class="page-head"><h2>Education</h2><a class="btn" href="{{ route('admin.education.create') }}">Add education</a></div>
<div class="card table-wrap"><table class="data-table"><thead><tr><th>Qualification</th><th>Institution</th><th>Dates</th><th></th></tr></thead><tbody>
@foreach($items as $item)<tr><td>{{ $item->qualification }}</td><td>{{ $item->institution }}</td><td>{{ $item->date_range }}</td><td class="actions"><a class="btn secondary" href="{{ route('admin.education.edit', $item) }}">Edit</a><form method="POST" action="{{ route('admin.education.destroy', $item) }}" onsubmit="return confirm('Delete this education entry?')">@csrf @method('DELETE')<button class="btn danger">Delete</button></form></td></tr>@endforeach
</tbody></table></div>
@endsection
