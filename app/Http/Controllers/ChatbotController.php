<?php

namespace App\Http\Controllers;

use App\Services\OpenAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    /**
     * Send a message to the AI assistant.
     */
    public function send(Request $request, OpenAIService $openAI)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $sessionId = $request->input('session_id', Str::uuid()->toString());
        $userId = Auth::id();

        $reply = $openAI->chat($request->message, $sessionId, $userId);

        return response()->json([
            'reply' => $reply,
            'session_id' => $sessionId,
        ]);
    }
}
