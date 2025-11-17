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

<header class="bg-white shadow-sm sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="KMG Environmental Solutions"
                         class="h-12">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-8">
                @foreach($navigation as $item)
                    @if(isset($item['children']))
                        <!-- Dropdown Menu -->
                        <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                            <button @click="open = !open"
                                    class="flex items-center gap-1 text-gray-700 hover:text-green-600 font-medium transition {{ request()->routeIs($item['route']) || request()->routeIs('team') || request()->routeIs('accreditations') ? 'text-green-600' : '' }}">
                                {{ $item['label'] }}
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-95"
                                 class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                                 style="display: none;">
                                @foreach($item['children'] as $child)
                                    <a href="{{ route($child['route']) }}"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition {{ request()->routeIs($child['route']) ? 'text-green-600 bg-green-50' : '' }}">
                                        {{ $child['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ route($item['route']) }}"
                           class="text-gray-700 hover:text-green-600 font-medium transition {{ request()->routeIs($item['route']) ? 'text-green-600' : '' }}">
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="md:hidden p-2 rounded-md text-gray-700 hover:text-green-600 hover:bg-gray-100 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;" />
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
         class="md:hidden border-t"
         style="display: none;">
        <nav class="px-4 pt-2 pb-4 space-y-1">
            @foreach($navigation as $item)
                @if(isset($item['children']))
                    <!-- Mobile Dropdown -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                                class="w-full flex items-center justify-between py-2 text-gray-700 hover:text-green-600 font-medium transition">
                            {{ $item['label'] }}
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="pl-4 space-y-1">
                            @foreach($item['children'] as $child)
                                <a href="{{ route($child['route']) }}"
                                   class="block py-2 text-sm text-gray-600 hover:text-green-600 transition {{ request()->routeIs($child['route']) ? 'text-green-600' : '' }}">
                                    {{ $child['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ route($item['route']) }}"
                       class="block py-2 text-gray-700 hover:text-green-600 font-medium transition {{ request()->routeIs($item['route']) ? 'text-green-600' : '' }}">
                        {{ $item['label'] }}
                    </a>
                @endif
            @endforeach
        </nav>
    </div>
</header>
