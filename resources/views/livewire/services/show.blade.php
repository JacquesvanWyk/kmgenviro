<?php use function Livewire\Volt\{state}; state(['service']); ?>
<x-layouts.public :title="$service->name . ' | KMG'">
    <x-public.breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Services', 'url' => route('services.index')], ['label' => $service->name]]" />
    <section class="py-16"><div class="max-w-4xl mx-auto px-4"><h1 class="text-5xl font-bold mb-6">{{ $service->name }}</h1><p class="text-xl text-gray-600">Coming soon...</p></div></section>
</x-layouts.public>
