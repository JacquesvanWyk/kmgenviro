<?php

use function Livewire\Volt\{layout, rules, state, title};
use App\Models\ContactSubmission;

layout('components.layouts.public');
title('Contact Us | KMG Environmental Solutions');

state([
    'name' => '',
    'email' => '',
    'phone' => '',
    'company' => '',
    'type' => 'general_inquiry',
    'subject' => '',
    'message' => '',
]);

rules([
    'name' => 'required|string|max:255',
    'email' => 'required|email|max:255',
    'phone' => 'required|string|max:20',
    'company' => 'nullable|string|max:255',
    'type' => 'required|in:general_inquiry,service_inquiry,training_inquiry,equipment_inquiry,quote_request',
    'subject' => 'required|string|max:255',
    'message' => 'required|string|max:2000',
]);

$submit = function() {
    $validated = $this->validate();

    ContactSubmission::create([
        ...$validated,
        'status' => 'new',
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);

    session()->flash('success', 'Thank you for contacting us! We will respond within 24 hours.');

    $this->reset(['name', 'email', 'phone', 'company', 'type', 'subject', 'message']);
};

?>

<div>
    <x-public.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Contact']
    ]" />

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <h1 class="text-5xl font-bold mb-6 text-gray-900">Contact Us</h1>
                    <p class="text-xl text-gray-600 mb-8">
                        Get in touch with our team of environmental consultancy experts.
                        We're here to help with your environmental compliance and sustainability needs.
                    </p>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Office Location</h3>
                                <p class="text-gray-600">
                                    Johannesburg, South Africa
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Phone</h3>
                                <p class="text-gray-600">
                                    <a href="tel:+27XXXXXXXXX" class="hover:text-green-600">+27 XX XXX XXXX</a>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
                                <p class="text-gray-600">
                                    <a href="mailto:info@kmgenviro.co.za" class="hover:text-green-600">info@kmgenviro.co.za</a>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Business Hours</h3>
                                <p class="text-gray-600">
                                    Monday - Friday: 8:00 AM - 5:00 PM<br>
                                    Saturday - Sunday: Closed
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold mb-6 text-gray-900">Send us a Message</h2>

                        @if(session('success'))
                            <div class="mb-6 bg-green-50 border-l-4 border-green-600 p-4 rounded">
                                <p class="text-green-800">{{ session('success') }}</p>
                            </div>
                        @endif

                        <form wire:submit="submit" class="space-y-6">
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
                                <flux:field label="Inquiry Type" required>
                                    <flux:select wire:model="type">
                                        <option value="general_inquiry">General Inquiry</option>
                                        <option value="service_inquiry">Service Inquiry</option>
                                        <option value="training_inquiry">Training Inquiry</option>
                                        <option value="equipment_inquiry">Equipment Inquiry</option>
                                        <option value="quote_request">Quote Request</option>
                                    </flux:select>
                                    @error('type') <flux:error>{{ $message }}</flux:error> @enderror
                                </flux:field>
                            </div>

                            <div>
                                <flux:field label="Subject" required>
                                    <flux:input type="text" wire:model="subject" />
                                    @error('subject') <flux:error>{{ $message }}</flux:error> @enderror
                                </flux:field>
                            </div>

                            <div>
                                <flux:field label="Message" required>
                                    <flux:textarea wire:model="message" rows="5" />
                                    @error('message') <flux:error>{{ $message }}</flux:error> @enderror
                                </flux:field>
                            </div>

                            <div>
                                <flux:button type="submit" variant="primary" class="w-full">
                                    Send Message
                                </flux:button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
