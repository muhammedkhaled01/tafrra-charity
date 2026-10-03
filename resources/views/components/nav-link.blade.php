@props(['href', 'active' => false, 'icon' => null])

@php
$classes = $active
            ? 'flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl bg-brand-50 text-brand-700 dark:bg-brand-900/30 dark:text-brand-300 transition-colors'
            : 'flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-100 transition-colors';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        @if($icon === 'home')
            <svg class="w-5 h-5 {{ $active ? 'text-brand-600 dark:text-brand-400' : 'text-gray-400 dark:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
        @elseif($icon === 'users')
            <svg class="w-5 h-5 {{ $active ? 'text-brand-600 dark:text-brand-400' : 'text-gray-400 dark:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        @elseif($icon === 'folder')
            <svg class="w-5 h-5 {{ $active ? 'text-brand-600 dark:text-brand-400' : 'text-gray-400 dark:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
            </svg>
        @elseif($icon === 'credit-card')
            <svg class="w-5 h-5 {{ $active ? 'text-brand-600 dark:text-brand-400' : 'text-gray-400 dark:text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>
        @endif
    @endif
    {{ $slot }}
</a>
