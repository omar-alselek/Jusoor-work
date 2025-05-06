@props(['route', 'icon'])

@php
$isActive = request()->routeIs($route);
$activeClasses = 'bg-white/30 text-white shadow-inner font-semibold';
$inactiveClasses = 'text-white hover:bg-white/20 hover:text-white';
@endphp

<a href="{{ route($route) }}"
   class="group flex items-center px-3 py-2 text-xs font-medium rounded-md relative transition-colors duration-200 gap-2 {{ $isActive ? $activeClasses : $inactiveClasses }}"
   :class="sidebarOpen ? '' : 'justify-center'">

    <svg class="flex-shrink-0 transition-colors duration-200 {{ $isActive ? 'text-white' : 'text-white group-hover:text-white' }}"
         width="20" height="20" style="min-width:20px;min-height:20px;" 
         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
    </svg>

    <span class="flex-1 transition-opacity duration-200 ease-in-out" :class="sidebarOpen ? 'opacity-100 delay-100' : 'opacity-0 w-0 h-0'">
        {{ $slot }}
    </span>

    {{-- Animated Active Indicator --}}
    <span
        class="absolute inset-y-0 left-0 w-1.5 bg-yellow-400 rounded-r-full transition-transform duration-300 ease-in-out {{ $isActive ? 'scale-y-100' : 'scale-y-0' }}"
        aria-hidden="true"
        :class="sidebarOpen ? '' : '-left-1 w-1.5'">
    </span>
</a> 