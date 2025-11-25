@php
$navigation = [
    ['label' => 'Home', 'route' => 'home'],
    ['label' => 'About', 'route' => 'about', 'children' => [
        ['label' => 'Our Team', 'route' => 'team'],
        ['label' => 'Accreditations', 'route' => 'accreditations'],
    ]],
    ['label' => 'Services', 'route' => 'services.index'],
    ['label' => 'Projects', 'route' => 'projects.index'],
    ['label' => 'Training', 'route' => 'training.index'],
    ['label' => 'Equipment', 'route' => 'equipment.index'],
    ['label' => 'Blog', 'route' => 'blog.index'],
    ['label' => 'Contact', 'route' => 'contact'],
];
@endphp

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
            <nav class="hidden lg:flex items-center gap-8">
                @foreach($navigation as $item)
                    @if(isset($item['children']))
                        <!-- Dropdown Menu -->
                        <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                            <button @click="open = !open"
                                    class="flex items-center gap-1 text-zinc-700 hover:text-green-600 font-semibold transition-colors {{ request()->routeIs($item['route']) || request()->routeIs('team') || request()->routeIs('accreditations') ? 'text-green-600' : '' }}">
                                {{ $item['label'] }}
                                <x-solar-icon name="alt-arrow-down" size="16" class="transition-transform" x-bind:class="{ 'rotate-180': open }" />
                            </button>

                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                                 class="absolute left-0 mt-4 w-56 bg-white border border-zinc-200 shadow-xl z-50"
                                 style="display: none;">
                                @foreach($item['children'] as $child)
                                    <a href="{{ route($child['route']) }}"
                                       class="block px-6 py-3 text-sm text-zinc-700 hover:bg-zinc-50 hover:text-green-600 transition-colors border-l-2 border-transparent hover:border-green-600 {{ request()->routeIs($child['route']) ? 'text-green-600 bg-zinc-50 border-green-600' : '' }}">
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
               class="hidden lg:inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all btn-beam">
                <x-solar-icon name="phone-calling" size="20" />
                <span>Get a Quote</span>
            </a>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden p-2 text-zinc-700 hover:text-green-600 hover:bg-zinc-50 transition">
                <x-solar-icon name="hamburger-menu" size="24" x-show="!mobileMenuOpen" />
                <x-solar-icon name="close-circle" size="24" x-show="mobileMenuOpen" style="display: none;" />
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
        <nav class="px-4 pt-4 pb-6 space-y-1">
            @foreach($navigation as $item)
                @if(isset($item['children']))
                    <!-- Mobile Dropdown -->
                    <div x-data="{ open: false }" class="border-b border-zinc-200 pb-2">
                        <button @click="open = !open"
                                class="w-full flex items-center justify-between py-3 text-zinc-700 hover:text-green-600 font-semibold transition-colors">
                            {{ $item['label'] }}
                            <x-solar-icon name="alt-arrow-down" size="16" class="transition-transform" x-bind:class="{ 'rotate-180': open }" />
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
               class="mt-4 flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                <x-solar-icon name="phone-calling" size="20" />
                <span>Get a Quote</span>
            </a>
        </nav>
    </div>
</header>
