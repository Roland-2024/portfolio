@extends('admin.layout')
@section('title', 'Projects')
@section('content')
<div class="page-head"><h2>Projects</h2><a class="btn" href="{{ route('admin.projects.create') }}">Add project</a></div>
<div class="card table-wrap"><table class="data-table"><thead><tr><th>Project</th><th>Category</th><th>Published</th><th>Order</th><th></th></tr></thead><tbody>
@foreach($items as $item)<tr><td>{{ $item->title }}</td><td>{{ $item->category }}</td><td>{{ $item->is_published ? 'Yes' : 'No' }}</td><td>{{ $item->sort_order }}</td><td class="actions"><a class="btn secondary" href="{{ route('admin.projects.edit', $item) }}">Edit</a><form method="POST" action="{{ route('admin.projects.destroy', $item) }}" onsubmit="return confirm('Delete this project?')">@csrf @method('DELETE')<button class="btn danger">Delete</button></form></td></tr>@endforeach
</tbody></table></div>
@endsection
