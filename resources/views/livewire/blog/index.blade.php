<?php

use function Livewire\Volt\{computed, layout, title};
use App\Models\BlogPost;

layout('components.layouts.public');
title('Blog | Environmental Insights | KMG Environmental Solutions');

$posts = computed(fn() =>
    BlogPost::where('is_published', true)
        ->latest('published_at')
        ->paginate(9)
);

?>

<div class="bg-white">
    <!-- Hero Section -->
    <section class="relative py-24 bg-zinc-900 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-zinc-900/80 to-zinc-900/95"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4">
            <x-public.breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Blog']
            ]" class="mb-8" />

            <div class="max-w-4xl">
                <h1 class="text-5xl md:text-6xl font-black text-white mb-6">
                    Environmental <span class="text-green-500">Insights</span>
                </h1>
                <p class="text-xl text-zinc-300 leading-relaxed">
                    Stay informed with our latest insights on environmental consultancy,
                    compliance, sustainability, and industry developments.
                </p>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">

            @if($this->posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($this->posts as $post)
                        <x-public.blog-post-card :post="$post" />
                    @endforeach
                </div>

                @if($this->posts->hasPages())
                    <div class="mt-12">
                        {{ $this->posts->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <p class="text-gray-600 text-lg">No blog posts available at this time.</p>
                </div>
            @endif
        </div>
    </section>
</div>
