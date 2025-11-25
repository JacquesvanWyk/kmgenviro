<?php

use function Livewire\Volt\{layout, title};

layout('components.layouts.public');
title('Gallery | KMG Environmental Solutions');

?>

<div
    x-data="{
        open: false,
        currentIndex: 0,
        currentCategory: 'all',
        allImages: [
            { src: 'gallery/team-monitoring-mountains.jpg', alt: 'Team monitoring in mountain landscape', category: 'fieldwork' },
            { src: 'gallery/water-sampling-river.jpg', alt: 'Water quality sampling in river', category: 'fieldwork' },
            { src: 'gallery/monitoring-coal-mine.jpg', alt: 'Environmental monitoring at coal mine', category: 'fieldwork' },
            { src: 'gallery/team-fieldwork.jpg', alt: 'Team conducting fieldwork', category: 'fieldwork' },
            { src: 'gallery/team-monitoring-data.jpg', alt: 'Team recording monitoring data', category: 'fieldwork' },
            { src: 'gallery/team-soil-sampling.jpg', alt: 'Soil sampling in the field', category: 'fieldwork' },
            { src: 'services/water-monitoring.jpg', alt: 'Water quality monitoring', category: 'services' },
            { src: 'services/water-infrastructure.jpg', alt: 'Water infrastructure sampling', category: 'services' },
            { src: 'services/water-samples-labeled.jpg', alt: 'Labeled water samples', category: 'services' },
            { src: 'services/soil-sampling.jpg', alt: 'Soil sampling process', category: 'services' },
            { src: 'services/soil-sampling-red.jpg', alt: 'Red soil sampling', category: 'services' },
            { src: 'services/soil-sampling-closeup.jpg', alt: 'Soil sampling closeup', category: 'services' },
            { src: 'services/air-monitoring.jpg', alt: 'Air quality monitoring equipment', category: 'services' },
            { src: 'services/noise-monitoring.jpg', alt: 'Noise monitoring assessment', category: 'services' },
            { src: 'services/environmental-monitoring.jpg', alt: 'Environmental monitoring station', category: 'services' },
            { src: 'equipment/weather-station.jpg', alt: 'Weather monitoring station', category: 'equipment' },
            { src: 'equipment/air-quality-monitor.jpg', alt: 'Air quality monitor', category: 'equipment' },
            { src: 'equipment/air-quality-station.jpg', alt: 'Safewill air quality station', category: 'equipment' },
            { src: 'equipment/air-monitor-construction.jpg', alt: 'Air monitor at construction site', category: 'equipment' },
            { src: 'equipment/noise-meter.jpg', alt: 'Noise level meter', category: 'equipment' },
            { src: 'equipment/noise-meter-indoor.jpg', alt: 'Indoor noise monitoring equipment', category: 'equipment' },
            { src: 'sectors/mining.jpg', alt: 'Mining sector environmental work', category: 'sectors' },
            { src: 'sectors/industrial-manufacturing.jpg', alt: 'Industrial manufacturing site', category: 'sectors' },
            { src: 'sectors/infrastructure-construction.jpg', alt: 'Infrastructure construction project', category: 'sectors' },
            { src: 'sectors/rail-infrastructure.jpg', alt: 'Rail infrastructure monitoring', category: 'sectors' },
            { src: 'projects/lesotho-highlands/featured.jpg', alt: 'Lesotho Highlands project', category: 'projects' },
            { src: 'projects/lesotho-highlands/dam-wildlife.jpg', alt: 'Dam with wildlife', category: 'projects' },
            { src: 'projects/lesotho-highlands/team-monitoring.jpg', alt: 'Team monitoring at project site', category: 'projects' },
            { src: 'about/kmg-vehicle-car.jpg', alt: 'KMG branded vehicle', category: 'about' },
            { src: 'about/kmg-vehicle-bakkie.jpg', alt: 'KMG field bakkie', category: 'about' },
            { src: 'about/kmg-bakkie-grey.jpg', alt: 'KMG grey bakkie', category: 'about' },
            { src: 'about/kmg-vehicle-waste.jpg', alt: 'KMG waste management vehicle', category: 'about' },
        ],
        get filteredImages() {
            if (this.currentCategory === 'all') return this.allImages;
            return this.allImages.filter(img => img.category === this.currentCategory);
        },
        openLightbox(index) {
            this.currentIndex = index;
            this.open = true;
            document.body.style.overflow = 'hidden';
        },
        closeLightbox() {
            this.open = false;
            document.body.style.overflow = '';
        },
        next() {
            this.currentIndex = (this.currentIndex + 1) % this.filteredImages.length;
        },
        prev() {
            this.currentIndex = (this.currentIndex - 1 + this.filteredImages.length) % this.filteredImages.length;
        }
    }"
    @keydown.escape.window="closeLightbox()"
    @keydown.arrow-right.window="if(open) next()"
    @keydown.arrow-left.window="if(open) prev()"
>
    <x-public.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Gallery']
    ]" />

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-5xl font-bold mb-6 text-gray-900">Photo Gallery</h1>
            <p class="text-xl text-gray-600 mb-12 max-w-3xl">
                Explore our work across South Africa and the SADC region. From environmental monitoring
                to specialist studies, see our team in action.
            </p>

            <!-- Category Filter -->
            <div class="flex flex-wrap gap-3 mb-10">
                <button
                    @click="currentCategory = 'all'"
                    :class="currentCategory === 'all' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                    class="px-4 py-2 rounded-full font-medium transition"
                >
                    All Photos
                </button>
                <button
                    @click="currentCategory = 'fieldwork'"
                    :class="currentCategory === 'fieldwork' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                    class="px-4 py-2 rounded-full font-medium transition"
                >
                    Fieldwork
                </button>
                <button
                    @click="currentCategory = 'services'"
                    :class="currentCategory === 'services' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                    class="px-4 py-2 rounded-full font-medium transition"
                >
                    Services
                </button>
                <button
                    @click="currentCategory = 'equipment'"
                    :class="currentCategory === 'equipment' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                    class="px-4 py-2 rounded-full font-medium transition"
                >
                    Equipment
                </button>
                <button
                    @click="currentCategory = 'sectors'"
                    :class="currentCategory === 'sectors' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                    class="px-4 py-2 rounded-full font-medium transition"
                >
                    Sectors
                </button>
                <button
                    @click="currentCategory = 'projects'"
                    :class="currentCategory === 'projects' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                    class="px-4 py-2 rounded-full font-medium transition"
                >
                    Projects
                </button>
                <button
                    @click="currentCategory = 'about'"
                    :class="currentCategory === 'about' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                    class="px-4 py-2 rounded-full font-medium transition"
                >
                    Our Fleet
                </button>
            </div>

            <!-- Image Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <template x-for="(image, index) in filteredImages" :key="image.src">
                    <button
                        @click="openLightbox(index)"
                        class="group relative aspect-video overflow-hidden rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                    >
                        <img
                            :src="'/images/' + image.src"
                            :alt="image.alt"
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors flex items-center justify-center">
                            <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                            <p class="text-white text-sm" x-text="image.alt"></p>
                        </div>
                    </button>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="filteredImages.length === 0" class="text-center py-12 text-gray-500">
                No images found in this category.
            </div>
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/95"
        @click.self="closeLightbox()"
        style="display: none;"
    >
        <!-- Close Button -->
        <button
            @click="closeLightbox()"
            class="absolute top-4 right-4 text-white/70 hover:text-white p-2 transition z-10"
        >
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Previous Button -->
        <button
            @click="prev()"
            class="absolute left-4 text-white/70 hover:text-white p-2 transition z-10"
        >
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <!-- Image Container -->
        <div class="max-w-6xl max-h-[85vh] mx-4">
            <template x-for="(image, index) in filteredImages" :key="'lb-' + image.src">
                <img
                    x-show="currentIndex === index"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    :src="'/images/' + image.src"
                    :alt="image.alt"
                    class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl"
                >
            </template>
        </div>

        <!-- Next Button -->
        <button
            @click="next()"
            class="absolute right-4 text-white/70 hover:text-white p-2 transition z-10"
        >
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <!-- Image Counter & Caption -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 text-center">
            <p class="text-white mb-2" x-text="filteredImages[currentIndex]?.alt"></p>
            <p class="text-white/60 text-sm">
                <span x-text="currentIndex + 1"></span> / <span x-text="filteredImages.length"></span>
                <span class="mx-2">|</span>
                Use arrow keys to navigate, ESC to close
            </p>
        </div>
    </div>
</div>
