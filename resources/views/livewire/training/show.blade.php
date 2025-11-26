<?php

use function Livewire\Volt\{computed, layout, mount, rules, state, title};
use App\Models\{TrainingCourse, TrainingSchedule, TrainingBooking};

state(['course' => null, 'showBookingForm' => false, 'selectedScheduleId' => null]);

mount(fn(TrainingCourse $course) => $this->course = $course);

state([
    'name' => '',
    'email' => '',
    'phone' => '',
    'company' => '',
    'number_of_delegates' => 1,
    'special_requirements' => '',
]);

layout('components.layouts.public');
title(fn() => ($this->course->meta_title ?? $this->course->name) . ' | Training | KMG');

$upcomingSchedules = computed(fn() =>
    TrainingSchedule::where('training_course_id', $this->course->id)
        ->where('is_active', true)
        ->where('start_date', '>=', now())
        ->with('trainingBookings')
        ->orderBy('start_date')
        ->get()
);

rules([
    'name' => 'required|string|max:255',
    'email' => 'required|email|max:255',
    'phone' => 'required|string|max:20',
    'company' => 'nullable|string|max:255',
    'number_of_delegates' => 'required|integer|min:1|max:50',
    'special_requirements' => 'nullable|string|max:1000',
]);

$openBookingForm = function($scheduleId) {
    $this->selectedScheduleId = $scheduleId;
    $this->showBookingForm = true;
};

$closeBookingForm = function() {
    $this->showBookingForm = false;
    $this->selectedScheduleId = null;
    $this->reset(['name', 'email', 'phone', 'company', 'number_of_delegates', 'special_requirements']);
};

$submitBooking = function() {
    $validated = $this->validate();

    TrainingBooking::create([
        'training_course_id' => $this->course->id,
        'training_schedule_id' => $this->selectedScheduleId,
        'name' => $this->name,
        'email' => $this->email,
        'phone' => $this->phone,
        'company' => $this->company,
        'number_of_delegates' => $this->number_of_delegates,
        'special_requirements' => $this->special_requirements,
        'status' => 'pending',
    ]);

    session()->flash('success', 'Booking request submitted! We will contact you shortly to confirm your booking.');

    $this->closeBookingForm();
};

?>

<div>
    <!-- Hero Section -->
    <section class="relative py-24 bg-zinc-900 overflow-hidden">
        @if($course->thumbnail)
            <img src="{{ Storage::url($course->thumbnail) }}"
                 alt="{{ $course->name }}"
                 class="absolute inset-0 w-full h-full object-cover opacity-20">
        @endif
        <div class="absolute inset-0 bg-gradient-to-b from-zinc-900/80 to-zinc-900/95"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4">
            <x-public.breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Training', 'url' => route('training.index')],
                ['label' => $course->name]
            ]" class="mb-8" />

            <div class="max-w-4xl">
                <h1 class="text-4xl md:text-5xl font-black text-white mb-6">{{ $course->name }}</h1>

                <div class="flex flex-wrap gap-3">
                    @if($course->duration)
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur text-white rounded-full font-medium text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $course->duration }}
                        </span>
                    @endif

                    @if($course->accreditation)
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-500/20 backdrop-blur text-green-400 rounded-full font-medium text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                            {{ $course->accreditation }}
                        </span>
                    @endif

                    @if($course->price)
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500/20 backdrop-blur text-amber-400 rounded-full font-bold text-sm">
                            R {{ number_format($course->price, 2) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="max-w-5xl mx-auto px-4">
            @if(session('success'))
                <div class="mb-8 bg-green-50 border-l-4 border-green-600 p-4 rounded">
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            @if($course->short_description)
                <div class="bg-green-50 border-l-4 border-green-600 p-6 mb-8">
                    <p class="text-lg text-gray-700">{{ $course->short_description }}</p>
                </div>
            @endif

            @if($course->full_description)
                <div class="prose prose-lg max-w-none mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Course Overview</h2>
                    {!! $course->full_description !!}
                </div>
            @endif

            <div class="grid md:grid-cols-2 gap-8 mb-8">
                @if($course->target_audience)
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Target Audience</h3>
                        <div class="prose">
                            {!! $course->target_audience !!}
                        </div>
                    </div>
                @endif

                @if($course->prerequisites)
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Prerequisites</h3>
                        <div class="prose">
                            {!! $course->prerequisites !!}
                        </div>
                    </div>
                @endif
            </div>

            @if($course->course_outline)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Course Outline</h2>
                    <div class="prose prose-lg max-w-none">
                        {!! $course->course_outline !!}
                    </div>
                </div>
            @endif

            @if($this->upcomingSchedules->count() > 0)
                <div class="bg-gray-50 rounded-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Upcoming Schedules</h2>
                    <div class="space-y-4">
                        @foreach($this->upcomingSchedules as $schedule)
                            @php
                                $bookedSeats = $schedule->trainingBookings->sum('number_of_delegates');
                                $availableSeats = $schedule->available_seats ? $schedule->available_seats - $bookedSeats : null;
                                $seatColor = $availableSeats === null ? 'gray' : ($availableSeats > 5 ? 'green' : ($availableSeats > 0 ? 'amber' : 'red'));
                            @endphp

                            <div class="bg-white rounded-lg p-6 shadow flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex-grow">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="font-semibold text-gray-900">
                                            {{ $schedule->start_date->format('j M Y') }}
                                            @if($schedule->end_date && !$schedule->start_date->isSameDay($schedule->end_date))
                                                - {{ $schedule->end_date->format('j M Y') }}
                                            @endif
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2 text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        </svg>
                                        <span>{{ $schedule->is_online ? 'Online' : $schedule->location }}</span>
                                    </div>

                                    @if($availableSeats !== null)
                                        <div class="mt-2">
                                            <flux:badge :color="$seatColor">
                                                {{ $availableSeats > 0 ? "$availableSeats seats available" : 'Fully booked' }}
                                            </flux:badge>
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    @if($availableSeats === null || $availableSeats > 0)
                                        <flux:button
                                            variant="primary"
                                            wire:click="openBookingForm({{ $schedule->id }})">
                                            Book Now
                                        </flux:button>
                                    @else
                                        <flux:button variant="ghost" disabled>
                                            Fully Booked
                                        </flux:button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-blue-50 border-l-4 border-blue-600 p-6 mb-8">
                    <p class="text-blue-800">
                        No scheduled dates available at this time. Contact us to arrange a custom training session for your team.
                    </p>
                </div>
            @endif

            <div class="flex gap-4 pt-8 border-t">
                <flux:button variant="primary" href="{{ route('contact') }}">
                    Enquire About This Course
                </flux:button>
                <flux:button variant="ghost" href="{{ route('training.index') }}">
                    Back to All Courses
                </flux:button>
            </div>
        </div>
    </section>

    @if($showBookingForm)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50" wire:click.self="closeBookingForm">
            <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto p-8">
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Book This Course</h2>
                    <button wire:click="closeBookingForm" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form wire:submit="submitBooking" class="space-y-6">
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

                    <div>
                        <flux:field label="Number of Delegates" required>
                            <flux:input type="number" wire:model="number_of_delegates" min="1" />
                            @error('number_of_delegates') <flux:error>{{ $message }}</flux:error> @enderror
                        </flux:field>
                    </div>

                    <div>
                        <flux:field label="Special Requirements (Optional)">
                            <flux:textarea wire:model="special_requirements" rows="3" />
                        </flux:field>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <flux:button type="submit" variant="primary">Submit Booking Request</flux:button>
                        <flux:button type="button" variant="ghost" wire:click="closeBookingForm">Cancel</flux:button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
