@extends('layouts.app')

@section('title', __('Prowise | Assistente de IA'))

@section('content')
<div x-data="{ sidebarOpen: false }" class="flex h-[calc(100vh-80px)] overflow-hidden relative">
    <!-- Sidebar -->
    <div 
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed lg:static inset-y-0 left-0 w-80 bg-prowise-navy/95 border-r border-prowise-gray/10 z-40 transform transition-transform duration-300 ease-in-out flex flex-col h-full shrink-0"
    >
        <!-- Sidebar Header (New Chat Button) -->
        <div class="p-4 border-b border-prowise-gray/10 flex items-center gap-3">
            <form action="{{ route('chat.new') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-prowise-blue to-prowise-blue/90 hover:from-prowise-blue/90 hover:to-prowise-blue hover:scale-[1.02] active:scale-[0.98] text-white py-3 px-4 rounded-xl font-heading font-medium text-sm transition-all shadow-lg shadow-prowise-blue/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    {{ __('Nova Conversa') }}
                </button>
            </form>
        </div>

        <!-- Conversations List -->
        <div class="flex-grow overflow-y-auto p-4 space-y-2 custom-scrollbar">
            @foreach($conversations as $conv)
                <div 
                    x-data="{ 
                        editing: false, 
                        title: '{{ addslashes($conv->title) }}', 
                        originalTitle: '{{ addslashes($conv->title) }}',
                        async saveTitle() {
                            if (!this.title.trim() || this.title === this.originalTitle) {
                                this.editing = false;
                                return;
                            }
                            try {
                                const response = await fetch('{{ route('chat.rename', $conv->id) }}', {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({ title: this.title })
                                });
                                if (!response.ok) throw new Error('{{ __('Erro ao renomear') }}');
                                const data = await response.json();
                                this.title = data.title;
                                this.originalTitle = data.title;
                                this.editing = false;
                                if ('{{ $conv->id }}' === '{{ $conversation->id }}') {
                                    const headerTitle = document.getElementById('active-chat-title');
                                    if (headerTitle) headerTitle.textContent = this.title;
                                }
                            } catch (e) {
                                alert(e.message);
                                this.title = this.originalTitle;
                                this.editing = false;
                            }
                        },
                        cancelEdit() {
                            this.title = this.originalTitle;
                            this.editing = false;
                        }
                    }"
                    class="group relative flex items-center justify-between rounded-xl transition-all duration-200 {{ $conv->id === $conversation->id ? 'bg-white/10 border border-prowise-blue/30 text-white font-medium shadow-md' : 'hover:bg-white/5 text-prowise-softblue border border-transparent' }}"
                >
                    <!-- Clickable area to navigate -->
                    <div class="flex-grow min-w-0 py-3 px-4">
                        <template x-if="!editing">
                            <a href="{{ route('chat', $conv->id) }}" class="block truncate pr-8 select-none">
                                <span x-text="title"></span>
                            </a>
                        </template>
                        <template x-if="editing">
                            <div class="flex items-center gap-1.5 w-full pr-8">
                                <input 
                                    type="text" 
                                    x-model="title" 
                                    @keydown.enter="saveTitle()" 
                                    @keydown.escape="cancelEdit()"
                                    class="w-full bg-prowise-navy/90 border border-prowise-blue/50 rounded-lg py-1 px-2 text-xs text-white focus:outline-none focus:ring-1 focus:ring-prowise-blue"
                                    x-ref="titleInput"
                                    @click.away="saveTitle()"
                                >
                            </div>
                        </template>
                        <span class="block text-[9px] opacity-40 mt-1 select-none">{{ $conv->updated_at->diffForHumans() }}</span>
                    </div>

                    <!-- Actions Overlay -->
                    <div class="absolute right-3 flex items-center gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity bg-gradient-to-l {{ $conv->id === $conversation->id ? 'from-white/10' : 'from-prowise-navy/90' }} pl-4 py-1 rounded-r-xl">
                        <template x-if="!editing">
                            <div class="flex items-center gap-1">
                                <!-- Edit Button -->
                                <button 
                                    @click="editing = true; $nextTick(() => $refs.titleInput.focus())" 
                                    class="p-1 hover:text-white transition-colors"
                                    title="{{ __('Renomear') }}"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                
                                <!-- Delete Button -->
                                <form action="{{ route('chat.destroy', $conv->id) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Tem certeza que deseja excluir esta conversa?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="p-1 text-prowise-coral hover:text-prowise-coral/80 transition-colors"
                                        title="{{ __('Excluir') }}"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </template>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Sidebar Backdrop for Mobile -->
    <div 
        x-show="sidebarOpen" 
        @click="sidebarOpen = false" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-30 lg:hidden"
    ></div>

    <!-- Chat Main Content -->
    <div class="flex-grow flex flex-col h-full overflow-hidden relative z-10">
        <!-- Chat Header -->
        <div class="px-6 py-4 bg-prowise-navy/90 border-b border-prowise-gray/10 backdrop-blur-md flex items-center justify-between z-20">
            <div class="flex items-center gap-3">
                <!-- Toggle Sidebar Button (Mobile) -->
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-prowise-softblue hover:text-white p-2 rounded-xl bg-white/5 hover:bg-white/10 border border-prowise-gray/20 transition-all shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="w-10 h-10 rounded-full bg-prowise-blue/20 flex items-center justify-center border border-prowise-blue/30">
                    <svg class="w-6 h-6 text-prowise-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <h2 id="active-chat-title" class="font-heading font-semibold text-base sm:text-lg text-white truncate max-w-[180px] sm:max-w-xs">{{ $conversation->title }}</h2>
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
                <button type="submit" class="bg-prowise-blue hover:bg-prowise-blue/90 text-white p-3 rounded-xl transition-all shadow-lg shrink-0" title="{{ __('Enviar mensagem (Enter)') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
            <div class="max-w-4xl mx-auto mt-2 px-2 flex justify-between items-center text-[11px] text-prowise-softblue/40 font-sans">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    {{ __('Pressione Enter para enviar') }}
                </span>
                <span class="hidden sm:inline">{{ __('Shift + Enter para quebrar linha') }}</span>
            </div>
        </div>
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

    // Submit form on Enter (without Shift)
    messageInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            chatForm.requestSubmit();
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

            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(errorData.message || "{{ __('Falha ao enviar mensagem') }}");
            }

            const data = await response.json();
            
            // 5. Hide typing & add AI response
            typingIndicator.classList.add('hidden');
            addMessageToUI('assistant', data.ai_message.content, data.citations);
            scrollToBottom();

            // Update conversation title in UI if changed
            if (data.conversation_title) {
                const headerTitle = document.getElementById('active-chat-title');
                if (headerTitle) {
                    headerTitle.textContent = data.conversation_title;
                }
                const activeSpan = document.querySelector('[class*="border-prowise-blue"] span[x-text="title"]');
                if (activeSpan) {
                    const alpineEl = activeSpan.closest('[x-data]');
                    if (alpineEl && window.Alpine) {
                        const alpineData = Alpine.$data(alpineEl);
                        if (alpineData) {
                            alpineData.title = data.conversation_title;
                            alpineData.originalTitle = data.conversation_title;
                        }
                    } else {
                        activeSpan.textContent = data.conversation_title;
                    }
                }
            }

        } catch (error) {
            console.error('Error:', error);
            typingIndicator.classList.add('hidden');
            alert("{{ __('Erro ao processar mensagem:') }} " + error.message);
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
                        ${citations.map(c => {
                            const url = typeof c === 'string' ? '#' : (c.url || '#');
                            const title = typeof c === 'string' ? c : (c.title || c.source || 'Referência');
                            return `<li><a href="${url}" target="_blank" class="text-prowise-blue hover:underline opacity-80">${title}</a></li>`;
                        }).join('')}
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
