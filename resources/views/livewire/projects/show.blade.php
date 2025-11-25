<?php

use function Livewire\Volt\{computed, layout, mount, state, title};
use App\Models\Project;

state(['project' => null]);

mount(fn(Project $project) => $this->project = $project);

layout('components.layouts.public');
title(fn() => ($this->project->meta_title ?? $this->project->title) . ' | KMG Projects');

$relatedProjects = computed(fn() =>
    Project::where('is_active', true)
        ->where('sector_id', $this->project->sector_id)
        ->where('id', '!=', $this->project->id)
        ->latest('completion_date')
        ->limit(3)
        ->get()
);

?>

<div>
    <x-public.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Projects', 'url' => route('projects.index')],
        ['label' => $project->title]
    ]" />

    <section class="py-16">
        <div class="max-w-5xl mx-auto px-4">
            <div class="mb-8">
                <h1 class="text-5xl font-bold mb-4 text-gray-900">{{ $project->title }}</h1>

                <div class="flex flex-wrap gap-4 text-sm">
                    @if($project->sector)
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 rounded-full font-medium">
                            @if($project->sector->icon)
                                <span>{{ $project->sector->icon }}</span>
                            @endif
                            {{ $project->sector->name }}
                        </span>
                    @endif

                    @if($project->province)
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $project->province }}
                        </span>
                    @endif

                    @if($project->completion_date)
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 text-gray-800 rounded-full font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Completed: {{ $project->completion_date->format('M Y') }}
                        </span>
                    @endif

                    @if($project->is_featured)
                        <flux:badge color="amber">Featured Project</flux:badge>
                    @endif
                </div>
            </div>

            @if($project->featured_image)
                <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ Storage::url($project->featured_image) }}"
                         alt="{{ $project->title }}"
                         class="w-full h-auto">
                </div>
            @endif

            @if($project->client_name)
                <div class="mb-6">
                    <p class="text-lg text-gray-600">
                        <span class="font-medium text-gray-900">Client:</span> {{ $project->client_name }}
                    </p>
                </div>
            @endif

            @if($project->short_description)
                <div class="bg-green-50 border-l-4 border-green-600 p-6 mb-8">
                    <p class="text-lg text-gray-700">{{ $project->short_description }}</p>
                </div>
            @endif

            @if($project->full_description)
                <div class="prose prose-lg max-w-none mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Project Overview</h2>
                    {!! $project->full_description !!}
                </div>
            @endif

            @if($project->services_provided)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Services Provided</h2>
                    <div class="prose prose-lg max-w-none">
                        {!! $project->services_provided !!}
                    </div>
                </div>
            @endif

            @if($project->outcomes)
                <div class="mb-8 bg-gray-50 rounded-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Project Outcomes</h2>
                    <div class="prose prose-lg max-w-none">
                        {!! $project->outcomes !!}
                    </div>
                </div>
            @endif

            <div class="flex gap-4 mb-12 pt-8 border-t">
                <flux:button variant="primary" href="{{ route('contact') }}">
                    Discuss Your Project
                </flux:button>
                <flux:button variant="ghost" href="{{ route('projects.index') }}">
                    Back to All Projects
                </flux:button>
            </div>

            @if($this->relatedProjects->count() > 0)
                <div class="border-t pt-12">
                    <h2 class="text-3xl font-bold mb-8 text-gray-900">Related Projects</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($this->relatedProjects as $relatedProject)
                            <x-public.project-card :project="$relatedProject" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
