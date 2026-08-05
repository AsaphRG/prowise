@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="flex flex-col justify-center items-center text-center px-6 pt-10 pb-20">
        <div class="max-w-4xl mx-auto">
            <h1 class="font-heading text-5xl md:text-7xl font-bold mb-6 tracking-tight leading-[1.1]">
                {{ __('Tudo alinhado.') }}<br>{{ __('Todo dia.') }}
            </h1>
            <p class="text-prowise-softblue text-lg md:text-xl mb-10 max-w-2xl mx-auto leading-relaxed font-light">
                {{ __('Somos uma solução de IA operacional criada para organizar a comunicação interna das PMEs. Conecte informações espalhadas, reduza o retrabalho e leve sua empresa a outro nível.') }}
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @auth
                    <a href="{{ route('chat') }}" class="bg-prowise-blue text-white hover:bg-prowise-blue/90 px-8 py-4 rounded-full font-medium transition-all w-full sm:w-auto shadow-[0_0_20px_rgba(63,121,242,0.3)] hover:shadow-[0_0_25px_rgba(63,121,242,0.5)]">
                        {{ __('Ir para o Chat IA') }}
                    </a>
                @else
                    <a href="{{ route('agendar-demonstracao') }}" class="bg-prowise-blue text-white hover:bg-prowise-blue/90 px-8 py-4 rounded-full font-medium transition-all w-full sm:w-auto shadow-[0_0_20px_rgba(63,121,242,0.3)] hover:shadow-[0_0_25px_rgba(63,121,242,0.5)]">
                        {{ __('Agende uma demonstração') }}
                    </a>
                @endauth
                <a href="#fluxo" class="border border-prowise-gray/50 text-white hover:border-white hover:bg-white/5 px-8 py-4 rounded-full font-medium transition-all w-full sm:w-auto">
                    {{ __('Entenda o fluxo') }}
                </a>
            </div>
        </div>
    </section>


    <!-- Features / Value Props -->
    <section id="solucao" class="w-full max-w-6xl mx-auto px-6 py-20 grid grid-cols-1 md:grid-cols-3 gap-10 bg-prowise-navy/80 backdrop-blur-sm border-t border-prowise-gray/20">
        <div class="flex flex-col items-center text-center md:items-start md:text-left">
            <div class="w-12 h-12 rounded-lg bg-prowise-blue/10 flex items-center justify-center mb-5 border border-prowise-blue/20">
                <svg class="w-6 h-6 text-prowise-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <h3 class="font-heading font-medium text-xl mb-3 text-white">{{ __('Agilidade que move resultados') }}</h3>
            <p class="text-prowise-softblue text-sm leading-relaxed">
                {{ __('Eliminamos atritos, aceleramos fluxos e garantimos que tudo circule no ritmo que sua empresa precisa para sobreviver e crescer.') }}
            </p>
        </div>

        <div class="flex flex-col items-center text-center md:items-start md:text-left">
            <div class="w-12 h-12 rounded-lg bg-prowise-green/10 flex items-center justify-center mb-5 border border-prowise-green/20">
                <svg class="w-6 h-6 text-prowise-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <h3 class="font-heading font-medium text-xl mb-3 text-white">{{ __('Clareza que conecta') }}</h3>
            <p class="text-prowise-softblue text-sm leading-relaxed">
                {{ __('Transformamos caos em ordem, ruídos em alinhamento e demandas dispersas em fluidez. A clareza é o núcleo da confiança interna.') }}
            </p>
        </div>

        <div class="flex flex-col items-center text-center md:items-start md:text-left">
            <div class="w-12 h-12 rounded-lg bg-prowise-coral/10 flex items-center justify-center mb-5 border border-prowise-coral/20">
                <svg class="w-6 h-6 text-prowise-coral" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <h3 class="font-heading font-medium text-xl mb-3 text-white">{{ __('Confiabilidade dia a dia') }}</h3>
            <p class="text-prowise-softblue text-sm leading-relaxed">
                {{ __('Comprometidos em ser uma base estável, entregamos previsibilidade e segurança. Nada se perde, tudo chega onde precisa chegar.') }}
            </p>
        </div>
    </section>

    <!-- Fluxo Section -->
    <section id="fluxo" class="w-full max-w-7xl mx-auto px-6 py-24 relative">
        <div class="absolute inset-0 bg-gradient-to-b from-prowise-navy via-prowise-blue/5 to-prowise-navy -z-10"></div>
        <div class="text-center mb-16">
            <span class="text-prowise-blue font-semibold uppercase tracking-wider text-sm">{{ __('Arquitetura RAG') }}</span>
            <h2 class="font-heading text-3xl md:text-5xl font-bold mt-2 mb-4 text-white">{{ __('Como o Prowise Agent Funciona') }}</h2>
            <p class="text-prowise-softblue text-lg max-w-3xl mx-auto font-light">
                {{ __('Para garantir segurança e confiabilidade, utilizamos a arquitetura RAG (Retrieval-Augmented Generation) integrada ao Google Cloud Vertex AI. Suas informações nunca são usadas para treinar modelos públicos.') }}
            </p>
        </div>

        <div class="relative flex flex-col md:flex-row items-stretch justify-between gap-6 md:gap-4 lg:gap-8 mt-12">
            <!-- Linha conectora animada (Desktop) -->
            <div class="hidden md:block absolute top-1/2 left-10 right-10 h-0.5 bg-prowise-gray/20 -translate-y-1/2 z-0">
                <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-prowise-blue via-prowise-green to-prowise-coral animate-[pulse_3s_ease-in-out_infinite] w-full opacity-50"></div>
            </div>
            
            <!-- Step 1: Input -->
            <div class="relative z-10 bg-prowise-navy/80 backdrop-blur-xl border border-prowise-gray/20 p-8 rounded-2xl w-full md:w-1/4 hover:border-prowise-blue hover:-translate-y-2 transition-all duration-300 shadow-xl hover:shadow-[0_10px_30px_rgba(63,121,242,0.15)] group flex flex-col">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-prowise-blue/20 to-prowise-blue/5 border border-prowise-blue/30 text-prowise-blue flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-[0_0_15px_rgba(63,121,242,0.3)]">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                <h3 class="font-heading text-white font-semibold text-xl mb-3">{{ __('1. Interação') }}</h3>
                <p class="text-prowise-softblue text-sm leading-relaxed flex-grow">{{ __('O colaborador faz uma pergunta natural no chat sobre um processo, política ou dado da empresa.') }}</p>
            </div>

            <!-- Step 2: RAG -->
            <div class="relative z-10 bg-prowise-navy/80 backdrop-blur-xl border border-prowise-gray/20 p-8 rounded-2xl w-full md:w-1/4 hover:border-prowise-green hover:-translate-y-2 transition-all duration-300 shadow-xl hover:shadow-[0_10px_30px_rgba(76,191,136,0.15)] group flex flex-col">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-prowise-green/20 to-prowise-green/5 border border-prowise-green/30 text-prowise-green flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-[0_0_15px_rgba(76,191,136,0.3)]">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="font-heading text-white font-semibold text-xl mb-3">{{ __('2. Recuperação') }}</h3>
                <p class="text-prowise-softblue text-sm leading-relaxed flex-grow">{{ __('O sistema busca no banco de dados vetorial os contextos e documentos internos mais relevantes.') }}</p>
            </div>

            <!-- Step 3: Vertex AI -->
            <div class="relative z-10 bg-prowise-navy/80 backdrop-blur-xl border border-prowise-gray/20 p-8 rounded-2xl w-full md:w-1/4 hover:border-prowise-coral hover:-translate-y-2 transition-all duration-300 shadow-xl hover:shadow-[0_10px_30px_rgba(252,113,88,0.15)] group flex flex-col">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-prowise-coral/20 to-prowise-coral/5 border border-prowise-coral/30 text-prowise-coral flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-[0_0_15px_rgba(252,113,88,0.3)]">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="font-heading text-white font-semibold text-xl mb-3">{{ __('3. Processamento') }}</h3>
                <p class="text-prowise-softblue text-sm leading-relaxed flex-grow">{{ __('A pergunta e os dados recuperados são enviados via proxy seguro ao Google Cloud Vertex AI.') }}</p>
            </div>

            <!-- Step 4: Output -->
            <div class="relative z-10 bg-prowise-navy/80 backdrop-blur-xl border border-prowise-gray/20 p-8 rounded-2xl w-full md:w-1/4 hover:border-prowise-yellow hover:-translate-y-2 transition-all duration-300 shadow-xl hover:shadow-[0_10px_30px_rgba(242,201,76,0.15)] group flex flex-col">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-prowise-yellow/20 to-prowise-yellow/5 border border-prowise-yellow/30 text-prowise-yellow flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-[0_0_15px_rgba(242,201,76,0.3)]">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="font-heading text-white font-semibold text-xl mb-3">{{ __('4. Resolução') }}</h3>
                <p class="text-prowise-softblue text-sm leading-relaxed flex-grow">{{ __('O agente gera uma resposta acionável, em tempo real e com citações exatas da sua documentação.') }}</p>
            </div>
        </div>
    </section>

    <!-- Bottom CTA Section -->
    <section class="w-full py-24 relative overflow-hidden">
        <!-- Glow effect behind -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-3/4 h-3/4 bg-prowise-blue/20 blur-[120px] rounded-full z-0 pointer-events-none"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center border border-prowise-gray/20 bg-prowise-navy/60 backdrop-blur-md rounded-3xl p-12 md:p-16 shadow-2xl">
            <h2 class="font-heading text-3xl md:text-5xl font-bold mb-6 text-white leading-tight">
                {{ __('Pronto para centralizar sua inteligência?') }}
            </h2>
            <p class="text-prowise-softblue text-lg mb-10 max-w-2xl mx-auto font-light leading-relaxed">
                {{ __('Dê o próximo passo para uma comunicação sem atritos e equipes perfeitamente alinhadas. O fluxo é simples e o resultado é imediato.') }}
            </p>
            <div class="flex justify-center">
                <a href="{{ route('agendar-demonstracao') }}" class="inline-flex items-center gap-3 bg-prowise-blue text-white hover:bg-prowise-blue/90 px-10 py-5 rounded-full font-semibold text-lg transition-all w-full sm:w-auto shadow-[0_0_25px_rgba(63,121,242,0.4)] hover:shadow-[0_0_35px_rgba(63,121,242,0.6)] hover:-translate-y-1">
                    <span>{{ __('Agende uma demonstração') }}</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </section>
@endsection
