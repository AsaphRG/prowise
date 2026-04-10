<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-heading font-bold text-white mb-2">{{ __('Welcome back') }}</h2>
        <p class="text-sm text-prowise-softblue">{{ __('Access your account to continue') }}</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-md border-prowise-gray/30 bg-white/5 text-prowise-blue shadow-sm focus:ring-prowise-blue focus:ring-offset-prowise-navy transition-all cursor-pointer" name="remember">
                <span class="ms-2 text-sm text-prowise-softblue group-hover:text-white transition-colors">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-prowise-blue hover:text-white transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full">
                {{ __('Log In') }}
            </x-primary-button>
        </div>

        @if (Route::has('register'))
            <p class="mt-8 text-center text-sm text-prowise-softblue">
                {{ __('Não tem uma conta?') }}
                <a href="{{ route('register') }}" class="text-prowise-blue font-semibold hover:text-white transition-colors">
                    {{ __('Cadastre-se agora') }}
                </a>
            </p>
        @endif
    </form>
</x-guest-layout>
