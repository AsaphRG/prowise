@extends('layouts.app')

@section('title', 'Prowise | Agendar Demonstração')

@section('content')
<div class="flex flex-col lg:flex-row min-h-[calc(100vh-160px)]">
    <!-- Left Side: Content -->
    <div class="lg:w-1/2 p-10 lg:p-24 flex flex-col justify-center relative overflow-hidden">
        <div class="relative z-10 max-w-md">
            <span class="text-prowise-blue font-semibold tracking-widest text-xs uppercase mb-4 block">DEMONSTRAÇÃO PERSONALIZADA</span>
            <h1 class="font-heading text-4xl md:text-5xl font-bold mb-6 leading-tight">
                Veja como a IA pode alinhar sua operação.
            </h1>
            <p class="text-prowise-softblue text-lg mb-8 leading-relaxed font-light">
                Agende uma conversa de 15 minutos com um de nossos especialistas e descubra como o Prowise pode reduzir ruídos na sua empresa.
            </p>

            <ul class="space-y-4">
                <li class="flex items-start gap-3">
                    <div class="mt-1 w-5 h-5 rounded-full bg-prowise-green/20 flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3 text-prowise-green" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                    </div>
                    <span class="text-sm text-prowise-softblue">Mapeamento de gargalos operacionais.</span>
                </li>
                <li class="flex items-start gap-3">
                    <div class="mt-1 w-5 h-5 rounded-full bg-prowise-green/20 flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3 text-prowise-green" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                    </div>
                    <span class="text-sm text-prowise-softblue">Demonstração real do processamento de dados.</span>
                </li>
                <li class="flex items-start gap-3">
                    <div class="mt-1 w-5 h-5 rounded-full bg-prowise-green/20 flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3 text-prowise-green" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                    </div>
                    <span class="text-sm text-prowise-softblue">Plano de implantação sob medida.</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Right Side: Form -->
    <div class="lg:w-1/2 p-10 lg:p-24 flex items-center justify-center">
        <div class="w-full max-w-lg bg-white/5 border border-prowise-gray/20 rounded-2xl p-8 md:p-10 backdrop-blur-sm shadow-2xl">
            <form action="#" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="first_name" class="text-xs font-semibold text-prowise-softblue uppercase tracking-wider">Nome</label>
                        <input type="text" id="first_name" name="first_name" required class="w-full bg-prowise-navy/50 border border-prowise-gray/30 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-prowise-blue transition-colors placeholder-prowise-gray/50" placeholder="Seu nome">
                    </div>
                    <div class="space-y-2">
                        <label for="company" class="text-xs font-semibold text-prowise-softblue uppercase tracking-wider">Empresa</label>
                        <input type="text" id="company" name="company" required class="w-full bg-prowise-navy/50 border border-prowise-gray/30 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-prowise-blue transition-colors placeholder-prowise-gray/50" placeholder="Nome da empresa">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="email" class="text-xs font-semibold text-prowise-softblue uppercase tracking-wider">E-mail Corporativo</label>
                    <input type="email" id="email" name="email" required class="w-full bg-prowise-navy/50 border border-prowise-gray/30 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-prowise-blue transition-colors placeholder-prowise-gray/50" placeholder="seu@email.com.br">
                </div>

                <div class="space-y-2">
                    <label for="size" class="text-xs font-semibold text-prowise-softblue uppercase tracking-wider">Tamanho da Empresa</label>
                    <select id="size" name="size" class="w-full bg-prowise-navy/50 border border-prowise-gray/30 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-prowise-blue transition-colors appearance-none">
                        <option value="1-10">1-10 funcionários</option>
                        <option value="11-50">11-50 funcionários</option>
                        <option value="51-200">51-200 funcionários</option>
                        <option value="201+">201+ funcionários</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="message" class="text-xs font-semibold text-prowise-softblue uppercase tracking-wider">Qual o seu maior desafio hoje?</label>
                    <textarea id="message" name="message" rows="3" class="w-full bg-prowise-navy/50 border border-prowise-gray/30 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-prowise-blue transition-colors placeholder-prowise-gray/50" placeholder="Ex: Centralizar informações de diferentes áreas..."></textarea>
                </div>

                <button type="submit" class="w-full bg-prowise-blue hover:bg-prowise-blue/90 text-white font-bold py-4 rounded-lg transition-all shadow-[0_0_20px_rgba(63,121,242,0.3)] hover:shadow-[0_0_25px_rgba(63,121,242,0.5)]">
                    Confirmar Agendamento
                </button>

                <p class="text-[10px] text-center text-prowise-gray/60 leading-relaxed">
                    Ao clicar em confirmar, você concorda com nossos termos de uso e política de privacidade. Seus dados estão seguros conosco.
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
