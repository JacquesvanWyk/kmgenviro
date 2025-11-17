@props(['service'])

<div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition h-full flex flex-col">
    @if($service->icon)
        <div class="text-4xl mb-4">{{ $service->icon }}</div>
    @endif

    <h3 class="text-xl font-semibold mb-2 text-gray-900">{{ $service->name }}</h3>

    <p class="text-gray-600 mb-4 flex-grow">
        {{ Str::limit(strip_tags($service->description), 120) }}
    </p>

    <a href="{{ route('services.show', $service->slug) }}"
       class="text-green-600 hover:text-green-700 font-medium inline-flex items-center gap-1 transition">
        Learn More
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
</div>
