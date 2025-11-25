<?php

use function Livewire\Volt\{computed, layout, title};
use App\Models\ServiceCategory;

layout('components.layouts.public');
title('Our Services | Environmental Consultancy | KMG');

$categories = computed(fn() =>
    ServiceCategory::where('is_active', true)
        ->with(['services' => function($q) {
            $q->where('is_active', true)->orderBy('sort_order')->orderBy('name');
        }])
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get()
);

?>

<div>
    <x-public.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Services']
    ]" />

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-5xl font-bold mb-6 text-gray-900">Our Services</h1>
            <p class="text-xl text-gray-600 mb-12 max-w-3xl">
                KMG Environmental Solutions offers comprehensive environmental consultancy services
                to help businesses achieve sustainability and regulatory compliance.
            </p>

            @if($this->categories->count() > 0)
                <div class="space-y-12">
                    @foreach($this->categories as $category)
                        @php
                            $categoryImages = [
                                'environmental-monitoring' => 'environmental-monitoring.jpg',
                                'water-quality' => 'water-monitoring.jpg',
                                'air-quality' => 'air-monitoring.jpg',
                                'noise-monitoring' => 'noise-monitoring.jpg',
                                'soil' => 'soil-sampling.jpg',
                                'occupational-hygiene' => 'air-monitoring.jpg',
                            ];
                            $categoryImage = null;
                            foreach ($categoryImages as $key => $image) {
                                if (Str::contains(Str::slug($category->name), $key)) {
                                    $categoryImage = $image;
                                    break;
                                }
                            }
                        @endphp
                        <div class="bg-white rounded-lg shadow-md overflow-hidden" id="category-{{ $category->slug }}">
                            <div class="md:flex">
                                @if($categoryImage && file_exists(public_path("images/services/{$categoryImage}")))
                                    <div class="md:w-1/3 flex-shrink-0">
                                        <img src="{{ asset("images/services/{$categoryImage}") }}"
                                             alt="{{ $category->name }}"
                                             class="w-full h-48 md:h-full object-cover">
                                    </div>
                                @endif
                                <div class="p-8 {{ $categoryImage ? 'md:w-2/3' : 'w-full' }}">
                                    <div class="flex items-start gap-4 mb-6">
                                        @if($category->icon)
                                            <div class="text-4xl flex-shrink-0">{{ $category->icon }}</div>
                                        @endif
                                        <div class="flex-grow">
                                            <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $category->name }}</h2>
                                            @if($category->description)
                                                <p class="text-gray-600">{{ $category->description }}</p>
                                            @endif
                                        </div>
                                    </div>

                            @if($category->services->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                                    @foreach($category->services as $service)
                                        <x-public.service-card :service="$service" />
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-center py-4">No services available in this category yet.</p>
                            @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-600 text-lg">No services available at this time.</p>
                </div>
            @endif
        </div>
    </section>
</div>
