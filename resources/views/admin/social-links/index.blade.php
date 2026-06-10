@extends('admin.layout')
@section('title', 'Social Links')
@section('content')
<div class="page-head"><h2>Social Links</h2><a class="btn" href="{{ route('admin.social-links.create') }}">Add link</a></div>
<div class="card table-wrap"><table class="data-table"><thead><tr><th>Platform</th><th>Label</th><th>Visible</th><th></th></tr></thead><tbody>
@foreach($items as $item)<tr><td>{{ $item->platform }}</td><td><a href="{{ $item->url }}" target="_blank">{{ $item->label }}</a></td><td>{{ $item->is_visible ? 'Yes' : 'No' }}</td><td class="actions"><a class="btn secondary" href="{{ route('admin.social-links.edit', $item) }}">Edit</a><form method="POST" action="{{ route('admin.social-links.destroy', $item) }}" onsubmit="return confirm('Delete this link?')">@csrf @method('DELETE')<button class="btn danger">Delete</button></form></td></tr>@endforeach
</tbody></table></div>
@endsection
