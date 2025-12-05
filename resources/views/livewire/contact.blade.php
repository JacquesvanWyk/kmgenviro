<?php

use App\Models\ContactSubmission;
use App\Models\ServiceCategory;

use function Livewire\Volt\computed;
use function Livewire\Volt\layout;
use function Livewire\Volt\state;
use function Livewire\Volt\title;
use function Livewire\Volt\usesFileUploads;

layout('components.layouts.public');
title('Contact Us | KMG Environmental Solutions');

usesFileUploads();

state([
    'activeForm' => request()->query('form') === 'quote' ? 'quote' : 'general',
    // General form fields
    'name' => '',
    'email' => '',
    'phone' => '',
    'company' => '',
    'subject' => '',
    'message' => '',
    'referralSource' => '',
    // Quote form fields
    'quoteName' => '',
    'quoteEmail' => '',
    'quotePhone' => '',
    'quoteCompany' => '',
    'serviceType' => '',
    'projectName' => '',
    'projectLocation' => '',
    'projectSector' => '',
    'projectDescription' => '',
    'projectTimeline' => '',
    'attachments' => [],
    // Submission states
    'generalSubmitted' => false,
    'quoteSubmitted' => false,
]);

$categories = computed(fn () => ServiceCategory::where('is_active', true)
    ->orderBy('name')
    ->get()
);

$submitGeneral = function () {
    $this->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'company' => 'nullable|string|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:2000',
        'referralSource' => 'nullable|string|max:100',
    ]);

    ContactSubmission::create([
        'type' => 'general_inquiry',
        'name' => $this->name,
        'email' => $this->email,
        'phone' => $this->phone,
        'company' => $this->company,
        'subject' => $this->subject,
        'message' => $this->message,
        'notes' => $this->referralSource ? 'Heard about us via: '.$this->referralSource : null,
        'status' => 'new',
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);

    $this->generalSubmitted = true;
    $this->reset(['name', 'email', 'phone', 'company', 'subject', 'message', 'referralSource']);
};

$submitQuote = function () {
    $this->validate([
        'quoteName' => 'required|string|max:255',
        'quoteEmail' => 'required|email|max:255',
        'quotePhone' => 'required|string|max:20',
        'quoteCompany' => 'nullable|string|max:255',
        'serviceType' => 'required|string|max:255',
        'projectName' => 'required|string|max:255',
        'projectLocation' => 'required|string|max:255',
        'projectSector' => 'required|string|max:100',
        'projectDescription' => 'required|string|max:3000',
        'projectTimeline' => 'required|string|max:100',
        'attachments.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png',
    ]);

    // Handle file uploads
    $attachmentPaths = [];
    if ($this->attachments && count($this->attachments) > 0) {
        foreach ($this->attachments as $attachment) {
            $path = $attachment->store('quote-attachments', 'public');
            $attachmentPaths[] = $path;
        }
    }

    ContactSubmission::create([
        'type' => 'quote_request',
        'name' => $this->quoteName,
        'email' => $this->quoteEmail,
        'phone' => $this->quotePhone,
        'company' => $this->quoteCompany,
        'service_type' => $this->serviceType,
        'project_name' => $this->projectName,
        'location' => $this->projectLocation,
        'sector' => $this->projectSector,
        'message' => $this->projectDescription,
        'timeline' => $this->projectTimeline,
        'attachments' => ! empty($attachmentPaths) ? json_encode($attachmentPaths) : null,
        'status' => 'new',
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);

    $this->quoteSubmitted = true;
    $this->reset(['quoteName', 'quoteEmail', 'quotePhone', 'quoteCompany', 'serviceType', 'projectName', 'projectLocation', 'projectSector', 'projectDescription', 'projectTimeline', 'attachments']);
};

$resetForm = function ($form) {
    if ($form === 'general') {
        $this->generalSubmitted = false;
    } else {
        $this->quoteSubmitted = false;
    }
};

?>

<div class="bg-white">
    <!-- Hero Section -->
    <section class="relative py-24 bg-zinc-900 overflow-hidden">
        @if(file_exists(public_path('images/contact/hero.jpg')))
            <img src="{{ asset('images/contact/hero.jpg') }}"
                 alt="Contact KMG Environmental"
                 class="absolute inset-0 w-full h-full object-cover opacity-30">
        @endif
        <div class="absolute inset-0 bg-gradient-to-b from-zinc-900/80 to-zinc-900/95"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4">
            <x-public.breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Contact']
            ]" class="mb-8" />

            <div class="max-w-4xl">
                <h1 class="text-5xl md:text-6xl font-black text-white mb-6">
                    Contact <span class="text-green-500">Us</span>
                </h1>
                <p class="text-xl text-zinc-300 leading-relaxed">
                    Get in touch with our team of environmental consultancy experts. We're ready to assist with your environmental compliance, ESG, and sustainability needs.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Details & Map Section -->
    <section class="py-24">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Information -->
                <div>
                    <h2 class="text-3xl font-black text-zinc-950 mb-8">Get In Touch</h2>

                    <div class="space-y-6">
                        <!-- Office Address -->
                        <div class="flex items-start gap-4 p-6 bg-zinc-50 rounded-lg border border-zinc-100">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <x-solar-icon name="map-point" size="24" class="text-white" />
                            </div>
                            <div>
                                <h3 class="font-bold text-zinc-950 mb-1">Office Location</h3>
                                <p class="text-zinc-600">
                                    08 Hillside Road, Metropolitan Building,<br>
                                    1st Floor B, Parktown,<br>
                                    Johannesburg, 2193
                                </p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start gap-4 p-6 bg-zinc-50 rounded-lg border border-zinc-100">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <x-solar-icon name="phone-calling" size="24" class="text-white" />
                            </div>
                            <div>
                                <h3 class="font-bold text-zinc-950 mb-2">Phone</h3>
                                <div class="space-y-1">
                                    <a href="tel:0114804822" class="text-zinc-600 hover:text-green-600 transition-colors text-lg font-semibold block">
                                        011 480 4822 <span class="text-sm font-normal text-zinc-500">(Office)</span>
                                    </a>
                                    <a href="tel:0119696184" class="text-zinc-600 hover:text-green-600 transition-colors text-lg font-semibold block">
                                        011 969 6184 <span class="text-sm font-normal text-zinc-500">(Office)</span>
                                    </a>
                                    <a href="tel:0725463191" class="text-zinc-600 hover:text-green-600 transition-colors block">
                                        072 546 3191 <span class="text-sm text-zinc-500">(Cell)</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start gap-4 p-6 bg-zinc-50 rounded-lg border border-zinc-100">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <x-solar-icon name="letter" size="24" class="text-white" />
                            </div>
                            <div>
                                <h3 class="font-bold text-zinc-950 mb-2">Email</h3>
                                <div class="space-y-1">
                                    <a href="mailto:info@kmgenviro.co.za" class="text-zinc-600 hover:text-green-600 transition-colors block">
                                        info@kmgenviro.co.za <span class="text-sm text-zinc-500">(General)</span>
                                    </a>
                                    <a href="mailto:marabekg@kmgenviro.co.za" class="text-zinc-600 hover:text-green-600 transition-colors block">
                                        marabekg@kmgenviro.co.za <span class="text-sm text-zinc-500">(Direct / Rentals / Training)</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <div class="flex items-start gap-4 p-6 bg-zinc-50 rounded-lg border border-zinc-100">
                            <div class="w-12 h-12 bg-[#25D366] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-zinc-950 mb-1">WhatsApp</h3>
                                <a href="https://wa.me/+27725463191?text=Hi%20KMG%2C%20I%27d%20like%20to%20enquire%20about%20your%20services."
                                   target="_blank"
                                   class="text-zinc-600 hover:text-green-600 transition-colors">
                                    +27 72 546 3191
                                </a>
                            </div>
                        </div>

                        <!-- Business Hours -->
                        <div class="flex items-start gap-4 p-6 bg-zinc-50 rounded-lg border border-zinc-100">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <x-solar-icon name="clock-circle" size="24" class="text-white" />
                            </div>
                            <div>
                                <h3 class="font-bold text-zinc-950 mb-1">Business Hours</h3>
                                <p class="text-zinc-600">
                                    Monday - Friday: 8:00 AM - 5:00 PM<br>
                                    Saturday - Sunday: Closed
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Google Map -->
                <div>
                    <h2 class="text-3xl font-black text-zinc-950 mb-8">Find Us</h2>
                    <div class="bg-zinc-100 rounded-lg overflow-hidden h-[500px]">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3582.5!2d28.0445!3d-26.1752!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e950bf8a3d6e1a7%3A0x8c8a8f8a8f8a8f8a!2s8%20Hillside%20Rd%2C%20Parktown%2C%20Johannesburg%2C%202193!5e0!3m2!1sen!2sza!4v1700000000000!5m2!1sen!2sza"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="grayscale hover:grayscale-0 transition-all duration-500">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Forms Section -->
    <section class="py-24 bg-zinc-50">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-black text-zinc-950 mb-4">Send Us a Message</h2>
                <p class="text-lg text-zinc-600">
                    Choose the form that best fits your needs. We typically respond within 24 hours.
                </p>
            </div>

            <!-- Form Tabs -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Tab Navigation -->
                <div class="flex border-b border-zinc-200">
                    <button wire:click="$set('activeForm', 'general')"
                            class="flex-1 px-6 py-4 text-center font-semibold transition-colors {{ $activeForm === 'general' ? 'bg-green-500 text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200' }}">
                        <x-solar-icon name="chat-round-dots" size="20" class="inline mr-2" />
                        General Enquiry
                    </button>
                    <button wire:click="$set('activeForm', 'quote')"
                            class="flex-1 px-6 py-4 text-center font-semibold transition-colors {{ $activeForm === 'quote' ? 'bg-green-500 text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200' }}">
                        <x-solar-icon name="document-text" size="20" class="inline mr-2" />
                        Request a Quotation
                    </button>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <!-- General Enquiry Form -->
                    @if($activeForm === 'general')
                        @if($generalSubmitted)
                            <div class="text-center py-12">
                                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <x-solar-icon name="check-circle" size="48" class="text-green-500" />
                                </div>
                                <h3 class="text-2xl font-bold text-zinc-950 mb-4">Message Sent Successfully!</h3>
                                <p class="text-zinc-600 mb-8">Thank you for contacting us. We will respond within 24 hours.</p>
                                <button wire:click="resetForm('general')"
                                        class="px-6 py-3 bg-zinc-900 text-white font-semibold rounded-lg hover:bg-zinc-800 transition-colors">
                                    Send Another Message
                                </button>
                            </div>
                        @else
                            <form wire:submit="submitGeneral" class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Full Name *</label>
                                        <input type="text" wire:model="name"
                                               class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                               placeholder="Your full name">
                                        @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Email Address *</label>
                                        <input type="email" wire:model="email"
                                               class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                               placeholder="your@email.com">
                                        @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Phone Number *</label>
                                        <input type="tel" wire:model="phone"
                                               class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                               placeholder="011 000 0000">
                                        @error('phone') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Company</label>
                                        <input type="text" wire:model="company"
                                               class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                               placeholder="Your company name">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 mb-1">Subject *</label>
                                    <input type="text" wire:model="subject"
                                           class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                           placeholder="What is your enquiry about?">
                                    @error('subject') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 mb-1">Message *</label>
                                    <textarea wire:model="message" rows="5"
                                              class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors resize-none"
                                              placeholder="Tell us more about your enquiry..."></textarea>
                                    @error('message') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 mb-1">How did you hear about us?</label>
                                    <select wire:model="referralSource"
                                            class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                        <option value="">Select an option</option>
                                        <option value="google">Google Search</option>
                                        <option value="linkedin">LinkedIn</option>
                                        <option value="referral">Referral / Word of Mouth</option>
                                        <option value="industry_event">Industry Event / Conference</option>
                                        <option value="existing_client">Existing Client</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <button type="submit"
                                        class="w-full px-8 py-4 bg-green-500 text-zinc-950 font-bold text-lg hover:bg-green-400 transition-colors flex items-center justify-center gap-3"
                                        wire:loading.attr="disabled"
                                        wire:loading.class="opacity-75 cursor-not-allowed">
                                    <span wire:loading.remove>Send Message</span>
                                    <span wire:loading>Sending...</span>
                                    <x-solar-icon name="arrow-right" size="20" wire:loading.remove />
                                </button>
                            </form>
                        @endif
                    @endif

                    <!-- Request a Quotation Form -->
                    @if($activeForm === 'quote')
                        @if($quoteSubmitted)
                            <div class="text-center py-12">
                                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <x-solar-icon name="check-circle" size="48" class="text-green-500" />
                                </div>
                                <h3 class="text-2xl font-bold text-zinc-950 mb-4">Quote Request Submitted!</h3>
                                <p class="text-zinc-600 mb-8">Thank you for your request. Our team will review your project details and provide a quotation within 2-3 business days.</p>
                                <button wire:click="resetForm('quote')"
                                        class="px-6 py-3 bg-zinc-900 text-white font-semibold rounded-lg hover:bg-zinc-800 transition-colors">
                                    Submit Another Request
                                </button>
                            </div>
                        @else
                            <form wire:submit="submitQuote" class="space-y-6">
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                                    <p class="text-sm text-blue-800">
                                        <strong>Need a formal quotation?</strong> Complete this form with your project details and we'll prepare a detailed proposal for you.
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Full Name *</label>
                                        <input type="text" wire:model="quoteName"
                                               class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                               placeholder="Your full name">
                                        @error('quoteName') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Email Address *</label>
                                        <input type="email" wire:model="quoteEmail"
                                               class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                               placeholder="your@email.com">
                                        @error('quoteEmail') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Phone Number *</label>
                                        <input type="tel" wire:model="quotePhone"
                                               class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                               placeholder="011 000 0000">
                                        @error('quotePhone') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Company / Organisation</label>
                                        <input type="text" wire:model="quoteCompany"
                                               class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                               placeholder="Your company name">
                                    </div>
                                </div>

                                <div class="border-t border-zinc-200 pt-6 mt-6">
                                    <h3 class="text-lg font-bold text-zinc-950 mb-4">Project Details</h3>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-zinc-700 mb-1">Type of Service Required *</label>
                                            <select wire:model="serviceType"
                                                    class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                                <option value="">Select a service category</option>
                                                @if($this->categories->count() > 0)
                                                    @foreach($this->categories as $category)
                                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="Environmental Monitoring">Environmental Monitoring</option>
                                                    <option value="Environmental Impact Assessments">Environmental Impact Assessments</option>
                                                    <option value="Permitting & Compliance">Permitting & Compliance</option>
                                                    <option value="Waste & Asbestos Management">Waste & Asbestos Management</option>
                                                    <option value="Climate, Carbon & ESG">Climate, Carbon & ESG</option>
                                                    <option value="Occupational Hygiene & OHS">Occupational Hygiene & OHS</option>
                                                    <option value="Training & Capacity Building">Training & Capacity Building</option>
                                                    <option value="Equipment Rental">Equipment Rental</option>
                                                    <option value="Environmental Auditing">Environmental Auditing</option>
                                                    <option value="Other">Other</option>
                                                @endif
                                            </select>
                                            @error('serviceType') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-zinc-700 mb-1">Project Name *</label>
                                            <input type="text" wire:model="projectName"
                                                   class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                                   placeholder="e.g. Gold Mine Water Monitoring">
                                            @error('projectName') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-zinc-700 mb-1">Project Location *</label>
                                            <input type="text" wire:model="projectLocation"
                                                   class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                                   placeholder="e.g. Rustenburg, North West">
                                            @error('projectLocation') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-zinc-700 mb-1">Industry Sector *</label>
                                            <select wire:model="projectSector"
                                                    class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                                <option value="">Select your sector</option>
                                                <option value="Mining & Minerals">Mining & Minerals</option>
                                                <option value="Infrastructure & Transport">Infrastructure & Transport</option>
                                                <option value="Municipal & Public Sector">Municipal & Public Sector</option>
                                                <option value="Renewable Energy">Renewable Energy</option>
                                                <option value="Industrial & Manufacturing">Industrial & Manufacturing</option>
                                                <option value="Water & Sanitation">Water & Sanitation</option>
                                                <option value="Healthcare & Medical">Healthcare & Medical</option>
                                                <option value="Agriculture">Agriculture</option>
                                                <option value="Commercial & Property">Commercial & Property</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            @error('projectSector') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Project Description *</label>
                                        <textarea wire:model="projectDescription" rows="5"
                                                  class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors resize-none"
                                                  placeholder="Describe your project, including scope, specific requirements, and any relevant background information..."></textarea>
                                        @error('projectDescription') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                        <div>
                                            <label class="block text-sm font-medium text-zinc-700 mb-1">Project Timeline *</label>
                                            <select wire:model="projectTimeline"
                                                    class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                                <option value="">When do you need this done?</option>
                                                <option value="Urgent (< 2 weeks)">Urgent (less than 2 weeks)</option>
                                                <option value="Short term (2-4 weeks)">Short term (2-4 weeks)</option>
                                                <option value="Medium term (1-3 months)">Medium term (1-3 months)</option>
                                                <option value="Long term (3+ months)">Long term (3+ months)</option>
                                                <option value="Flexible / Ongoing">Flexible / Ongoing</option>
                                            </select>
                                            @error('projectTimeline') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-zinc-700 mb-1">Supporting Documents</label>
                                            <input type="file" wire:model="attachments"
                                                   multiple
                                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                                                   class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                            <p class="text-xs text-zinc-500 mt-1">PDF, Word, Excel, or images. Max 10MB each.</p>
                                            @error('attachments.*') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror

                                            <div wire:loading wire:target="attachments" class="mt-2">
                                                <span class="text-sm text-zinc-600">Uploading files...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit"
                                        class="w-full px-8 py-4 bg-green-500 text-zinc-950 font-bold text-lg hover:bg-green-400 transition-colors flex items-center justify-center gap-3"
                                        wire:loading.attr="disabled"
                                        wire:loading.class="opacity-75 cursor-not-allowed">
                                    <span wire:loading.remove>Submit Quote Request</span>
                                    <span wire:loading>Submitting...</span>
                                    <x-solar-icon name="arrow-right" size="20" wire:loading.remove />
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Urgent Assistance CTA Strip -->
    <section class="py-16 bg-zinc-900">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <div class="flex flex-col md:flex-row items-center justify-center gap-6 md:gap-12">
                <div>
                    <h3 class="text-2xl md:text-3xl font-black text-white mb-2">
                        Need <span class="text-green-500">Urgent</span> Assistance?
                    </h3>
                    <p class="text-zinc-400">
                        Our team is ready to help with emergency environmental support.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="tel:0119696184"
                       class="inline-flex items-center justify-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                        <x-solar-icon name="phone-calling" size="24" />
                        <span>011 969 6184</span>
                    </a>

                    <a href="https://wa.me/27119696184?text=Hi%20KMG%2C%20I%20need%20urgent%20assistance%20with%20an%20environmental%20matter."
                       target="_blank"
                       class="inline-flex items-center justify-center gap-3 px-8 py-4 text-lg font-bold text-white bg-[#25D366] hover:bg-[#20BD5A] transition-all">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <span>WhatsApp Us</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Links Section -->
    <section class="py-16 bg-zinc-50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl font-black text-zinc-950 text-center mb-8">Quick Links</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('services.index') }}" class="p-6 bg-white rounded-lg border border-zinc-200 hover:border-green-500 hover:shadow-lg transition-all text-center group">
                    <x-solar-icon name="clipboard-list" size="32" class="text-green-500 mx-auto mb-3" />
                    <span class="font-semibold text-zinc-950 group-hover:text-green-600 transition-colors">Our Services</span>
                </a>

                <a href="{{ route('training.index') }}" class="p-6 bg-white rounded-lg border border-zinc-200 hover:border-green-500 hover:shadow-lg transition-all text-center group">
                    <x-solar-icon name="graduation-cap" size="32" class="text-green-500 mx-auto mb-3" />
                    <span class="font-semibold text-zinc-950 group-hover:text-green-600 transition-colors">Training Courses</span>
                </a>

                <a href="{{ route('equipment.index') }}" class="p-6 bg-white rounded-lg border border-zinc-200 hover:border-green-500 hover:shadow-lg transition-all text-center group">
                    <x-solar-icon name="settings" size="32" class="text-green-500 mx-auto mb-3" />
                    <span class="font-semibold text-zinc-950 group-hover:text-green-600 transition-colors">Equipment Rental</span>
                </a>

                <a href="{{ route('about') }}" class="p-6 bg-white rounded-lg border border-zinc-200 hover:border-green-500 hover:shadow-lg transition-all text-center group">
                    <x-solar-icon name="users-group-rounded" size="32" class="text-green-500 mx-auto mb-3" />
                    <span class="font-semibold text-zinc-950 group-hover:text-green-600 transition-colors">About KMG</span>
                </a>
            </div>
        </div>
    </section>
</div>
