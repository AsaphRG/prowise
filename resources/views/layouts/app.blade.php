<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('img/prowise_logo_bg-removebg-preview.png') }}">

        <title>@yield('title', config('app.name', 'Prowise | Tudo alinhado. Todo dia.'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @stack('styles')
    </head>
    <body class="bg-prowise-navy text-white font-body antialiased min-h-screen flex flex-col selection:bg-prowise-blue selection:text-white overflow-x-hidden">
        
        @include('layouts.navigation')

        <!-- Main Content -->
        <main class="flex-grow z-10 relative">
            @if(isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </main>

        <!-- Graphic Element (Neural Inspired Background) -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none opacity-50 z-0">
            <svg class="absolute w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <path d="M-100,600 C200,500 300,700 800,400 C1200,100 1600,500 2000,300" stroke="#3F79F2" stroke-width="1.5" fill="none" opacity="0.4"/>
                <path d="M-50,700 C300,600 400,800 900,500 C1300,200 1700,600 2100,400" stroke="#4CBF88" stroke-width="1" fill="none" opacity="0.3"/>
                <path d="M0,800 C400,700 500,900 1000,600 C1400,300 1800,700 2200,500" stroke="#3F79F2" stroke-width="1" fill="none" opacity="0.2"/>
                <path d="M100,900 C500,800 600,1000 1100,700 C1500,400 1900,800 2300,600" stroke="#FC7158" stroke-width="0.5" fill="none" opacity="0.2"/>
                <circle cx="800" cy="400" r="3" fill="#3F79F2" class="animate-pulse" />
                <circle cx="900" cy="500" r="2.5" fill="#4CBF88" class="animate-pulse" style="animation-delay: 1s;" />
                <circle cx="1000" cy="600" r="2" fill="#B8C7E0" class="animate-pulse" style="animation-delay: 0.5s;" />
                <circle cx="300" cy="650" r="3" fill="#3F79F2" class="animate-pulse" style="animation-delay: 1.5s;" />
                <circle cx="1200" cy="180" r="2" fill="#FC7158" class="animate-pulse" style="animation-delay: 2s;" />
            </svg>
            <div class="absolute inset-0 bg-gradient-to-t from-prowise-navy via-transparent to-transparent"></div>
        </div>

        <!-- Footer -->
        <footer class="w-full pt-16 pb-8 z-10 relative bg-prowise-navy/95 border-t border-prowise-gray/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                    <!-- Brand Column -->
                    <div class="col-span-1 md:col-span-1">
                        <a href="{{ url('/') }}" class="flex items-center gap-3 mb-6 opacity-90 hover:opacity-100 transition-opacity">
                            <img src="{{ asset('img/prowise_logo_bg-removebg-preview.png') }}" alt="Prowise Logo" class="h-8 w-auto">
                            <span class="font-heading font-semibold text-xl tracking-wide text-white">Prowise</span>
                        </a>
                        <p class="text-prowise-softblue text-sm leading-relaxed mb-6">
                            {{ __('Somos uma solução de IA operacional criada para organizar a comunicação interna das PMEs. Conecte informações espalhadas, reduza o retrabalho e leve sua empresa a outro nível.') }}
                        </p>
                    </div>

                    <!-- Sitemap Column 1 -->
                    <div>
                        <h4 class="text-white font-heading font-bold text-sm uppercase tracking-widest mb-6">{{ __('Plataforma') }}</h4>
                        <ul class="space-y-4">
                            <li><a href="{{ route('chat') }}" class="text-prowise-softblue hover:text-prowise-blue text-sm transition-colors">{{ __('Chat IA') }}</a></li>
                            <li><a href="#solucao" class="text-prowise-softblue hover:text-prowise-blue text-sm transition-colors">{{ __('Como Funciona') }}</a></li>
                        </ul>
                    </div>

                    <!-- Sitemap Column 2 -->
                    <div>
                        <h4 class="text-white font-heading font-bold text-sm uppercase tracking-widest mb-6">{{ __('Empresa') }}</h4>
                        <ul class="space-y-4">
                            <li><a href="{{ route('agendar-demonstracao') }}" class="text-prowise-softblue hover:text-prowise-blue text-sm transition-colors">{{ __('Agendar Demonstração') }}</a></li>
                            <li><a href="#" class="text-prowise-softblue hover:text-prowise-blue text-sm transition-colors">{{ __('Sobre Nós') }}</a></li>
                            <li><a href="#" class="text-prowise-softblue hover:text-prowise-blue text-sm transition-colors">{{ __('Blog') }}</a></li>
                        </ul>
                    </div>

                    <!-- Contact Column -->
                    <div>
                        <h4 class="text-white font-heading font-bold text-sm uppercase tracking-widest mb-6">{{ __('Contato') }}</h4>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-prowise-blue shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span class="text-prowise-softblue text-sm">contato@prowise.ai</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-prowise-blue shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span class="text-prowise-softblue text-sm">+55 (11) 99999-9999</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-prowise-blue shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="text-prowise-softblue text-sm">{{ __('Av. Paulista, 1000 - São Paulo, SP') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Footer -->
                <div class="pt-8 border-t border-prowise-gray/10 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-prowise-gray/60 text-xs italic">
                        &copy; {{ date('Y') }} Prowise. {{ __('Todos os direitos reservados. Grupo Startup One.') }}
                    </p>
                    <div class="flex gap-6">
                        <a href="#" class="text-prowise-gray/60 hover:text-white text-xs transition-colors">{{ __('Privacidade') }}</a>
                        <a href="#" class="text-prowise-gray/60 hover:text-white text-xs transition-colors">{{ __('Termos de Uso') }}</a>
                    </div>
                </div>
            </div>
        </footer>

        @stack('scripts')
    </body>
</html>
