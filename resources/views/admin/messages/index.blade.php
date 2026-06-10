@extends('admin.layout')
@section('title', 'Messages')
@section('content')
<div class="page-head"><div><h2>Contact Messages</h2><p class="muted">Messages submitted through the public contact form.</p></div></div>
<div class="card table-wrap"><table class="data-table"><thead><tr><th>Sender</th><th>Message</th><th>Received</th><th></th></tr></thead><tbody>
@forelse($messages as $message)<tr class="{{ $message->is_read ? '' : 'message-unread' }}"><td>{{ $message->name }}<br><span class="muted">{{ $message->email }}</span></td><td>{{ \Illuminate\Support\Str::limit($message->message, 80) }}</td><td>{{ $message->created_at->format('M j, Y H:i') }}</td><td><a class="btn secondary" href="{{ route('admin.messages.show', $message) }}">Open</a></td></tr>@empty<tr><td colspan="4">No messages yet.</td></tr>@endforelse
</tbody></table>{{ $messages->links() }}</div>
@endsection
