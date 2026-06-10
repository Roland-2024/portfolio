@extends('admin.layout')
@section('title', 'Skills')
@section('content')
<div class="page-head"><div><h2>Skills</h2><p class="muted">Grouped by category on the public portfolio.</p></div><a class="btn" href="{{ route('admin.skills.create') }}">Add skill</a></div>
<div class="card table-wrap"><table class="data-table"><thead><tr><th>Category</th><th>Name</th><th>Order</th><th></th></tr></thead><tbody>
@foreach($items as $item)<tr><td>{{ $item->category }}</td><td>{{ $item->name }}</td><td>{{ $item->sort_order }}</td><td class="actions"><a class="btn secondary" href="{{ route('admin.skills.edit', $item) }}">Edit</a><form method="POST" action="{{ route('admin.skills.destroy', $item) }}" onsubmit="return confirm('Delete this skill?')">@csrf @method('DELETE')<button class="btn danger">Delete</button></form></td></tr>@endforeach
</tbody></table></div>
@endsection
