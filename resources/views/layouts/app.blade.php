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
        <footer class="w-full py-8 text-center text-prowise-gray/60 text-sm z-10 relative bg-prowise-navy/90 border-t border-prowise-gray/10">
            <p>&copy; {{ date('Y') }} Prowise. Todos os direitos reservados. Grupo Startup One.</p>
        </footer>

        @stack('scripts')
    </body>
</html>
