<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display the chat interface.
     */
    public function index()
    {
        // For now, we'll just handle one main conversation per user for simplicity
        $conversation = Auth::user()->conversations()->firstOrCreate([
            'title' => 'Conversa Principal',
        ]);

        $messages = $conversation->messages()->orderBy('created_at', 'asc')->get();

        return view('chat', compact('messages', 'conversation'));
    }

    /**
     * Store a new message and generate a placeholder AI response.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'conversation_id' => 'required|exists:conversations,id',
        ]);

        $conversation = Conversation::findOrFail($request->conversation_id);

        // Ensure user owns the conversation
        if ($conversation->user_id !== Auth::id()) {
            abort(403);
        }

        // 1. Save User Message
        $userMessage = $conversation->messages()->create([
            'role' => 'user',
            'content' => $request->message,
        ]);

        // 2. Placeholder AI Response (Integration with Vertex AI will go here)
        // Simulate a delay
        // usleep(500000); 

        $aiContent = "Olá! Eu sou o assistente da Prowise. Recebi sua mensagem: \"" . $request->message . "\". Em breve estarei integrado com o Google Vertex AI para te ajudar de forma ainda mais inteligente.";

        $aiMessage = $conversation->messages()->create([
            'role' => 'assistant',
            'content' => $aiContent,
        ]);

        return response()->json([
            'user_message' => $userMessage,
            'ai_message' => $aiMessage,
        ]);
    }
}
