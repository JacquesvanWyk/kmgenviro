<?php

use function Livewire\Volt\{computed};
use App\Models\{ServiceCategory, Project, ClientLogo, BlogPost, TeamMember, Accreditation};

$serviceCategories = computed(fn() =>
    ServiceCategory::where('active', true)
        ->orderBy('display_order')
        ->limit(6)
        ->get()
);

$featuredProjects = computed(fn() =>
    Project::where('featured', true)
        ->latest('completion_date')
        ->limit(3)
        ->get()
);

$clientLogos = computed(fn() =>
    ClientLogo::where('active', true)
        ->orderBy('display_order')
        ->get()
);

$latestPosts = computed(fn() =>
    BlogPost::where('published', true)
        ->latest('published_at')
        ->limit(3)
        ->get()
);

$teamCount = computed(fn() => TeamMember::where('active', true)->count());
$accreditationCount = computed(fn() => Accreditation::where('active', true)->count());
$projectCount = computed(fn() => Project::count());

?>

<x-layouts.public title="KMG Environmental Solutions | Environmental Consultancy South Africa">
    <!-- Hero Section -->
    <section class="relative h-screen min-h-[600px] flex items-center justify-center bg-cover bg-center"
             style="background-image: url('{{ asset('images/hero-bg.jpg') }}')">
        <div class="absolute inset-0 bg-gradient-to-r from-green-900/80 to-green-700/80"></div>
        <div class="relative z-10 max-w-4xl mx-auto px-4 text-center text-white">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">
                Environmental Solutions for Sustainable Growth
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-gray-100">
                Leading environmental consultancy providing expert solutions across South Africa
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('services.index') }}"
                   class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-green-600 hover:bg-green-700 rounded-lg transition">
                    Our Services
                </a>
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-green-600 bg-white hover:bg-gray-100 rounded-lg transition">
                    Get a Quote
                </a>
            </div>
        </div>
    </section>

    <!-- Services Overview -->
    @if($this->serviceCategories->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-4xl font-bold text-center mb-12">Our Services</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                    @foreach($this->serviceCategories as $category)
                        <x-public.service-card :service="$category" />
                    @endforeach
                </div>
                <div class="text-center">
                    <a href="{{ route('services.index') }}"
                       class="text-green-600 hover:text-green-700 font-semibold text-lg inline-flex items-center gap-1">
                        View All Services
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Why Choose KMG -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">Why Choose KMG</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-5xl mb-4">👥</div>
                    <h3 class="text-2xl font-semibold mb-2">Expert Team</h3>
                    <p class="text-gray-600">{{ $this->teamCount }}+ environmental professionals</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl mb-4">🏆</div>
                    <h3 class="text-2xl font-semibold mb-2">Accredited & Certified</h3>
                    <p class="text-gray-600">{{ $this->accreditationCount }}+ industry accreditations</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl mb-4">📊</div>
                    <h3 class="text-2xl font-semibold mb-2">Proven Track Record</h3>
                    <p class="text-gray-600">{{ $this->projectCount }}+ successful projects</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Projects -->
    @if($this->featuredProjects->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-4xl font-bold text-center mb-12">Featured Projects</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    @foreach($this->featuredProjects as $project)
                        <x-public.project-card :project="$project" />
                    @endforeach
                </div>
                <div class="text-center">
                    <a href="{{ route('projects.index') }}"
                       class="text-green-600 hover:text-green-700 font-semibold text-lg inline-flex items-center gap-1">
                        View All Projects
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Client Logos -->
    @if($this->clientLogos->count() > 0)
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-4xl font-bold text-center mb-12">Trusted by Leading Organizations</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 items-center">
                    @foreach($this->clientLogos as $logo)
                        <div class="flex items-center justify-center grayscale hover:grayscale-0 transition">
                            <img src="{{ Storage::url($logo->logo) }}"
                                 alt="{{ $logo->name }}"
                                 class="max-h-20 w-auto">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Latest Blog Posts -->
    @if($this->latestPosts->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-4xl font-bold text-center mb-12">Latest Insights</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    @foreach($this->latestPosts as $post)
                        <x-public.blog-post-card :post="$post" />
                    @endforeach
                </div>
                <div class="text-center">
                    <a href="{{ route('blog.index') }}"
                       class="text-green-600 hover:text-green-700 font-semibold text-lg inline-flex items-center gap-1">
                        Read Our Blog
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Contact CTA -->
    <section class="py-16 bg-gradient-to-r from-green-700 to-green-600 text-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-6">Ready to Get Started?</h2>
            <p class="text-xl mb-8">
                Contact us today to discuss your environmental consultancy needs
            </p>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-green-600 bg-white hover:bg-gray-100 rounded-lg transition">
                Contact Us
            </a>
        </div>
    </section>
</x-layouts.public>
