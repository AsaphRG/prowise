<section>
    <header>
        <h2 class="text-2xl font-heading font-bold text-white tracking-tight">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-2 text-sm text-prowise-softblue/80">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('put')

        <div class="space-y-2">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-prowise-softblue" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full !bg-white/5 !text-white !border-prowise-gray/20 focus:!border-prowise-blue focus:!ring-prowise-blue transition-all" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-prowise-softblue" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full !bg-white/5 !text-white !border-prowise-gray/20 focus:!border-prowise-blue focus:!ring-prowise-blue transition-all" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-prowise-softblue" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full !bg-white/5 !text-white !border-prowise-gray/20 focus:!border-prowise-blue focus:!ring-prowise-blue transition-all" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
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
