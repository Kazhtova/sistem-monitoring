@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-slate-700 focus:ring-slate-700 rounded-md shadow-sm']) }}>
