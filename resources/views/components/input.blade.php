@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-white border-gray-200 text-gray-800 focus:border-[#5a4fcf] focus:ring-[#5a4fcf]/20 rounded-xl shadow-sm transition-all py-3 px-4']) !!}>