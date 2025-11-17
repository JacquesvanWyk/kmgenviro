<?php use function Livewire\Volt\{state}; state(['equipment']); ?>
<x-layouts.public :title="$equipment->name . ' | Equipment | KMG'">
    <x-public.breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Equipment', 'url' => route('equipment.index')], ['label' => $equipment->name]]" />
    <section class="py-16"><div class="max-w-4xl mx-auto px-4"><h1 class="text-5xl font-bold mb-6">{{ $equipment->name }}</h1><p class="text-xl text-gray-600">Coming soon...</p></div></section>
</x-layouts.public>
