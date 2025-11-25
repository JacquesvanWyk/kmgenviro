@props(['project'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition h-full flex flex-col">
    @if($project->featured_image)
        <div class="aspect-video bg-gray-200">
            <img src="{{ Storage::url($project->featured_image) }}"
                 alt="{{ $project->title }}"
                 class="w-full h-full object-cover">
        </div>
    @else
        <div class="aspect-video bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center">
            <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
        </div>
    @endif

    <div class="p-6 flex-grow flex flex-col">
        <h3 class="text-xl font-semibold mb-2 text-gray-900">{{ $project->title }}</h3>

        <div class="flex flex-wrap gap-2 mb-3">
            @if($project->sector)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    {{ $project->sector->name }}
                </span>
            @endif
            @if($project->province)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    {{ $project->province }}
                </span>
            @endif
        </div>

        @if($project->completion_date)
            <p class="text-sm text-gray-500 mb-4">
                Completed: {{ $project->completion_date->format('F Y') }}
            </p>
        @endif

        <div class="mt-auto">
            <a href="{{ route('projects.show', $project->slug) }}"
               class="text-green-600 hover:text-green-700 font-medium inline-flex items-center gap-1 transition">
                View Details
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>
