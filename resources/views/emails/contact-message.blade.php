<h1>New portfolio enquiry</h1>
<p><strong>Name:</strong> {{ $contactMessage->name }}</p>
<p><strong>Email:</strong> <a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></p>
<p><strong>Message:</strong></p>
<p>{!! nl2br(e($contactMessage->message)) !!}</p>
