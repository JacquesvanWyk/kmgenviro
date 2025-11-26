<?php

use function Livewire\Volt\{computed, layout, state, title};
use App\Models\{Project, Sector};

layout('components.layouts.public');
title('Our Projects | Environmental Consultancy Portfolio | KMG');

state([
    'sectorFilter' => '',
    'provinceFilter' => '',
    'search' => '',
    'featuredOnly' => false,
]);

$projects = computed(fn() =>
    Project::where('is_active', true)
        ->with('sector')
        ->when($this->sectorFilter, fn($q) => $q->where('sector_id', $this->sectorFilter))
        ->when($this->provinceFilter, fn($q) => $q->where('province', $this->provinceFilter))
        ->when($this->featuredOnly, fn($q) => $q->where('is_featured', true))
        ->when($this->search, fn($q) => $q->where(function($query) {
            $query->where('title', 'like', "%{$this->search}%")
                  ->orWhere('client_name', 'like', "%{$this->search}%");
        }))
        ->latest('completion_date')
        ->paginate(9)
);

$sectors = computed(fn() =>
    Sector::where('is_active', true)
        ->orderBy('name')
        ->get()
);

$provinces = computed(fn() => [
    'Eastern Cape',
    'Free State',
    'Gauteng',
    'KwaZulu-Natal',
    'Limpopo',
    'Mpumalanga',
    'North West',
    'Northern Cape',
    'Western Cape',
]);

?>

<div class="bg-white">
    <!-- Hero Section -->
    <section class="relative py-24 bg-zinc-900 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-zinc-900/80 to-zinc-900/95"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4">
            <x-public.breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Projects']
            ]" class="mb-8" />

            <div class="max-w-4xl">
                <h1 class="text-5xl md:text-6xl font-black text-white mb-6">
                    Our <span class="text-green-500">Projects</span>
                </h1>
                <p class="text-xl text-zinc-300 leading-relaxed">
                    Explore our portfolio of successful environmental consultancy projects across South Africa.
                </p>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">

            <div class="bg-white rounded-lg shadow-md p-6 mb-12">
                <h2 class="text-lg font-semibold mb-4 text-gray-900">Filter Projects</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <flux:input
                            type="text"
                            id="search"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search projects..."
                        />
                    </div>

                    <div>
                        <label for="sector" class="block text-sm font-medium text-gray-700 mb-1">Sector</label>
                        <flux:select id="sector" wire:model.live="sectorFilter">
                            <option value="">All Sectors</option>
                            @foreach($this->sectors as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700 mb-1">Province</label>
                        <flux:select id="province" wire:model.live="provinceFilter">
                            <option value="">All Provinces</option>
                            @foreach($this->provinces as $province)
                                <option value="{{ $province }}">{{ $province }}</option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div class="flex items-end">
                        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                            <input type="checkbox" wire:model.live="featuredOnly" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span>Featured only</span>
                        </label>
                    </div>
                </div>
            </div>

            @if($this->projects->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($this->projects as $project)
                        <x-public.project-card :project="$project" />
                    @endforeach
                </div>

                @if($this->projects->hasPages())
                    <div class="mt-12">
                        {{ $this->projects->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <p class="text-gray-600 text-lg">No projects found matching your criteria.</p>
                </div>
            @endif
        </div>
    </section>
</div>
