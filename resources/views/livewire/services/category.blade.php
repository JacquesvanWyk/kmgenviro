<?php

use function Livewire\Volt\{computed, layout, title, mount, state};
use App\Models\ServiceCategory;

layout('components.layouts.public');

state(['category' => null]);

mount(function (ServiceCategory $category) {
    $this->category = $category;
});

title(fn() => $this->category->name . ' | Services | KMG');

$services = computed(fn() =>
    $this->category->services()
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get()
);

?>

@php
    // Category-specific content data
    $categoryContent = [
        'environmental-monitoring' => [
            'overview' => 'KMG provides comprehensive environmental monitoring services to measure, assess and report on environmental parameters critical to regulatory compliance and operational sustainability. Our monitoring programmes are designed to meet NEMA, NWA, AQA and licence-specific requirements.',
            'standards' => [
                ['name' => 'SANS 1929', 'description' => 'Ambient Air Quality Standards'],
                ['name' => 'NEMA', 'description' => 'National Environmental Management Act'],
                ['name' => 'NWA', 'description' => 'National Water Act requirements'],
                ['name' => 'NEM:AQA', 'description' => 'Air Quality Act compliance'],
                ['name' => 'WML/AEL', 'description' => 'Water Use & Air Emission Licence conditions'],
            ],
            'clients' => ['Mining operations', 'Industrial facilities', 'Municipalities', 'Power stations', 'Petrochemical plants', 'Construction projects'],
        ],
        'environmental-impact' => [
            'overview' => 'Our team of registered Environmental Assessment Practitioners (EAPs) delivers comprehensive impact assessments and specialist studies for projects across all sectors. We ensure scientifically defensible outputs that meet regulatory requirements and facilitate project authorisation.',
            'standards' => [
                ['name' => 'NEMA EIA Regulations', 'description' => '2014 Regulations (as amended)'],
                ['name' => 'DFFE Guidelines', 'description' => 'Competent Authority requirements'],
                ['name' => 'IFC Standards', 'description' => 'International Finance Corporation Performance Standards'],
                ['name' => 'Equator Principles', 'description' => 'Project finance environmental standards'],
            ],
            'clients' => ['Infrastructure developers', 'Mining companies', 'Energy projects', 'Property developers', 'Government departments', 'Financial institutions'],
        ],
        'permitting' => [
            'overview' => 'KMG assists clients in obtaining, maintaining and amending environmental permits and authorisations. Our permitting specialists navigate complex regulatory requirements to ensure compliant operations and avoid costly delays or penalties.',
            'standards' => [
                ['name' => 'Environmental Authorisation', 'description' => 'NEMA Section 24 applications'],
                ['name' => 'Water Use Licence', 'description' => 'NWA Section 21 applications'],
                ['name' => 'Air Emission Licence', 'description' => 'NEM:AQA applications'],
                ['name' => 'Waste Management Licence', 'description' => 'NEM:WA applications'],
                ['name' => 'Mining Rights', 'description' => 'MPRDA environmental compliance'],
            ],
            'clients' => ['New project developments', 'Existing operations', 'Mining rights holders', 'Industrial facilities', 'Municipalities'],
        ],
        'waste' => [
            'overview' => 'As a DoEL-approved asbestos contractor (RAC2024-CI/100), KMG provides comprehensive waste management and asbestos services. From waste audits and classification to safe asbestos removal, we ensure regulatory compliance and environmental protection.',
            'standards' => [
                ['name' => 'NEM:WA', 'description' => 'National Environmental Management: Waste Act'],
                ['name' => 'Asbestos Regulations', 'description' => 'DoEL Asbestos Abatement Regulations'],
                ['name' => 'SANS 10228', 'description' => 'Identification and classification of dangerous substances'],
                ['name' => 'NRCS', 'description' => 'National Regulator for Compulsory Specifications'],
            ],
            'clients' => ['Building owners', 'Demolition contractors', 'Industrial facilities', 'Mining operations', 'Municipalities', 'Property managers'],
        ],
        'climate' => [
            'overview' => 'KMG helps organisations measure, manage and report on their carbon footprint and climate risks. Our ESG services support sustainability strategy development, disclosure frameworks, and stakeholder reporting requirements.',
            'standards' => [
                ['name' => 'GHG Protocol', 'description' => 'Corporate carbon accounting standard'],
                ['name' => 'ISO 14064', 'description' => 'Greenhouse gas quantification'],
                ['name' => 'TCFD', 'description' => 'Task Force on Climate-related Financial Disclosures'],
                ['name' => 'CDP', 'description' => 'Carbon Disclosure Project reporting'],
                ['name' => 'JSE Sustainability', 'description' => 'JSE Listing Requirements'],
            ],
            'clients' => ['Listed companies', 'Financial institutions', 'Multinational corporations', 'Mining houses', 'Industrial manufacturers'],
        ],
        'occupational' => [
            'overview' => 'Our SAIOH-registered Occupational Hygienists conduct workplace exposure assessments and health risk evaluations. We help employers comply with OHS legislation while protecting worker health through evidence-based interventions.',
            'standards' => [
                ['name' => 'OHSA', 'description' => 'Occupational Health and Safety Act'],
                ['name' => 'MHSA', 'description' => 'Mine Health and Safety Act'],
                ['name' => 'HCS Regulations', 'description' => 'Hazardous Chemical Substances Regulations'],
                ['name' => 'Noise Regulations', 'description' => 'Noise-Induced Hearing Loss Regulations'],
                ['name' => 'NIHL', 'description' => 'Lead, Asbestos and other substance regulations'],
            ],
            'clients' => ['Mining operations', 'Manufacturing facilities', 'Construction sites', 'Chemical plants', 'Food processing', 'Warehousing & logistics'],
        ],
        'training' => [
            'overview' => 'KMG is an EAPASA-accredited training provider offering professional development courses in environmental management, occupational hygiene, and regulatory compliance. Our courses are designed for working professionals seeking to enhance their expertise.',
            'standards' => [
                ['name' => 'EAPASA', 'description' => 'Accredited CPD provider'],
                ['name' => 'SACNASP', 'description' => 'Registered training provider'],
                ['name' => 'SAIOH', 'description' => 'Occupational hygiene training'],
                ['name' => 'SETA', 'description' => 'Skills development compliance'],
            ],
            'clients' => ['Environmental practitioners', 'Safety officers', 'Mining professionals', 'Municipal officials', 'Compliance managers', 'Graduate scientists'],
        ],
        'equipment' => [
            'overview' => 'KMG offers professional environmental monitoring equipment for short-term hire. All equipment is calibrated, maintained and supplied with operational support to ensure accurate, reliable data collection.',
            'standards' => [
                ['name' => 'ISO 17025', 'description' => 'Calibration standards'],
                ['name' => 'SANS Methods', 'description' => 'SA National Standards compliance'],
                ['name' => 'OEM Specifications', 'description' => 'Manufacturer maintenance protocols'],
            ],
            'clients' => ['Environmental consultants', 'Mining companies', 'Research institutions', 'Municipalities', 'Industrial facilities', 'Contractors'],
        ],
        'audit' => [
            'overview' => 'Our experienced auditors conduct environmental, OHS and ESG compliance audits against regulatory requirements, management systems and international standards. We identify gaps, risks and opportunities for improvement.',
            'standards' => [
                ['name' => 'ISO 14001', 'description' => 'Environmental Management Systems'],
                ['name' => 'ISO 45001', 'description' => 'Occupational Health & Safety'],
                ['name' => 'Legal Compliance', 'description' => 'Regulatory audit protocols'],
                ['name' => 'Due Diligence', 'description' => 'Transaction support audits'],
                ['name' => 'ESG Frameworks', 'description' => 'Sustainability assurance'],
            ],
            'clients' => ['Listed companies', 'Mining operations', 'Industrial facilities', 'Property portfolios', 'Financial institutions', 'Private equity'],
        ],
    ];

    // Match category to content
    $content = null;
    $slug = $category->slug;
    foreach ($categoryContent as $key => $data) {
        if (Str::contains($slug, $key)) {
            $content = $data;
            break;
        }
    }

    // Default content if no match
    if (!$content) {
        $content = [
            'overview' => $category->description ?: 'KMG provides professional ' . strtolower($category->name) . ' services to meet your environmental and regulatory requirements.',
            'standards' => [
                ['name' => 'NEMA', 'description' => 'National Environmental Management Act'],
                ['name' => 'Industry Standards', 'description' => 'Sector-specific requirements'],
            ],
            'clients' => ['Mining operations', 'Industrial facilities', 'Municipalities', 'Developers'],
        ];
    }

    // Hero images
    $categoryImages = [
        'monitoring' => 'environmental-monitoring.jpg',
        'water' => 'water-monitoring.jpg',
        'air' => 'air-monitoring.jpg',
        'impact' => 'environmental-monitoring.jpg',
        'waste' => 'soil-sampling.jpg',
        'asbestos' => 'soil-sampling.jpg',
        'climate' => 'environmental-monitoring.jpg',
        'occupational' => 'air-monitoring.jpg',
        'training' => 'environmental-monitoring.jpg',
        'equipment' => 'noise-monitoring.jpg',
        'audit' => 'environmental-monitoring.jpg',
    ];
    $heroImage = null;
    foreach ($categoryImages as $key => $image) {
        if (Str::contains($slug, $key)) {
            $heroImage = $image;
            break;
        }
    }
@endphp

<div class="bg-white">
    <!-- Hero Section -->
    <section class="relative py-24 bg-zinc-900 overflow-hidden">
        @if($heroImage && file_exists(public_path("images/services/{$heroImage}")))
            <img src="{{ asset("images/services/{$heroImage}") }}"
                 alt="{{ $category->name }}"
                 class="absolute inset-0 w-full h-full object-cover opacity-30">
        @endif
        <div class="absolute inset-0 bg-gradient-to-b from-zinc-900/80 to-zinc-900/95"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4">
            <x-public.breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Services', 'url' => route('services.index')],
                ['label' => $category->name],
            ]" class="mb-8" />

            <div class="max-w-4xl">
                <div class="flex items-center gap-4 mb-6">
                    @if($category->icon)
                        <span class="text-5xl">{{ $category->icon }}</span>
                    @endif
                    <h1 class="text-4xl md:text-6xl font-black text-white">
                        {{ $category->name }}
                    </h1>
                </div>

                <p class="text-xl text-zinc-300 leading-relaxed">
                    {{ $content['overview'] }}
                </p>
            </div>
        </div>
    </section>

    <!-- Services List Section -->
    <section class="py-24">
        <div class="max-w-7xl mx-auto px-4">
            <div class="mb-12 border-l-4 border-green-500 pl-6">
                <h2 class="text-3xl md:text-4xl font-black text-zinc-950 mb-2">
                    Specific Services
                </h2>
                <p class="text-zinc-500">
                    {{ $this->services->count() }} {{ Str::plural('service', $this->services->count()) }} available in this category
                </p>
            </div>

            @if($this->services->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($this->services as $service)
                        <a href="{{ route('services.show', $service) }}"
                           class="group bg-zinc-50 rounded-lg overflow-hidden hover:shadow-xl transition-all border border-zinc-100 hover:border-green-500">
                            @if($service->featured_image && file_exists(public_path('storage/' . $service->featured_image)))
                                <div class="aspect-video bg-zinc-200 overflow-hidden">
                                    <img src="{{ asset('storage/' . $service->featured_image) }}"
                                         alt="{{ $service->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @endif

                            <div class="p-6">
                                <h3 class="text-xl font-bold text-zinc-950 mb-3 group-hover:text-green-600 transition-colors">
                                    {{ $service->name }}
                                </h3>

                                @if($service->short_description)
                                    <p class="text-zinc-600 text-sm leading-relaxed mb-4">
                                        {{ Str::limit($service->short_description, 120) }}
                                    </p>
                                @elseif($service->description)
                                    <p class="text-zinc-600 text-sm leading-relaxed mb-4">
                                        {{ Str::limit(strip_tags($service->description), 120) }}
                                    </p>
                                @endif

                                <div class="flex items-center gap-2 text-green-600 font-semibold group-hover:gap-3 transition-all">
                                    <span>Learn More</span>
                                    <x-solar-icon name="alt-arrow-right" size="20" class="group-hover:translate-x-1 transition-transform" />
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-zinc-50 rounded-lg">
                    <x-solar-icon name="folder" size="64" class="text-zinc-300 mx-auto mb-4" />
                    <p class="text-zinc-500 mb-4">Services coming soon.</p>
                    <a href="{{ route('contact') }}" class="text-green-600 font-semibold hover:text-green-700">
                        Contact us for more information
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Compliance & Standards Section -->
    <section class="py-24 bg-zinc-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                <!-- Standards -->
                <div>
                    <div class="mb-8 border-l-4 border-green-500 pl-6">
                        <h2 class="text-3xl md:text-4xl font-black text-zinc-950 mb-2">
                            Compliance & Standards
                        </h2>
                        <p class="text-zinc-500">
                            Regulatory frameworks and standards we work with
                        </p>
                    </div>

                    <div class="space-y-4">
                        @foreach($content['standards'] as $standard)
                            <div class="bg-white p-4 rounded-lg border border-zinc-100 flex items-start gap-4">
                                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <x-solar-icon name="document-text" size="20" class="text-white" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-zinc-950">{{ $standard['name'] }}</h4>
                                    <p class="text-sm text-zinc-600">{{ $standard['description'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Clients & Applications -->
                <div>
                    <div class="mb-8 border-l-4 border-green-500 pl-6">
                        <h2 class="text-3xl md:text-4xl font-black text-zinc-950 mb-2">
                            Typical Clients
                        </h2>
                        <p class="text-zinc-500">
                            Industries and applications we serve
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        @foreach($content['clients'] as $client)
                            <div class="bg-white p-4 rounded-lg border border-zinc-100 flex items-center gap-3">
                                <x-solar-icon name="check-circle" size="24" class="text-green-500 flex-shrink-0" />
                                <span class="text-zinc-700 font-medium">{{ $client }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Quick Stats -->
                    <div class="mt-8 grid grid-cols-3 gap-4">
                        <div class="bg-green-500 p-4 rounded-lg text-center">
                            <div class="text-2xl font-black text-zinc-900">15+</div>
                            <div class="text-xs text-zinc-800">Years</div>
                        </div>
                        <div class="bg-green-500 p-4 rounded-lg text-center">
                            <div class="text-2xl font-black text-zinc-900">500+</div>
                            <div class="text-xs text-zinc-800">Projects</div>
                        </div>
                        <div class="bg-green-500 p-4 rounded-lg text-center">
                            <div class="text-2xl font-black text-zinc-900">9</div>
                            <div class="text-xs text-zinc-800">Provinces</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-zinc-900 text-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-4xl md:text-5xl font-black mb-6">
                Need {{ $category->name }}?
            </h2>
            <p class="text-xl text-zinc-400 mb-12 max-w-2xl mx-auto">
                Request a quote from our team of accredited specialists or download our service brochure for more information.
            </p>

            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ route('contact') }}?service={{ urlencode($category->name) }}"
                   class="inline-flex items-center justify-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                    <x-solar-icon name="chat-round-money" size="24" />
                    <span>Request a Quote</span>
                </a>

                <a href="#"
                   class="inline-flex items-center justify-center gap-3 px-8 py-4 text-lg font-bold text-white bg-transparent border-2 border-white/30 hover:border-green-500 hover:bg-white/10 transition-all">
                    <x-solar-icon name="file-download" size="24" />
                    <span>Download Brochure</span>
                </a>
            </div>

            <div class="mt-12 pt-12 border-t border-white/10">
                <p class="text-zinc-500 mb-4">Or call us directly</p>
                <a href="tel:0119696184" class="text-3xl font-black text-green-500 hover:text-green-400 transition-colors">
                    011 969 6184
                </a>
            </div>
        </div>
    </section>

    <!-- Related Categories -->
    <section class="py-24 bg-zinc-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-zinc-950 mb-2">
                    Other Service Categories
                </h2>
                <p class="text-zinc-500">
                    Explore our full range of environmental services
                </p>
            </div>

            @php
                $otherCategories = ServiceCategory::where('is_active', true)
                    ->where('id', '!=', $category->id)
                    ->withCount(['services' => fn($q) => $q->where('is_active', true)])
                    ->orderBy('sort_order')
                    ->limit(6)
                    ->get();
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($otherCategories as $otherCategory)
                    <a href="{{ route('services.category', $otherCategory) }}"
                       class="bg-white p-4 rounded-lg text-center hover:shadow-lg transition-all border border-zinc-100 hover:border-green-500 group">
                        @if($otherCategory->icon)
                            <span class="text-3xl block mb-2">{{ $otherCategory->icon }}</span>
                        @endif
                        <h3 class="text-sm font-bold text-zinc-950 group-hover:text-green-600 transition-colors">
                            {{ Str::limit($otherCategory->name, 25) }}
                        </h3>
                        <span class="text-xs text-zinc-400">{{ $otherCategory->services_count }} services</span>
                    </a>
                @endforeach
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('services.index') }}"
                   class="inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-700">
                    <span>View All Categories</span>
                    <x-solar-icon name="alt-arrow-right" size="20" />
                </a>
            </div>
        </div>
    </section>
</div>
