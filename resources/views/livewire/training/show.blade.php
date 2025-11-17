<?php use function Livewire\Volt\{state}; state(['course']); ?>
<x-layouts.public :title="$course->name . ' | Training | KMG'">
    <x-public.breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Training', 'url' => route('training.index')], ['label' => $course->name]]" />
    <section class="py-16"><div class="max-w-4xl mx-auto px-4"><h1 class="text-5xl font-bold mb-6">{{ $course->name }}</h1><p class="text-xl text-gray-600">Coming soon...</p></div></section>
</x-layouts.public>
