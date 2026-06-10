@extends('admin.layout')
@section('title', 'Message from '.$message->name)
@section('content')
<div class="page-head"><div><h2>Message from {{ $message->name }}</h2><p class="muted">Received {{ $message->created_at->format('M j, Y H:i') }}</p></div><a class="btn secondary" href="{{ route('admin.messages.index') }}">Back</a></div>
<article class="card"><p><strong>Email:</strong> <a href="mailto:{{ $message->email }}">{{ $message->email }}</a></p><hr><p class="message-body">{{ $message->message }}</p><form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">@csrf @method('DELETE')<button class="btn danger">Delete message</button></form></article>
@endsection
