@php
use App\Models\ServiceCategory;

$topServices = ServiceCategory::where('is_active', true)
    ->orderBy('sort_order')
    ->limit(5)
    ->get();
@endphp

<footer class="bg-zinc-50 text-zinc-700 border-t border-zinc-200">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
            <!-- Column 1: Brand & Contact -->
            <div>
                <a href="{{ route('home') }}" class="inline-block mb-6 group">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="KMG Environmental Solutions Services"
                         class="h-16 w-auto transition-opacity group-hover:opacity-80">
                </a>

                <p class="text-sm text-zinc-600 mb-6 leading-relaxed">
                    Leading environmental consultancy providing expert solutions across South Africa and the SADC region.
                </p>

                <!-- Contact Info -->
                <div class="space-y-3 text-sm">
                    <div class="flex items-start gap-3">
                        <x-solar-icon name="phone-calling" size="20" class="text-green-500 flex-shrink-0 mt-0.5" />
                        <div>
                            <div class="text-zinc-950 font-semibold">011 969 6184</div>
                            <div class="text-zinc-500 text-xs">Mon - Fri, 8AM - 5PM</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <x-solar-icon name="letter" size="20" class="text-green-500 flex-shrink-0 mt-0.5" />
                        <a href="mailto:info@kmgenviro.co.za" class="text-zinc-600 hover:text-green-600 transition-colors">
                            info@kmgenviro.co.za
                        </a>
                    </div>
                    <div class="flex items-start gap-3">
                        <x-solar-icon name="map-point" size="20" class="text-green-500 flex-shrink-0 mt-0.5" />
                        <div class="text-zinc-600">
                            Gauteng, South Africa<br>
                            <span class="text-zinc-500 text-xs">Serving all 9 provinces & SADC</span>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="flex items-center gap-4 mt-6">
                    <a href="https://wa.me/27119696184" target="_blank" class="text-zinc-400 hover:text-green-500 transition-colors" title="WhatsApp">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/company/kmg-environmental" target="_blank" class="text-zinc-400 hover:text-green-500 transition-colors" title="LinkedIn">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/kmgenviro" target="_blank" class="text-zinc-400 hover:text-green-500 transition-colors" title="Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div>
                <h3 class="text-zinc-950 font-bold text-lg mb-6 border-l-4 border-green-500 pl-4">Quick Links</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home') }}" class="flex items-center gap-2 text-zinc-600 hover:text-green-600 transition-colors group">
                            <x-solar-icon name="alt-arrow-right" size="16" class="group-hover:translate-x-1 transition-transform" />
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="flex items-center gap-2 text-zinc-600 hover:text-green-600 transition-colors group">
                            <x-solar-icon name="alt-arrow-right" size="16" class="group-hover:translate-x-1 transition-transform" />
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services.index') }}" class="flex items-center gap-2 text-zinc-600 hover:text-green-600 transition-colors group">
                            <x-solar-icon name="alt-arrow-right" size="16" class="group-hover:translate-x-1 transition-transform" />
                            Services
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('training.index') }}" class="flex items-center gap-2 text-zinc-600 hover:text-green-600 transition-colors group">
                            <x-solar-icon name="alt-arrow-right" size="16" class="group-hover:translate-x-1 transition-transform" />
                            Training
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('equipment.index') }}" class="flex items-center gap-2 text-zinc-600 hover:text-green-600 transition-colors group">
                            <x-solar-icon name="alt-arrow-right" size="16" class="group-hover:translate-x-1 transition-transform" />
                            Equipment Rental
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="flex items-center gap-2 text-zinc-600 hover:text-green-600 transition-colors group">
                            <x-solar-icon name="alt-arrow-right" size="16" class="group-hover:translate-x-1 transition-transform" />
                            Contact
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 3: Top Services -->
            <div>
                <h3 class="text-zinc-950 font-bold text-lg mb-6 border-l-4 border-green-500 pl-4">Top Services</h3>
                <ul class="space-y-3">
                    @foreach($topServices as $service)
                        <li>
                            <a href="{{ route('services.index') }}#category-{{ $service->slug }}"
                               class="flex items-center gap-2 text-zinc-600 hover:text-green-600 transition-colors group">
                                <x-solar-icon name="alt-arrow-right" size="16" class="group-hover:translate-x-1 transition-transform" />
                                {{ Str::limit($service->name, 30) }}
                            </a>
                        </li>
                    @endforeach
                    @if($topServices->count() > 0)
                        <li class="pt-2">
                            <a href="{{ route('services.index') }}"
                               class="inline-flex items-center gap-2 text-green-500 hover:text-green-600 font-semibold transition-colors group">
                                <span>View All Services</span>
                                <x-solar-icon name="arrow-right" size="16" class="group-hover:translate-x-1 transition-transform" />
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- Column 4: Accreditations & Certifications -->
            <div>
                <h3 class="text-zinc-950 font-bold text-lg mb-6 border-l-4 border-green-500 pl-4">Accreditations</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2">
                        <x-solar-icon name="verified-check" size="16" class="text-green-500 flex-shrink-0 mt-0.5" />
                        <span class="text-zinc-600">DoEL Approved Asbestos Contractor</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <x-solar-icon name="verified-check" size="16" class="text-green-500 flex-shrink-0 mt-0.5" />
                        <span class="text-zinc-600">SACNASP Registered Professionals</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <x-solar-icon name="verified-check" size="16" class="text-green-500 flex-shrink-0 mt-0.5" />
                        <span class="text-zinc-600">EAPASA Accredited Training Provider</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <x-solar-icon name="verified-check" size="16" class="text-green-500 flex-shrink-0 mt-0.5" />
                        <span class="text-zinc-600">GBCSA Professional Member</span>
                    </li>
                </ul>

                <a href="{{ route('accreditations') }}"
                   class="inline-flex items-center gap-2 text-green-500 hover:text-green-600 font-semibold transition-colors group mt-6">
                    <span>View All</span>
                    <x-solar-icon name="arrow-right" size="16" class="group-hover:translate-x-1 transition-transform" />
                </a>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-zinc-200 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm">
                <div class="text-zinc-500 text-center md:text-left">
                    <div class="flex items-center gap-2 justify-center md:justify-start mb-1">
                        <x-solar-icon name="copyright" size="16" />
                        <span>{{ date('Y') }} KMG Environmental Solutions (Pty) Ltd. All rights reserved.</span>
                    </div>
                    <div class="text-xs text-zinc-400">
                        Registration No: 2008/014273/07 | VAT No: 4350263982 | B-BBEE Level 2
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <a href="{{ route('contact') }}" class="text-zinc-500 hover:text-green-500 transition-colors">Contact</a>
                    <span class="text-zinc-300">|</span>
                    <div class="flex items-center gap-2 text-zinc-500">
                        <span>Proudly</span>
                        <x-solar-icon name="flag" size="16" class="text-green-500" />
                        <span>South African</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
