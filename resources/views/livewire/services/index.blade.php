<?php

use function Livewire\Volt\{computed, layout, title};
use App\Models\ServiceCategory;

layout('components.layouts.public');
title('Our Services | Environmental Consultancy | KMG');

$categories = computed(fn() =>
    ServiceCategory::where('is_active', true)
        ->withCount(['services' => fn($q) => $q->where('is_active', true)])
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get()
);

?>

<div class="bg-white">
    <!-- Hero Section -->
    <section class="relative py-24 bg-zinc-900 overflow-hidden">
        @if(file_exists(public_path('images/services/environmental-monitoring.jpg')))
            <img src="{{ asset('images/services/environmental-monitoring.jpg') }}"
                 alt="Environmental monitoring services"
                 class="absolute inset-0 w-full h-full object-cover opacity-30">
        @endif
        <div class="absolute inset-0 bg-gradient-to-b from-zinc-900/80 to-zinc-900/95"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4">
            <x-public.breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Services']
            ]" class="mb-8" />

            <div class="max-w-4xl">
                <h1 class="text-5xl md:text-6xl font-black text-white mb-6">
                    Our <span class="text-green-500">Services</span>
                </h1>
                <p class="text-xl text-zinc-300 leading-relaxed">
                    KMG provides a comprehensive suite of environmental, ESG, and occupational services designed to help organisations achieve regulatory compliance, manage environmental risks, and drive sustainable operations across South Africa and the SADC region.
                </p>
            </div>
        </div>
    </section>

    <!-- Service Categories Grid -->
    <section class="py-24">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-zinc-950 mb-4">
                    Service Categories
                </h2>
                <p class="text-xl text-zinc-500 max-w-3xl mx-auto">
                    Explore our full range of accredited environmental and occupational services
                </p>
            </div>

            @php
                // Define service category details with icons and descriptions
                $categoryDetails = [
                    'environmental-monitoring' => [
                        'icon' => 'chart-2',
                        'color' => 'bg-blue-500',
                        'description' => 'Water, air, noise, and soil quality monitoring with accredited laboratory analysis.',
                    ],
                    'environmental-impact-specialist-studies' => [
                        'icon' => 'document-text',
                        'color' => 'bg-green-500',
                        'description' => 'EIA, specialist studies, and environmental assessments for projects of all sizes.',
                    ],
                    'permitting-compliance' => [
                        'icon' => 'diploma',
                        'color' => 'bg-purple-500',
                        'description' => 'Environmental permits, licenses, and regulatory compliance management.',
                    ],
                    'waste-asbestos-management' => [
                        'icon' => 'trash-bin-minimalistic',
                        'color' => 'bg-orange-500',
                        'description' => 'Hazardous waste management, asbestos surveys, and DoEL-approved abatement.',
                    ],
                    'climate-carbon-esg' => [
                        'icon' => 'leaf',
                        'color' => 'bg-emerald-500',
                        'description' => 'Carbon footprinting, climate risk, and ESG strategy development.',
                    ],
                    'occupational-hygiene-ohs' => [
                        'icon' => 'shield-user',
                        'color' => 'bg-red-500',
                        'description' => 'Workplace exposure assessments, OHS compliance, and health risk management.',
                    ],
                    'training-capacity-building' => [
                        'icon' => 'graduation-cap',
                        'color' => 'bg-indigo-500',
                        'description' => 'EAPASA-accredited training courses for environmental professionals.',
                    ],
                    'equipment-rental' => [
                        'icon' => 'settings',
                        'color' => 'bg-zinc-600',
                        'description' => 'Professional environmental monitoring equipment available for hire.',
                    ],
                    'environmental-ohs-esg-auditing' => [
                        'icon' => 'clipboard-check',
                        'color' => 'bg-cyan-500',
                        'description' => 'Compliance audits, due diligence, and management system assessments.',
                    ],
                ];

                // Map category slugs to their details
                function getCategoryDetails($slug, $details) {
                    foreach ($details as $key => $detail) {
                        if (Str::contains($slug, $key) || Str::contains($key, $slug)) {
                            return $detail;
                        }
                    }
                    // Default
                    return [
                        'icon' => 'folder',
                        'color' => 'bg-green-500',
                        'description' => 'Professional environmental consulting services.',
                    ];
                }
            @endphp

            @if($this->categories->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($this->categories as $category)
                        @php
                            $details = getCategoryDetails($category->slug, $categoryDetails);
                        @endphp
                        <a href="{{ route('services.category', $category) }}"
                           class="group bg-zinc-50 rounded-lg overflow-hidden hover:shadow-xl transition-all border border-zinc-100 hover:border-green-500"
                           id="category-{{ $category->slug }}">
                            <!-- Category Header -->
                            <div class="p-6 border-b border-zinc-100">
                                <div class="flex items-start gap-4">
                                    <div class="w-14 h-14 {{ $details['color'] }} rounded-lg flex items-center justify-center flex-shrink-0">
                                        @if($category->icon)
                                            <span class="text-2xl">{{ $category->icon }}</span>
                                        @else
                                            <x-solar-icon name="{{ $details['icon'] }}" size="28" class="text-white" />
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-zinc-950 group-hover:text-green-600 transition-colors mb-1">
                                            {{ $category->name }}
                                        </h3>
                                        <span class="text-sm text-zinc-500">
                                            {{ $category->services_count }} {{ Str::plural('service', $category->services_count) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Category Description -->
                            <div class="p-6">
                                <p class="text-zinc-600 text-sm leading-relaxed mb-4">
                                    {{ $category->description ?: $details['description'] }}
                                </p>

                                <div class="flex items-center gap-2 text-green-600 font-semibold group-hover:gap-3 transition-all">
                                    <span>View Services</span>
                                    <x-solar-icon name="alt-arrow-right" size="20" class="group-hover:translate-x-1 transition-transform" />
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-zinc-50 rounded-lg">
                    <x-solar-icon name="folder" size="64" class="text-zinc-300 mx-auto mb-4" />
                    <p class="text-zinc-500">No services available at this time.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Not Sure CTA Section -->
    <section class="py-24 bg-zinc-50">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <div class="bg-white p-12 rounded-lg shadow-sm border border-zinc-100">
                <x-solar-icon name="question-circle" size="64" class="text-green-500 mx-auto mb-6" />

                <h2 class="text-3xl md:text-4xl font-black text-zinc-950 mb-4">
                    Not Sure Which Service You Need?
                </h2>

                <p class="text-lg text-zinc-600 mb-8 max-w-2xl mx-auto">
                    Our team of environmental specialists can help you identify the right solutions for your project. Get in touch for a free initial consultation.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}"
                       class="inline-flex items-center justify-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                        <x-solar-icon name="chat-round-dots" size="24" />
                        <span>Request Guidance</span>
                    </a>

                    <a href="tel:0119696184"
                       class="inline-flex items-center justify-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-white border-2 border-zinc-200 hover:border-green-500 transition-all">
                        <x-solar-icon name="phone-calling" size="24" />
                        <span>011 969 6184</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Stats -->
    <section class="py-16 bg-zinc-900 text-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-black text-green-500 mb-2">{{ $this->categories->count() }}</div>
                    <div class="text-sm text-zinc-400 uppercase tracking-wider">Service Categories</div>
                </div>
                <div>
                    <div class="text-4xl font-black text-green-500 mb-2">{{ $this->categories->sum('services_count') }}+</div>
                    <div class="text-sm text-zinc-400 uppercase tracking-wider">Individual Services</div>
                </div>
                <div>
                    <div class="text-4xl font-black text-green-500 mb-2">15+</div>
                    <div class="text-sm text-zinc-400 uppercase tracking-wider">Years Experience</div>
                </div>
                <div>
                    <div class="text-4xl font-black text-green-500 mb-2">9</div>
                    <div class="text-sm text-zinc-400 uppercase tracking-wider">SA Provinces</div>
                </div>
            </div>
        </div>
    </section>
</div>
