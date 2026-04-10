<nav x-data="{ open: false }" class="bg-prowise-navy/90 border-b border-prowise-gray/10 backdrop-blur-md sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 hover:opacity-90 transition-opacity">
                        <img src="{{ asset('img/prowise_logo_bg-removebg-preview.png') }}" alt="Prowise Logo" class="h-10 w-auto">
                        <span class="font-heading font-semibold text-2xl tracking-wide text-white">Prowise</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-prowise-softblue hover:text-white border-transparent hover:border-prowise-blue">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('chat')" :active="request()->routeIs('chat')" class="text-prowise-softblue hover:text-white border-transparent hover:border-prowise-blue">
                            {{ __('Chat IA') }}
                        </x-nav-link>
                    @endauth
                    @guest
                        <x-nav-link :href="route('agendar-demonstracao')" :active="request()->routeIs('agendar-demonstracao')" class="text-prowise-softblue hover:text-white border-transparent hover:border-prowise-blue">
                            {{ __('Agendar Demo') }}
                        </x-nav-link>
                    @endguest
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Language Switcher -->
                <div class="me-10">
                    @php
                        $locales = [
                            'en' => 'English', 'pt' => 'Português', 'fr' => 'Français', 'zh' => 'Mandarin',
                            'hi' => 'Hindi', 'es' => 'Español', 'ar' => 'العربية', 'bn' => 'Bengali',
                            'ru' => 'Русский', 'ur' => 'Urdu', 'id' => 'Indonesian', 'de' => 'Deutsch',
                            'ja' => '日本語', 'pcm' => 'Nigerian Pidgin', 'mr' => 'Marathi', 'te' => 'Telugu',
                            'tr' => 'Türkçe', 'ta' => 'Tamil', 'yue' => 'Cantonese', 'vi' => 'Tiếng Việt',
                            'tl' => 'Tagalog', 'wuu' => 'Wu Chinese', 'ko' => '한국어'
                        ];
                        $currentLocale = App::getLocale();
                    @endphp

                    <x-dropdown align="right" width="48" contentClasses="py-1 bg-prowise-navy border border-prowise-gray/20 shadow-2xl max-h-96 overflow-y-auto custom-scrollbar">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-5 py-2.5 border border-prowise-gray/20 text-xs font-bold rounded-full text-prowise-softblue bg-white/5 hover:text-white hover:bg-white/10 transition-all uppercase gap-3 group">
                                <svg class="w-4.5 h-4.5 text-prowise-blue group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                                <span>{{ $currentLocale }}</span>
                                <svg class="h-3 w-3 fill-current opacity-40" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @foreach($locales as $code => $name)
                                <x-dropdown-link :href="route('locale.switch', $code)" 
                                    class="text-xs {{ $currentLocale == $code ? 'text-prowise-blue bg-white/5 font-bold' : 'text-prowise-softblue hover:text-white hover:bg-white/10' }} flex justify-between items-center px-4 py-2 transition-colors">
                                    <span>{{ $name }}</span>
                                    <span class="text-[10px] opacity-50 uppercase">{{ $code }}</span>
                                </x-dropdown-link>
                            @endforeach
                        </x-slot>
                    </x-dropdown>
                </div>

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 border border-prowise-gray/20 text-sm leading-4 font-medium rounded-full text-prowise-softblue bg-white/5 hover:text-white hover:bg-white/10 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="hover:bg-prowise-blue/10">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                        class="hover:bg-prowise-blue/10">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-prowise-softblue hover:text-white text-sm font-medium transition-colors">{{ __('Log In') }}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-prowise-blue hover:bg-prowise-blue/90 text-white px-6 py-2.5 rounded-full text-sm font-medium transition-all shadow-md">{{ __('Get Started') }}</a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-prowise-softblue hover:text-white hover:bg-white/5 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-prowise-navy border-t border-prowise-gray/10">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-prowise-softblue hover:text-white hover:bg-prowise-blue/10">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('chat')" :active="request()->routeIs('chat')" class="text-prowise-softblue hover:text-white hover:bg-prowise-blue/10">
                    {{ __('Chat IA') }}
                </x-responsive-nav-link>
            @endauth
            @guest
                <x-responsive-nav-link :href="route('agendar-demonstracao')" :active="request()->routeIs('agendar-demonstracao')" class="text-prowise-softblue hover:text-white hover:bg-prowise-blue/10">
                    {{ __('Agendar Demo') }}
                </x-responsive-nav-link>
            @endguest
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-prowise-gray/10">
            <!-- Language Switcher Mobile -->
            <div class="px-4 mb-4">
                <div class="text-xs font-bold text-prowise-softblue uppercase tracking-widest mb-3 opacity-50">{{ __('Language') }}</div>
                <div class="flex flex-wrap gap-2">
                    @php
                        $locales = [
                            'pt' => 'PT', 'en' => 'EN', 'es' => 'ES', 'fr' => 'FR', 'de' => 'DE'
                        ];
                        $currentLocale = App::getLocale();
                    @endphp
                    @foreach($locales as $code => $label)
                        <a href="{{ route('locale.switch', $code) }}" 
                           class="px-3 py-1.5 rounded-full border {{ $currentLocale == $code ? 'bg-prowise-blue border-prowise-blue text-white font-bold' : 'border-prowise-gray/20 text-prowise-softblue hover:text-white hover:bg-white/5' }} text-xs transition-all">
                            {{ $label }}
                        </a>
                    @endforeach
                    <x-dropdown align="left" width="48" contentClasses="py-1 bg-prowise-navy border border-prowise-gray/20 shadow-2xl max-h-64 overflow-y-auto custom-scrollbar">
                        <x-slot name="trigger">
                            <button class="px-3 py-1.5 rounded-full border border-prowise-gray/20 text-prowise-softblue hover:text-white hover:bg-white/5 text-xs transition-all flex items-center gap-1">
                                <span>+</span>
                                <svg class="h-3 w-3 fill-current opacity-60" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @php
                                $allLocales = [
                                    'en' => 'English', 'pt' => 'Português', 'fr' => 'Français', 'zh' => 'Mandarin',
                                    'hi' => 'Hindi', 'es' => 'Español', 'ar' => 'العربية', 'bn' => 'Bengali',
                                    'ru' => 'Русский', 'ur' => 'Urdu', 'id' => 'Indonesian', 'de' => 'Deutsch',
                                    'ja' => '日本語', 'pcm' => 'Nigerian Pidgin', 'mr' => 'Marathi', 'te' => 'Telugu',
                                    'tr' => 'Türkçe', 'ta' => 'Tamil', 'yue' => 'Cantonese', 'vi' => 'Tiếng Việt',
                                    'tl' => 'Tagalog', 'wuu' => 'Wu Chinese', 'ko' => '한국어'
                                ];
                            @endphp
                            @foreach($allLocales as $code => $name)
                                <x-dropdown-link :href="route('locale.switch', $code)" class="text-xs text-prowise-softblue hover:text-white">
                                    {{ $name }}
                                </x-dropdown-link>
                            @endforeach
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-prowise-softblue">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-prowise-softblue hover:text-white hover:bg-prowise-blue/10">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                class="text-prowise-softblue hover:text-white hover:bg-prowise-blue/10">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('login')" class="text-prowise-softblue hover:text-white hover:bg-prowise-blue/10">
                        {{ __('Log In') }}
                    </x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')" class="text-prowise-softblue hover:text-white hover:bg-prowise-blue/10">
                            {{ __('Get Started') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>
