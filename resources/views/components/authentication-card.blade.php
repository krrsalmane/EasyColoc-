<div
    class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#f8f9fa] font-sans text-gray-800">
    <div class="mb-4">
        {{ $logo }}
    </div>

    <div
        class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white border border-gray-100 shadow-xl shadow-gray-200/50 overflow-hidden sm:rounded-3xl">
        {{ $slot }}
    </div>
</div>