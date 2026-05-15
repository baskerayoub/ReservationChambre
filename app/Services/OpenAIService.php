<?php

namespace App\Services;

use App\Models\ChatbotMessage;
use App\Models\Room;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    private string $apiKey;
    private string $model;
    private string $baseUrl = 'https://api.openai.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key', '');
        $this->model = config('services.openai.model', 'gpt-4.1-mini');
    }

    /**
     * Build the system prompt with real-time hotel context.
     */
    private function buildSystemPrompt(): string
    {
        $rooms = Room::available()
            ->with('amenities')
            ->get()
            ->map(fn (Room $r) => sprintf(
                '- %s (%s): $%s/night, capacity %d, beds %d | Amenities: %s',
                $r->name, $r->type, $r->price_per_night, $r->capacity, $r->beds,
                $r->amenities->pluck('name')->implode(', ') ?: 'N/A'
            ))
            ->implode("\n");

        return <<<PROMPT
You are "Hotelia Assistant", the AI concierge for Hotelia — a premium family hotel.

## STRICT RULES
1. ONLY answer questions related to the hotel, rooms, reservations, services, local tourism, and hospitality.
2. If a user asks about programming, math, politics, or any unrelated topic, politely decline and redirect them to hotel services.
3. Be warm, professional, and helpful.
4. When recommending rooms, use the real-time data below.
5. Quote prices accurately. Never invent rooms or prices.
6. If asked to make a reservation, guide the user to use the booking system on the website.
7. Always respond in the same language as the user.

## CURRENT AVAILABLE ROOMS
{$rooms}

## HOTEL SERVICES
- 24/7 Reception
- Free Wi-Fi throughout the hotel
- Restaurant & Bar
- Swimming Pool
- Spa & Wellness Center
- Airport Shuttle
- Room Service
- Concierge Service
- Laundry & Dry Cleaning
- Free Parking
- Children's Playground

## HOTEL POLICIES
- Check-in: 3:00 PM | Check-out: 11:00 AM
- Cancellation: Free up to 24 hours before check-in
- Pets: Not allowed
- Smoking: Non-smoking property
PROMPT;
    }

    /**
     * Send a message to OpenAI and get a response.
     */
    public function chat(string $userMessage, string $sessionId, ?int $userId = null): string
    {
        if (empty($this->apiKey)) {
            return 'The AI assistant is currently unavailable. Please contact reception for assistance.';
        }

        // Retrieve conversation history (last 10 messages for context)
        $history = ChatbotMessage::where('session_id', $sessionId)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->reverse()
            ->map(fn ($m) => ['role' => $m->role, 'content' => $m->content])
            ->values()
            ->toArray();

        // Store user message
        ChatbotMessage::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'role' => 'user',
            'content' => $userMessage,
        ]);

        $messages = array_merge(
            [['role' => 'system', 'content' => $this->buildSystemPrompt()]],
            $history,
            [['role' => 'user', 'content' => $userMessage]]
        );

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post("{$this->baseUrl}/chat/completions", [
                'model' => $this->model,
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => 500,
            ]);

            if ($response->failed()) {
                Log::error('OpenAI API error', ['status' => $response->status(), 'body' => $response->body()]);
                return 'I apologize, but I\'m having trouble connecting right now. Please try again or contact our reception desk.';
            }

            $reply = $response->json('choices.0.message.content', 'Sorry, I could not generate a response.');

            // Store assistant reply
            ChatbotMessage::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'role' => 'assistant',
                'content' => $reply,
            ]);

            return $reply;
        } catch (\Exception $e) {
            Log::error('OpenAI service exception', ['error' => $e->getMessage()]);
            return 'I apologize for the inconvenience. Our AI assistant is temporarily unavailable. Please contact reception for immediate help.';
        }
    }
}
