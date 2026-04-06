@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-white/5 border-prowise-gray/20 focus:border-prowise-blue focus:ring-prowise-blue text-white placeholder-prowise-gray/50 rounded-xl shadow-sm transition-all px-4 py-3']) }}>
