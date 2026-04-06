<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('img/prowise_logo_bg-removebg-preview.png') }}">

        <title>{{ config('app.name', 'Prowise') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-prowise-navy text-white font-body antialiased min-h-screen selection:bg-prowise-blue selection:text-white overflow-x-hidden">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
            <div class="mb-8 transition-transform hover:scale-105 duration-300">
                <a href="/" class="flex flex-col items-center gap-4">
                    <img src="{{ asset('img/prowise_logo_bg-removebg-preview.png') }}" alt="Prowise Logo" class="w-20 h-20 drop-shadow-[0_0_15px_rgba(63,121,242,0.5)]">
                    <span class="font-heading font-semibold text-3xl tracking-wider text-white">Prowise</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-prowise-navy/80 backdrop-blur-xl border border-prowise-gray/20 shadow-2xl overflow-hidden sm:rounded-3xl relative">
                <!-- Inner Glow -->
                <div class="absolute -top-24 -left-24 w-48 h-48 bg-prowise-blue/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-prowise-green/10 rounded-full blur-3xl pointer-events-none"></div>
                
                {{ $slot }}
            </div>
            
            <p class="mt-8 text-prowise-gray/50 text-xs">
                &copy; {{ date('Y') }} Prowise. Grupo Startup One.
            </p>
        </div>

        <!-- Graphic Element (Neural Inspired Background) -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none opacity-40 z-0">
            <svg class="absolute w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <path d="M-100,600 C200,500 300,700 800,400 C1200,100 1600,500 2000,300" stroke="#3F79F2" stroke-width="1.5" fill="none" opacity="0.4"/>
                <path d="M-50,700 C300,600 400,800 900,500 C1300,200 1700,600 2100,400" stroke="#4CBF88" stroke-width="1" fill="none" opacity="0.3"/>
                <path d="M100,900 C500,800 600,1000 1100,700 C1500,400 1900,800 2300,600" stroke="#FC7158" stroke-width="0.5" fill="none" opacity="0.2"/>
                <circle cx="800" cy="400" r="3" fill="#3F79F2" class="animate-pulse" />
                <circle cx="300" cy="650" r="3" fill="#3F79F2" class="animate-pulse" style="animation-delay: 1.5s;" />
            </svg>
            <div class="absolute inset-0 bg-gradient-to-t from-prowise-navy via-transparent to-transparent"></div>
        </div>
    </body>
</html>
