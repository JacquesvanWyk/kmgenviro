<?php

use function Livewire\Volt\{computed, layout, mount, rules, state, title};
use App\Models\{Equipment, EquipmentRentalQuote};

state(['equipment' => null]);

mount(fn(Equipment $equipment) => $this->equipment = $equipment);
state(['showQuoteForm' => false]);
state([
    'name' => '',
    'email' => '',
    'phone' => '',
    'company' => '',
    'rental_duration' => '',
    'start_date' => '',
    'location' => '',
    'delivery_required' => false,
    'message' => '',
]);

layout('components.layouts.public');
title(fn() => $this->equipment->name . ' | Equipment Rental | KMG');

rules([
    'name' => 'required|string|max:255',
    'email' => 'required|email|max:255',
    'phone' => 'required|string|max:20',
    'company' => 'nullable|string|max:255',
    'rental_duration' => 'required|string|max:100',
    'start_date' => 'required|date|after:today',
    'location' => 'required|string|max:255',
    'delivery_required' => 'boolean',
    'message' => 'nullable|string|max:1000',
]);

$openQuoteForm = function() {
    $this->showQuoteForm = true;
};

$closeQuoteForm = function() {
    $this->showQuoteForm = false;
    $this->reset(['name', 'email', 'phone', 'company', 'rental_duration', 'start_date', 'location', 'delivery_required', 'message']);
};

$submitQuote = function() {
    $validated = $this->validate();

    EquipmentRentalQuote::create([
        'equipment_id' => $this->equipment->id,
        'equipment_requested' => $this->equipment->name,
        'name' => $this->name,
        'email' => $this->email,
        'phone' => $this->phone,
        'company' => $this->company,
        'rental_duration' => $this->rental_duration,
        'start_date' => $this->start_date,
        'location' => $this->location,
        'delivery_required' => $this->delivery_required,
        'message' => $this->message,
        'status' => 'pending',
    ]);

    session()->flash('success', 'Quote request submitted! We will respond within 24 hours.');

    $this->closeQuoteForm();
};

?>

<div>
    <x-public.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Equipment', 'url' => route('equipment.index')],
        ['label' => $equipment->name]
    ]" />

    <section class="py-16">
        <div class="max-w-5xl mx-auto px-4">
            @if(session('success'))
                <div class="mb-8 bg-green-50 border-l-4 border-green-600 p-4 rounded">
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            <div class="mb-8">
                <div class="flex items-center gap-2 mb-4">
                    @if($equipment->equipmentCategory)
                        <flux:badge>{{ $equipment->equipmentCategory->name }}</flux:badge>
                    @endif
                    @if($equipment->is_featured)
                        <flux:badge color="amber">Featured</flux:badge>
                    @endif
                </div>

                <h1 class="text-5xl font-bold mb-4 text-gray-900">{{ $equipment->name }}</h1>
            </div>

            @if($equipment->photo)
                <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ Storage::url($equipment->photo) }}"
                         alt="{{ $equipment->name }}"
                         class="w-full h-auto">
                </div>
            @endif

            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <div class="md:col-span-2">
                    @if($equipment->description)
                        <div class="prose prose-lg max-w-none mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Equipment Description</h2>
                            {!! $equipment->description !!}
                        </div>
                    @endif

                    @if($equipment->specifications)
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Technical Specifications</h2>
                            <div class="prose max-w-none">
                                {!! $equipment->specifications !!}
                            </div>
                        </div>
                    @endif

                    @if($equipment->typical_uses)
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Typical Uses</h2>
                            <div class="prose max-w-none">
                                {!! $equipment->typical_uses !!}
                            </div>
                        </div>
                    @endif
                </div>

                <div class="md:col-span-1">
                    <div class="bg-white rounded-lg shadow-lg p-6 sticky top-4">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Rental Rates</h3>

                        <div class="space-y-3 mb-6">
                            @if($equipment->daily_rate)
                                <div class="flex justify-between items-center pb-2 border-b">
                                    <span class="text-gray-700">Daily Rate</span>
                                    <span class="text-xl font-bold text-green-600">R {{ number_format($equipment->daily_rate, 2) }}</span>
                                </div>
                            @endif

                            @if($equipment->weekly_rate)
                                <div class="flex justify-between items-center pb-2 border-b">
                                    <span class="text-gray-700">Weekly Rate</span>
                                    <span class="text-xl font-bold text-green-600">R {{ number_format($equipment->weekly_rate, 2) }}</span>
                                </div>
                            @endif

                            @if($equipment->monthly_rate)
                                <div class="flex justify-between items-center pb-2">
                                    <span class="text-gray-700">Monthly Rate</span>
                                    <span class="text-xl font-bold text-green-600">R {{ number_format($equipment->monthly_rate, 2) }}</span>
                                </div>
                            @endif
                        </div>

                        <flux:button variant="primary" wire:click="openQuoteForm" class="w-full mb-3">
                            Request Quote
                        </flux:button>

                        <p class="text-xs text-gray-500 text-center">
                            We'll respond within 24 hours
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-8 border-t">
                <flux:button variant="ghost" href="{{ route('equipment.index') }}">
                    Back to All Equipment
                </flux:button>
            </div>
        </div>
    </section>

    @if($showQuoteForm)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50" wire:click.self="closeQuoteForm">
            <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto p-8">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Request a Quote</h2>
                        <p class="text-gray-600 mt-1">{{ $equipment->name }}</p>
                    </div>
                    <button wire:click="closeQuoteForm" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form wire:submit="submitQuote" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <flux:field label="Name" required>
                                <flux:input type="text" wire:model="name" />
                                @error('name') <flux:error>{{ $message }}</flux:error> @enderror
                            </flux:field>
                        </div>

                        <div>
                            <flux:field label="Email" required>
                                <flux:input type="email" wire:model="email" />
                                @error('email') <flux:error>{{ $message }}</flux:error> @enderror
                            </flux:field>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <flux:field label="Phone" required>
                                <flux:input type="text" wire:model="phone" />
                                @error('phone') <flux:error>{{ $message }}</flux:error> @enderror
                            </flux:field>
                        </div>

                        <div>
                            <flux:field label="Company (Optional)">
                                <flux:input type="text" wire:model="company" />
                            </flux:field>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <flux:field label="Rental Duration" required>
                                <flux:input type="text" wire:model="rental_duration" placeholder="e.g., 1 week, 3 months" />
                                @error('rental_duration') <flux:error>{{ $message }}</flux:error> @enderror
                            </flux:field>
                        </div>

                        <div>
                            <flux:field label="Start Date" required>
                                <flux:input type="date" wire:model="start_date" />
                                @error('start_date') <flux:error>{{ $message }}</flux:error> @enderror
                            </flux:field>
                        </div>
                    </div>

                    <div>
                        <flux:field label="Location" required>
                            <flux:input type="text" wire:model="location" placeholder="Where will the equipment be used?" />
                            @error('location') <flux:error>{{ $message }}</flux:error> @enderror
                        </flux:field>
                    </div>

                    <div>
                        <label class="flex items-center gap-2 text-gray-700 cursor-pointer">
                            <input type="checkbox" wire:model="delivery_required" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span>Delivery required</span>
                        </label>
                    </div>

                    <div>
                        <flux:field label="Additional Message (Optional)">
                            <flux:textarea wire:model="message" rows="3" placeholder="Any additional information or requirements..." />
                        </flux:field>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <flux:button type="submit" variant="primary">Submit Quote Request</flux:button>
                        <flux:button type="button" variant="ghost" wire:click="closeQuoteForm">Cancel</flux:button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
