<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-3xl text-white leading-tight tracking-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 relative z-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            <!-- Profile Information Section -->
            <div class="p-8 sm:p-12 bg-white/5 backdrop-blur-xl border border-prowise-gray/10 shadow-2xl sm:rounded-3xl transition-all hover:border-prowise-blue/20">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Update Section -->
            <div class="p-8 sm:p-12 bg-white/5 backdrop-blur-xl border border-prowise-gray/10 shadow-2xl sm:rounded-3xl transition-all hover:border-prowise-blue/20">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Section -->
            <div class="p-8 sm:p-12 bg-white/5 backdrop-blur-xl border border-prowise-gray/10 shadow-2xl sm:rounded-3xl transition-all hover:border-prowise-coral/20">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
