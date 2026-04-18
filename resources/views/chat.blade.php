@extends('layouts.app')

@section('title', __('Prowise | Assistente de IA'))

@section('content')
<div class="flex flex-col h-[calc(100vh-80px)] overflow-hidden">
    <!-- Chat Header -->
    <div class="px-6 py-4 bg-prowise-navy/90 border-b border-prowise-gray/10 backdrop-blur-md flex items-center justify-between z-20">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-prowise-blue/20 flex items-center justify-center border border-prowise-blue/30">
                <svg class="w-6 h-6 text-prowise-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div>
                <h2 class="font-heading font-semibold text-lg text-white">{{ __('Assistente Prowise') }}</h2>
                <p class="text-xs text-prowise-green flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-prowise-green animate-pulse"></span>
                    {{ __('Online • Vertex AI Ready') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Chat Messages Area -->
    <div id="chat-messages" class="flex-grow overflow-y-auto p-6 space-y-6 scroll-smooth custom-scrollbar">
        @forelse($messages as $message)
            <div class="flex {{ $message->role === 'user' ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[80%] md:max-w-[70%] rounded-2xl p-4 {{ $message->role === 'user' ? 'bg-prowise-blue text-white rounded-tr-none' : 'bg-white/5 border border-prowise-gray/20 text-prowise-softblue rounded-tl-none' }}">
                    <div class="message-content text-sm leading-relaxed prose prose-invert max-w-none prose-p:my-0 prose-sm" data-raw="{{ $message->content }}">
                        @if($message->role === 'user')
                            {{ $message->content }}
                        @else
                            {{-- Content will be rendered by marked.js on load --}}
                            <p class="animate-pulse">...</p>
                        @endif
                    </div>
                    
                    @if($message->role === 'assistant' && isset($message->metadata['citations']))
                        <div class="mt-3 pt-3 border-t border-prowise-gray/10 text-[10px]">
                            <p class="font-semibold text-prowise-softblue mb-1 uppercase tracking-wider">{{ __('Fontes:') }}</p>
                            <ul class="space-y-1">
                                @foreach($message->metadata['citations'] as $citation)
                                    <li><a href="{{ $citation['url'] ?? '#' }}" target="_blank" class="text-prowise-blue hover:underline opacity-80">{{ $citation['title'] ?? $citation['source'] ?? 'Referência' }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <span class="text-[10px] mt-2 block opacity-50">{{ $message->created_at->format('H:i') }}</span>
                </div>
            </div>
        @empty
            <div id="empty-state" class="flex flex-col items-center justify-center h-full text-center space-y-4 opacity-60">
                <div class="w-16 h-16 rounded-2xl bg-white/5 flex items-center justify-center border border-prowise-gray/20">
                    <svg class="w-8 h-8 text-prowise-softblue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </div>
                <div>
                    <h3 class="font-medium text-white">{{ __('Como posso ajudar hoje?') }}</h3>
                    <p class="text-xs text-prowise-softblue">{{ __('Inicie uma conversa para alinhar sua operação.') }}</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Typing Indicator (Hidden by default) -->
    <div id="typing-indicator" class="hidden px-6 py-2">
        <div class="flex justify-start">
            <div class="bg-white/5 border border-prowise-gray/20 rounded-2xl rounded-tl-none p-4 flex gap-1">
                <span class="w-1.5 h-1.5 bg-prowise-softblue rounded-full animate-bounce"></span>
                <span class="w-1.5 h-1.5 bg-prowise-softblue rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                <span class="w-1.5 h-1.5 bg-prowise-softblue rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
            </div>
        </div>
    </div>

    <!-- Chat Input Area -->
    <div class="p-6 bg-prowise-navy/80 border-t border-prowise-gray/10 backdrop-blur-sm z-20">
        <form id="chat-form" class="max-w-4xl mx-auto flex items-end gap-3 bg-white/5 border border-prowise-gray/20 rounded-2xl p-2 focus-within:border-prowise-blue transition-colors">
            @csrf
            <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
            <textarea id="message-input" name="message" rows="1" class="flex-grow bg-transparent border-none focus:ring-0 text-white placeholder-prowise-gray/50 py-3 px-4 resize-none overflow-hidden" placeholder="{{ __('Escreva sua mensagem aqui...') }}" required></textarea>
            <button type="submit" class="bg-prowise-blue hover:bg-prowise-blue/90 text-white p-3 rounded-xl transition-all shadow-lg shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </button>
        </form>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(138, 149, 165, 0.2);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(138, 149, 165, 0.3);
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const chatMessages = document.getElementById('chat-messages');
    const typingIndicator = document.getElementById('typing-indicator');
    const emptyState = document.getElementById('empty-state');

    // Configure marked
    marked.setOptions({
        breaks: true,
        gfm: true
    });

    // Initialize existing messages with markdown
    document.querySelectorAll('.message-content').forEach(el => {
        const raw = el.getAttribute('data-raw');
        if (raw) {
            el.innerHTML = marked.parse(raw);
        }
    });

    // Auto-resize textarea
    messageInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
        if (this.scrollHeight > 150) {
            this.style.overflowY = 'auto';
            this.style.height = '150px';
        } else {
            this.style.overflowY = 'hidden';
        }
    });

    // Scroll to bottom
    const scrollToBottom = () => {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    };
    scrollToBottom();

    // Send message
    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = messageInput.value.trim();
        if (!message) return;

        // 1. Add User Message to UI
        if (emptyState) emptyState.remove();
        addMessageToUI('user', message);
        
        // 2. Clear input
        messageInput.value = '';
        messageInput.style.height = 'auto';
        
        // 3. Show typing indicator
        typingIndicator.classList.remove('hidden');
        scrollToBottom();

        // 4. Send to Backend
        try {
            const formData = new FormData(chatForm);
            formData.set('message', message); // Just in case

            const response = await fetch('{{ route("chat.send") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            });

            if (!response.ok) throw new Error("{{ __('Falha ao enviar mensagem') }}");

            const data = await response.json();
            
            // 5. Hide typing & add AI response
            typingIndicator.classList.add('hidden');
            addMessageToUI('assistant', data.ai_message.content, data.citations);
            scrollToBottom();

        } catch (error) {
            console.error('Error:', error);
            typingIndicator.classList.add('hidden');
            alert("{{ __('Erro ao processar mensagem. Tente novamente.') }}");
        }
    });

    function addMessageToUI(role, content, citations = []) {
        const div = document.createElement('div');
        div.className = `flex ${role === 'user' ? 'justify-end' : 'justify-start'}`;
        
        const now = new Date();
        const time = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

        let citationsHtml = '';
        if (citations && citations.length > 0) {
            citationsHtml = `
                <div class="mt-3 pt-3 border-t border-prowise-gray/10 text-[10px]">
                    <p class="font-semibold text-prowise-softblue mb-1 uppercase tracking-wider">{{ __('Fontes:') }}</p>
                    <ul class="space-y-1">
                        ${citations.map(c => `
                            <li><a href="${c.url || '#'}" target="_blank" class="text-prowise-blue hover:underline opacity-80">${c.title || c.source || 'Referência'}</a></li>
                        `).join('')}
                    </ul>
                </div>
            `;
        }

        const parsedContent = role === 'assistant' ? marked.parse(content) : content;

        div.innerHTML = `
            <div class="max-w-[80%] md:max-w-[70%] rounded-2xl p-4 ${role === 'user' ? 'bg-prowise-blue text-white rounded-tr-none' : 'bg-white/5 border border-prowise-gray/20 text-prowise-softblue rounded-tl-none'}">
                <div class="message-content text-sm leading-relaxed prose prose-invert max-w-none prose-p:my-0 prose-sm">${parsedContent}</div>
                ${citationsHtml}
                <span class="text-[10px] mt-2 block opacity-50">${time}</span>
            </div>
        `;
        
        chatMessages.appendChild(div);
    }
});
</script>
@endpush
@endsection
