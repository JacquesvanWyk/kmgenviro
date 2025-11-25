@php
    $galleryImages = [
        ['src' => 'gallery/team-monitoring-mountains.jpg', 'alt' => 'Team monitoring in mountain landscape'],
        ['src' => 'gallery/water-sampling-river.jpg', 'alt' => 'Water quality sampling in river'],
        ['src' => 'gallery/monitoring-coal-mine.jpg', 'alt' => 'Environmental monitoring at coal mine'],
        ['src' => 'gallery/team-fieldwork.jpg', 'alt' => 'Team conducting fieldwork'],
        ['src' => 'gallery/team-monitoring-data.jpg', 'alt' => 'Team recording monitoring data'],
        ['src' => 'gallery/team-soil-sampling.jpg', 'alt' => 'Soil sampling in the field'],
        ['src' => 'services/water-monitoring.jpg', 'alt' => 'Water quality monitoring'],
        ['src' => 'services/soil-sampling.jpg', 'alt' => 'Soil sampling process'],
        ['src' => 'services/air-monitoring.jpg', 'alt' => 'Air quality monitoring equipment'],
        ['src' => 'services/noise-monitoring.jpg', 'alt' => 'Noise monitoring assessment'],
        ['src' => 'equipment/weather-station.jpg', 'alt' => 'Weather monitoring station'],
        ['src' => 'sectors/mining.jpg', 'alt' => 'Mining sector environmental work'],
    ];
@endphp

<section
    x-data="{
        open: false,
        currentIndex: 0,
        images: {{ Js::from($galleryImages) }},
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
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
        },
        prev() {
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
        }
    }"
    @keydown.escape.window="closeLightbox()"
    @keydown.arrow-right.window="if(open) next()"
    @keydown.arrow-left.window="if(open) prev()"
    class="py-12 bg-zinc-900"
>
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-white">Our Work in Action</h2>
            <a href="{{ route('gallery') }}" class="text-green-400 hover:text-green-300 font-medium inline-flex items-center gap-2 transition">
                View Full Gallery
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <!-- Scrollable Image Strip -->
        <div class="flex gap-4 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-hide">
            @foreach($galleryImages as $index => $image)
                <button
                    @click="openLightbox({{ $index }})"
                    class="flex-shrink-0 snap-start group relative overflow-hidden rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-zinc-900"
                >
                    <img
                        src="{{ asset('images/' . $image['src']) }}"
                        alt="{{ $image['alt'] }}"
                        class="w-48 h-32 object-cover transition-transform duration-300 group-hover:scale-110"
                        loading="lazy"
                    >
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                        <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                        </svg>
                    </div>
                </button>
            @endforeach
        </div>
    </div>

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
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <!-- Image Container -->
        <div class="max-w-5xl max-h-[80vh] mx-4">
            <template x-for="(image, index) in images" :key="index">
                <img
                    x-show="currentIndex === index"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    :src="'/images/' + image.src"
                    :alt="image.alt"
                    class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl"
                >
            </template>
        </div>

        <!-- Next Button -->
        <button
            @click="next()"
            class="absolute right-4 text-white/70 hover:text-white p-2 transition z-10"
        >
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <!-- Image Counter -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white/70 text-sm">
            <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
        </div>

        <!-- Caption -->
        <div class="absolute bottom-12 left-1/2 -translate-x-1/2 text-white text-center max-w-md">
            <p x-text="images[currentIndex]?.alt" class="text-sm"></p>
        </div>
    </div>
</section>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
