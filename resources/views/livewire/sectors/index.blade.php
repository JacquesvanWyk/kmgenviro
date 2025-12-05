<?php

use function Livewire\Volt\{computed, layout, state, title};
use App\Models\Sector;

layout('components.layouts.public');
title('Industry Sectors | KMG Environmental');

state(['activeTab' => 'mining-mineral-resources']);

$sectors = computed(fn() =>
    Sector::where('is_active', true)
        ->orderBy('sort_order')
        ->get()
);

?>

<div x-data="{ activeTab: @entangle('activeTab') }">
    <!-- Hero Section -->
    <section class="relative py-24 bg-zinc-900 overflow-hidden">
        @if(file_exists(public_path('images/sectors/mining.jpg')))
            <img src="{{ asset('images/sectors/mining.jpg') }}"
                 alt="Industry sectors"
                 class="absolute inset-0 w-full h-full object-cover opacity-30">
        @endif
        <div class="absolute inset-0 bg-gradient-to-b from-zinc-900/80 to-zinc-900/95"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4">
            <x-public.breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Sectors']
            ]" class="mb-8" />

            <div class="max-w-4xl">
                <h1 class="text-5xl md:text-6xl font-black text-white mb-6">
                    Industry <span class="text-green-500">Sectors</span>
                </h1>
                <p class="text-xl text-zinc-300 leading-relaxed">
                    KMG delivers environmental solutions across South Africa's key industries. Explore how we help organisations in your sector achieve compliance.
                </p>
            </div>
        </div>
    </section>

    <!-- Sector Tabs Navigation -->
    <section class="bg-zinc-100 border-b border-zinc-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex overflow-x-auto scrollbar-hide -mx-4 px-4 md:mx-0 md:px-0">
                @php
                    $sectorIcons = [
                        'mining-mineral-resources' => 'mining',
                        'infrastructure-construction' => 'buildings-2',
                        'municipal-public-sector' => 'city',
                        'renewable-energy' => 'sun-2',
                        'industrial-manufacturing' => 'settings',
                        'water-sanitation-utilities' => 'waterdrops',
                        'healthcare-medical-waste' => 'health',
                    ];
                @endphp
                @foreach($this->sectors as $sector)
                    <button
                        @click="activeTab = '{{ $sector->slug }}'"
                        :class="activeTab === '{{ $sector->slug }}'
                            ? 'border-green-500 text-green-600 bg-white'
                            : 'border-transparent text-zinc-600 hover:text-zinc-900 hover:border-zinc-300'"
                        class="flex-shrink-0 px-6 py-4 text-sm font-semibold border-b-2 transition-colors whitespace-nowrap"
                    >
                        {{ $sector->name }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sector Content Sections -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            @php
                // Sector-specific content
                $sectorContent = [
                    'mining-mineral-resources' => [
                        'intro' => 'KMG has extensive experience supporting mining operations from prospecting through to mine closure. We understand the unique regulatory landscape governing mining in South Africa, including MPRDA, NEMA, and the NWA, and deliver solutions that ensure compliance while enabling operational efficiency.',
                        'services' => [
                            'Environmental Impact Assessments',
                            'Mining Right Applications (MPRDA)',
                            'Water Use License Applications',
                            'Mine Closure & Rehabilitation Plans',
                            'Dust & Noise Monitoring',
                            'Groundwater Assessments',
                            'Biodiversity Management Plans',
                            'Waste Management Licensing',
                        ],
                        'image' => 'sectors/mining.jpg',
                    ],
                    'infrastructure-construction' => [
                        'intro' => 'From roads and bridges to bulk infrastructure and urban development, KMG provides the environmental assessments and ongoing monitoring that infrastructure projects require. Our team works closely with engineers, contractors, and government departments to ensure projects proceed smoothly.',
                        'services' => [
                            'Basic Assessment Reports (BAR)',
                            'Environmental Management Programmes',
                            'Construction Environmental Management',
                            'Traffic & Air Quality Studies',
                            'Stormwater Management Plans',
                            'Archaeological Impact Assessments',
                            'Noise Impact Assessments',
                            'Environmental Control Officer (ECO) Services',
                        ],
                        'image' => 'sectors/infrastructure-construction.jpg',
                    ],
                    'municipal-public-sector' => [
                        'intro' => 'KMG partners with local and district municipalities, provincial departments, and national government entities to deliver environmental compliance for public projects. We understand the procurement processes and regulatory requirements unique to the public sector.',
                        'services' => [
                            'Municipal Infrastructure Grant (MIG) EIAs',
                            'Housing Development Assessments',
                            'Landfill & Waste Site Licensing',
                            'Water & Sanitation Projects',
                            'Sports & Recreation Facilities',
                            'Cemetery Environmental Assessments',
                            'Public Building Compliance Audits',
                            'Integrated Environmental Management',
                        ],
                        'image' => 'gallery/team-fieldwork.jpg',
                    ],
                    'renewable-energy' => [
                        'intro' => 'As South Africa transitions to cleaner energy, KMG supports solar PV, wind, and hybrid renewable energy projects with comprehensive environmental services. We help developers navigate the REIPPP and private PPA landscape efficiently.',
                        'services' => [
                            'Solar PV Environmental Assessments',
                            'Wind Farm Impact Studies',
                            'Grid Connection Assessments',
                            'Avifauna & Bat Monitoring',
                            'Visual Impact Assessments',
                            'EMPr Development & Implementation',
                            'Decommissioning Plans',
                            'Biodiversity Offset Strategies',
                        ],
                        'image' => 'services/environmental-monitoring.jpg',
                    ],
                    'industrial-manufacturing' => [
                        'intro' => 'Industrial facilities face complex environmental and occupational health challenges. KMG provides integrated solutions covering air quality, waste management, occupational hygiene, and regulatory compliance to keep your operations running safely and legally.',
                        'services' => [
                            'Atmospheric Emission Licensing (AEL)',
                            'Occupational Hygiene Surveys',
                            'Hazardous Chemical Management',
                            'Waste Classification & Management',
                            'Noise & Vibration Assessments',
                            'Industrial Wastewater Management',
                            'Environmental Compliance Audits',
                            'OHS Legal Appointments',
                        ],
                        'image' => 'sectors/industrial-manufacturing.jpg',
                    ],
                    'water-sanitation-utilities' => [
                        'intro' => 'Clean water and sanitation are fundamental to public health. KMG supports water boards, municipalities, and private utilities with environmental assessments for water treatment plants, reservoirs, pipelines, and sanitation infrastructure.',
                        'services' => [
                            'Water Treatment Plant EIAs',
                            'Water Use License Applications',
                            'Pipeline Route Assessments',
                            'Wastewater Treatment Works Studies',
                            'Aquatic Biomonitoring',
                            'Stormwater Management',
                            'Dam Safety Assessments',
                            'Groundwater Resource Assessments',
                        ],
                        'image' => 'services/water-monitoring.jpg',
                    ],
                    'healthcare-medical-waste' => [
                        'intro' => 'Healthcare facilities generate hazardous medical waste that requires specialized management. KMG provides healthcare waste audits, treatment facility assessments, and compliance support for hospitals, clinics, and medical waste treatment companies.',
                        'services' => [
                            'Healthcare Waste Management Plans',
                            'Medical Waste Treatment Facility Licensing',
                            'Infection Control Assessments',
                            'Pharmaceutical Waste Management',
                            'Sharps & Pathological Waste Audits',
                            'Healthcare Facility Compliance Audits',
                            'Staff Training & Awareness',
                            'Waste Contractor Evaluations',
                        ],
                        'image' => 'gallery/team-fieldwork.jpg',
                    ],
                ];
            @endphp

            @foreach($this->sectors as $sector)
                @php
                    $content = $sectorContent[$sector->slug] ?? [
                        'intro' => $sector->description,
                        'services' => [],
                        'image' => 'gallery/team-fieldwork.jpg',
                    ];
                @endphp

                <div
                    x-show="activeTab === '{{ $sector->slug }}'"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-cloak
                    id="{{ $sector->slug }}"
                >
                    <!-- Sector Header -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
                        <div>
                            <h2 class="text-3xl font-black text-zinc-950 mb-4">
                                {{ $sector->name }}
                            </h2>
                            <p class="text-zinc-600 leading-relaxed">
                                {{ $content['intro'] }}
                            </p>
                        </div>

                        <div class="relative overflow-hidden h-48 lg:h-auto">
                            @if(file_exists(public_path('images/' . $content['image'])))
                                <img src="{{ asset('images/' . $content['image']) }}"
                                     alt="{{ $sector->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-zinc-200 flex items-center justify-center">
                                    <x-solar-icon name="gallery" size="64" class="text-zinc-400" />
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Services for this Sector -->
                    @if(count($content['services']) > 0)
                        <div class="mb-10">
                            <h3 class="text-xl font-bold text-zinc-950 mb-4">
                                Services for {{ $sector->name }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                                @foreach($content['services'] as $service)
                                    <div class="flex items-center gap-2 p-3 bg-zinc-50">
                                        <x-solar-icon name="check-circle" size="18" class="text-green-500 flex-shrink-0" />
                                        <span class="text-sm text-zinc-700">{{ $service }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Sector CTA -->
                    <div class="bg-zinc-50 p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-zinc-950">
                                Need services for {{ $sector->name }}?
                            </h3>
                            <p class="text-zinc-600 text-sm">
                                Our team has deep experience in this sector.
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('contact') }}"
                               class="inline-flex items-center gap-2 px-6 py-3 font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                                <x-solar-icon name="chat-round-dots" size="20" />
                                <span>Get in Touch</span>
                            </a>
                            <a href="{{ route('services.index') }}"
                               class="inline-flex items-center gap-2 px-6 py-3 font-bold text-zinc-700 bg-white border border-zinc-200 hover:border-green-500 transition-all">
                                <span>View Services</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- All Sectors Overview (mobile-friendly) -->
    <section class="py-10 bg-zinc-50 lg:hidden">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl font-black text-zinc-950 mb-6 text-center">All Sectors</h2>
            <div class="grid grid-cols-2 gap-3">
                @foreach($this->sectors as $sector)
                    <button
                        @click="activeTab = '{{ $sector->slug }}'; window.scrollTo({top: 0, behavior: 'smooth'})"
                        class="p-3 bg-white border border-zinc-200 text-left hover:border-green-500 transition-colors"
                    >
                        <h3 class="font-bold text-zinc-950 text-sm">{{ $sector->name }}</h3>
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Our Work in Action CTA -->
    <section class="py-12 bg-zinc-900 text-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-white text-2xl md:text-3xl font-black mb-3">
                Our Work in <span class="text-green-500">Action</span>
            </h2>
            <p class="text-zinc-400 mb-6">
                See our team conducting environmental monitoring and assessments across all sectors.
            </p>
            <a href="{{ route('gallery') }}"
               class="inline-flex items-center justify-center gap-2 px-8 py-3 font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                <x-solar-icon name="gallery" size="20" />
                <span>View Gallery</span>
            </a>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-10 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div>
                    <div class="text-3xl font-black text-green-500 mb-1">{{ $this->sectors->count() }}</div>
                    <div class="text-xs text-zinc-500 uppercase tracking-wider">Sectors</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-green-500 mb-1">100+</div>
                    <div class="text-xs text-zinc-500 uppercase tracking-wider">Projects</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-green-500 mb-1">9</div>
                    <div class="text-xs text-zinc-500 uppercase tracking-wider">Provinces</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-green-500 mb-1">13+</div>
                    <div class="text-xs text-zinc-500 uppercase tracking-wider">Years</div>
                </div>
            </div>
        </div>
    </section>
</div>
