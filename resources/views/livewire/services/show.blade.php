<?php

use function Livewire\Volt\{computed, layout, mount, state, title};
use App\Models\Service;

state(['service' => null]);

mount(fn(Service $service) => $this->service = $service);

layout('components.layouts.public');
title(fn() => ($this->service->meta_title ?? $this->service->name) . ' | KMG Environmental Solutions');

$relatedServices = computed(fn() =>
    Service::where('is_active', true)
        ->where('service_category_id', $this->service->service_category_id)
        ->where('id', '!=', $this->service->id)
        ->orderBy('sort_order')
        ->limit(3)
        ->get()
);

?>

<div>
    <x-public.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Services', 'url' => route('services.index')],
        ['label' => $service->name]
    ]" />

    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4">
            <div class="flex items-start gap-4 mb-8">
                @if($service->icon)
                    <div class="text-5xl flex-shrink-0">{{ $service->icon }}</div>
                @endif
                <div class="flex-grow">
                    <h1 class="text-5xl font-bold mb-4 text-gray-900">{{ $service->name }}</h1>
                    @if($service->serviceCategory)
                        <p class="text-lg text-green-600 font-medium">{{ $service->serviceCategory->name }}</p>
                    @endif
                </div>
            </div>

            @if($service->short_description)
                <div class="bg-green-50 border-l-4 border-green-600 p-6 mb-8">
                    <p class="text-lg text-gray-700">{{ $service->short_description }}</p>
                </div>
            @endif

            @if($service->full_description)
                <div class="prose prose-lg max-w-none mb-12">
                    {!! $service->full_description !!}
                </div>
            @endif

            <div class="flex gap-4 mb-12">
                <flux:button variant="primary" href="{{ route('contact') }}">
                    Request a Quote
                </flux:button>
                <flux:button variant="ghost" href="{{ route('services.index') }}">
                    Back to All Services
                </flux:button>
            </div>

            @if($this->relatedServices->count() > 0)
                <div class="border-t pt-12">
                    <h2 class="text-3xl font-bold mb-8 text-gray-900">Related Services</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($this->relatedServices as $relatedService)
                            <x-public.service-card :service="$relatedService" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
