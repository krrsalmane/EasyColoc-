<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-[#5a4fcf] border border-transparent rounded-xl font-semibold text-sm text-white transition-colors hover:bg-[#4a3fbf] focus:outline-none focus:ring-4 focus:ring-[#5a4fcf]/20 disabled:opacity-50 shadow-md']) }}>
    {{ $slot }}
</button>