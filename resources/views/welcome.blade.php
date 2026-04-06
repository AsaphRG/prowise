@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="flex flex-col justify-center items-center text-center px-6 pt-10 pb-20">
        <div class="max-w-4xl mx-auto">
            <h1 class="font-heading text-5xl md:text-7xl font-bold mb-6 tracking-tight leading-[1.1]">
                Tudo alinhado.<br>Todo dia.
            </h1>
            <p class="text-prowise-softblue text-lg md:text-xl mb-10 max-w-2xl mx-auto leading-relaxed font-light">
                Somos uma solução de IA operacional criada para organizar a comunicação interna das PMEs. Conecte informações espalhadas, reduza o retrabalho e leve sua empresa a outro nível.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @auth
                    <a href="{{ route('chat') }}" class="bg-prowise-blue text-white hover:bg-prowise-blue/90 px-8 py-4 rounded-full font-medium transition-all w-full sm:w-auto shadow-[0_0_20px_rgba(63,121,242,0.3)] hover:shadow-[0_0_25px_rgba(63,121,242,0.5)]">
                        Ir para o Chat IA
                    </a>
                @else
                    <a href="{{ route('agendar-demonstracao') }}" class="bg-prowise-blue text-white hover:bg-prowise-blue/90 px-8 py-4 rounded-full font-medium transition-all w-full sm:w-auto shadow-[0_0_20px_rgba(63,121,242,0.3)] hover:shadow-[0_0_25px_rgba(63,121,242,0.5)]">
                        Agende uma demonstração
                    </a>
                @endauth
                <a href="#solucao" class="border border-prowise-gray/50 text-white hover:border-white hover:bg-white/5 px-8 py-4 rounded-full font-medium transition-all w-full sm:w-auto">
                    Entenda o fluxo
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
            <h3 class="font-heading font-medium text-xl mb-3 text-white">Agilidade que move resultados</h3>
            <p class="text-prowise-softblue text-sm leading-relaxed">
                Eliminamos atritos, aceleramos fluxos e garantimos que tudo circule no ritmo que sua empresa precisa para sobreviver e crescer.
            </p>
        </div>

        <div class="flex flex-col items-center text-center md:items-start md:text-left">
            <div class="w-12 h-12 rounded-lg bg-prowise-green/10 flex items-center justify-center mb-5 border border-prowise-green/20">
                <svg class="w-6 h-6 text-prowise-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <h3 class="font-heading font-medium text-xl mb-3 text-white">Clareza que conecta</h3>
            <p class="text-prowise-softblue text-sm leading-relaxed">
                Transformamos caos em ordem, ruídos em alinhamento e demandas dispersas em fluidez. A clareza é o núcleo da confiança interna.
            </p>
        </div>

        <div class="flex flex-col items-center text-center md:items-start md:text-left">
            <div class="w-12 h-12 rounded-lg bg-prowise-coral/10 flex items-center justify-center mb-5 border border-prowise-coral/20">
                <svg class="w-6 h-6 text-prowise-coral" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <h3 class="font-heading font-medium text-xl mb-3 text-white">Confiabilidade dia a dia</h3>
            <p class="text-prowise-softblue text-sm leading-relaxed">
                Comprometidos em ser uma base estável, entregamos previsibilidade e segurança. Nada se perde, tudo chega onde precisa chegar.
            </p>
        </div>
    </section>
@endsection
