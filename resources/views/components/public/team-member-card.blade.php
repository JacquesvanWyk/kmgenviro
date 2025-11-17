@props(['member'])

<div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition h-full flex flex-col text-center">
    <div class="mb-4">
        @if($member->photo)
            <img src="{{ Storage::url($member->photo) }}"
                 alt="{{ $member->name }}"
                 class="w-32 h-32 rounded-full mx-auto object-cover">
        @else
            <div class="w-32 h-32 rounded-full mx-auto bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                <span class="text-4xl font-bold text-white">
                    {{ substr($member->name, 0, 1) }}
                </span>
            </div>
        @endif
    </div>

    <h3 class="text-xl font-semibold text-gray-900 mb-1">{{ $member->name }}</h3>

    <p class="text-green-600 font-medium mb-3">{{ $member->position }}</p>

    <p class="text-gray-600 text-sm mb-4 flex-grow line-clamp-3">
        {{ Str::limit($member->bio, 120) }}
    </p>

    @if($member->registrations && count($member->registrations) > 0)
        <div class="border-t pt-4 mt-auto">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                Professional Registrations
            </p>
            <div class="space-y-1">
                @foreach(array_slice($member->registrations, 0, 2) as $registration)
                    <p class="text-xs text-gray-600">
                        {{ $registration['organization'] }}: {{ $registration['number'] }}
                    </p>
                @endforeach
                @if(count($member->registrations) > 2)
                    <p class="text-xs text-green-600">
                        +{{ count($member->registrations) - 2 }} more
                    </p>
                @endif
            </div>
        </div>
    @endif

    @if($member->linkedin_url)
        <div class="mt-4">
            <a href="{{ $member->linkedin_url }}"
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center gap-1 text-sm text-gray-600 hover:text-green-600 transition">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
                LinkedIn
            </a>
        </div>
    @endif
</div>
