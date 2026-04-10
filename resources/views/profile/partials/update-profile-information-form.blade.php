<section>
    <header>
        <h2 class="text-2xl font-heading font-bold text-white tracking-tight">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-2 text-sm text-prowise-softblue/80">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('patch')

        <div class="space-y-2">
            <x-input-label for="name" :value="__('Name')" class="text-prowise-softblue" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full !bg-white/5 !text-white !border-prowise-gray/20 focus:!border-prowise-blue focus:!ring-prowise-blue transition-all" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email')" class="text-prowise-softblue" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full !bg-white/5 !text-white !border-prowise-gray/20 focus:!border-prowise-blue focus:!ring-prowise-blue transition-all" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-prowise-coral/10 border border-prowise-coral/20 rounded-xl">
                    <p class="text-sm text-prowise-coral">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="ms-1 underline text-sm text-prowise-coral/80 hover:text-prowise-coral rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-prowise-coral">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-prowise-green">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-prowise-green flex items-center gap-1"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
