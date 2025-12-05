<?php

use App\Mail\NewFormSubmission;
use App\Models\Equipment;
use App\Models\EquipmentCategory;
use Illuminate\Support\Facades\Mail;

use function Livewire\Volt\computed;
use function Livewire\Volt\layout;
use function Livewire\Volt\state;
use function Livewire\Volt\title;
use function Livewire\Volt\usesFileUploads;

layout('components.layouts.public');
title('Equipment Rental | Environmental & Scientific Equipment | KMG');

usesFileUploads();

state([
    'activeCategory' => 'all',
    // Quote form fields
    'quoteName' => '',
    'quoteEmail' => '',
    'quotePhone' => '',
    'quoteCompany' => '',
    'equipmentNeeded' => '',
    'rentalDuration' => '',
    'deliveryLocation' => '',
    'additionalNotes' => '',
    'quoteSubmitted' => false,
    // FAQ
    'openFaq' => null,
]);

$categories = computed(fn () => EquipmentCategory::where('is_active', true)
    ->withCount(['equipment' => fn ($q) => $q->where('is_available', true)])
    ->orderBy('sort_order')
    ->orderBy('name')
    ->get()
);

$equipment = computed(fn () => Equipment::where('is_available', true)
    ->with('equipmentCategory')
    ->when($this->activeCategory !== 'all', fn ($q) => $q->whereHas('equipmentCategory', fn ($q) => $q->where('slug', $this->activeCategory))
    )
    ->orderBy('sort_order')
    ->orderBy('name')
    ->get()
);

$submitQuote = function () {
    $this->validate([
        'quoteName' => 'required|string|max:255',
        'quoteEmail' => 'required|email|max:255',
        'quotePhone' => 'required|string|max:20',
        'quoteCompany' => 'nullable|string|max:255',
        'equipmentNeeded' => 'required|string|max:500',
        'rentalDuration' => 'required|string|max:100',
        'deliveryLocation' => 'required|string|max:255',
        'additionalNotes' => 'nullable|string|max:2000',
    ]);

    \App\Models\ContactSubmission::create([
        'type' => 'equipment_inquiry',
        'name' => $this->quoteName,
        'email' => $this->quoteEmail,
        'phone' => $this->quotePhone,
        'company' => $this->quoteCompany,
        'subject' => 'Equipment Rental Quote Request',
        'message' => "Equipment Needed: {$this->equipmentNeeded}\nRental Duration: {$this->rentalDuration}\nDelivery Location: {$this->deliveryLocation}\n\nAdditional Notes: {$this->additionalNotes}",
        'status' => 'new',
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);

    Mail::to(config('forms.emails.equipment', config('forms.default')))
        ->send(new NewFormSubmission('equipment', [
            'Name' => $this->quoteName,
            'Email' => $this->quoteEmail,
            'Phone' => $this->quotePhone,
            'Company' => $this->quoteCompany,
            'Equipment Needed' => $this->equipmentNeeded,
            'Rental Duration' => $this->rentalDuration,
            'Delivery Location' => $this->deliveryLocation,
            'Additional Notes' => $this->additionalNotes,
        ], $this->quoteEmail, $this->quoteName));

    $this->quoteSubmitted = true;
    $this->reset(['quoteName', 'quoteEmail', 'quotePhone', 'quoteCompany', 'equipmentNeeded', 'rentalDuration', 'deliveryLocation', 'additionalNotes']);
};

$resetQuoteForm = fn () => $this->quoteSubmitted = false;

?>

<x-slot:description>Rent professional environmental and scientific monitoring equipment in South Africa. Air quality monitors, noise meters, water sampling equipment, and more. Flexible rental terms with technical support.</x-slot:description>
<x-slot:keywords>environmental equipment rental, scientific equipment hire, air quality monitor rental, noise meter hire, water sampling equipment, environmental monitoring equipment South Africa, laboratory equipment rental</x-slot:keywords>

@php
$categoryDetails = [
    'water-monitoring' => [
        'name' => 'Water Monitoring Equipment',
        'icon' => 'water',
        'description' => 'Used for groundwater assessments, WUL monitoring, borehole surveys, and surface water sampling programmes.',
        'items' => [
            ['name' => 'Water Level Meters (50m / 100m)', 'description' => 'Precision measurement of groundwater levels in boreholes and wells.', 'uses' => 'Groundwater monitoring, borehole surveys, WUL compliance'],
            ['name' => 'Multiparameter Water Quality Meters', 'description' => 'Measure pH, EC, TDS, DO, temperature and more in a single device.', 'uses' => 'Water quality assessment, baseline studies, pollution monitoring'],
            ['name' => 'pH / EC / TDS Meters', 'description' => 'Handheld meters for quick field measurements of water chemistry.', 'uses' => 'Rapid field screening, process monitoring'],
            ['name' => 'Dissolved Oxygen Meters', 'description' => 'Accurate DO measurement for aquatic ecosystem assessment.', 'uses' => 'River health assessment, effluent monitoring'],
            ['name' => 'Water Sampling Kits', 'description' => 'Complete kits for surface and groundwater sample collection.', 'uses' => 'Laboratory sample collection, baseline studies'],
        ],
    ],
    'air-quality' => [
        'name' => 'Air Quality & Dust Monitoring',
        'icon' => 'wind',
        'description' => 'Professional instruments for ambient air quality assessment and dust fallout monitoring.',
        'items' => [
            ['name' => 'PM10 / PM2.5 Monitors', 'description' => 'Real-time particulate matter monitoring for air quality assessment.', 'uses' => 'AQA compliance, construction monitoring, health assessments'],
            ['name' => 'Dust Fallout Buckets (ASTM D1739)', 'description' => 'Standard dust fallout collection units for long-term monitoring.', 'uses' => 'Mining operations, construction sites, industrial facilities'],
            ['name' => 'Passive Gas Samplers', 'description' => 'Passive sampling devices for SO2, NO2, and other gases.', 'uses' => 'Ambient air quality, industrial emissions monitoring'],
            ['name' => 'Stack Monitoring Accessories', 'description' => 'Equipment for point source emission measurements.', 'uses' => 'AEL compliance, emission inventories'],
        ],
    ],
    'noise-vibration' => [
        'name' => 'Noise & Vibration Monitoring',
        'icon' => 'volume-2',
        'description' => 'SANS-compliant noise measurement and logging equipment for environmental and occupational assessments.',
        'items' => [
            ['name' => 'Class 1 Sound Level Meters', 'description' => 'High-precision sound level measurement to SANS standards.', 'uses' => 'Environmental noise surveys, community complaints'],
            ['name' => 'Noise Loggers', 'description' => 'Unattended long-term noise monitoring with data logging.', 'uses' => '24-hour noise assessments, baseline studies'],
            ['name' => 'Personal Dosimeters', 'description' => 'Wearable noise exposure measurement devices.', 'uses' => 'Occupational noise exposure, MHSA compliance'],
            ['name' => 'Vibration Meters', 'description' => 'Ground and structural vibration measurement equipment.', 'uses' => 'Blasting assessments, construction impact studies'],
        ],
    ],
    'occupational-hygiene' => [
        'name' => 'Occupational Hygiene Equipment',
        'icon' => 'shield-check',
        'description' => 'Professional instruments for workplace exposure assessment and health risk monitoring.',
        'items' => [
            ['name' => 'IAQ Monitors', 'description' => 'Indoor air quality monitors for CO2, temperature, humidity, and VOCs.', 'uses' => 'Office IAQ assessments, building commissioning'],
            ['name' => 'Personal Sampling Pumps', 'description' => 'Calibrated pumps for personal exposure monitoring.', 'uses' => 'Dust exposure, chemical exposure assessments'],
            ['name' => 'Multi-Gas Detectors', 'description' => 'Portable detectors for H2S, CO, O2, and LEL.', 'uses' => 'Confined space entry, hazardous area monitoring'],
            ['name' => 'Heat Stress Monitors', 'description' => 'WBGT meters for heat stress risk assessment.', 'uses' => 'Mining operations, outdoor work assessment'],
            ['name' => 'Light (Lux) Meters', 'description' => 'Illumination measurement for workplace lighting assessment.', 'uses' => 'Workplace lighting surveys, OHS compliance'],
        ],
    ],
    'field-tools' => [
        'name' => 'Soil, GPS & Field Tools',
        'icon' => 'map-pin',
        'description' => 'Essential field equipment for environmental site assessments and data collection.',
        'items' => [
            ['name' => 'GPS Survey Tools', 'description' => 'High-accuracy GPS units for environmental sampling locations.', 'uses' => 'Sample point recording, site mapping'],
            ['name' => 'Soil Augers', 'description' => 'Manual and powered augers for soil sampling.', 'uses' => 'Soil contamination assessment, geotechnical surveys'],
            ['name' => 'Core Samplers', 'description' => 'Soil core sampling equipment for profile analysis.', 'uses' => 'Soil science studies, contamination profiling'],
            ['name' => 'Field Measuring Tools', 'description' => 'Measuring wheels, tapes, and survey equipment.', 'uses' => 'Site measurements, transect surveys'],
        ],
    ],
    'field-kits' => [
        'name' => 'Complete Field Kits',
        'icon' => 'briefcase',
        'description' => 'Pre-assembled equipment bundles for specific monitoring programmes at discounted rates.',
        'items' => [
            ['name' => 'Water Monitoring Kit', 'description' => 'Complete groundwater monitoring package with all essential equipment.', 'uses' => 'Baseline studies, WUL monitoring programmes'],
            ['name' => 'Dust Monitoring Kit', 'description' => 'Everything needed for dust fallout monitoring programmes.', 'uses' => 'Mining, construction, industrial monitoring'],
            ['name' => 'Noise Assessment Kit', 'description' => 'Full noise monitoring setup for environmental assessments.', 'uses' => 'EIA noise studies, community monitoring'],
            ['name' => 'Hygiene Sampling Kit', 'description' => 'Occupational hygiene sampling equipment bundle.', 'uses' => 'Workplace exposure surveys, compliance audits'],
        ],
    ],
];
@endphp

<div class="bg-white">
    <!-- Hero Section -->
    <section class="relative py-24 bg-zinc-900 overflow-hidden">
        @if(file_exists(public_path('images/equipment/hero.jpg')))
            <img src="{{ asset('images/equipment/hero.jpg') }}"
                 alt="Environmental monitoring equipment"
                 class="absolute inset-0 w-full h-full object-cover opacity-30">
        @endif
        <div class="absolute inset-0 bg-gradient-to-b from-zinc-900/80 to-zinc-900/95"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4">
            <x-public.breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Equipment Rental']
            ]" class="mb-8" />

            <div class="max-w-4xl">
                <h1 class="text-5xl md:text-6xl font-black text-white mb-6">
                    Environmental & Scientific <span class="text-green-500">Equipment Rental</span>
                </h1>
                <p class="text-xl text-zinc-300 leading-relaxed mb-8">
                    Rent high-quality, professionally calibrated field instruments for environmental and occupational studies. Affordable rates with expert support.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#quote-form"
                       class="inline-flex items-center justify-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                        <x-solar-icon name="document-text" size="24" />
                        <span>Request Rental Quote</span>
                    </a>
                    <a href="https://wa.me/+27725463191?text=Hi%20KMG%2C%20I%20would%20like%20to%20enquire%20about%20equipment%20rental."
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

    <!-- Why Rent From KMG Section -->
    <section class="py-24">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-zinc-950 mb-4">
                    Why Choose <span class="text-green-500">KMG</span> Rental Services?
                </h2>
                <p class="text-xl text-zinc-600 max-w-3xl mx-auto">
                    Professional equipment, expert support, and flexible terms to suit your project needs.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-6 bg-zinc-50 rounded-lg border border-zinc-100">
                    <div class="w-16 h-16 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <x-solar-icon name="verified-check" size="32" class="text-white" />
                    </div>
                    <h3 class="font-bold text-zinc-950 mb-2">Professionally Calibrated</h3>
                    <p class="text-sm text-zinc-600">All instruments calibrated and maintained to manufacturer specifications.</p>
                </div>

                <div class="text-center p-6 bg-zinc-50 rounded-lg border border-zinc-100">
                    <div class="w-16 h-16 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <x-solar-icon name="wallet-money" size="32" class="text-white" />
                    </div>
                    <h3 class="font-bold text-zinc-950 mb-2">Affordable Rates</h3>
                    <p class="text-sm text-zinc-600">Competitive daily, weekly, and monthly rental options to fit your budget.</p>
                </div>

                <div class="text-center p-6 bg-zinc-50 rounded-lg border border-zinc-100">
                    <div class="w-16 h-16 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <x-solar-icon name="graduation-cap" size="32" class="text-white" />
                    </div>
                    <h3 class="font-bold text-zinc-950 mb-2">Training Available</h3>
                    <p class="text-sm text-zinc-600">Optional on-site or virtual training on instrument operation.</p>
                </div>

                <div class="text-center p-6 bg-zinc-50 rounded-lg border border-zinc-100">
                    <div class="w-16 h-16 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <x-solar-icon name="delivery" size="32" class="text-white" />
                    </div>
                    <h3 class="font-bold text-zinc-950 mb-2">Delivery Available</h3>
                    <p class="text-sm text-zinc-600">Nationwide delivery and collection services available.</p>
                </div>

                <div class="text-center p-6 bg-zinc-50 rounded-lg border border-zinc-100">
                    <div class="w-16 h-16 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <x-solar-icon name="chat-round-dots" size="32" class="text-white" />
                    </div>
                    <h3 class="font-bold text-zinc-950 mb-2">24/7 WhatsApp Support</h3>
                    <p class="text-sm text-zinc-600">Field support available when you need it most.</p>
                </div>

                <div class="text-center p-6 bg-zinc-50 rounded-lg border border-zinc-100">
                    <div class="w-16 h-16 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <x-solar-icon name="users-group-rounded" size="32" class="text-white" />
                    </div>
                    <h3 class="font-bold text-zinc-950 mb-2">Ideal For Everyone</h3>
                    <p class="text-sm text-zinc-600">Consultants, contractors, municipalities, and students welcome.</p>
                </div>

                <div class="text-center p-6 bg-zinc-50 rounded-lg border border-zinc-100">
                    <div class="w-16 h-16 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <x-solar-icon name="box" size="32" class="text-white" />
                    </div>
                    <h3 class="font-bold text-zinc-950 mb-2">Large Inventory</h3>
                    <p class="text-sm text-zinc-600">Wide selection of environmental monitoring equipment.</p>
                </div>

                <div class="text-center p-6 bg-zinc-50 rounded-lg border border-zinc-100">
                    <div class="w-16 h-16 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <x-solar-icon name="map-point" size="32" class="text-white" />
                    </div>
                    <h3 class="font-bold text-zinc-950 mb-2">Countrywide Coverage</h3>
                    <p class="text-sm text-zinc-600">Serving clients across all nine provinces of South Africa.</p>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="#quote-form"
                   class="inline-flex items-center justify-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                    <x-solar-icon name="document-text" size="24" />
                    <span>Request a Rental Quote</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Equipment Categories Section -->
    <section class="py-24 bg-zinc-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-black text-zinc-950 mb-4">
                    Available Equipment
                </h2>
                <p class="text-xl text-zinc-600 max-w-3xl mx-auto">
                    Browse our comprehensive range of environmental and scientific monitoring equipment.
                </p>
            </div>

            <!-- Category Tabs -->
            <div class="flex flex-wrap justify-center gap-2 mb-12">
                <button wire:click="$set('activeCategory', 'all')"
                        class="px-6 py-3 rounded-full font-semibold transition-all {{ $activeCategory === 'all' ? 'bg-green-500 text-zinc-950' : 'bg-white text-zinc-600 hover:bg-zinc-100 border border-zinc-200' }}">
                    All Equipment
                </button>
                @foreach($categoryDetails as $slug => $details)
                    <button wire:click="$set('activeCategory', '{{ $slug }}')"
                            class="px-6 py-3 rounded-full font-semibold transition-all {{ $activeCategory === $slug ? 'bg-green-500 text-zinc-950' : 'bg-white text-zinc-600 hover:bg-zinc-100 border border-zinc-200' }}">
                        {{ $details['name'] }}
                    </button>
                @endforeach
            </div>

            <!-- Equipment from Database -->
            @if($this->equipment->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                    @foreach($this->equipment as $item)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-lg transition-all border border-zinc-100 flex flex-col">
                            @if($item->photo)
                                <div class="aspect-video bg-zinc-100">
                                    <img src="{{ Storage::url($item->photo) }}"
                                         alt="{{ $item->name }}"
                                         class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="aspect-video bg-gradient-to-br from-zinc-200 to-zinc-300 flex items-center justify-center">
                                    <x-solar-icon name="settings" size="64" class="text-zinc-400" />
                                </div>
                            @endif

                            <div class="p-6 flex-grow flex flex-col">
                                @if($item->equipmentCategory)
                                    <span class="text-xs font-semibold text-green-600 uppercase tracking-wider mb-2">
                                        {{ $item->equipmentCategory->name }}
                                    </span>
                                @endif

                                <h3 class="text-xl font-bold text-zinc-950 mb-2">{{ $item->name }}</h3>

                                @if($item->description)
                                    <p class="text-zinc-600 text-sm mb-4 flex-grow line-clamp-3">
                                        {{ Str::limit(strip_tags($item->description), 150) }}
                                    </p>
                                @endif

                                @if($item->daily_rate || $item->weekly_rate || $item->monthly_rate)
                                    <div class="border-t border-zinc-100 pt-4 mt-auto mb-4">
                                        <div class="flex flex-wrap gap-2 text-sm">
                                            @if($item->daily_rate)
                                                <span class="px-3 py-1 bg-zinc-100 rounded-full">
                                                    <span class="text-zinc-500">Daily:</span>
                                                    <span class="font-semibold text-green-600">R{{ number_format($item->daily_rate) }}</span>
                                                </span>
                                            @endif
                                            @if($item->weekly_rate)
                                                <span class="px-3 py-1 bg-zinc-100 rounded-full">
                                                    <span class="text-zinc-500">Weekly:</span>
                                                    <span class="font-semibold text-green-600">R{{ number_format($item->weekly_rate) }}</span>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <a href="#quote-form"
                                   onclick="document.getElementById('equipmentNeeded').value = '{{ $item->name }}'"
                                   class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-green-500 hover:bg-green-400 text-zinc-950 font-bold transition-colors">
                                    <span>Request Quote</span>
                                    <x-solar-icon name="arrow-right" size="20" />
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Placeholder Equipment Categories when database is empty -->
                @foreach($categoryDetails as $slug => $details)
                    @if($activeCategory === 'all' || $activeCategory === $slug)
                        <div class="mb-16" id="category-{{ $slug }}">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                    <x-solar-icon name="settings" size="24" class="text-white" />
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-zinc-950">{{ $details['name'] }}</h3>
                                    <p class="text-zinc-600">{{ $details['description'] }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($details['items'] as $item)
                                    <div class="bg-white rounded-lg p-6 border border-zinc-200 hover:border-green-500 hover:shadow-lg transition-all">
                                        <div class="w-16 h-16 bg-zinc-100 rounded-lg flex items-center justify-center mb-4">
                                            <x-solar-icon name="settings" size="32" class="text-zinc-400" />
                                        </div>
                                        <h4 class="font-bold text-zinc-950 mb-2">{{ $item['name'] }}</h4>
                                        <p class="text-sm text-zinc-600 mb-3">{{ $item['description'] }}</p>
                                        <p class="text-xs text-zinc-500 mb-4">
                                            <span class="font-semibold">Typical uses:</span> {{ $item['uses'] }}
                                        </p>
                                        <a href="#quote-form"
                                           class="inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-700 transition-colors">
                                            <span>Request Quote</span>
                                            <x-solar-icon name="arrow-right" size="16" />
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-24">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-zinc-950 mb-4">
                    How Our Rental Process Works
                </h2>
                <p class="text-xl text-zinc-600 max-w-3xl mx-auto">
                    Simple, straightforward, and designed for your convenience.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $steps = [
                        ['num' => '1', 'title' => 'Browse Equipment', 'desc' => 'Explore our range of available equipment and identify what you need.'],
                        ['num' => '2', 'title' => 'Request a Quote', 'desc' => 'Submit your requirements using our simple quote form.'],
                        ['num' => '3', 'title' => 'Confirm Availability', 'desc' => 'We confirm availability and send you our competitive rates.'],
                        ['num' => '4', 'title' => 'Sign Rental Form', 'desc' => 'Complete our simple rental agreement and payment.'],
                        ['num' => '5', 'title' => 'Collect or Delivery', 'desc' => 'Collect from our office or request delivery to your site.'],
                        ['num' => '6', 'title' => 'Training (Optional)', 'desc' => 'Free demonstration on equipment use available on request.'],
                        ['num' => '7', 'title' => 'Return & Closeout', 'desc' => 'Return equipment and we handle the closeout check.'],
                    ];
                @endphp

                @foreach($steps as $index => $step)
                    <div class="relative {{ $index === 6 ? 'lg:col-start-2' : '' }}">
                        <div class="bg-zinc-50 rounded-lg p-6 border border-zinc-100 h-full">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-zinc-950 font-black text-xl mb-4">
                                {{ $step['num'] }}
                            </div>
                            <h3 class="font-bold text-zinc-950 mb-2">{{ $step['title'] }}</h3>
                            <p class="text-sm text-zinc-600">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-24 bg-zinc-50">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-zinc-950 mb-4">
                    Frequently Asked Questions
                </h2>
                <p class="text-xl text-zinc-600">
                    Common questions about our equipment rental services.
                </p>
            </div>

            @php
                $faqs = [
                    ['q' => 'What if I need the equipment longer than expected?', 'a' => 'No problem! Simply contact us to extend your rental period. We\'ll confirm availability and adjust your invoice accordingly. Extensions are subject to availability.'],
                    ['q' => 'Do you offer a discount on long-term rentals?', 'a' => 'Yes! We offer discounted rates for weekly and monthly rentals compared to daily rates. Contact us for custom quotes on extended rental periods or ongoing projects.'],
                    ['q' => 'Is training included with the rental?', 'a' => 'Basic operational training is available free of charge. For more comprehensive training or on-site demonstrations, we can arrange this at an additional cost. Just ask when requesting your quote.'],
                    ['q' => 'Do you deliver countrywide?', 'a' => 'Yes, we deliver to all nine provinces of South Africa. Delivery costs are calculated based on location and urgency. Collection from our Johannesburg office is also available.'],
                    ['q' => 'What happens if equipment is damaged?', 'a' => 'Normal wear and tear is expected and covered. For significant damage, the renter is responsible for repair or replacement costs. We recommend discussing insurance options for high-value equipment.'],
                    ['q' => 'How do I know the equipment is properly calibrated?', 'a' => 'All our equipment is professionally calibrated and maintained according to manufacturer specifications. Calibration certificates can be provided upon request for compliance purposes.'],
                    ['q' => 'Can I rent equipment for student projects?', 'a' => 'Absolutely! We welcome students and offer student-friendly rates for academic projects. A valid student ID and supervisor approval may be required.'],
                    ['q' => 'What forms of payment do you accept?', 'a' => 'We accept EFT, company purchase orders, and credit card payments. For new clients, payment may be required upfront. Established clients may qualify for account terms.'],
                ];
            @endphp

            <div class="space-y-4">
                @foreach($faqs as $index => $faq)
                    <div class="bg-white rounded-lg border border-zinc-200 overflow-hidden"
                         x-data="{ open: @entangle('openFaq').live === {{ $index }} }">
                        <button wire:click="$set('openFaq', {{ $openFaq === $index ? 'null' : $index }})"
                                class="w-full flex items-center justify-between p-6 text-left hover:bg-zinc-50 transition-colors group">
                            <span class="font-bold text-zinc-950 pr-4">{{ $faq['q'] }}</span>
                            <span class="w-8 h-8 rounded-full bg-green-100 group-hover:bg-green-500 flex items-center justify-center flex-shrink-0 transition-colors">
                                @if($openFaq === $index)
                                    <x-solar-icon name="alt-arrow-up" size="16" class="text-green-600 group-hover:text-white" />
                                @else
                                    <x-solar-icon name="alt-arrow-down" size="16" class="text-green-600 group-hover:text-white" />
                                @endif
                            </span>
                        </button>
                        @if($openFaq === $index)
                            <div class="px-6 pb-6 text-zinc-600 border-t border-zinc-100 pt-4">
                                {{ $faq['a'] }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Quick Rental Quote Form -->
    <section class="py-24" id="quote-form">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-black text-zinc-950 mb-4">
                    Quick Rental Quote
                </h2>
                <p class="text-xl text-zinc-600">
                    Fill in your requirements and we'll get back to you with availability and rates.
                </p>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8 border border-zinc-200">
                @if($quoteSubmitted)
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <x-solar-icon name="check-circle" size="48" class="text-green-500" />
                        </div>
                        <h3 class="text-2xl font-bold text-zinc-950 mb-4">Quote Request Submitted!</h3>
                        <p class="text-zinc-600 mb-8">Thank you for your enquiry. We'll check availability and get back to you within 24 hours with our rates.</p>
                        <button wire:click="resetQuoteForm"
                                class="px-6 py-3 bg-zinc-900 text-white font-semibold rounded-lg hover:bg-zinc-800 transition-colors">
                            Submit Another Request
                        </button>
                    </div>
                @else
                    <form wire:submit="submitQuote" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1">Full Name *</label>
                                <input type="text" wire:model="quoteName"
                                       class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                       placeholder="Your name">
                                @error('quoteName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1">Company / Organisation</label>
                                <input type="text" wire:model="quoteCompany"
                                       class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                       placeholder="Your company">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1">Email Address *</label>
                                <input type="email" wire:model="quoteEmail"
                                       class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                       placeholder="your@email.com">
                                @error('quoteEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1">Phone Number *</label>
                                <input type="tel" wire:model="quotePhone"
                                       class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                       placeholder="011 000 0000">
                                @error('quotePhone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1">Equipment Required *</label>
                            <select wire:model="equipmentNeeded" id="equipmentNeeded"
                                    class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                <option value="">Select equipment category or specify below</option>
                                <option value="Water Level Meters">Water Level Meters</option>
                                <option value="Multiparameter Water Quality Meters">Multiparameter Water Quality Meters</option>
                                <option value="PM Air Quality Monitors">PM Air Quality Monitors</option>
                                <option value="Dust Fallout Monitoring Kits">Dust Fallout Monitoring Kits</option>
                                <option value="Noise Loggers">Noise Loggers</option>
                                <option value="Sound Level Meters">Sound Level Meters</option>
                                <option value="Multi-Gas Detectors">Multi-Gas Detectors</option>
                                <option value="Personal Sampling Pumps">Personal Sampling Pumps</option>
                                <option value="GPS Survey Tools">GPS Survey Tools</option>
                                <option value="Complete Water Monitoring Kit">Complete Water Monitoring Kit</option>
                                <option value="Complete Dust Monitoring Kit">Complete Dust Monitoring Kit</option>
                                <option value="Complete Noise Assessment Kit">Complete Noise Assessment Kit</option>
                                <option value="Other / Multiple Items">Other / Multiple Items (specify below)</option>
                            </select>
                            @error('equipmentNeeded') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1">Rental Duration *</label>
                                <select wire:model="rentalDuration"
                                        class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                    <option value="">Select duration</option>
                                    <option value="1 Day">1 Day</option>
                                    <option value="2-3 Days">2-3 Days</option>
                                    <option value="1 Week">1 Week</option>
                                    <option value="2 Weeks">2 Weeks</option>
                                    <option value="1 Month">1 Month</option>
                                    <option value="Ongoing / Long-term">Ongoing / Long-term</option>
                                </select>
                                @error('rentalDuration') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1">Delivery Location *</label>
                                <input type="text" wire:model="deliveryLocation"
                                       class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors"
                                       placeholder="City / Province or 'Collection'">
                                @error('deliveryLocation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1">Additional Notes / Specific Requirements</label>
                            <textarea wire:model="additionalNotes" rows="4"
                                      class="w-full px-4 py-3 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors resize-none"
                                      placeholder="Specify any additional equipment, project details, or special requirements..."></textarea>
                        </div>

                        <button type="submit"
                                class="w-full px-8 py-4 bg-green-500 text-zinc-950 font-bold text-lg hover:bg-green-400 transition-colors flex items-center justify-center gap-3"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-75 cursor-not-allowed">
                            <span wire:loading.remove>Submit Quote Request</span>
                            <span wire:loading>Submitting...</span>
                            <x-solar-icon name="arrow-right" size="20" wire:loading.remove />
                        </button>

                        <p class="text-center text-sm text-zinc-500 mt-4">
                            Need urgent confirmation? Email <a href="mailto:marabekg@kmgenviro.co.za" class="text-green-600 font-semibold hover:text-green-700">marabekg@kmgenviro.co.za</a> or
                            <a href="https://wa.me/+27725463191?text=Hi%20KMG%2C%20I%20need%20urgent%20equipment%20rental%20assistance."
                               target="_blank"
                               class="text-green-600 font-semibold hover:text-green-700">
                                Chat on WhatsApp
                            </a>
                        </p>
                    </form>
                @endif
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-zinc-900">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">
                Ready to Rent? <span class="text-green-500">Let's Get Started</span>
            </h2>
            <p class="text-lg text-zinc-400 mb-8">
                Professional equipment, competitive rates, expert support.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#quote-form"
                   class="inline-flex items-center justify-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                    <x-solar-icon name="document-text" size="24" />
                    <span>Request Rental Quote</span>
                </a>

                <a href="tel:0114804822"
                   class="inline-flex items-center justify-center gap-3 px-8 py-4 text-lg font-bold text-white border-2 border-zinc-600 hover:border-green-500 transition-all">
                    <x-solar-icon name="phone-calling" size="24" />
                    <span>011 480 4822</span>
                </a>

                <a href="mailto:marabekg@kmgenviro.co.za"
                   class="inline-flex items-center justify-center gap-3 px-8 py-4 text-lg font-bold text-white border-2 border-zinc-600 hover:border-green-500 transition-all">
                    <x-solar-icon name="letter" size="24" />
                    <span>marabekg@kmgenviro.co.za</span>
                </a>

                <a href="https://wa.me/+27725463191?text=Hi%20KMG%2C%20I%20would%20like%20to%20enquire%20about%20equipment%20rental."
                   target="_blank"
                   class="inline-flex items-center justify-center gap-3 px-8 py-4 text-lg font-bold text-white bg-[#25D366] hover:bg-[#20BD5A] transition-all">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    <span>WhatsApp</span>
                </a>
            </div>
        </div>
    </section>
</div>
