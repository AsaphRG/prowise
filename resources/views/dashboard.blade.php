<x-app-layout>
    @section('title', __('Prowise | Dashboard'))

    <x-slot name="header">
        <h2 class="font-heading font-semibold text-2xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-prowise-navy/60 backdrop-blur-xl border border-prowise-gray/20 overflow-hidden shadow-2xl sm:rounded-3xl">
                <div class="p-8 text-white">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-2xl bg-prowise-blue/20 flex items-center justify-center border border-prowise-blue/30 text-prowise-blue">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-heading font-bold">{{ __('Olá, :name!', ['name' => Auth::user()->name]) }}</h3>
                            <p class="text-prowise-softblue text-sm">{{ __('Bem-vindo à sua central de operações.') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        <!-- Chat IA Card -->
                        <a href="{{ route('chat') }}" class="group bg-white/5 border border-prowise-gray/10 p-6 rounded-2xl hover:border-prowise-blue hover:bg-prowise-blue/5 transition-all">
                            <div class="flex items-start justify-between">
                                <div class="w-10 h-10 rounded-xl bg-prowise-blue/10 flex items-center justify-center text-prowise-blue mb-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                </div>
                                <svg class="w-5 h-5 text-prowise-gray/30 group-hover:text-prowise-blue transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                            <h4 class="font-heading font-bold text-lg mb-1">{{ __('Assistente de IA') }}</h4>
                            <p class="text-sm text-prowise-softblue leading-relaxed">{{ __('Inicie uma conversa com nossa inteligência para organizar sua comunicação.') }}</p>
                        </a>

                        <!-- Profile Card -->
                        <a href="{{ route('profile.edit') }}" class="group bg-white/5 border border-prowise-gray/10 p-6 rounded-2xl hover:border-prowise-blue hover:bg-prowise-blue/5 transition-all">
                            <div class="flex items-start justify-between">
                                <div class="w-10 h-10 rounded-xl bg-prowise-green/10 flex items-center justify-center text-prowise-green mb-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <svg class="w-5 h-5 text-prowise-gray/30 group-hover:text-prowise-green transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                            <h4 class="font-heading font-bold text-lg mb-1">{{ __('Configurações') }}</h4>
                            <p class="text-sm text-prowise-softblue leading-relaxed">{{ __('Gerencie suas informações de conta e preferências de segurança.') }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
