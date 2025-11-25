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
                            South Africa & SADC Region
                        </div>
                    </div>
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
                <div class="flex items-center gap-2 text-zinc-500">
                    <x-solar-icon name="copyright" size="16" />
                    <span>{{ date('Y') }} KMG Environmental Solutions. All rights reserved.</span>
                </div>
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-2 text-zinc-500">
                        <span>Built with</span>
                        <x-solar-icon name="heart" size="16" class="text-green-500" />
                        <span>in South Africa</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
