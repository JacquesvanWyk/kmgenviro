<?php

use function Livewire\Volt\{computed, layout, title};
use App\Models\Sector;

layout('components.layouts.public');
title('Industry Sectors | KMG Environmental Solutions');

$sectors = computed(fn() =>
    Sector::where('is_active', true)
        ->withCount('projects')
        ->orderBy('sort_order')
        ->get()
);

?>

<div>
    <x-public.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Sectors']
    ]" />

    @php
        $sectorImages = [
            'mining-mineral-resources' => 'sectors/mining.jpg',
            'infrastructure-construction' => 'sectors/infrastructure-construction.jpg',
            'municipal-public-sector' => 'gallery/team-fieldwork.jpg',
            'renewable-energy' => 'services/environmental-monitoring.jpg',
            'industrial-manufacturing' => 'sectors/industrial-manufacturing.jpg',
            'water-sanitation-utilities' => 'services/water-monitoring.jpg',
        ];

        $sectorIcons = [
            'mining-mineral-resources' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>',
            'infrastructure-construction' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
            'municipal-public-sector' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>',
            'renewable-energy' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
            'industrial-manufacturing' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>',
            'water-sanitation-utilities' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>',
        ];
    @endphp

    <!-- Hero Section -->
    <section class="relative py-20 bg-gradient-to-br from-green-900 to-green-700 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="{{ asset('images/sectors/mining.jpg') }}" alt="" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-green-900/90 to-green-800/80"></div>
        <div class="relative max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold mb-6">Industry Sectors We Serve</h1>
            <p class="text-xl text-green-100 max-w-3xl mx-auto">
                KMG Environmental Solutions provides specialized environmental consultancy services
                across diverse industry sectors throughout South Africa and the SADC region.
            </p>
        </div>
    </section>

    <!-- Sectors Grid -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($this->sectors as $sector)
                    @php
                        $image = $sectorImages[$sector->slug] ?? 'gallery/team-fieldwork.jpg';
                        $icon = $sectorIcons[$sector->slug] ?? '';
                    @endphp
                    <div class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <!-- Image -->
                        <div class="relative h-48 overflow-hidden">
                            <img
                                src="{{ asset('images/' . $image) }}"
                                alt="{{ $sector->name }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-green-600 rounded-lg text-white">
                                        {!! $icon !!}
                                    </div>
                                    <h3 class="text-xl font-bold text-white">{{ $sector->name }}</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <p class="text-gray-600 mb-4">{{ $sector->description }}</p>

                            @if($sector->projects_count > 0)
                                <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    {{ $sector->projects_count }} {{ Str::plural('project', $sector->projects_count) }} completed
                                </div>
                            @endif

                            <a href="{{ route('projects.index', ['sector' => $sector->slug]) }}"
                               class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-medium transition">
                                View Projects
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-zinc-100">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Need Environmental Services for Your Sector?</h2>
            <p class="text-xl text-gray-600 mb-8">
                Our team has experience across all major industries. Contact us to discuss your specific requirements.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('contact') }}"
                   class="px-8 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                    Request a Quote
                </a>
                <a href="{{ route('services.index') }}"
                   class="px-8 py-3 bg-white text-green-600 font-semibold rounded-lg border-2 border-green-600 hover:bg-green-50 transition">
                    View All Services
                </a>
            </div>
        </div>
    </section>
</div>
