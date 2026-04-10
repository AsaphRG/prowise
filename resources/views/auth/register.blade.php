<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-heading font-bold text-white mb-2">{{ __('Create your account') }}</h2>
        <p class="text-sm text-prowise-softblue">{{ __('Join Prowise and organize your operation') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="{{ __('Seu Nome') }}" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="{{ __('Minimum 8 characters') }}" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="{{ __('Repeat your password') }}" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        <p class="mt-8 text-center text-sm text-prowise-softblue">
            {{ __('Already have an account?') }}
            <a href="{{ route('login') }}" class="text-prowise-blue font-semibold hover:text-white transition-colors">
                {{ __('Log In') }}
            </a>
        </p>
    </form>
</x-guest-layout>
