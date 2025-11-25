<?php

use function Livewire\Volt\{computed, layout, state, title};
use App\Models\{Sector, Project, ServiceCategory};

layout('components.layouts.public');
title('Industry Sectors | Our Track Record | KMG Environmental');

state(['activeTab' => null]);

$sectors = computed(fn() =>
    Sector::where('is_active', true)
        ->with(['projects' => fn($q) => $q->where('is_active', true)->latest('completion_date')->limit(3)])
        ->withCount(['projects' => fn($q) => $q->where('is_active', true)])
        ->orderBy('sort_order')
        ->get()
);

$mounted = function () {
    if ($this->sectors->count() > 0) {
        $this->activeTab = $this->sectors->first()->slug;
    }
};

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
                    KMG has delivered environmental solutions across South Africa's key industries for over 15 years. Explore our track record and see how we've helped organisations in your sector achieve compliance and sustainability.
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
    <section class="py-16 bg-white">
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
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
                        <div>
                            <h2 class="text-4xl font-black text-zinc-950 mb-6">
                                {{ $sector->name }}
                            </h2>
                            <p class="text-lg text-zinc-600 leading-relaxed mb-8">
                                {{ $content['intro'] }}
                            </p>

                            <div class="flex items-center gap-6 text-sm text-zinc-500">
                                <div class="flex items-center gap-2">
                                    <x-solar-icon name="clipboard-check" size="20" class="text-green-500" />
                                    <span>{{ $sector->projects_count }} completed {{ Str::plural('project', $sector->projects_count) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="relative rounded-lg overflow-hidden h-64 lg:h-auto">
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
                        <div class="mb-16">
                            <h3 class="text-2xl font-bold text-zinc-950 mb-6">
                                Services for {{ $sector->name }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                @foreach($content['services'] as $service)
                                    <div class="flex items-center gap-3 p-4 bg-zinc-50 rounded-lg">
                                        <x-solar-icon name="check-circle" size="20" class="text-green-500 flex-shrink-0" />
                                        <span class="text-sm font-medium text-zinc-700">{{ $service }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Case Studies / Projects -->
                    <div class="mb-12">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-zinc-950">
                                Featured Projects
                            </h3>
                            <a href="{{ route('projects.index', ['sector' => $sector->id]) }}"
                               class="text-green-600 hover:text-green-700 font-semibold flex items-center gap-2">
                                View All Projects
                                <x-solar-icon name="alt-arrow-right" size="20" />
                            </a>
                        </div>

                        @if($sector->projects->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach($sector->projects as $project)
                                    <a href="{{ route('projects.show', $project) }}"
                                       class="group bg-white border border-zinc-200 rounded-lg overflow-hidden hover:shadow-lg hover:border-green-500 transition-all">
                                        @if($project->featured_image)
                                            <div class="h-40 overflow-hidden">
                                                <img src="{{ asset('storage/' . $project->featured_image) }}"
                                                     alt="{{ $project->title }}"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                            </div>
                                        @else
                                            <div class="h-40 bg-zinc-100 flex items-center justify-center">
                                                <x-solar-icon name="buildings" size="48" class="text-zinc-300" />
                                            </div>
                                        @endif

                                        <div class="p-5">
                                            <h4 class="font-bold text-zinc-950 mb-2 group-hover:text-green-600 transition-colors">
                                                {{ $project->title }}
                                            </h4>
                                            <div class="text-sm text-zinc-500 mb-3">
                                                <span class="font-medium">{{ $project->client_name }}</span>
                                                @if($project->province)
                                                    <span class="mx-2">•</span>
                                                    <span>{{ $project->province }}</span>
                                                @endif
                                            </div>
                                            @if($project->outcomes)
                                                <p class="text-sm text-zinc-600 line-clamp-2">
                                                    {{ Str::limit($project->outcomes, 100) }}
                                                </p>
                                            @endif
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <!-- Placeholder case studies when no projects exist -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @php
                                    $placeholderProjects = [
                                        'mining-mineral-resources' => [
                                            ['title' => 'Chrome Mine EIA', 'client' => 'Mining Company', 'province' => 'Limpopo', 'outcome' => 'Successfully obtained mining right and environmental authorisation within 12 months.'],
                                            ['title' => 'PGM Processing Plant', 'client' => 'Metals Processor', 'province' => 'North West', 'outcome' => 'Achieved AEL and WUL compliance for new processing facility.'],
                                            ['title' => 'Aggregate Quarry Expansion', 'client' => 'Construction Supplier', 'province' => 'Gauteng', 'outcome' => 'Completed S24G rectification and ongoing compliance monitoring.'],
                                        ],
                                        'infrastructure-construction' => [
                                            ['title' => 'Provincial Road Upgrade', 'client' => 'Provincial Roads Department', 'province' => 'Mpumalanga', 'outcome' => 'BAR and EMPr approved, construction completed within environmental conditions.'],
                                            ['title' => 'Bulk Water Pipeline', 'client' => 'Water Board', 'province' => 'Free State', 'outcome' => 'ECO services provided throughout 18-month construction phase.'],
                                            ['title' => 'Bridge Construction', 'client' => 'SANRAL', 'province' => 'Eastern Cape', 'outcome' => 'Wetland offset successfully implemented as per ROD conditions.'],
                                        ],
                                        'municipal-public-sector' => [
                                            ['title' => 'Housing Development EIA', 'client' => 'Local Municipality', 'province' => 'Gauteng', 'outcome' => 'EA obtained for 2,500 unit housing project with stormwater management plan.'],
                                            ['title' => 'Landfill License Application', 'client' => 'District Municipality', 'province' => 'KwaZulu-Natal', 'outcome' => 'Waste management license issued for new regional landfill site.'],
                                            ['title' => 'Sports Complex Development', 'client' => 'Metropolitan Municipality', 'province' => 'Western Cape', 'outcome' => 'Integrated environmental assessment for multi-use sports facility.'],
                                        ],
                                        'renewable-energy' => [
                                            ['title' => '75MW Solar PV Facility', 'client' => 'IPP Developer', 'province' => 'Northern Cape', 'outcome' => 'Full EIA and WULA completed within REIPPP bid window timeline.'],
                                            ['title' => 'Wind Farm Development', 'client' => 'Energy Company', 'province' => 'Eastern Cape', 'outcome' => 'Avifauna study and EMPr approved with 24-month bird monitoring programme.'],
                                            ['title' => 'Rooftop Solar Programme', 'client' => 'Commercial Property Group', 'province' => 'Gauteng', 'outcome' => 'Heritage and structural assessments for 15 commercial buildings.'],
                                        ],
                                        'industrial-manufacturing' => [
                                            ['title' => 'Chemical Plant AEL', 'client' => 'Chemical Manufacturer', 'province' => 'KwaZulu-Natal', 'outcome' => 'Atmospheric Emission License obtained with emission reduction plan.'],
                                            ['title' => 'Factory OHS Compliance', 'client' => 'Automotive Parts Supplier', 'province' => 'Gauteng', 'outcome' => 'Full occupational hygiene survey and legal appointments completed.'],
                                            ['title' => 'Waste Management System', 'client' => 'Food Processor', 'province' => 'Western Cape', 'outcome' => 'Waste classification and management plan reducing disposal costs by 30%.'],
                                        ],
                                        'water-sanitation-utilities' => [
                                            ['title' => 'WWTW Upgrade EIA', 'client' => 'Water Board', 'province' => 'Gauteng', 'outcome' => 'Environmental authorisation for 50ML/day capacity upgrade.'],
                                            ['title' => 'Regional Water Scheme', 'client' => 'District Municipality', 'province' => 'Limpopo', 'outcome' => 'WULA and EIA for bulk water supply to 5 towns.'],
                                            ['title' => 'Dam Safety Assessment', 'client' => 'Agricultural Irrigation Board', 'province' => 'Free State', 'outcome' => 'Dam classification and safety compliance programme implemented.'],
                                        ],
                                        'healthcare-medical-waste' => [
                                            ['title' => 'Medical Waste Treatment Facility', 'client' => 'Waste Management Company', 'province' => 'Gauteng', 'outcome' => 'Waste license and AEL obtained for autoclave treatment facility.'],
                                            ['title' => 'Hospital Waste Audit', 'client' => 'Provincial Health Department', 'province' => 'KwaZulu-Natal', 'outcome' => 'Healthcare waste management plan for 12 provincial hospitals.'],
                                            ['title' => 'Pharmaceutical Disposal Programme', 'client' => 'Pharmacy Chain', 'province' => 'Multiple', 'outcome' => 'Compliant disposal system for expired medicines across 200 stores.'],
                                        ],
                                    ];
                                    $projects = $placeholderProjects[$sector->slug] ?? [];
                                @endphp

                                @foreach($projects as $project)
                                    <div class="bg-white border border-zinc-200 rounded-lg overflow-hidden hover:shadow-lg hover:border-green-500 transition-all">
                                        <div class="h-40 bg-gradient-to-br from-green-600 to-green-800 flex items-center justify-center">
                                            <x-solar-icon name="buildings" size="48" class="text-white/50" />
                                        </div>

                                        <div class="p-5">
                                            <h4 class="font-bold text-zinc-950 mb-2">
                                                {{ $project['title'] }}
                                            </h4>
                                            <div class="text-sm text-zinc-500 mb-3">
                                                <span class="font-medium">{{ $project['client'] }}</span>
                                                <span class="mx-2">•</span>
                                                <span>{{ $project['province'] }}</span>
                                            </div>
                                            <p class="text-sm text-zinc-600 line-clamp-2">
                                                {{ $project['outcome'] }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Sector CTA -->
                    <div class="bg-zinc-50 rounded-lg p-8 text-center">
                        <h3 class="text-2xl font-bold text-zinc-950 mb-4">
                            Need Environmental Services for {{ $sector->name }}?
                        </h3>
                        <p class="text-zinc-600 mb-6 max-w-2xl mx-auto">
                            Our team has deep experience in this sector. Contact us to discuss your project requirements.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('contact') }}"
                               class="inline-flex items-center justify-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                                <x-solar-icon name="chat-round-dots" size="24" />
                                <span>Discuss Your Project</span>
                            </a>
                            <a href="{{ route('services.index') }}"
                               class="inline-flex items-center justify-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-white border-2 border-zinc-200 hover:border-green-500 transition-all">
                                <x-solar-icon name="document-text" size="24" />
                                <span>View All Services</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- All Sectors Overview (mobile-friendly) -->
    <section class="py-16 bg-zinc-50 lg:hidden">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-black text-zinc-950 mb-8 text-center">All Sectors</h2>
            <div class="grid grid-cols-2 gap-4">
                @foreach($this->sectors as $sector)
                    <button
                        @click="activeTab = '{{ $sector->slug }}'; window.scrollTo({top: 0, behavior: 'smooth'})"
                        class="p-4 bg-white rounded-lg border border-zinc-200 text-left hover:border-green-500 transition-colors"
                    >
                        <h3 class="font-bold text-zinc-950 text-sm mb-1">{{ $sector->name }}</h3>
                        <span class="text-xs text-zinc-500">{{ $sector->projects_count }} {{ Str::plural('project', $sector->projects_count) }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <!-- View All Projects CTA -->
    <section class="py-16 bg-zinc-900 text-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-black mb-4">
                View Our Complete <span class="text-green-500">Project Portfolio</span>
            </h2>
            <p class="text-lg text-zinc-400 mb-8 max-w-2xl mx-auto">
                Browse all our completed projects across every sector. Filter by province, sector, or search for specific clients.
            </p>
            <a href="{{ route('projects.index') }}"
               class="inline-flex items-center justify-center gap-3 px-10 py-5 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                <x-solar-icon name="folder-2" size="24" />
                <span>View All Projects</span>
            </a>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-black text-green-500 mb-2">{{ $this->sectors->count() }}</div>
                    <div class="text-sm text-zinc-500 uppercase tracking-wider">Industry Sectors</div>
                </div>
                <div>
                    <div class="text-4xl font-black text-green-500 mb-2">{{ $this->sectors->sum('projects_count') }}+</div>
                    <div class="text-sm text-zinc-500 uppercase tracking-wider">Completed Projects</div>
                </div>
                <div>
                    <div class="text-4xl font-black text-green-500 mb-2">9</div>
                    <div class="text-sm text-zinc-500 uppercase tracking-wider">SA Provinces</div>
                </div>
                <div>
                    <div class="text-4xl font-black text-green-500 mb-2">15+</div>
                    <div class="text-sm text-zinc-500 uppercase tracking-wider">Years Experience</div>
                </div>
            </div>
        </div>
    </section>
</div>
