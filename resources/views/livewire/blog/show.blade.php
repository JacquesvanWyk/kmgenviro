<?php

use function Livewire\Volt\{computed, layout, mount, state, title};
use App\Models\BlogPost;

state(['post' => null]);

mount(fn(BlogPost $post) => $this->post = $post);

layout('components.layouts.public');
title(fn() => ($this->post->meta_title ?? $this->post->title) . ' | KMG Blog');

$relatedPosts = computed(fn() =>
    BlogPost::where('is_published', true)
        ->where('id', '!=', $this->post->id)
        ->latest('published_at')
        ->limit(3)
        ->get()
);

?>

<div>
    <x-public.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Blog', 'url' => route('blog.index')],
        ['label' => $post->title]
    ]" />

    <article class="py-16">
        <div class="max-w-4xl mx-auto px-4">
            <header class="mb-8">
                <h1 class="text-5xl font-bold mb-6 text-gray-900">{{ $post->title }}</h1>

                <div class="flex items-center gap-4 text-gray-600">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>{{ $post->author }}</span>
                    </div>

                    <span>•</span>

                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <time datetime="{{ $post->published_at->toIso8601String() }}">
                            {{ $post->published_at->format('F j, Y') }}
                        </time>
                    </div>

                    @if($post->is_featured)
                        <flux:badge color="amber">Featured</flux:badge>
                    @endif
                </div>
            </header>

            @if($post->featured_image)
                <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ Storage::url($post->featured_image) }}"
                         alt="{{ $post->title }}"
                         class="w-full h-auto">
                </div>
            @endif

            @if($post->excerpt)
                <div class="bg-green-50 border-l-4 border-green-600 p-6 mb-8">
                    <p class="text-lg text-gray-700">{{ $post->excerpt }}</p>
                </div>
            @endif

            <div class="prose prose-lg max-w-none mb-12">
                {!! $post->content !!}
            </div>

            <footer class="border-t pt-8">
                <div class="flex gap-4">
                    <flux:button variant="primary" href="{{ route('contact') }}">
                        Contact Us for More Information
                    </flux:button>
                    <flux:button variant="ghost" href="{{ route('blog.index') }}">
                        Back to Blog
                    </flux:button>
                </div>
            </footer>
        </div>
    </article>

    @if($this->relatedPosts->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl font-bold mb-8 text-gray-900">Related Posts</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($this->relatedPosts as $relatedPost)
                        <x-public.blog-post-card :post="$relatedPost" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
