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

$teamCount = computed(fn() => TeamMember::where('is_active', true)->count());
$accreditationCount = computed(fn() => Accreditation::where('is_active', true)->count());
$projectCount = computed(fn() => Project::count());

?>

<div class="bg-zinc-50">
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden liquid-glass">
        @if(file_exists(public_path('images/hero/team-water-sampling.jpg')))
            <!-- Background Image -->
            <img src="{{ asset('images/hero/team-water-sampling.jpg') }}"
                 alt="KMG Environmental team conducting water quality sampling"
                 class="absolute inset-0 w-full h-full object-cover object-center"
                 loading="eager">

            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-b from-zinc-900/70 via-zinc-900/60 to-zinc-900/80"></div>
        @endif

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
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white mb-8 leading-tight">
                    Accredited Environmental, ESG,
                    <span class="block text-green-500">Waste & Occupational Hygiene</span>
                    <span class="block">Consultants</span>
                </h1>

                <p class="text-xl md:text-2xl text-zinc-300 mb-12 max-w-4xl mx-auto leading-relaxed">
                    Delivering scientifically robust, regulation-aligned environmental solutions across South Africa and the SADC region since 2008
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
                        <div class="text-3xl md:text-4xl font-black text-green-500 mb-2">15+</div>
                        <div class="text-sm text-zinc-300 uppercase tracking-wider">Years Experience</div>
                    </div>
                    <div class="text-center bg-white/10 backdrop-blur-sm p-6 rounded">
                        <div class="text-3xl md:text-4xl font-black text-green-500 mb-2">{{ $this->projectCount ?: '500' }}+</div>
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
    <section class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Content -->
                <div>
                    <div class="mb-8 border-l-4 border-green-500 pl-6">
                        <h2 class="text-4xl md:text-5xl font-black text-zinc-950 mb-4">
                            Who We Are
                        </h2>
                    </div>

                    <p class="text-lg text-zinc-600 mb-6 leading-relaxed">
                        KMG Environmental Solutions is a leading South African environmental consultancy providing expert services across the full spectrum of environmental management, ESG compliance, occupational hygiene, and professional training.
                    </p>

                    <p class="text-lg text-zinc-600 mb-8 leading-relaxed">
                        Our multidisciplinary team of registered professionals brings together expertise in environmental science, chemistry, occupational hygiene, waste management, and regulatory compliance to deliver scientifically defensible solutions.
                    </p>

                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="flex items-start gap-3">
                            <x-solar-icon name="verified-check" size="24" class="text-green-500 flex-shrink-0 mt-1" />
                            <div>
                                <div class="font-bold text-zinc-950">DoEL Approved</div>
                                <div class="text-sm text-zinc-500">Asbestos Contractor</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <x-solar-icon name="verified-check" size="24" class="text-green-500 flex-shrink-0 mt-1" />
                            <div>
                                <div class="font-bold text-zinc-950">SACNASP</div>
                                <div class="text-sm text-zinc-500">Registered Professionals</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <x-solar-icon name="verified-check" size="24" class="text-green-500 flex-shrink-0 mt-1" />
                            <div>
                                <div class="font-bold text-zinc-950">EAPASA</div>
                                <div class="text-sm text-zinc-500">Accredited Training</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <x-solar-icon name="verified-check" size="24" class="text-green-500 flex-shrink-0 mt-1" />
                            <div>
                                <div class="font-bold text-zinc-950">GBCSA</div>
                                <div class="text-sm text-zinc-500">Professional Member</div>
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
                    @if(file_exists(public_path('images/about/kmg-vehicle-1.jpg')))
                        <img src="{{ asset('images/about/kmg-vehicle-1.jpg') }}"
                             alt="KMG Environmental Solutions team vehicle"
                             class="w-full h-auto rounded-lg shadow-xl">
                    @else
                        <div class="aspect-video bg-zinc-100 rounded-lg flex items-center justify-center">
                            <x-solar-icon name="buildings" size="64" class="text-zinc-300" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Core Services Section -->
    <section class="py-24 bg-zinc-50 relative">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-zinc-950 mb-4">
                    Core Service Categories
                </h2>
                <p class="text-xl text-zinc-500 max-w-3xl mx-auto">
                    Comprehensive environmental solutions from accredited specialists
                </p>
            </div>

            <!-- Services Grid - 9 categories -->
            @if($this->serviceCategories->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                    @foreach($this->serviceCategories as $category)
                        <a href="{{ route('services.index') }}#category-{{ $category->slug }}"
                           class="bg-white p-6 rounded-lg shadow-sm hover:shadow-lg transition-all group border border-zinc-100 hover:border-green-500">
                            <div class="flex items-start gap-4">
                                <div class="text-4xl flex-shrink-0">{{ $category->icon }}</div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-zinc-950 mb-2 group-hover:text-green-600 transition-colors">
                                        {{ $category->name }}
                                    </h3>
                                    <p class="text-zinc-500 text-sm leading-relaxed">
                                        {{ Str::limit(strip_tags($category->description), 100) }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- View All Button -->
            <div class="text-center">
                <a href="{{ route('services.index') }}"
                   class="inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                    <span>View All Services</span>
                    <x-solar-icon name="alt-arrow-right" size="24" />
                </a>
            </div>
        </div>
    </section>

    <!-- Accreditations Logos -->
    <section class="py-16 bg-white border-y border-zinc-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-zinc-950 mb-2">Key Accreditations & Registrations</h2>
                <p class="text-zinc-500">Trusted by leading regulatory bodies</p>
            </div>

            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-12">
                @if($this->accreditations->count() > 0)
                    @foreach($this->accreditations as $accreditation)
                        @if($accreditation->logo_path && file_exists(public_path('storage/' . $accreditation->logo_path)))
                            <img src="{{ asset('storage/' . $accreditation->logo_path) }}"
                                 alt="{{ $accreditation->name }}"
                                 class="h-12 md:h-16 w-auto grayscale hover:grayscale-0 transition-all opacity-70 hover:opacity-100"
                                 title="{{ $accreditation->name }}">
                        @else
                            <div class="flex items-center gap-2 px-4 py-2 bg-zinc-50 rounded">
                                <x-solar-icon name="verified-check" size="20" class="text-green-500" />
                                <span class="text-sm font-medium text-zinc-700">{{ $accreditation->abbreviation ?? $accreditation->name }}</span>
                            </div>
                        @endif
                    @endforeach
                @else
                    <!-- Fallback accreditation badges -->
                    <div class="flex items-center gap-2 px-4 py-2 bg-zinc-50 rounded">
                        <x-solar-icon name="verified-check" size="20" class="text-green-500" />
                        <span class="text-sm font-medium text-zinc-700">DoEL Approved</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 bg-zinc-50 rounded">
                        <x-solar-icon name="verified-check" size="20" class="text-green-500" />
                        <span class="text-sm font-medium text-zinc-700">SACNASP</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 bg-zinc-50 rounded">
                        <x-solar-icon name="verified-check" size="20" class="text-green-500" />
                        <span class="text-sm font-medium text-zinc-700">EAPASA</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 bg-zinc-50 rounded">
                        <x-solar-icon name="verified-check" size="20" class="text-green-500" />
                        <span class="text-sm font-medium text-zinc-700">GBCSA</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 bg-zinc-50 rounded">
                        <x-solar-icon name="verified-check" size="20" class="text-green-500" />
                        <span class="text-sm font-medium text-zinc-700">SAIOH</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 bg-zinc-50 rounded">
                        <x-solar-icon name="verified-check" size="20" class="text-green-500" />
                        <span class="text-sm font-medium text-zinc-700">IAIAsa</span>
                    </div>
                @endif
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('accreditations') }}" class="text-green-600 hover:text-green-700 font-semibold inline-flex items-center gap-2">
                    View All Accreditations
                    <x-solar-icon name="alt-arrow-right" size="16" />
                </a>
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

            @php
                $sectorImages = [
                    'mining' => 'sectors/mining-site.jpg',
                    'industrial' => 'sectors/industrial-site.jpg',
                    'infrastructure' => 'sectors/infrastructure-site.jpg',
                    'rail' => 'sectors/rail-site.jpg',
                    'energy' => 'sectors/energy-site.jpg',
                    'municipal' => 'sectors/municipal-site.jpg',
                    'healthcare' => 'sectors/healthcare-site.jpg',
                    'property' => 'sectors/property-site.jpg',
                ];
            @endphp

            @if($this->sectors->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($this->sectors as $sector)
                        <a href="{{ route('sectors.show', $sector) }}"
                           class="group relative aspect-square overflow-hidden rounded-lg bg-zinc-200">
                            @php
                                $sectorSlug = Str::slug($sector->name);
                                $imagePath = $sectorImages[$sectorSlug] ?? null;
                            @endphp

                            @if($imagePath && file_exists(public_path('images/' . $imagePath)))
                                <img src="{{ asset('images/' . $imagePath) }}"
                                     alt="{{ $sector->name }}"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @elseif($sector->image_path && file_exists(public_path('storage/' . $sector->image_path)))
                                <img src="{{ asset('storage/' . $sector->image_path) }}"
                                     alt="{{ $sector->name }}"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-zinc-900/90 via-zinc-900/40 to-transparent"></div>

                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h3 class="text-lg font-bold text-white">{{ $sector->name }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <!-- Fallback sectors grid -->
                @php
                    $defaultSectors = [
                        ['name' => 'Mining & Resources', 'icon' => 'mining'],
                        ['name' => 'Industrial & Manufacturing', 'icon' => 'factory'],
                        ['name' => 'Infrastructure & Transport', 'icon' => 'road'],
                        ['name' => 'Rail & Logistics', 'icon' => 'train'],
                        ['name' => 'Renewable Energy', 'icon' => 'bolt'],
                        ['name' => 'Municipal & Government', 'icon' => 'buildings'],
                        ['name' => 'Healthcare & Medical Waste', 'icon' => 'hospital'],
                        ['name' => 'Property & Land Development', 'icon' => 'home'],
                    ];
                @endphp
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($defaultSectors as $sector)
                        <div class="group relative aspect-square overflow-hidden rounded-lg bg-zinc-800 flex items-center justify-center">
                            <div class="text-center p-4">
                                <x-solar-icon name="{{ $sector['icon'] }}" size="48" class="text-green-500 mx-auto mb-3" />
                                <h3 class="text-lg font-bold text-white">{{ $sector['name'] }}</h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="text-center mt-12">
                <a href="{{ route('sectors.index') }}"
                   class="inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                    <span>Explore All Sectors</span>
                    <x-solar-icon name="alt-arrow-right" size="24" />
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Projects -->
    @if($this->featuredProjects->count() > 0)
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-black text-zinc-950 mb-4">
                        Featured Projects
                    </h2>
                    <p class="text-xl text-zinc-500 max-w-3xl mx-auto">
                        Recent environmental projects showcasing our expertise
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($this->featuredProjects as $project)
                        <a href="{{ route('projects.show', $project) }}"
                           class="group bg-zinc-50 rounded-lg overflow-hidden hover:shadow-xl transition-all">
                            <div class="aspect-video bg-zinc-200 relative overflow-hidden">
                                @if($project->featured_image && file_exists(public_path('storage/' . $project->featured_image)))
                                    <img src="{{ asset('storage/' . $project->featured_image) }}"
                                         alt="{{ $project->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <x-solar-icon name="folder" size="48" class="text-zinc-400" />
                                    </div>
                                @endif

                                @if($project->sector)
                                    <div class="absolute top-4 left-4 px-3 py-1 bg-green-500 text-zinc-950 text-sm font-semibold rounded">
                                        {{ $project->sector->name }}
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <h3 class="text-xl font-bold text-zinc-950 mb-2 group-hover:text-green-600 transition-colors">
                                    {{ $project->title }}
                                </h3>
                                <p class="text-zinc-500 text-sm mb-4">
                                    {{ Str::limit($project->description, 100) }}
                                </p>
                                <div class="flex items-center gap-2 text-green-600 font-semibold">
                                    <span>View Project</span>
                                    <x-solar-icon name="alt-arrow-right" size="16" class="group-hover:translate-x-1 transition-transform" />
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('projects.index') }}"
                       class="inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-white bg-zinc-900 hover:bg-zinc-800 transition-all">
                        <span>View All Projects</span>
                        <x-solar-icon name="alt-arrow-right" size="24" />
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Training & Events -->
    <section class="py-24 bg-zinc-900 text-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="mb-8 border-l-4 border-green-500 pl-6">
                        <h2 class="text-4xl md:text-5xl font-black mb-4">
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

                    <a href="tel:0119696184"
                       class="inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-white hover:bg-zinc-100 transition-all">
                        <x-solar-icon name="phone-calling" size="24" />
                        <span>011 969 6184</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
