<?php

use function Livewire\Volt\{computed, layout, state, title};
use App\Models\Resource;

layout('components.layouts.public');
title('Resources & Downloads | KMG Environmental Solutions');

$seoDescription = 'Download KMG Environmental Solutions company profile, service brochures, training materials, and technical guides. Free resources for environmental professionals and industry stakeholders.';
$seoKeywords = 'environmental resources, company profile download, environmental brochures, training materials, technical guides, KMG downloads, environmental documentation';

state([
    'categoryFilter' => '',
]);

$resources = computed(fn() =>
    Resource::where('is_active', true)
        ->when($this->categoryFilter, fn($q) => $q->where('category', $this->categoryFilter))
        ->orderBy('sort_order')
        ->orderBy('title')
        ->get()
);

$categories = computed(fn() =>
    Resource::where('is_active', true)
        ->distinct()
        ->pluck('category')
        ->filter()
        ->sort()
        ->values()
);

$resourceCategories = computed(fn() => [
    'Company Information' => [
        'icon' => 'buildings',
        'color' => 'bg-blue-500',
        'description' => 'Company profile and corporate information',
    ],
    'Service Brochures' => [
        'icon' => 'document-text',
        'color' => 'bg-green-500',
        'description' => 'Detailed brochures on our service offerings',
    ],
    'Training Materials' => [
        'icon' => 'graduation-cap',
        'color' => 'bg-purple-500',
        'description' => 'Training schedules and course information',
    ],
    'Technical Guides' => [
        'icon' => 'book-2',
        'color' => 'bg-orange-500',
        'description' => 'Helpful guides on environmental compliance',
    ],
]);

$downloadResource = function ($resourceId) {
    $resource = Resource::find($resourceId);
    if (!$resource) return;

    $resource->increment('download_count');
    $this->dispatch('download-file', url: \Storage::url($resource->file));
};

?>

<x-slot:description>{{ $seoDescription }}</x-slot:description>
<x-slot:keywords>{{ $seoKeywords }}</x-slot:keywords>

<div x-data="{ activeCategory: @entangle('categoryFilter') }"
     @download-file.window="window.open($event.detail.url, '_blank')">

    <!-- Hero Section -->
    <section class="relative py-24 bg-zinc-900 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-zinc-900/80 to-zinc-900/95"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4">
            <x-public.breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Resources']
            ]" class="mb-8" />

            <div class="max-w-4xl">
                <h1 class="text-5xl md:text-6xl font-black text-white mb-6">
                    Resources & <span class="text-green-500">Downloads</span>
                </h1>
                <p class="text-xl text-zinc-300 leading-relaxed">
                    Access our library of environmental compliance guides, service brochures, and technical resources.
                </p>
            </div>
        </div>
    </section>

    <!-- Resource Categories Overview -->
    <section class="py-8 bg-zinc-100 border-b border-zinc-200">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-wrap justify-center gap-4">
                <button @click="activeCategory = ''"
                        :class="activeCategory === '' ? 'bg-green-500 text-zinc-950 border-green-500' : 'bg-white text-zinc-700 border-zinc-200 hover:border-green-500'"
                        class="px-5 py-2 font-semibold border-2 transition-colors rounded-full">
                    All Resources
                </button>
                @foreach($this->resourceCategories as $catName => $catInfo)
                    <button @click="activeCategory = '{{ $catName }}'"
                            :class="activeCategory === '{{ $catName }}' ? '{{ $catInfo['color'] }} text-white border-transparent' : 'bg-white text-zinc-700 border-zinc-200 hover:border-green-500'"
                            class="px-5 py-2 font-semibold border-2 transition-colors rounded-full flex items-center gap-2">
                        <x-solar-icon name="{{ $catInfo['icon'] }}" size="18" />
                        {{ $catName }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Downloads Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-black text-zinc-950 mb-2">
                    Download Centre
                </h2>
                <p class="text-zinc-600">
                    Free resources for environmental compliance
                </p>
            </div>

            @if($this->resources->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($this->resources as $resource)
                        @php
                            $catInfo = $this->resourceCategories[$resource->category] ?? [
                                'icon' => 'document',
                                'color' => 'bg-zinc-500',
                            ];
                            $fileExt = strtoupper(pathinfo($resource->file ?? '', PATHINFO_EXTENSION) ?: 'PDF');
                        @endphp

                        <div class="bg-white border border-zinc-200 rounded-lg overflow-hidden hover:shadow-lg hover:border-green-500 transition-all group"
                             x-show="activeCategory === '' || activeCategory === '{{ $resource->category }}'"
                             x-transition>
                            <!-- Card Header -->
                            <div class="p-6 border-b border-zinc-100">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 {{ $catInfo['color'] }} rounded-lg flex items-center justify-center flex-shrink-0">
                                        <x-solar-icon name="{{ $catInfo['icon'] }}" size="24" class="text-white" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-zinc-950 mb-1 group-hover:text-green-600 transition-colors">
                                            {{ $resource->title }}
                                        </h3>
                                        @if($resource->category)
                                            <span class="text-xs text-zinc-500">{{ $resource->category }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-6">
                                @if($resource->description)
                                    <p class="text-sm text-zinc-600 mb-4 line-clamp-2">
                                        {{ $resource->description }}
                                    </p>
                                @endif

                                <div class="flex items-center gap-4 text-xs text-zinc-500 mb-4">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-zinc-100 rounded">
                                        <x-solar-icon name="file" size="12" />
                                        {{ $fileExt }}
                                    </span>
                                    @if($resource->file_size)
                                        <span>{{ $resource->file_size }}</span>
                                    @endif
                                    @if($resource->download_count > 0)
                                        <span class="flex items-center gap-1">
                                            <x-solar-icon name="download-minimalistic" size="12" />
                                            {{ number_format($resource->download_count) }}
                                        </span>
                                    @endif
                                </div>

                                <button wire:click="downloadResource({{ $resource->id }})"
                                        class="w-full px-4 py-3 bg-green-500 hover:bg-green-400 text-zinc-950 font-bold transition-all flex items-center justify-center gap-2">
                                    <x-solar-icon name="download-minimalistic" size="20" />
                                    Download Now
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Placeholder Downloads when database is empty -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        $placeholderResources = [
                            [
                                'title' => 'KMG Company Profile',
                                'category' => 'Company Information',
                                'description' => 'Learn about KMG Environmental Solutions, our history, capabilities, and team.',
                                'icon' => 'buildings',
                                'color' => 'bg-blue-500',
                                'download_url' => route('download.company-profile'),
                            ],
                            [
                                'title' => 'Environmental Monitoring Services',
                                'category' => 'Service Brochures',
                                'description' => 'Water, air, noise, and soil monitoring capabilities and accreditations.',
                                'icon' => 'chart-2',
                                'color' => 'bg-green-500',
                            ],
                            [
                                'title' => 'Waste & Asbestos Management',
                                'category' => 'Service Brochures',
                                'description' => 'Hazardous waste, asbestos surveys, and DoEL-approved services.',
                                'icon' => 'trash-bin-minimalistic',
                                'color' => 'bg-orange-500',
                            ],
                            [
                                'title' => 'ESG & Carbon Services',
                                'category' => 'Service Brochures',
                                'description' => 'Carbon footprinting, climate risk, and ESG strategy development.',
                                'icon' => 'leaf',
                                'color' => 'bg-emerald-500',
                            ],
                            [
                                'title' => 'Training Course Schedule',
                                'category' => 'Training Materials',
                                'description' => 'Upcoming training dates, venues, and CPD point information.',
                                'icon' => 'graduation-cap',
                                'color' => 'bg-purple-500',
                            ],
                            [
                                'title' => 'Basic EIA Process Guide',
                                'category' => 'Technical Guides',
                                'description' => 'Understanding the Environmental Impact Assessment process in South Africa.',
                                'icon' => 'book-2',
                                'color' => 'bg-orange-500',
                            ],
                            [
                                'title' => 'What is a WULA?',
                                'category' => 'Technical Guides',
                                'description' => 'Guide to Water Use License Applications under the National Water Act.',
                                'icon' => 'book-2',
                                'color' => 'bg-orange-500',
                            ],
                            [
                                'title' => 'Asbestos Compliance Overview',
                                'category' => 'Technical Guides',
                                'description' => 'Requirements for asbestos surveys, management, and abatement.',
                                'icon' => 'book-2',
                                'color' => 'bg-orange-500',
                            ],
                            [
                                'title' => 'AEL Application Checklist',
                                'category' => 'Technical Guides',
                                'description' => 'Checklist for Atmospheric Emission License applications.',
                                'icon' => 'book-2',
                                'color' => 'bg-orange-500',
                            ],
                        ];
                    @endphp

                    @foreach($placeholderResources as $resource)
                        <div class="bg-white border border-zinc-200 rounded-lg overflow-hidden hover:shadow-lg hover:border-green-500 transition-all group"
                             x-show="activeCategory === '' || activeCategory === '{{ $resource['category'] }}'"
                             x-transition>
                            <div class="p-6 border-b border-zinc-100">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 {{ $resource['color'] }} rounded-lg flex items-center justify-center flex-shrink-0">
                                        <x-solar-icon name="{{ $resource['icon'] }}" size="24" class="text-white" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-zinc-950 mb-1 group-hover:text-green-600 transition-colors">
                                            {{ $resource['title'] }}
                                        </h3>
                                        <span class="text-xs text-zinc-500">{{ $resource['category'] }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6">
                                <p class="text-sm text-zinc-600 mb-4 line-clamp-2">
                                    {{ $resource['description'] }}
                                </p>

                                <div class="flex items-center gap-4 text-xs text-zinc-500 mb-4">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-zinc-100 rounded">
                                        <x-solar-icon name="file" size="12" />
                                        PDF
                                    </span>
                                </div>

                                @if(isset($resource['download_url']))
                                    <a href="{{ $resource['download_url'] }}"
                                       class="w-full px-4 py-3 bg-green-500 hover:bg-green-400 text-zinc-950 font-bold transition-all flex items-center justify-center gap-2">
                                        <x-solar-icon name="download-minimalistic" size="20" />
                                        Download Now
                                    </a>
                                @else
                                    <a href="{{ route('contact') }}?subject={{ urlencode('Request: ' . $resource['title']) }}"
                                       class="w-full px-4 py-3 bg-green-500 hover:bg-green-400 text-zinc-950 font-bold transition-all flex items-center justify-center gap-2">
                                        <x-solar-icon name="download-minimalistic" size="20" />
                                        Request Download
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Newsletter / Stay Updated CTA -->
    <section class="py-12 bg-zinc-900 text-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-white text-2xl md:text-3xl font-black mb-3">
                Stay <span class="text-green-500">Informed</span>
            </h2>
            <p class="text-zinc-400 mb-6">
                Get environmental compliance updates and training announcements.
            </p>
            <a href="{{ route('contact') }}?subject=Newsletter%20Subscription"
               class="inline-flex items-center justify-center gap-2 px-8 py-3 font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                <x-solar-icon name="letter" size="20" />
                Subscribe to Updates
            </a>
        </div>
    </section>

    <!-- Quick Help CTA -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-zinc-50 p-6 md:p-8 border border-zinc-100">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h2 class="text-2xl font-black text-zinc-950 mb-2">
                            Can't Find What You're Looking For?
                        </h2>
                        <p class="text-zinc-600">
                            Our team can provide custom guidance or connect you with the right specialist.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('contact') }}"
                           class="inline-flex items-center justify-center gap-2 px-6 py-3 font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                            <x-solar-icon name="chat-round-dots" size="20" />
                            Ask a Question
                        </a>
                        <a href="tel:0114804822"
                           class="inline-flex items-center justify-center gap-2 px-6 py-3 font-bold text-zinc-950 bg-white border-2 border-zinc-200 hover:border-green-500 transition-all">
                            <x-solar-icon name="phone-calling" size="20" />
                            011 480 4822
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
