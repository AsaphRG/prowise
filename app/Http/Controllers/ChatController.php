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
    public function index($conversationId = null)
    {
        $user = Auth::user();
        $conversations = $user->conversations()->orderBy('updated_at', 'desc')->get();

        if ($conversationId) {
            $conversation = $user->conversations()->findOrFail($conversationId);
        } else {
            $conversation = $conversations->first();
            if (!$conversation) {
                $conversation = $user->conversations()->create([
                    'title' => __('Nova Conversa'),
                ]);
                $conversations = $user->conversations()->orderBy('updated_at', 'desc')->get();
            }
        }

        $messages = $conversation->messages()->orderBy('created_at', 'asc')->get();

        return view('chat', compact('conversations', 'conversation', 'messages'));
    }

    /**
     * Create a new conversation session.
     */
    public function create()
    {
        $conversation = Auth::user()->conversations()->create([
            'title' => __('Nova Conversa'),
        ]);

        return redirect()->route('chat', $conversation->id);
    }

    /**
     * Rename a conversation session.
     */
    public function rename(Request $request, Conversation $conversation)
    {
        if ($conversation->user_id !== Auth::id()) {
            return response()->json(['error' => __('Não autorizado')], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $conversation->update([
            'title' => $request->title,
        ]);

        return response()->json([
            'success' => true,
            'title' => $conversation->title,
        ]);
    }

    /**
     * Delete a conversation session.
     */
    public function destroy(Conversation $conversation)
    {
        if ($conversation->user_id !== Auth::id()) {
            return back()->with('error', __('Não autorizado'));
        }

        $conversation->delete();

        return redirect()->route('chat');
    }

    /**
     * Store a new message and generate an AI response from Vertex AI.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string',
                'conversation_id' => 'required|exists:conversations,id',
            ]);

            $conversation = Conversation::findOrFail($request->conversation_id);

            // Ensure user owns the conversation
            if ($conversation->user_id !== Auth::id()) {
                return response()->json(['error' => 'Não autorizado'], 403);
            }

            // 1. Save User Message
            $userMessage = $conversation->messages()->create([
                'role' => 'user',
                'content' => $request->message,
            ]);

            // Auto-rename conversation if this is the first message and it has the default title
            $isFirstMessage = $conversation->messages()->count() === 1;
            $isDefaultTitle = in_array($conversation->title, ['Nova Conversa', __('Nova Conversa'), 'New Conversation']);

            if ($isFirstMessage && $isDefaultTitle) {
                $rawTitle = strip_tags($request->message);
                $rawTitle = preg_replace('/\s+/', ' ', $rawTitle);
                $rawTitle = trim($rawTitle);
                
                if (preg_match('/^([^.!?\n]{5,40})[.!?\n]/u', $rawTitle, $matches)) {
                    $conversation->title = trim($matches[1]);
                } else {
                    $conversation->title = \Illuminate\Support\Str::limit($rawTitle, 35, '...');
                }
            }

            // 2. Ensure the ADK session exists
            if (!$conversation->vertex_session_id) {
                $conversation->vertex_session_id = $this->vertexAI->createSession(Auth::id());
            }
            $conversation->touch();

            // 3. Query Vertex AI Reasoning Engine
            $aiResponse = $this->vertexAI->query($request->message, $conversation->vertex_session_id);
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
                'conversation_title' => $conversation->title,
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('ChatController Store Error: ' . $e->getMessage(), [
                'trace' => substr($e->getTraceAsString(), 0, 500)
            ]);
            
            return response()->json([
                'error' => 'Erro ao processar mensagem',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
