@extends('layouts.app')

@section('title', __('Sobre o Prowise Agent'))

@section('content')
    <!-- Hero Section -->
    <section class="w-full relative overflow-hidden py-24">
        <div class="absolute inset-0 bg-gradient-to-b from-prowise-navy via-prowise-blue/5 to-prowise-navy -z-10"></div>
        <div class="max-w-4xl mx-auto px-6 text-center">
            <span class="text-prowise-blue font-semibold uppercase tracking-wider text-sm">{{ __('Sobre Nós') }}</span>
            <h1 class="font-heading text-4xl md:text-6xl font-bold mt-2 mb-6 text-white leading-tight">
                {{ __('Nossa Missão') }}
            </h1>
            <p class="text-prowise-softblue text-lg md:text-xl leading-relaxed font-light">
                {{ __('Acreditamos que o conhecimento de uma empresa é seu maior ativo. O Prowise nasceu para evitar que esse ativo fique fragmentado e perdido, unificando a inteligência corporativa de forma acessível e segura.') }}
            </p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="w-full max-w-5xl mx-auto px-6 pb-24 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            
            <!-- Text Content -->
            <div class="order-2 md:order-1 space-y-10">
                <div>
                    <h3 class="font-heading text-2xl text-white font-semibold mb-3">{{ __('O Problema') }}</h3>
                    <p class="text-prowise-softblue leading-relaxed font-light text-sm">
                        {{ __('Em empresas em crescimento, o conhecimento costuma se dissipar. Regras de negócios ficam escondidas em documentos não lidos, fluxos perdem a rastreabilidade e equipes perdem horas preciosas perguntando e respondendo as mesmas coisas diversas vezes no dia.') }}
                    </p>
                </div>
                <div>
                    <h3 class="font-heading text-2xl text-white font-semibold mb-3">{{ __('A Solução Prowise') }}</h3>
                    <p class="text-prowise-softblue leading-relaxed font-light text-sm">
                        {{ __('Criamos um agente de inteligência artificial corporativa alimentado pela sua própria base de conhecimento. Por meio da arquitetura RAG e modelos avançados do Google Cloud Vertex AI, conseguimos ler, interpretar e entregar respostas exatas baseadas nos manuais e procedimentos internos da sua organização.') }}
                    </p>
                </div>
                <div>
                    <h3 class="font-heading text-2xl text-white font-semibold mb-3">{{ __('Privacidade e Segurança') }}</h3>
                    <p class="text-prowise-softblue leading-relaxed font-light text-sm">
                        {{ __('Entendemos que seus dados são confidenciais. A infraestrutura do Prowise Agent foi desenhada com privacidade "by-design". Nenhum dado interno da sua empresa é utilizado para treinar LLMs públicos.') }}
                    </p>
                </div>
            </div>

            <!-- Visual element -->
            <div class="order-1 md:order-2 flex items-center justify-center">
                <img src="{{ asset('img/prowise_logo_bg-removebg-preview.png') }}" alt="Prowise Logo" class="w-64 md:w-80 h-auto opacity-90">
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="w-full py-20 bg-prowise-navy border-t border-prowise-gray/20">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="font-heading text-3xl font-bold mb-6 text-white">{{ __('Pronto para mudar a forma como sua equipe trabalha?') }}</h2>
            <div class="flex justify-center mt-10">
                <a href="{{ route('agendar-demonstracao') }}" class="inline-flex items-center gap-3 bg-prowise-blue text-white hover:bg-prowise-blue/90 px-8 py-4 rounded-full font-medium transition-all shadow-[0_0_20px_rgba(63,121,242,0.3)] hover:shadow-[0_0_25px_rgba(63,121,242,0.5)] hover:-translate-y-1">
                    <span>{{ __('Agende uma demonstração') }}</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </section>
@endsection
