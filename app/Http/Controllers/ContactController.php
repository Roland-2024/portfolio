<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\PortfolioProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $message = ContactMessage::create($request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]));

        try {
            $recipient = PortfolioProfile::first()?->email ?? 'info@rolandaga.com';
            Mail::to($recipient)->send(new ContactMessageReceived($message));
        } catch (Throwable $exception) {
            report($exception);
        }

        return response()->json(['message' => 'Thank you. Your message has been sent.'], 201);
    }
}
