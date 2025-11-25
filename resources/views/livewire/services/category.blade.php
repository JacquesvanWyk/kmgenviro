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

<div class="bg-white">
    <!-- Hero Section -->
    <section class="relative py-24 bg-zinc-900 overflow-hidden">
        @php
            $categoryImages = [
                'environmental-monitoring' => 'environmental-monitoring.jpg',
                'water' => 'water-monitoring.jpg',
                'air' => 'air-monitoring.jpg',
                'noise' => 'noise-monitoring.jpg',
                'soil' => 'soil-sampling.jpg',
            ];
            $heroImage = null;
            foreach ($categoryImages as $key => $image) {
                if (Str::contains(Str::slug($category->name), $key)) {
                    $heroImage = $image;
                    break;
                }
            }
        @endphp

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
                    <h1 class="text-5xl md:text-6xl font-black text-white">
                        {{ $category->name }}
                    </h1>
                </div>

                @if($category->description)
                    <p class="text-xl text-zinc-300 leading-relaxed">
                        {{ $category->description }}
                    </p>
                @endif
            </div>
        </div>
    </section>

    <!-- Services List -->
    <section class="py-24">
        <div class="max-w-7xl mx-auto px-4">
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-zinc-950 mb-2">
                    Available Services
                </h2>
                <p class="text-zinc-500">
                    {{ $this->services->count() }} {{ Str::plural('service', $this->services->count()) }} in this category
                </p>
            </div>

            @if($this->services->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($this->services as $service)
                        <a href="{{ route('services.show', $service) }}"
                           class="group bg-zinc-50 rounded-lg overflow-hidden hover:shadow-xl transition-all border border-zinc-100 hover:border-green-500">
                            <!-- Service Image -->
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
                    <p class="text-zinc-500 mb-4">No services available in this category yet.</p>
                    <a href="{{ route('contact') }}" class="text-green-600 font-semibold hover:text-green-700">
                        Contact us for more information
                    </a>
                </div>
            @endif
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

    <!-- CTA Section -->
    <section class="py-16 bg-green-500">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <div>
                    <h2 class="text-3xl md:text-4xl font-black text-zinc-950 mb-2">
                        Need {{ $category->name }}?
                    </h2>
                    <p class="text-lg text-zinc-800">
                        Get a quote from our team of accredited specialists
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
