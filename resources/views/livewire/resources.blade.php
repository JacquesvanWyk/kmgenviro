<?php

use function Livewire\Volt\{computed, layout, state, title};
use App\Models\{Resource, LeadCapture, BlogPost};

layout('components.layouts.public');
title('Resources & Downloads | KMG Environmental Solutions');

state([
    'categoryFilter' => '',
    'showLeadForm' => false,
    'selectedResource' => null,
    // Lead form fields
    'leadName' => '',
    'leadEmail' => '',
    'leadCompany' => '',
    'leadProvince' => '',
    'leadSubmitted' => false,
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

$blogPosts = computed(fn() =>
    BlogPost::where('is_published', true)
        ->orderBy('published_at', 'desc')
        ->limit(6)
        ->get()
);

$provinces = computed(fn() => [
    'Gauteng',
    'Western Cape',
    'KwaZulu-Natal',
    'Eastern Cape',
    'Free State',
    'Limpopo',
    'Mpumalanga',
    'North West',
    'Northern Cape',
]);

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

$requestDownload = function ($resourceId) {
    $resource = Resource::find($resourceId);
    if (!$resource) return;

    if ($resource->requires_details) {
        $this->selectedResource = $resource;
        $this->showLeadForm = true;
        $this->leadSubmitted = false;
    } else {
        $resource->increment('download_count');
        $this->dispatch('download-file', url: \Storage::url($resource->file));
    }
};

$submitLeadAndDownload = function () {
    $this->validate([
        'leadName' => 'required|string|max:255',
        'leadEmail' => 'required|email|max:255',
        'leadCompany' => 'nullable|string|max:255',
        'leadProvince' => 'required|string|max:50',
    ]);

    LeadCapture::create([
        'name' => $this->leadName,
        'email' => $this->leadEmail,
        'company' => $this->leadCompany,
        'province' => $this->leadProvince,
        'source' => 'resource_download',
        'resource_id' => $this->selectedResource->id,
    ]);

    $this->selectedResource->increment('download_count');
    $downloadUrl = \Storage::url($this->selectedResource->file);

    $this->leadSubmitted = true;
    $this->dispatch('download-file', url: $downloadUrl);

    $this->reset(['leadName', 'leadEmail', 'leadCompany', 'leadProvince']);
};

?>

<div x-data="{
        showLeadForm: @entangle('showLeadForm'),
        activeCategory: @entangle('categoryFilter')
     }"
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
                    Access our library of environmental compliance guides, service brochures, and technical resources. Build your knowledge and stay informed on regulatory requirements.
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
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-black text-zinc-950 mb-4">
                    Download Centre
                </h2>
                <p class="text-lg text-zinc-600 max-w-2xl mx-auto">
                    Free resources to help you understand environmental compliance requirements
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

                                <button wire:click="requestDownload({{ $resource->id }})"
                                        class="w-full px-4 py-3 bg-green-500 hover:bg-green-400 text-zinc-950 font-bold transition-all flex items-center justify-center gap-2">
                                    <x-solar-icon name="download-minimalistic" size="20" />
                                    @if($resource->requires_details)
                                        Download (Free)
                                    @else
                                        Download Now
                                    @endif
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

                                <a href="{{ route('contact') }}?subject={{ urlencode('Request: ' . $resource['title']) }}"
                                   class="w-full px-4 py-3 bg-green-500 hover:bg-green-400 text-zinc-950 font-bold transition-all flex items-center justify-center gap-2">
                                    <x-solar-icon name="download-minimalistic" size="20" />
                                    Request Download
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Lead Capture Modal -->
    <div x-show="showLeadForm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 bg-zinc-900/75" @click="showLeadForm = false"></div>

            <div x-show="showLeadForm"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto overflow-hidden">

                <!-- Modal Header -->
                <div class="bg-green-500 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-zinc-950">Download Resource</h3>
                        <button @click="showLeadForm = false" class="text-zinc-950/70 hover:text-zinc-950">
                            <x-solar-icon name="close-circle" size="24" />
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6">
                    @if($leadSubmitted)
                        <div class="text-center py-4">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <x-solar-icon name="check-circle" size="40" class="text-green-600" />
                            </div>
                            <h4 class="text-xl font-bold text-zinc-950 mb-2">Download Starting...</h4>
                            <p class="text-zinc-600 mb-6">
                                Thank you! Your download should begin automatically. If it doesn't, click the button below.
                            </p>
                            @if($selectedResource)
                                <a href="{{ Storage::url($selectedResource->file) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-green-500 hover:bg-green-400 text-zinc-950 font-bold transition-all">
                                    <x-solar-icon name="download-minimalistic" size="20" />
                                    Download Again
                                </a>
                            @endif
                            <button @click="showLeadForm = false"
                                    class="block w-full mt-4 text-zinc-500 hover:text-zinc-700">
                                Close
                            </button>
                        </div>
                    @else
                        <div class="mb-6">
                            @if($selectedResource)
                                <div class="flex items-center gap-3 p-3 bg-zinc-50 rounded-lg mb-4">
                                    <x-solar-icon name="file-text" size="24" class="text-green-500" />
                                    <div>
                                        <div class="font-semibold text-zinc-950">{{ $selectedResource->title }}</div>
                                        <div class="text-xs text-zinc-500">Free download</div>
                                    </div>
                                </div>
                            @endif
                            <p class="text-sm text-zinc-600">
                                Please provide your details to download this resource. We'll also send you occasional updates on environmental compliance.
                            </p>
                        </div>

                        <form wire:submit="submitLeadAndDownload" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1">Full Name *</label>
                                <input type="text" wire:model="leadName" required
                                       class="w-full px-4 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                @error('leadName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1">Email Address *</label>
                                <input type="email" wire:model="leadEmail" required
                                       class="w-full px-4 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                @error('leadEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1">Company / Organisation</label>
                                <input type="text" wire:model="leadCompany"
                                       class="w-full px-4 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1">Province *</label>
                                <select wire:model="leadProvince" required
                                        class="w-full px-4 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="">-- Select Province --</option>
                                    @foreach($this->provinces as $province)
                                        <option value="{{ $province }}">{{ $province }}</option>
                                    @endforeach
                                </select>
                                @error('leadProvince') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit"
                                    class="w-full px-6 py-4 bg-green-500 hover:bg-green-400 text-zinc-950 font-bold text-lg transition-all flex items-center justify-center gap-2">
                                <x-solar-icon name="download-minimalistic" size="24" />
                                Download Now
                            </button>

                            <p class="text-xs text-zinc-500 text-center">
                                By downloading, you agree to receive occasional updates from KMG. You can unsubscribe at any time.
                            </p>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Knowledge Articles / Blog Section -->
    <section class="py-16 bg-zinc-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-black text-zinc-950 mb-4">
                    Knowledge Articles
                </h2>
                <p class="text-lg text-zinc-600 max-w-2xl mx-auto">
                    Environmental compliance tips, regulatory updates, and industry insights
                </p>
            </div>

            @if($this->blogPosts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($this->blogPosts as $post)
                        <a href="{{ route('blog.show', $post) }}"
                           class="group bg-white border border-zinc-200 rounded-lg overflow-hidden hover:shadow-lg hover:border-green-500 transition-all">
                            @if($post->featured_image)
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ str_starts_with($post->featured_image, '/') ? asset($post->featured_image) : Storage::url($post->featured_image) }}"
                                         alt="{{ $post->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                            @else
                                <div class="h-48 bg-gradient-to-br from-green-600 to-green-800 flex items-center justify-center">
                                    <x-solar-icon name="document-text" size="48" class="text-white/50" />
                                </div>
                            @endif

                            <div class="p-6">
                                <h3 class="font-bold text-zinc-950 mb-2 group-hover:text-green-600 transition-colors">
                                    {{ $post->title }}
                                </h3>
                                @if($post->excerpt)
                                    <p class="text-sm text-zinc-600 line-clamp-2 mb-4">
                                        {{ $post->excerpt }}
                                    </p>
                                @endif
                                <div class="flex items-center gap-2 text-sm text-green-600 font-semibold">
                                    <span>Read More</span>
                                    <x-solar-icon name="alt-arrow-right" size="16" class="group-hover:translate-x-1 transition-transform" />
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="text-center mt-10">
                    <a href="{{ route('blog.index') }}"
                       class="inline-flex items-center gap-2 px-8 py-4 bg-zinc-900 hover:bg-zinc-800 text-white font-bold transition-all">
                        <x-solar-icon name="book-2" size="20" />
                        View All Articles
                    </a>
                </div>
            @else
                <!-- Placeholder Articles -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @php
                        $placeholderArticles = [
                            [
                                'title' => 'Understanding the EIA Process in South Africa',
                                'excerpt' => 'A step-by-step guide to Environmental Impact Assessments under NEMA regulations.',
                                'category' => 'Compliance Guide',
                            ],
                            [
                                'title' => 'Water Use License Application Timeline',
                                'excerpt' => 'What to expect when applying for a WULA and how to prepare for the process.',
                                'category' => 'Licensing',
                            ],
                            [
                                'title' => 'New AEL Requirements for 2024',
                                'excerpt' => 'Recent changes to Atmospheric Emission Licensing and what it means for your facility.',
                                'category' => 'Regulatory Update',
                            ],
                            [
                                'title' => 'Asbestos Management for Building Owners',
                                'excerpt' => 'Your legal obligations under the OHS Act for managing asbestos-containing materials.',
                                'category' => 'Compliance Guide',
                            ],
                            [
                                'title' => 'Carbon Tax: What You Need to Know',
                                'excerpt' => 'Understanding South Africa\'s carbon tax and how to calculate your liability.',
                                'category' => 'ESG',
                            ],
                            [
                                'title' => 'Occupational Hygiene Survey Requirements',
                                'excerpt' => 'When and how often you need occupational hygiene surveys under the OHS Act.',
                                'category' => 'Compliance Guide',
                            ],
                        ];
                    @endphp

                    @foreach($placeholderArticles as $article)
                        <div class="group bg-white border border-zinc-200 rounded-lg overflow-hidden hover:shadow-lg hover:border-green-500 transition-all">
                            <div class="h-48 bg-gradient-to-br from-green-600 to-green-800 flex items-center justify-center">
                                <x-solar-icon name="document-text" size="48" class="text-white/50" />
                            </div>

                            <div class="p-6">
                                <span class="inline-block px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded mb-3">
                                    {{ $article['category'] }}
                                </span>
                                <h3 class="font-bold text-zinc-950 mb-2 group-hover:text-green-600 transition-colors">
                                    {{ $article['title'] }}
                                </h3>
                                <p class="text-sm text-zinc-600 line-clamp-2 mb-4">
                                    {{ $article['excerpt'] }}
                                </p>
                                <span class="flex items-center gap-2 text-sm text-zinc-400">
                                    Coming Soon
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Newsletter / Stay Updated CTA -->
    <section class="py-16 bg-zinc-900 text-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <x-solar-icon name="letter-opened" size="64" class="text-green-500 mx-auto mb-6" />

            <h2 class="text-white text-3xl md:text-4xl font-black mb-4">
                Stay <span class="text-green-500">Informed</span>
            </h2>

            <p class="text-lg text-zinc-400 mb-8 max-w-2xl mx-auto">
                Get environmental compliance updates, new resource alerts, and training announcements delivered to your inbox.
            </p>

            <a href="{{ route('contact') }}?subject=Newsletter%20Subscription"
               class="inline-flex items-center justify-center gap-3 px-10 py-5 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                <x-solar-icon name="letter" size="24" />
                Subscribe to Updates
            </a>
        </div>
    </section>

    <!-- Quick Help CTA -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-zinc-50 rounded-lg p-8 md:p-12 border border-zinc-100">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div>
                        <h2 class="text-3xl font-black text-zinc-950 mb-4">
                            Can't Find What You're Looking For?
                        </h2>
                        <p class="text-lg text-zinc-600 mb-6">
                            Our team is here to help with any environmental compliance questions. We can provide custom guidance, specific documentation, or connect you with the right specialist.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-end">
                        <a href="{{ route('contact') }}"
                           class="inline-flex items-center justify-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                            <x-solar-icon name="chat-round-dots" size="24" />
                            Ask a Question
                        </a>
                        <a href="tel:0119696184"
                           class="inline-flex items-center justify-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-white border-2 border-zinc-200 hover:border-green-500 transition-all">
                            <x-solar-icon name="phone-calling" size="24" />
                            011 969 6184
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
