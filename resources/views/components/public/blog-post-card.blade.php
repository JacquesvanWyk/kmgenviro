@props(['post'])

<article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition h-full flex flex-col">
    @if($post->featured_image)
        <div class="aspect-video bg-gray-200">
            <img src="{{ str_starts_with($post->featured_image, '/') ? asset($post->featured_image) : Storage::url($post->featured_image) }}"
                 alt="{{ $post->title }}"
                 class="w-full h-full object-cover">
        </div>
    @else
        <div class="aspect-video bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center">
            <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
        </div>
    @endif

    <div class="p-6 flex-grow flex flex-col">
        <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
            <span>{{ $post->author }}</span>
            <span>•</span>
            <time>{{ $post->published_at->format('M j, Y') }}</time>
        </div>

        <h3 class="text-xl font-semibold mb-2 text-gray-900 line-clamp-2">
            {{ $post->title }}
        </h3>

        <p class="text-gray-600 mb-4 flex-grow line-clamp-3">
            {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}
        </p>

        <div class="mt-auto">
            <a href="{{ route('blog.show', $post->slug) }}"
               class="text-green-600 hover:text-green-700 font-medium inline-flex items-center gap-1 transition">
                Read More
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</article>
