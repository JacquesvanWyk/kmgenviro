<?php

use function Livewire\Volt\{state, layout};

state(['service']);

layout('components.layouts.public');

?>

<div>
    <x-public.breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Services', 'url' => route('services.index')], ['label' => $service->name]]" />
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-5xl font-bold mb-6">{{ $service->name }}</h1>
            <p class="text-xl text-gray-600">Coming soon...</p>
        </div>
    </section>
</div>
