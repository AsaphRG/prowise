<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-white border border-prowise-gray/30 rounded-full font-semibold text-sm text-prowise-navy hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-prowise-blue focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm']) }}>
    {{ $slot }}
</button>
