@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')
<div class="page-head"><div><h2>Dashboard</h2><p class="muted">Manage the content shown on your portfolio.</p></div></div>
<section class="stats">@foreach($stats as $label => $value)<div class="card stat"><strong>{{ $value }}</strong><span>{{ $label }}</span></div>@endforeach</section>
<section class="card">
    <div class="page-head"><h2>Latest messages</h2><a class="btn secondary" href="{{ route('admin.messages.index') }}">View all</a></div>
    <div class="table-wrap"><table class="data-table"><thead><tr><th>From</th><th>Received</th><th></th></tr></thead><tbody>
    @forelse($messages as $message)<tr class="{{ $message->is_read ? '' : 'message-unread' }}"><td>{{ $message->name }}<br><span class="muted">{{ $message->email }}</span></td><td>{{ $message->created_at->format('M j, Y H:i') }}</td><td><a href="{{ route('admin.messages.show', $message) }}">Open</a></td></tr>@empty<tr><td colspan="3">No messages yet.</td></tr>@endforelse
    </tbody></table></div>
</section>
@endsection
