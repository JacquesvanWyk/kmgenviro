@php
$navigation = [
    ['label' => 'Home', 'route' => 'home'],
    ['label' => 'About', 'route' => 'about'],
    ['label' => 'Services', 'route' => 'services.index'],
    ['label' => 'Sectors & Projects', 'route' => 'sectors.index'],
    ['label' => 'Training & Events', 'route' => 'training.index'],
    ['label' => 'Resources', 'route' => 'resources', 'children' => [
        ['label' => 'Downloads', 'route' => 'resources'],
        ['label' => 'Equipment Rental', 'route' => 'equipment.index'],
        ['label' => 'Gallery', 'route' => 'gallery'],
        // ['label' => 'Blog', 'route' => 'blog.index'], // Commented out for now
    ]],
    ['label' => 'Contact', 'route' => 'contact'],
];
@endphp

<!-- Top Contact Bar -->
<div class="bg-zinc-900 text-white text-sm hidden md:block">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-10">
            <div class="flex items-center gap-4">
                <a href="tel:0114804822" class="flex items-center gap-2 hover:text-green-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span>011 480 4822</span>
                </a>
                <span class="text-zinc-600">/</span>
                <a href="tel:0119696184" class="hover:text-green-400 transition-colors">
                    <span>011 969 6184</span>
                </a>
                <span class="text-zinc-600">|</span>
                <a href="tel:0725463191" class="flex items-center gap-2 hover:text-green-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <span>072 546 3191</span>
                </a>
                <span class="text-zinc-600">|</span>
                <a href="mailto:info@kmgenviro.co.za" class="flex items-center gap-2 hover:text-green-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>info@kmgenviro.co.za</span>
                </a>
            </div>
            <div class="flex items-center gap-4">
                <a href="https://wa.me/+27725463191" target="_blank" class="flex items-center gap-2 hover:text-green-400 transition-colors" title="WhatsApp">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </a>
                <a href="https://www.facebook.com/kmgenviro" target="_blank" class="hover:text-green-400 transition-colors" title="Facebook">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                <a href="https://www.linkedin.com/company/53420196" target="_blank" class="hover:text-green-400 transition-colors" title="LinkedIn">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </a>
                <span class="text-zinc-600">|</span>
                <a href="{{ route('resources') }}" class="flex items-center gap-1 hover:text-green-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Company Profile</span>
                </a>
            </div>
        </div>
    </div>
</div>

<header class="bg-white/95 backdrop-blur-sm border-b border-zinc-200 sticky top-0 z-50 shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center group">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="KMG Environmental Solutions Services"
                         class="h-12 w-auto transition-opacity group-hover:opacity-80">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center gap-6">
                @foreach($navigation as $item)
                    @if(isset($item['children']))
                        <!-- Dropdown Menu -->
                        <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                            <a href="{{ route($item['route']) }}"
                               class="flex items-center gap-1 text-zinc-700 hover:text-green-600 font-semibold transition-colors {{ request()->routeIs($item['route'] . '*') ? 'text-green-600' : '' }}">
                                {{ $item['label'] }}
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </a>

                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                                 class="absolute left-0 mt-2 w-56 bg-white border border-zinc-200 rounded-lg shadow-xl z-50"
                                 style="display: none;">
                                @foreach($item['children'] as $child)
                                    <a href="{{ route($child['route']) }}"
                                       class="block px-5 py-3 text-sm text-zinc-700 hover:bg-green-50 hover:text-green-600 transition-colors first:rounded-t-lg last:rounded-b-lg {{ request()->routeIs($child['route']) ? 'text-green-600 bg-green-50' : '' }}">
                                        {{ $child['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ route($item['route']) }}"
                           class="text-zinc-700 hover:text-green-600 font-semibold transition-colors {{ request()->routeIs($item['route']) ? 'text-green-600' : '' }}">
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>

            <!-- CTA Button (Desktop) -->
            <a href="{{ route('contact') }}"
               class="hidden lg:inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-green-600 hover:bg-green-700 rounded-lg transition-all shadow-lg shadow-green-600/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <span>Get a Quote</span>
            </a>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden p-2 text-zinc-700 hover:text-green-600 hover:bg-zinc-50 rounded-lg transition">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="lg:hidden border-t border-zinc-200 bg-white"
         style="display: none;">

        <!-- Mobile Contact Bar -->
        <div class="px-4 py-3 bg-zinc-50 border-b border-zinc-200 flex flex-wrap gap-3 text-sm">
            <a href="tel:0114804822" class="flex items-center gap-2 text-zinc-700">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                011 480 4822
            </a>
            <a href="tel:0725463191" class="flex items-center gap-2 text-zinc-700">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                072 546 3191
            </a>
            <a href="mailto:info@kmgenviro.co.za" class="flex items-center gap-2 text-zinc-700">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                info@kmgenviro.co.za
            </a>
        </div>

        <nav class="px-4 pt-4 pb-6 space-y-1">
            @foreach($navigation as $item)
                @if(isset($item['children']))
                    <!-- Mobile Dropdown -->
                    <div x-data="{ open: false }" class="border-b border-zinc-200 pb-2">
                        <button @click="open = !open"
                                class="w-full flex items-center justify-between py-3 text-zinc-700 hover:text-green-600 font-semibold transition-colors">
                            {{ $item['label'] }}
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="pl-4 space-y-1 mt-2">
                            @foreach($item['children'] as $child)
                                <a href="{{ route($child['route']) }}"
                                   class="block py-2 text-sm text-zinc-600 hover:text-green-600 transition-colors {{ request()->routeIs($child['route']) ? 'text-green-600' : '' }}">
                                    {{ $child['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ route($item['route']) }}"
                       class="block py-3 text-zinc-700 hover:text-green-600 font-semibold transition-colors border-b border-zinc-200 {{ request()->routeIs($item['route']) ? 'text-green-600' : '' }}">
                        {{ $item['label'] }}
                    </a>
                @endif
            @endforeach

            <!-- Mobile CTA -->
            <a href="{{ route('contact') }}"
               class="mt-4 flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold text-white bg-green-600 hover:bg-green-700 rounded-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <span>Get a Quote</span>
            </a>

            <!-- Mobile WhatsApp -->
            <a href="https://wa.me/27119696184" target="_blank"
               class="mt-2 flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold text-white bg-green-500 hover:bg-green-600 rounded-lg transition-all">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                <span>Chat on WhatsApp</span>
            </a>
        </nav>
    </div>
</header>
