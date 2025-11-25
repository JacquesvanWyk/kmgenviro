<?php

use function Livewire\Volt\{computed, layout, title};
use App\Models\TrainingCourse;

layout('components.layouts.public');
title('Training Courses | Environmental Training | KMG');

$courses = computed(fn() =>
    TrainingCourse::where('is_active', true)
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get()
);

?>

<div>
    <x-public.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Training']
    ]" />

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-5xl font-bold mb-6 text-gray-900">Training Courses</h1>
            <p class="text-xl text-gray-600 mb-12 max-w-3xl">
                Enhance your team's environmental knowledge and compliance expertise with our
                accredited training courses. Led by industry experts with hands-on experience.
            </p>

            @if($this->courses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($this->courses as $course)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition h-full flex flex-col">
                            @if($course->thumbnail)
                                <div class="aspect-video bg-gray-200">
                                    <img src="{{ Storage::url($course->thumbnail) }}"
                                         alt="{{ $course->name }}"
                                         class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="aspect-video bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            @endif

                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="text-2xl font-bold mb-2 text-gray-900">{{ $course->name }}</h3>

                                @if($course->short_description)
                                    <p class="text-gray-600 mb-4 flex-grow line-clamp-3">
                                        {{ $course->short_description }}
                                    </p>
                                @endif

                                <div class="space-y-2 mb-6">
                                    @if($course->duration)
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span><strong>Duration:</strong> {{ $course->duration }}</span>
                                        </div>
                                    @endif

                                    @if($course->accreditation)
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                            </svg>
                                            <span><strong>Accredited:</strong> {{ $course->accreditation }}</span>
                                        </div>
                                    @endif

                                    @if($course->price)
                                        <div class="flex items-center gap-2 text-sm">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-xl font-bold text-green-600">R {{ number_format($course->price, 2) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-auto">
                                    <flux:button
                                        variant="primary"
                                        href="{{ route('training.show', $course->slug) }}"
                                        class="w-full">
                                        View Details & Book
                                    </flux:button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-600 text-lg">No training courses available at this time.</p>
                </div>
            @endif
        </div>
    </section>
</div>
