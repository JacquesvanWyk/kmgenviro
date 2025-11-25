<?php

use function Livewire\Volt\{computed, layout, state, title};
use App\Models\{Equipment, EquipmentCategory};

layout('components.layouts.public');
title('Equipment Rental | Environmental Equipment | KMG');

state(['categoryFilter' => '']);

$equipment = computed(fn() =>
    Equipment::where('is_available', true)
        ->with('equipmentCategory')
        ->when($this->categoryFilter, fn($q) => $q->where('equipment_category_id', $this->categoryFilter))
        ->orderBy('sort_order')
        ->orderBy('name')
        ->paginate(12)
);

$categories = computed(fn() =>
    EquipmentCategory::where('is_active', true)
        ->orderBy('name')
        ->get()
);

?>

<div>
    <x-public.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Equipment']
    ]" />

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-5xl font-bold mb-6 text-gray-900">Equipment Rental</h1>
            <p class="text-xl text-gray-600 mb-12 max-w-3xl">
                Rent high-quality environmental monitoring and testing equipment for your projects.
                Competitive rates with flexible rental periods.
            </p>

            @if($this->categories->count() > 1)
                <div class="mb-8">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Filter by Category</label>
                    <flux:select id="category" wire:model.live="categoryFilter" class="max-w-xs">
                        <option value="">All Categories</option>
                        @foreach($this->categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </flux:select>
                </div>
            @endif

            @if($this->equipment->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($this->equipment as $item)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition h-full flex flex-col">
                            @if($item->photo)
                                <div class="aspect-video bg-gray-200">
                                    <img src="{{ Storage::url($item->photo) }}"
                                         alt="{{ $item->name }}"
                                         class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="aspect-video bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                    </svg>
                                </div>
                            @endif

                            <div class="p-6 flex-grow flex flex-col">
                                <div class="mb-2">
                                    @if($item->equipmentCategory)
                                        <flux:badge>{{ $item->equipmentCategory->name }}</flux:badge>
                                    @endif
                                    @if($item->is_featured)
                                        <flux:badge color="amber">Featured</flux:badge>
                                    @endif
                                </div>

                                <h3 class="text-xl font-bold mb-2 text-gray-900">{{ $item->name }}</h3>

                                @if($item->description)
                                    <p class="text-gray-600 mb-4 flex-grow line-clamp-3">
                                        {{ Str::limit(strip_tags($item->description), 120) }}
                                    </p>
                                @endif

                                <div class="space-y-1 mb-4 text-sm">
                                    @if($item->daily_rate)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Daily Rate:</span>
                                            <span class="font-semibold text-green-600">R {{ number_format($item->daily_rate, 2) }}</span>
                                        </div>
                                    @endif
                                    @if($item->weekly_rate)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Weekly Rate:</span>
                                            <span class="font-semibold text-green-600">R {{ number_format($item->weekly_rate, 2) }}</span>
                                        </div>
                                    @endif
                                    @if($item->monthly_rate)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Monthly Rate:</span>
                                            <span class="font-semibold text-green-600">R {{ number_format($item->monthly_rate, 2) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-auto">
                                    <flux:button
                                        variant="primary"
                                        href="{{ route('equipment.show', $item->slug) }}"
                                        class="w-full">
                                        View Details & Request Quote
                                    </flux:button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($this->equipment->hasPages())
                    <div class="mt-12">
                        {{ $this->equipment->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <p class="text-gray-600 text-lg">No equipment available at this time.</p>
                </div>
            @endif
        </div>
    </section>
</div>
