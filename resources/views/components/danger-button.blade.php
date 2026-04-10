<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-prowise-coral border border-transparent rounded-full font-semibold text-sm text-white hover:bg-prowise-coral/90 active:bg-prowise-coral/80 focus:outline-none focus:ring-2 focus:ring-prowise-coral focus:ring-offset-2 focus:ring-offset-white transition ease-in-out duration-150 shadow-lg hover:shadow-prowise-coral/30']) }}>
    {{ $slot }}
</button>
