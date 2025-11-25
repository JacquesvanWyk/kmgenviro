<?php

use function Livewire\Volt\{computed, layout, state, title};
use App\Models\Resource;

layout('components.layouts.public');
title('Resources & Downloads | KMG Environmental Solutions');

state(['categoryFilter' => '']);

$resources = computed(fn() =>
    Resource::where('is_active', true)
        ->when($this->categoryFilter, fn($q) => $q->where('category', $this->categoryFilter))
        ->orderBy('sort_order')
        ->orderBy('title')
        ->get()
);

$categories = computed(fn() =>
    Resource::where('is_active', true)
        ->distinct()
        ->pluck('category')
        ->filter()
        ->sort()
        ->values()
);

$incrementDownload = function($resourceId) {
    $resource = Resource::find($resourceId);
    if ($resource) {
        $resource->increment('download_count');
    }
};

?>

<div>
    <x-public.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Resources']
    ]" />

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-5xl font-bold mb-6 text-gray-900">Resources & Downloads</h1>
            <p class="text-xl text-gray-600 mb-12 max-w-3xl">
                Download helpful guides, reports, brochures, and templates related to
                environmental compliance and sustainability.
            </p>

            @if($this->categories->count() > 1)
                <div class="mb-8">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Filter by Category</label>
                    <flux:select id="category" wire:model.live="categoryFilter" class="max-w-xs">
                        <option value="">All Categories</option>
                        @foreach($this->categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </flux:select>
                </div>
            @endif

            @if($this->resources->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($this->resources as $resource)
                        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    @php
                                        $fileExt = strtolower(pathinfo($resource->file, PATHINFO_EXTENSION));
                                        $icon = match($fileExt) {
                                            'pdf' => '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>',
                                            'doc', 'docx' => '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
                                            'xls', 'xlsx' => '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>',
                                            default => '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>',
                                        };
                                    @endphp
                                    {!! $icon !!}
                                </div>

                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 mb-1">{{ $resource->title }}</h3>
                                    @if($resource->category)
                                        <flux:badge>{{ $resource->category }}</flux:badge>
                                    @endif
                                </div>
                            </div>

                            @if($resource->description)
                                <p class="text-gray-600 text-sm mb-4">{{ $resource->description }}</p>
                            @endif

                            <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                                @if($resource->file_type)
                                    <span class="uppercase">{{ $resource->file_type }}</span>
                                @endif
                                @if($resource->file_size)
                                    <span>{{ $resource->file_size }}</span>
                                @endif
                                @if($resource->download_count)
                                    <span>{{ $resource->download_count }} {{ Str::plural('download', $resource->download_count) }}</span>
                                @endif
                            </div>

                            <a href="{{ Storage::url($resource->file) }}"
                               download
                               wire:click="incrementDownload({{ $resource->id }})"
                               target="_blank"
                               class="flex items-center justify-center gap-2 w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                <span>Download</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-600 text-lg">No resources available at this time.</p>
                </div>
            @endif
        </div>
    </section>
</div>
