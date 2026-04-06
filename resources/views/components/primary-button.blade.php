<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-prowise-blue border border-transparent rounded-full font-semibold text-sm text-white hover:bg-prowise-blue/90 focus:outline-none focus:ring-2 focus:ring-prowise-blue focus:ring-offset-2 focus:ring-offset-prowise-navy transition ease-in-out duration-150 shadow-lg hover:shadow-prowise-blue/30']) }}>
    {{ $slot }}
</button>
