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

<div>
    <x-public.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Blog']
    ]" />

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-5xl font-bold mb-6 text-gray-900">Blog</h1>
            <p class="text-xl text-gray-600 mb-12 max-w-3xl">
                Stay informed with our latest insights on environmental consultancy,
                compliance, sustainability, and industry developments.
            </p>

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
