<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Services\VertexAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected $vertexAI;

    public function __construct(VertexAIService $vertexAI)
    {
        $this->vertexAI = $vertexAI;
    }

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
     * Store a new message and generate an AI response from Vertex AI.
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

        // 2. Prepare history for context (last 5 messages for example)
        $history = $conversation->messages()
            ->where('id', '!=', $userMessage->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->reverse()
            ->values() // Importante: reseta as chaves para 0, 1, 2...
            ->map(function ($msg) {
                return [
                    'role' => $msg->role === 'user' ? 'human' : 'ai',
                    'content' => $msg->content,
                ];
            })
            ->toArray();

        if (!$conversation->vertex_session_id) {
            $conversation->vertex_session_id = $this->vertexAI->createSession(Auth::id());
            $conversation->save();
        }

        // 3. Query Vertex AI Reasoning Engine
        $aiResponse = $this->vertexAI->query($request->message, $conversation->vertex_session_id, $history);
        $aiContent = $aiResponse['content'];
        $citations = $aiResponse['citations'];

        // 4. Save AI Response
        $aiMessage = $conversation->messages()->create([
            'role' => 'assistant',
            'content' => $aiContent,
            'metadata' => !empty($citations) ? ['citations' => $citations] : null,
        ]);

        return response()->json([
            'user_message' => $userMessage,
            'ai_message' => $aiMessage,
            'citations' => $citations,
        ]);
    }
}
