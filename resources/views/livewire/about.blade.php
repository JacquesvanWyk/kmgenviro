<?php

use function Livewire\Volt\{computed, layout, title};
use App\Models\Accreditation;

layout('components.layouts.public');
title('About Us | KMG Environmental Solutions');

$accreditations = computed(fn() =>
    Accreditation::where('is_active', true)
        ->orderBy('sort_order')
        ->get()
);

?>

<x-slot:description>Learn about KMG Environmental Solutions - a leading South African environmental consultancy with 13+ years experience. DoEL approved, SACNASP, EAPASA & GBCSA registered. B-BBEE Level 2 contributor serving all 9 provinces and SADC region.</x-slot:description>
<x-slot:keywords>about KMG Environmental, environmental consultancy South Africa, SACNASP registered, EAPASA accredited, DoEL approved, B-BBEE Level 2, environmental specialists, South African environmental company</x-slot:keywords>

<div class="bg-white">
    <!-- Hero Section -->
    <section class="relative py-24 bg-zinc-900 overflow-hidden">
        @if(file_exists(public_path('images/about/kmg-vehicle-1.jpg')))
            <img src="{{ asset('images/about/kmg-vehicle-1.jpg') }}"
                 alt="KMG Environmental Solutions"
                 class="absolute inset-0 w-full h-full object-cover opacity-30">
        @endif
        <div class="absolute inset-0 bg-gradient-to-b from-zinc-900/80 to-zinc-900/95"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4">
            <x-public.breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'About Us'],
            ]" class="mb-8" />

            <div class="max-w-4xl">
                <h1 class="text-5xl md:text-6xl font-black text-white mb-6">
                    About <span class="text-green-500">KMG</span>
                </h1>
                <p class="text-xl text-zinc-300 leading-relaxed">
                    Accredited environmental consultancy delivering scientifically robust, regulation-aligned solutions across South Africa and the SADC region.
                </p>
            </div>
        </div>
    </section>

    <!-- Who We Are Section -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="mb-8 border-l-4 border-green-500 pl-6">
                        <h2 class="text-4xl md:text-5xl font-black text-zinc-950 mb-4">
                            Who We Are
                        </h2>
                    </div>

                    <div class="prose prose-lg max-w-none text-zinc-600">
                        <p>
                            KMG Environmental Solutions (Pty) Ltd is a leading South African environmental consultancy providing expert services across the full spectrum of environmental management, ESG compliance, occupational hygiene, and professional training.
                        </p>

                        <p>
                            We have grown to become a trusted partner for clients in mining, industrial, infrastructure, and renewable energy sectors. Our multidisciplinary team of registered professionals brings together expertise in environmental science, chemistry, occupational hygiene, waste management, and regulatory compliance.
                        </p>

                        <p>
                            We deliver scientifically defensible solutions that meet the highest regulatory standards while remaining practical and cost-effective. Our work spans all nine provinces of South Africa and extends into the broader SADC region, including notable projects in Lesotho, Botswana, and Mozambique.
                        </p>

                        <p>
                            As a DoEL-approved asbestos contractor, SACNASP-registered training provider, and EAPASA-accredited organisation, we maintain the credentials and expertise necessary to handle complex environmental challenges with confidence and precision.
                        </p>
                    </div>
                </div>

                <div class="space-y-6">
                    @if(file_exists(public_path('images/about/kmg-vehicle-2.jpg')))
                        <img src="{{ asset('images/about/kmg-vehicle-2.jpg') }}"
                             alt="KMG Environmental team in the field"
                             class="w-full h-auto rounded-lg shadow-xl">
                    @endif

                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-zinc-50 p-6 rounded-lg text-center">
                            <div class="text-4xl font-black text-green-500 mb-2">13+</div>
                            <div class="text-sm text-zinc-600">Years Experience</div>
                        </div>
                        <div class="bg-zinc-50 p-6 rounded-lg text-center">
                            <div class="text-4xl font-black text-green-500 mb-2">9</div>
                            <div class="text-sm text-zinc-600">SA Provinces</div>
                        </div>
                        <div class="bg-zinc-50 p-6 rounded-lg text-center">
                            <div class="text-4xl font-black text-green-500 mb-2">100+</div>
                            <div class="text-sm text-zinc-600">Projects Completed</div>
                        </div>
                        <div class="bg-zinc-50 p-6 rounded-lg text-center">
                            <div class="text-4xl font-black text-green-500 mb-2">B-BBEE</div>
                            <div class="text-sm text-zinc-600">Level 2 Contributor</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission, Vision & Values -->
    <section class="py-16 bg-zinc-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-black text-zinc-950 mb-3">
                    Mission, Vision & Values
                </h2>
                <p class="text-lg text-zinc-500 max-w-3xl mx-auto">
                    The principles that guide everything we do
                </p>
            </div>

            <!-- Mission & Vision -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div class="bg-white p-8 rounded-lg shadow-sm border-l-4 border-green-500">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                            <x-solar-icon name="target" size="24" class="text-white" />
                        </div>
                        <h3 class="text-2xl font-bold text-zinc-950">Our Mission</h3>
                    </div>
                    <p class="text-zinc-600 leading-relaxed">
                        To provide scientifically robust, regulation-aligned environmental solutions that protect ecosystems, ensure compliance, and enable sustainable development for our clients across South Africa and the SADC region.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-sm border-l-4 border-green-500">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                            <x-solar-icon name="eye" size="24" class="text-white" />
                        </div>
                        <h3 class="text-2xl font-bold text-zinc-950">Our Vision</h3>
                    </div>
                    <p class="text-zinc-600 leading-relaxed">
                        To be the most trusted environmental consultancy in Southern Africa, recognised for our scientific excellence, professional integrity, and commitment to sustainable development that balances economic growth with environmental stewardship.
                    </p>
                </div>
            </div>

            <!-- Core Values -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm text-center group hover:shadow-lg transition-all">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-500 transition-colors">
                        <x-solar-icon name="shield-check" size="32" class="text-green-600 group-hover:text-white transition-colors" />
                    </div>
                    <h4 class="font-bold text-zinc-950 mb-2">Integrity</h4>
                    <p class="text-sm text-zinc-500">Honest, ethical conduct in all dealings</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm text-center group hover:shadow-lg transition-all">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-500 transition-colors">
                        <x-solar-icon name="cup-star" size="32" class="text-green-600 group-hover:text-white transition-colors" />
                    </div>
                    <h4 class="font-bold text-zinc-950 mb-2">Excellence</h4>
                    <p class="text-sm text-zinc-500">Highest scientific & professional standards</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm text-center group hover:shadow-lg transition-all">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-500 transition-colors">
                        <x-solar-icon name="leaf" size="32" class="text-green-600 group-hover:text-white transition-colors" />
                    </div>
                    <h4 class="font-bold text-zinc-950 mb-2">Sustainability</h4>
                    <p class="text-sm text-zinc-500">Long-term environmental stewardship</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm text-center group hover:shadow-lg transition-all">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-500 transition-colors">
                        <x-solar-icon name="diploma" size="32" class="text-green-600 group-hover:text-white transition-colors" />
                    </div>
                    <h4 class="font-bold text-zinc-950 mb-2">Professionalism</h4>
                    <p class="text-sm text-zinc-500">Registered, accredited expertise</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm text-center group hover:shadow-lg transition-all">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-500 transition-colors">
                        <x-solar-icon name="lightbulb" size="32" class="text-green-600 group-hover:text-white transition-colors" />
                    </div>
                    <h4 class="font-bold text-zinc-950 mb-2">Innovation</h4>
                    <p class="text-sm text-zinc-500">Modern solutions to complex challenges</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm text-center group hover:shadow-lg transition-all">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-500 transition-colors">
                        <x-solar-icon name="handshake" size="32" class="text-green-600 group-hover:text-white transition-colors" />
                    </div>
                    <h4 class="font-bold text-zinc-950 mb-2">Partnership</h4>
                    <p class="text-sm text-zinc-500">Collaborative client relationships</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Accreditations & Memberships -->
    <section class="py-16 bg-zinc-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-black text-zinc-950 mb-3">
                    Accreditations & <span class="text-green-500">Memberships</span>
                </h2>
                <p class="text-lg text-zinc-500 max-w-3xl mx-auto">
                    Our credentials demonstrate our commitment to professional excellence
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- DoEL -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-full h-32 flex items-center justify-center mb-4 p-4">
                        @if(file_exists(public_path('images/accreditations/doel.jpg')))
                            <img src="{{ asset('images/accreditations/doel.jpg') }}" alt="DoEL" class="w-full h-full object-contain">
                        @else
                            <div class="text-sm font-bold text-zinc-700">DoEL</div>
                        @endif
                    </div>
                    <div class="font-bold text-zinc-950 mb-1">DoEL</div>
                    <p class="text-xs text-zinc-500">Approved Asbestos Contractor</p>
                </div>

                <!-- SACNASP -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-full h-32 flex items-center justify-center mb-4 p-4">
                        @if(file_exists(public_path('images/accreditations/sacnasp.png')))
                            <img src="{{ asset('images/accreditations/sacnasp.png') }}" alt="SACNASP" class="w-full h-full object-contain">
                        @else
                            <div class="text-sm font-bold text-zinc-700">SACNASP</div>
                        @endif
                    </div>
                    <div class="font-bold text-zinc-950 mb-1">SACNASP</div>
                    <p class="text-xs text-zinc-500">Registered Professionals</p>
                </div>

                <!-- EAPASA -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-full h-32 flex items-center justify-center mb-4 p-4">
                        @if(file_exists(public_path('images/accreditations/eapasa.png')))
                            <img src="{{ asset('images/accreditations/eapasa.png') }}" alt="EAPASA" class="w-full h-full object-contain">
                        @else
                            <div class="text-sm font-bold text-zinc-700">EAPASA</div>
                        @endif
                    </div>
                    <div class="font-bold text-zinc-950 mb-1">EAPASA</div>
                    <p class="text-xs text-zinc-500">Accredited Training Provider</p>
                </div>

                <!-- GBCSA -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-full h-32 flex items-center justify-center mb-4 p-4">
                        @if(file_exists(public_path('images/accreditations/GBCSA-logo.png')))
                            <img src="{{ asset('images/accreditations/GBCSA-logo.png') }}" alt="GBCSA" class="w-full h-full object-contain">
                        @else
                            <div class="text-sm font-bold text-zinc-700">GBCSA</div>
                        @endif
                    </div>
                    <div class="font-bold text-zinc-950 mb-1">GBCSA</div>
                    <p class="text-xs text-zinc-500">Professional Member</p>
                </div>

                <!-- WISA -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-full h-32 flex items-center justify-center mb-4 p-4">
                        @if(file_exists(public_path('images/accreditations/WISA.png')))
                            <img src="{{ asset('images/accreditations/WISA.png') }}" alt="WISA" class="w-full h-full object-contain">
                        @else
                            <div class="text-sm font-bold text-zinc-700">WISA</div>
                        @endif
                    </div>
                    <div class="font-bold text-zinc-950 mb-1">WISA</div>
                    <p class="text-xs text-zinc-500">Water Institute Member</p>
                </div>

                <!-- IIAV -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-full h-32 flex items-center justify-center mb-4 p-4">
                        @if(file_exists(public_path('images/accreditations/IIAV.png')))
                            <img src="{{ asset('images/accreditations/IIAV.png') }}" alt="IIAV" class="w-full h-full object-contain">
                        @else
                            <div class="text-sm font-bold text-zinc-700">IIAV</div>
                        @endif
                    </div>
                    <div class="font-bold text-zinc-950 mb-1">IIAV</div>
                </div>

                <!-- IAIAsa -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-full h-32 flex items-center justify-center mb-4 p-4">
                        @if(file_exists(public_path('images/accreditations/IAIAsa.png')))
                            <img src="{{ asset('images/accreditations/IAIAsa.png') }}" alt="IAIAsa" class="w-full h-full object-contain">
                        @else
                            <div class="text-sm font-bold text-zinc-700">IAIAsa</div>
                        @endif
                    </div>
                    <div class="font-bold text-zinc-950 mb-1">IAIAsa</div>
                    <p class="text-xs text-zinc-500">Impact Assessment</p>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                    <span>Get in Touch</span>
                    <x-solar-icon name="alt-arrow-right" size="24" />
                </a>
            </div>
        </div>
    </section>

    <!-- Our Approach / Methodology -->
    <section class="py-16 bg-zinc-900 text-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-white text-3xl md:text-4xl font-black mb-3">
                    Our Approach
                </h2>
                <p class="text-lg text-zinc-400 max-w-3xl mx-auto">
                    A systematic methodology ensuring comprehensive environmental management
                </p>
            </div>

            <!-- Methodology Flow -->
            <div class="relative">
                <!-- Desktop Flow -->
                <div class="hidden lg:flex items-center justify-between gap-4">
                    <div class="flex-1 text-center">
                        <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-black text-zinc-900">1</span>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Baseline</h3>
                        <p class="text-sm text-zinc-400">Environmental baseline studies & site characterisation</p>
                    </div>

                    <x-solar-icon name="arrow-right" size="32" class="text-green-500 flex-shrink-0" />

                    <div class="flex-1 text-center">
                        <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-black text-zinc-900">2</span>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Impact Assessment</h3>
                        <p class="text-sm text-zinc-400">Comprehensive environmental & social impact assessment</p>
                    </div>

                    <x-solar-icon name="arrow-right" size="32" class="text-green-500 flex-shrink-0" />

                    <div class="flex-1 text-center">
                        <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-black text-zinc-900">3</span>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Compliance</h3>
                        <p class="text-sm text-zinc-400">Regulatory compliance assessment & permitting</p>
                    </div>

                    <x-solar-icon name="arrow-right" size="32" class="text-green-500 flex-shrink-0" />

                    <div class="flex-1 text-center">
                        <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-black text-zinc-900">4</span>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Mitigation</h3>
                        <p class="text-sm text-zinc-400">Practical mitigation strategies & management plans</p>
                    </div>

                    <x-solar-icon name="arrow-right" size="32" class="text-green-500 flex-shrink-0" />

                    <div class="flex-1 text-center">
                        <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-black text-zinc-900">5</span>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Implementation</h3>
                        <p class="text-sm text-zinc-400">On-site support & implementation assistance</p>
                    </div>

                    <x-solar-icon name="arrow-right" size="32" class="text-green-500 flex-shrink-0" />

                    <div class="flex-1 text-center">
                        <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-black text-zinc-900">6</span>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Improvement</h3>
                        <p class="text-sm text-zinc-400">Continuous monitoring & adaptive management</p>
                    </div>
                </div>

                <!-- Mobile/Tablet Flow -->
                <div class="lg:hidden grid grid-cols-2 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-xl font-black text-zinc-900">1</span>
                        </div>
                        <h3 class="text-base font-bold text-white mb-1">Baseline</h3>
                        <p class="text-xs text-zinc-400">Environmental baseline studies</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-xl font-black text-zinc-900">2</span>
                        </div>
                        <h3 class="text-base font-bold text-white mb-1">Impact Assessment</h3>
                        <p class="text-xs text-zinc-400">Environmental & social impact</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-xl font-black text-zinc-900">3</span>
                        </div>
                        <h3 class="text-base font-bold text-white mb-1">Compliance</h3>
                        <p class="text-xs text-zinc-400">Regulatory assessment</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-xl font-black text-zinc-900">4</span>
                        </div>
                        <h3 class="text-base font-bold text-white mb-1">Mitigation</h3>
                        <p class="text-xs text-zinc-400">Mitigation strategies</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-xl font-black text-zinc-900">5</span>
                        </div>
                        <h3 class="text-base font-bold text-white mb-1">Implementation</h3>
                        <p class="text-xs text-zinc-400">On-site support</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-xl font-black text-zinc-900">6</span>
                        </div>
                        <h3 class="text-base font-bold text-white mb-1">Improvement</h3>
                        <p class="text-xs text-zinc-400">Continuous monitoring</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Work in Action -->
    <section class="py-16 bg-zinc-50">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-black text-zinc-950 mb-4">
                Our Work in <span class="text-green-500">Action</span>
            </h2>
            <p class="text-lg text-zinc-600 mb-8 max-w-2xl mx-auto">
                See our team in the field conducting environmental monitoring and assessments across South Africa.
            </p>
            <a href="{{ route('gallery') }}"
               class="inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-white bg-zinc-900 hover:bg-zinc-800 transition-all">
                <x-solar-icon name="gallery" size="24" />
                <span>View Gallery</span>
            </a>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-green-500">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <div>
                    <h2 class="text-3xl md:text-4xl font-black text-zinc-950 mb-2">
                        Ready to Work With Us?
                    </h2>
                    <p class="text-lg text-zinc-800">
                        Get expert environmental consulting from our team of registered professionals
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('contact') }}"
                       class="inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-white bg-zinc-900 hover:bg-zinc-800 transition-all">
                        <x-solar-icon name="chat-round-money" size="24" />
                        <span>Request a Quote</span>
                    </a>

                    <a href="tel:0114804822"
                       class="inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-zinc-950 bg-white hover:bg-zinc-100 transition-all">
                        <x-solar-icon name="phone-calling" size="24" />
                        <span>011 480 4822</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
