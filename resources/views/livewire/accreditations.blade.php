<?php

use function Livewire\Volt\{computed, layout, state, title};
use App\Models\Accreditation;

layout('components.layouts.public');
title('Accreditations & Certifications | KMG Environmental Solutions');

state(['showOnlyValid' => true]);

$accreditations = computed(fn() =>
    Accreditation::where('is_active', true)
        ->when($this->showOnlyValid, fn($q) =>
            $q->where('valid_until', '>=', now())
        )
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get()
);

?>

<div>
    <x-public.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Accreditations']
    ]" />

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-5xl font-bold mb-6 text-gray-900">Accreditations & Certifications</h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl">
                KMG Environmental Solutions maintains the highest industry standards through
                our accreditations and certifications.
            </p>

            <div class="mb-8">
                <label class="flex items-center gap-2 text-gray-700 cursor-pointer">
                    <input type="checkbox"
                           wire:model.live="showOnlyValid"
                           class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <span>Show only valid accreditations</span>
                </label>
            </div>

            @if($this->accreditations->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($this->accreditations as $accreditation)
                        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                            @if($accreditation->logo)
                                <div class="flex items-center justify-center h-24 mb-4">
                                    <img src="{{ Storage::url($accreditation->logo) }}"
                                         alt="{{ $accreditation->name }}"
                                         class="max-h-full max-w-full object-contain">
                                </div>
                            @endif

                            <h3 class="text-xl font-semibold mb-2 text-gray-900">
                                {{ $accreditation->name }}
                                @if($accreditation->acronym)
                                    <span class="text-gray-500">({{ $accreditation->acronym }})</span>
                                @endif
                            </h3>

                            @if($accreditation->description)
                                <p class="text-gray-600 mb-3 text-sm">{{ $accreditation->description }}</p>
                            @endif

                            @if($accreditation->certificate_number)
                                <p class="text-sm text-gray-500 mb-2">
                                    <span class="font-medium">Certificate No:</span> {{ $accreditation->certificate_number }}
                                </p>
                            @endif

                            @if($accreditation->valid_until)
                                <p class="text-sm text-gray-500 mb-3">
                                    <span class="font-medium">Valid until:</span> {{ $accreditation->valid_until->format('F Y') }}
                                </p>

                                @if($accreditation->valid_until >= now())
                                    <flux:badge color="green">Valid</flux:badge>
                                @else
                                    <flux:badge color="red">Expired</flux:badge>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-600 text-lg">
                        @if($this->showOnlyValid)
                            No valid accreditations available at this time.
                        @else
                            No accreditations available at this time.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </section>
</div>
