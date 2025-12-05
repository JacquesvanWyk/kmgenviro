<?php

use function Livewire\Volt\{computed, layout, title};
use App\Models\{ServiceCategory, Project, ClientLogo, BlogPost, TeamMember, Accreditation, Sector, TrainingCourse};

layout('components.layouts.public');
title('KMG Environmental Solutions | Environmental Consultancy South Africa');

$serviceCategories = computed(fn() =>
    ServiceCategory::where('is_active', true)
        ->orderBy('sort_order')
        ->limit(9)
        ->get()
);

$featuredProjects = computed(fn() =>
    Project::where('is_featured', true)
        ->where('is_active', true)
        ->with('sector')
        ->latest('completion_date')
        ->limit(3)
        ->get()
);

$sectors = computed(fn() =>
    Sector::where('is_active', true)
        ->orderBy('sort_order')
        ->limit(8)
        ->get()
);

$accreditations = computed(fn() =>
    Accreditation::where('is_active', true)
        ->orderBy('sort_order')
        ->limit(8)
        ->get()
);

$upcomingTraining = computed(fn() =>
    TrainingCourse::where('is_active', true)
        ->orderBy('sort_order')
        ->limit(4)
        ->get()
);

$clientLogos = computed(fn() =>
    ClientLogo::where('is_active', true)
        ->orderBy('sort_order')
        ->get()
);

$teamCount = computed(fn() => TeamMember::where('is_active', true)->count());
$accreditationCount = computed(fn() => Accreditation::where('is_active', true)->count());
$projectCount = computed(fn() => Project::count());

?>

<div class="bg-zinc-50">
    <!-- Hero Section with Auto-Slider -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden liquid-glass"
             x-data="{
                currentSlide: 0,
                slides: [
                    { image: '{{ asset('images/hero/team-water-sampling.jpg') }}', alt: 'KMG Environmental team conducting water quality sampling' },
                    { image: '{{ asset('images/gallery/team-fieldwork.jpg') }}', alt: 'KMG team performing environmental fieldwork' },
                    { image: '{{ asset('images/services/environmental-monitoring.jpg') }}', alt: 'Environmental monitoring equipment' },
                    { image: '{{ asset('images/gallery/team-monitoring-mountains.jpg') }}', alt: 'KMG team monitoring in mountainous terrain' },
                    { image: '{{ asset('images/gallery/water-sampling-river.jpg') }}', alt: 'Water sampling at river site' }
                ],
                init() {
                    setInterval(() => {
                        this.currentSlide = (this.currentSlide + 1) % this.slides.length
                    }, 5000)
                }
             }">
        <!-- Background Image Slider -->
        <template x-for="(slide, index) in slides" :key="index">
            <img :src="slide.image"
                 :alt="slide.alt"
                 class="absolute inset-0 w-full h-full object-cover object-center transition-opacity duration-1000"
                 :class="currentSlide === index ? 'opacity-100' : 'opacity-0'"
                 loading="eager">
        </template>

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-zinc-900/70 via-zinc-900/60 to-zinc-900/80"></div>

        <!-- Grid pattern overlay -->
        <div class="absolute inset-0 grid-pattern opacity-10"></div>

        <!-- Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 py-32">
            <div class="text-center">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 mb-8 px-4 py-2 bg-white/10 border border-green-500/50 backdrop-blur-sm rounded">
                    <x-solar-icon name="verified-check" size="20" class="text-green-500" />
                    <span class="text-white text-sm font-medium">DoEL Approved | SACNASP | EAPASA | GBCSA Registered</span>
                </div>

                <!-- Main Heading -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-6 leading-tight">
                    Your Trusted Partner in
                    <span class="block text-green-500">Environmental Compliance</span>
                </h1>

                <p class="text-lg md:text-xl text-zinc-300 mb-12 max-w-5xl mx-auto leading-relaxed">
                    Specialist Studies | Environmental Authorizations | Environmental Audits | Environmental Training | ESG Compliance | OHS
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <a href="{{ route('services.index') }}"
                       class="group relative inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all duration-300">
                        <x-solar-icon name="library" size="24" />
                        <span>Explore Services</span>
                        <x-solar-icon name="alt-arrow-right" size="24" class="group-hover:translate-x-1 transition-transform" />
                    </a>

                    <a href="{{ route('contact') }}"
                       class="group relative inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-white bg-transparent border-2 border-white/50 hover:border-green-500 hover:bg-white/10 transition-all duration-300">
                        <x-solar-icon name="chat-round-money" size="24" />
                        <span>Request Quote</span>
                    </a>
                </div>

                <!-- Stats Bar -->
                <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                    <div class="text-center bg-white/10 backdrop-blur-sm p-6 rounded">
                        <div class="text-3xl md:text-4xl font-black text-green-500 mb-2">13+</div>
                        <div class="text-sm text-zinc-300 uppercase tracking-wider">Years Experience</div>
                    </div>
                    <div class="text-center bg-white/10 backdrop-blur-sm p-6 rounded">
                        <div class="text-3xl md:text-4xl font-black text-green-500 mb-2">100+</div>
                        <div class="text-sm text-zinc-300 uppercase tracking-wider">Projects</div>
                    </div>
                    <div class="text-center bg-white/10 backdrop-blur-sm p-6 rounded">
                        <div class="text-3xl md:text-4xl font-black text-green-500 mb-2">{{ $this->accreditationCount ?: '10' }}+</div>
                        <div class="text-sm text-zinc-300 uppercase tracking-wider">Accreditations</div>
                    </div>
                    <div class="text-center bg-white/10 backdrop-blur-sm p-6 rounded">
                        <div class="text-3xl md:text-4xl font-black text-green-500 mb-2">9</div>
                        <div class="text-sm text-zinc-300 uppercase tracking-wider">Provinces</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <x-solar-icon name="double-alt-arrow-down" size="32" class="text-white/50" />
        </div>
    </section>

    <!-- Who We Are Section -->
    <section class="py-20 bg-white relative">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Content -->
                <div>
                    <div class="mb-6 border-l-4 border-green-500 pl-6">
                        <h2 class="text-3xl md:text-4xl font-black text-zinc-950">
                            We are KMG Environmental Solutions Services
                        </h2>
                    </div>

                    <p class="text-lg text-zinc-600 mb-8 leading-relaxed">
                        We help organisations build projects that meet the law, respect communities, and protect the environment. Our team combines on-site monitoring, laboratory analysis, and specialist impact assessments to deliver defensible, regulator-ready reports on time and in full.
                    </p>

                    <!-- What We Do -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-zinc-950 mb-4">What We Do</h3>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <x-solar-icon name="chart-2" size="24" class="text-green-500 flex-shrink-0 mt-1" />
                                <div>
                                    <div class="font-bold text-zinc-950">Environmental Monitoring</div>
                                    <div class="text-sm text-zinc-600">Ambient air & dust fallout, stack emissions, water & effluent quality, groundwater, noise, soil, and occupational hygiene.</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <x-solar-icon name="document-text" size="24" class="text-green-500 flex-shrink-0 mt-1" />
                                <div>
                                    <div class="font-bold text-zinc-950">Specialist Studies</div>
                                    <div class="text-sm text-zinc-600">Terrestrial & aquatic biodiversity, wetlands, agricultural impact, air quality impact, noise impact, visual, socio-economic, hydropedology, geohydrology, heritage & palaeontology.</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <x-solar-icon name="diploma" size="24" class="text-green-500 flex-shrink-0 mt-1" />
                                <div>
                                    <div class="font-bold text-zinc-950">Compliance & Permitting</div>
                                    <div class="text-sm text-zinc-600">EIA/BA Authorization, WML Applications, Green Star Rating Applications, ESG Compliance, licence conditions tracking, risk matrices, mitigation design, and monitoring plans.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('about') }}"
                       class="inline-flex items-center gap-3 px-6 py-3 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                        <span>Learn More About Us</span>
                        <x-solar-icon name="alt-arrow-right" size="20" />
                    </a>
                </div>

                <!-- Image -->
                <div class="relative">
                    @if(file_exists(public_path('images/about/kmg-vehicle-bakkie.jpg')))
                        <img src="{{ asset('images/about/kmg-vehicle-bakkie.jpg') }}"
                             alt="KMG Environmental Solutions team vehicle"
                             class="w-full h-auto shadow-xl">
                    @else
                        <div class="aspect-video bg-zinc-100 flex items-center justify-center">
                            <x-solar-icon name="buildings" size="64" class="text-zinc-300" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Why Clients Choose KMG -->
    <section class="py-16 bg-zinc-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-black text-zinc-950 mb-4">
                    Why Clients Choose <span class="text-green-500">KMG</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                <div class="bg-white p-6 text-center">
                    <x-solar-icon name="shield-check" size="40" class="text-green-500 mx-auto mb-4" />
                    <h3 class="font-bold text-zinc-950 mb-2">Compliance Without Chaos</h3>
                    <p class="text-sm text-zinc-600">We align deliverables to NEMA, NWA, NEM: AQA and licence conditions—so you avoid penalties and delays.</p>
                </div>
                <div class="bg-white p-6 text-center">
                    <x-solar-icon name="chart-square" size="40" class="text-green-500 mx-auto mb-4" />
                    <h3 class="font-bold text-zinc-950 mb-2">Data → Decisions</h3>
                    <p class="text-sm text-zinc-600">Dashboards, trends, and plain-language insights your project team can act on.</p>
                </div>
                <div class="bg-white p-6 text-center">
                    <x-solar-icon name="rocket" size="40" class="text-green-500 mx-auto mb-4" />
                    <h3 class="font-bold text-zinc-950 mb-2">Speed & Reliability</h3>
                    <p class="text-sm text-zinc-600">Rapid field mobilisation and fast reporting cycles.</p>
                </div>
                <div class="bg-white p-6 text-center">
                    <x-solar-icon name="settings" size="40" class="text-green-500 mx-auto mb-4" />
                    <h3 class="font-bold text-zinc-950 mb-2">In-House Capability</h3>
                    <p class="text-sm text-zinc-600">Calibrated monitoring instruments (noise meters, portable ambient air units, sampling kits) and a multi-disciplinary team.</p>
                </div>
                <div class="bg-white p-6 text-center">
                    <x-solar-icon name="medal-ribbons-star" size="40" class="text-green-500 mx-auto mb-4" />
                    <h3 class="font-bold text-zinc-950 mb-2">Proven Track Record</h3>
                    <p class="text-sm text-zinc-600">Mining, energy, transport, water utilities, and municipal projects nationwide and in SADC.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Standing & Footprint -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Professional Standing -->
                <div>
                    <h3 class="text-2xl font-bold text-zinc-950 mb-6 border-l-4 border-green-500 pl-4">Professional Standing</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <x-solar-icon name="verified-check" size="20" class="text-green-500 flex-shrink-0 mt-1" />
                            <span class="text-zinc-700">SACNASP-registered scientists</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <x-solar-icon name="verified-check" size="20" class="text-green-500 flex-shrink-0 mt-1" />
                            <span class="text-zinc-700">WISA registered scientists</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <x-solar-icon name="verified-check" size="20" class="text-green-500 flex-shrink-0 mt-1" />
                            <span class="text-zinc-700">Department of Employment & Labour Approved Asbestos Contractor (RAC2024-CI/100)</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <x-solar-icon name="verified-check" size="20" class="text-green-500 flex-shrink-0 mt-1" />
                            <span class="text-zinc-700">EAPASA-registered scientists and aligned practice</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <x-solar-icon name="verified-check" size="20" class="text-green-500 flex-shrink-0 mt-1" />
                            <span class="text-zinc-700">GBCSA Member and registered EP</span>
                        </li>
                    </ul>
                </div>

                <!-- Footprint -->
                <div>
                    <h3 class="text-2xl font-bold text-zinc-950 mb-6 border-l-4 border-green-500 pl-4">Our Footprint</h3>
                    <div class="flex items-start gap-3 mb-4">
                        <x-solar-icon name="map-point" size="20" class="text-green-500 flex-shrink-0 mt-1" />
                        <div>
                            <div class="font-bold text-zinc-950">Head Office</div>
                            <div class="text-zinc-600">08 Hillside Road, Metropolitan Building, 1st Floor B, Parktown, Johannesburg, 2193</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <x-solar-icon name="globe" size="20" class="text-green-500 flex-shrink-0 mt-1" />
                        <div>
                            <div class="font-bold text-zinc-950">Projects Across</div>
                            <div class="text-zinc-600">Gauteng, Limpopo, North West, KZN, Mpumalanga, Northern Cape, Eastern Cape, Western Cape and Lesotho/SADC</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Accreditations & Memberships -->
    <section class="py-16 bg-zinc-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-black text-zinc-950 mb-4">
                    Key Accreditations & <span class="text-green-500">Memberships</span>
                </h2>
                <p class="text-zinc-500 max-w-2xl mx-auto">
                    Recognized by leading industry bodies for our commitment to excellence and compliance
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- DoEL -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-48 h-32 flex items-center justify-center mb-4 p-4">
                        @if(file_exists(public_path('images/accreditations/doel.jpg')))
                            <img src="{{ asset('images/accreditations/doel.jpg') }}" alt="DoEL" class="w-full h-full object-contain">
                        @else
                            <div class="text-sm font-bold text-zinc-700">DoEL</div>
                        @endif
                    </div>
                    <div class="font-bold text-zinc-950 mb-1">DoEL</div>
                </div>

                <!-- SACNASP -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-48 h-32 flex items-center justify-center mb-4 p-4">
                        @if(file_exists(public_path('images/accreditations/sacnasp.png')))
                            <img src="{{ asset('images/accreditations/sacnasp.png') }}" alt="SACNASP" class="w-full h-full object-contain">
                        @else
                            <div class="text-sm font-bold text-zinc-700">SACNASP</div>
                        @endif
                    </div>
                    <div class="font-bold text-zinc-950 mb-1">SACNASP</div>
                </div>

                <!-- EAPASA -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-48 h-32 flex items-center justify-center mb-4 p-4">
                        @if(file_exists(public_path('images/accreditations/eapasa.png')))
                            <img src="{{ asset('images/accreditations/eapasa.png') }}" alt="EAPASA" class="w-full h-full object-contain">
                        @else
                            <div class="text-sm font-bold text-zinc-700">EAPASA</div>
                        @endif
                    </div>
                    <div class="font-bold text-zinc-950 mb-1">EAPASA</div>
                </div>

                <!-- GBCSA -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-48 h-32 flex items-center justify-center mb-4 p-4">
                        @if(file_exists(public_path('images/accreditations/GBCSA-logo.png')))
                            <img src="{{ asset('images/accreditations/GBCSA-logo.png') }}" alt="GBCSA" class="w-full h-full object-contain">
                        @else
                            <div class="text-sm font-bold text-zinc-700">GBCSA</div>
                        @endif
                    </div>
                    <div class="font-bold text-zinc-950 mb-1">GBCSA</div>
                </div>

                <!-- WISA -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-48 h-32 flex items-center justify-center mb-4 p-4">
                        @if(file_exists(public_path('images/accreditations/WISA.png')))
                            <img src="{{ asset('images/accreditations/WISA.png') }}" alt="WISA" class="w-full h-full object-contain">
                        @else
                            <div class="text-sm font-bold text-zinc-700">WISA</div>
                        @endif
                    </div>
                    <div class="font-bold text-zinc-950 mb-1">WISA</div>
                </div>

                <!-- IIAV -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-48 h-32 flex items-center justify-center mb-4 p-4">
                        @if(file_exists(public_path('images/accreditations/IIAV.png')))
                            <img src="{{ asset('images/accreditations/IIAV.png') }}" alt="The International Institute of Acoustics and Vibration" class="w-full h-full object-contain">
                        @else
                            <div class="text-sm font-bold text-zinc-700">IIAV</div>
                        @endif
                    </div>
                    <div class="font-bold text-zinc-950 mb-1">IIAV</div>
                </div>

                <!-- IAIAsa -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-48 h-32 flex items-center justify-center mb-4 p-4">
                        @if(file_exists(public_path('images/accreditations/IAIAsa.png')))
                            <img src="{{ asset('images/accreditations/IAIAsa.png') }}" alt="IAIAsa" class="w-full h-full object-contain">
                        @else
                            <div class="text-sm font-bold text-zinc-700">IAIAsa</div>
                        @endif
                    </div>
                    <div class="font-bold text-zinc-950 mb-1">IAIAsa</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Industries We Serve -->
    <section class="py-24 bg-zinc-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-zinc-950 mb-4">
                    Industries We Serve
                </h2>
                <p class="text-xl text-zinc-500 max-w-3xl mx-auto">
                    Delivering environmental solutions across diverse sectors
                </p>
            </div>

            <!-- Industry Icons/Badges Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Mining & Minerals -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-4 border border-zinc-100 hover:shadow-lg transition-shadow">
                        <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-zinc-950 mb-1">Mining & Minerals</h3>
                    <p class="text-sm text-zinc-600">Environmental assessments & compliance</p>
                </div>

                <!-- Infrastructure & Transport -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-4 border border-zinc-100 hover:shadow-lg transition-shadow">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-zinc-950 mb-1">Infrastructure & Transport</h3>
                    <p class="text-sm text-zinc-600">Large-scale project management</p>
                </div>

                <!-- Municipal & Public Sector -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-4 border border-zinc-100 hover:shadow-lg transition-shadow">
                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-zinc-950 mb-1">Municipal & Public Sector</h3>
                    <p class="text-sm text-zinc-600">Public service environmental support</p>
                </div>

                <!-- Renewable Energy -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-4 border border-zinc-100 hover:shadow-lg transition-shadow">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-zinc-950 mb-1">Renewable Energy</h3>
                    <p class="text-sm text-zinc-600">Sustainable energy solutions</p>
                </div>

                <!-- Industrial & Manufacturing -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-4 border border-zinc-100 hover:shadow-lg transition-shadow">
                        <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-zinc-950 mb-1">Industrial & Manufacturing</h3>
                    <p class="text-sm text-zinc-600">Industrial environmental compliance</p>
                </div>

                <!-- Water & Sanitation -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-4 border border-zinc-100 hover:shadow-lg transition-shadow">
                        <svg class="w-10 h-10 text-cyan-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-zinc-950 mb-1">Water & Sanitation</h3>
                    <p class="text-sm text-zinc-600">Water resource management</p>
                </div>

                <!-- Healthcare & Medical Waste -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-4 border border-zinc-100 hover:shadow-lg transition-shadow">
                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-zinc-950 mb-1">Healthcare & Medical Waste</h3>
                    <p class="text-sm text-zinc-600">Medical waste management</p>
                </div>

                <!-- Property & Land Development -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-4 border border-zinc-100 hover:shadow-lg transition-shadow">
                        <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-zinc-950 mb-1">Property & Land Development</h3>
                    <p class="text-sm text-zinc-600">Property environmental assessments</p>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('sectors.index') }}"
                   class="inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                    <span>Explore All Sectors</span>
                    <x-solar-icon name="alt-arrow-right" size="24" />
                </a>
            </div>
        </div>
    </section>

    <!-- Our Work in Action -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-black text-zinc-950 mb-4">
                    Our Work in <span class="text-green-500">Action</span>
                </h2>
                <p class="text-zinc-500 max-w-2xl mx-auto">
                    See our field monitoring activities and project highlights across South Africa and SADC
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                @php
                    $galleryImages = [
                        ['src' => 'images/gallery/team-fieldwork.jpg', 'alt' => 'Team fieldwork'],
                        ['src' => 'images/gallery/water-sampling-river.jpg', 'alt' => 'Water sampling'],
                        ['src' => 'images/gallery/team-soil-sampling.jpg', 'alt' => 'Soil sampling'],
                        ['src' => 'images/gallery/monitoring-coal-mine.jpg', 'alt' => 'Mining monitoring'],
                    ];
                @endphp
                @foreach($galleryImages as $image)
                    <div class="aspect-video bg-zinc-200 overflow-hidden group">
                        @if(file_exists(public_path($image['src'])))
                            <img src="{{ asset($image['src']) }}"
                                 alt="{{ $image['alt'] }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-zinc-100">
                                <x-solar-icon name="camera" size="32" class="text-zinc-400" />
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="text-center">
                <a href="{{ route('gallery') }}"
                   class="inline-flex items-center gap-3 px-6 py-3 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                    <x-solar-icon name="gallery" size="24" />
                    <span>View Full Gallery</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Our Clients -->
    <section class="py-16 bg-zinc-50 border-y border-zinc-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-zinc-950 mb-2">Trusted by Leading Organisations</h2>
                <p class="text-zinc-500">Our clients across South Africa and SADC</p>
            </div>

            @if($this->clientLogos->count() > 0)
                <div class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-6">
                    @foreach($this->clientLogos as $client)
                        <div class="flex items-center justify-center p-4 bg-white aspect-square">
                            @if($client->logo && file_exists(public_path($client->logo)))
                                <img src="{{ asset($client->logo) }}"
                                     alt="{{ $client->name }}"
                                     class="max-w-full max-h-full object-contain grayscale hover:grayscale-0 transition-all opacity-70 hover:opacity-100"
                                     title="{{ $client->name }}">
                            @else
                                <x-solar-icon name="buildings" size="32" class="text-zinc-300" />
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Placeholder for client logos -->
                <div class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-6">
                    @for($i = 0; $i < 8; $i++)
                        <div class="flex items-center justify-center p-4 bg-white aspect-square border border-dashed border-zinc-300">
                            <x-solar-icon name="buildings" size="32" class="text-zinc-300" />
                        </div>
                    @endfor
                </div>
                <p class="text-center text-zinc-400 text-sm mt-4">Client logos coming soon</p>
            @endif
        </div>
    </section>

    <!-- Sectors & Projects -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-zinc-950 mb-4">
                    Sectors & <span class="text-green-500">Projects</span>
                </h2>
                <p class="text-xl text-zinc-500 max-w-3xl mx-auto">
                    Delivering environmental solutions across South Africa's key industries
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Mining & Minerals -->
                <a href="{{ route('sectors.index') }}?sector=mining-mineral-resources"
                   class="group bg-zinc-900 overflow-hidden hover:shadow-xl transition-all">
                    <div class="aspect-video bg-zinc-800 relative overflow-hidden">
                        @if(file_exists(public_path('images/sectors/mining.jpg')))
                            <img src="{{ asset('images/sectors/mining.jpg') }}"
                                 alt="Mining & Mineral Resources"
                                 class="w-full h-full object-cover opacity-60 group-hover:scale-105 group-hover:opacity-80 transition-all duration-500">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-zinc-900 to-transparent"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-green-500 transition-colors">
                            Mining & Mineral Resources
                        </h3>
                        <p class="text-zinc-400 text-sm mb-4">
                            EIAs, mining rights, water use licenses, closure plans & rehabilitation
                        </p>
                        <div class="flex items-center gap-2 text-green-500 font-semibold">
                            <span>Explore Sector</span>
                            <x-solar-icon name="alt-arrow-right" size="16" class="group-hover:translate-x-1 transition-transform" />
                        </div>
                    </div>
                </a>

                <!-- Infrastructure -->
                <a href="{{ route('sectors.index') }}?sector=infrastructure-construction"
                   class="group bg-zinc-900 overflow-hidden hover:shadow-xl transition-all">
                    <div class="aspect-video bg-zinc-800 relative overflow-hidden">
                        @if(file_exists(public_path('images/sectors/infrastructure-construction.jpg')))
                            <img src="{{ asset('images/sectors/infrastructure-construction.jpg') }}"
                                 alt="Infrastructure & Construction"
                                 class="w-full h-full object-cover opacity-60 group-hover:scale-105 group-hover:opacity-80 transition-all duration-500">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-zinc-900 to-transparent"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-green-500 transition-colors">
                            Infrastructure & Construction
                        </h3>
                        <p class="text-zinc-400 text-sm mb-4">
                            Roads, bridges, bulk infrastructure & urban development assessments
                        </p>
                        <div class="flex items-center gap-2 text-green-500 font-semibold">
                            <span>Explore Sector</span>
                            <x-solar-icon name="alt-arrow-right" size="16" class="group-hover:translate-x-1 transition-transform" />
                        </div>
                    </div>
                </a>

                <!-- Renewable Energy -->
                <a href="{{ route('sectors.index') }}?sector=renewable-energy"
                   class="group bg-zinc-900 overflow-hidden hover:shadow-xl transition-all">
                    <div class="aspect-video bg-zinc-800 relative overflow-hidden">
                        @if(file_exists(public_path('images/services/environmental-monitoring.jpg')))
                            <img src="{{ asset('images/services/environmental-monitoring.jpg') }}"
                                 alt="Renewable Energy"
                                 class="w-full h-full object-cover opacity-60 group-hover:scale-105 group-hover:opacity-80 transition-all duration-500">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-zinc-900 to-transparent"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-green-500 transition-colors">
                            Renewable Energy
                        </h3>
                        <p class="text-zinc-400 text-sm mb-4">
                            Solar PV, wind farms, grid connections & REIPPP support
                        </p>
                        <div class="flex items-center gap-2 text-green-500 font-semibold">
                            <span>Explore Sector</span>
                            <x-solar-icon name="alt-arrow-right" size="16" class="group-hover:translate-x-1 transition-transform" />
                        </div>
                    </div>
                </a>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('sectors.index') }}"
                   class="inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-white bg-zinc-900 hover:bg-zinc-800 transition-all">
                    <span>View All Sectors & Projects</span>
                    <x-solar-icon name="alt-arrow-right" size="24" />
                </a>
            </div>
        </div>
    </section>

    <!-- Training & Events -->
    <section class="py-24 bg-zinc-900 text-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="mb-8 border-l-4 border-green-500 pl-6">
                        <h2 class="text-4xl md:text-5xl font-black text-white mb-4">
                            Training & Events
                        </h2>
                    </div>

                    <p class="text-lg text-zinc-300 mb-6 leading-relaxed">
                        KMG is an EAPASA-accredited training provider offering professional development courses in environmental management, occupational hygiene, asbestos awareness, and regulatory compliance.
                    </p>

                    <p class="text-lg text-zinc-300 mb-8 leading-relaxed">
                        Our training programmes are designed to equip professionals with the knowledge and skills needed to meet South African environmental and occupational health requirements.
                    </p>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-center gap-3">
                            <x-solar-icon name="verified-check" size="24" class="text-green-500" />
                            <span>EAPASA Accredited Courses</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-solar-icon name="verified-check" size="24" class="text-green-500" />
                            <span>CPD Points for Registered Professionals</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-solar-icon name="verified-check" size="24" class="text-green-500" />
                            <span>On-Site & Remote Training Options</span>
                        </div>
                    </div>

                    <a href="{{ route('training.index') }}"
                       class="inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                        <span>View Training Courses</span>
                        <x-solar-icon name="alt-arrow-right" size="24" />
                    </a>
                </div>

                <div>
                    @if($this->upcomingTraining->count() > 0)
                        <div class="space-y-4">
                            @foreach($this->upcomingTraining as $course)
                                <div class="bg-white/10 backdrop-blur-sm p-6 rounded-lg">
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $course->name }}</h3>
                                    <p class="text-zinc-400 text-sm mb-3">{{ Str::limit($course->description, 80) }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-green-500 font-semibold">{{ $course->duration }}</span>
                                        <a href="{{ route('training.show', $course) }}" class="text-green-500 hover:text-green-400">
                                            Learn More &rarr;
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white/10 backdrop-blur-sm p-8 rounded-lg text-center">
                            <x-solar-icon name="graduation-cap" size="64" class="text-green-500 mx-auto mb-4" />
                            <h3 class="text-xl font-bold text-white mb-2">Professional Training</h3>
                            <p class="text-zinc-400 mb-4">Browse our full catalogue of accredited training courses</p>
                            <a href="{{ route('training.index') }}" class="text-green-500 hover:text-green-400 font-semibold">
                                View All Courses &rarr;
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Strip -->
    <section class="py-16 bg-green-500">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <div>
                    <h2 class="text-3xl md:text-4xl font-black text-zinc-950 mb-2">
                        Ready to Start Your Project?
                    </h2>
                    <p class="text-lg text-zinc-800">
                        Get expert environmental consulting from SACNASP-registered professionals
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('contact') }}"
                       class="inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-white bg-zinc-900 hover:bg-zinc-800 transition-all">
                        <x-solar-icon name="chat-round-money" size="24" />
                        <span>Request a Quote</span>
                    </a>

                    <a href="tel:0114804822"
                       class="inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-white hover:bg-zinc-100 transition-all">
                        <x-solar-icon name="phone-calling" size="24" />
                        <span>011 480 4822</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
