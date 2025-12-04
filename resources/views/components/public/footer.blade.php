@php
use App\Models\ServiceCategory;

$topServices = ServiceCategory::where('is_active', true)
    ->orderBy('sort_order')
    ->limit(5)
    ->get();
@endphp

<footer class="bg-zinc-800 text-zinc-300 relative overflow-hidden">
    <!-- Subtle pattern overlay -->
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="footer-pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M0 20h40M20 0v40" stroke="currentColor" stroke-width="0.5" fill="none" class="text-white"/>
                    <circle cx="20" cy="20" r="1" fill="currentColor" class="text-white"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#footer-pattern)"/>
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-16 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
            <!-- Column 1: Brand & Contact -->
            <div>
                <a href="{{ route('home') }}" class="inline-block mb-6 group">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="KMG Environmental Solutions Services"
                         class="h-16 w-auto transition-opacity group-hover:opacity-80 brightness-0 invert">
                </a>

                <p class="text-sm text-zinc-400 mb-6 leading-relaxed">
                    Leading environmental consultancy providing expert solutions across South Africa and the SADC region.
                </p>

                <!-- Contact Info -->
                <div class="space-y-3 text-sm">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <div>
                            <div class="text-white font-semibold">011 480 4822</div>
                            <div class="text-zinc-400">072 546 3191</div>
                            <div class="text-zinc-500 text-xs">Mon - Fri, 8AM - 5PM</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <a href="mailto:info@kmgenviro.co.za" class="text-zinc-300 hover:text-green-400 transition-colors block">
                                info@kmgenviro.co.za
                            </a>
                            <a href="mailto:marabekg@kmgenviro.co.za" class="text-zinc-400 hover:text-green-400 transition-colors block text-xs">
                                marabekg@kmgenviro.co.za
                            </a>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div class="text-zinc-400">
                            08 Hillside Road, Metropolitan Building,<br>
                            1st Floor B, Parktown, Johannesburg, 2193<br>
                            <span class="text-zinc-500 text-xs">Serving all 9 provinces & SADC</span>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="flex items-center gap-4 mt-6">
                    <a href="https://wa.me/+27725463191" target="_blank" class="text-zinc-500 hover:text-green-500 transition-colors" title="WhatsApp">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/company/53420196" target="_blank" class="text-zinc-500 hover:text-green-500 transition-colors" title="LinkedIn">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/kmgenviro" target="_blank" class="text-zinc-500 hover:text-green-500 transition-colors" title="Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div>
                <h3 class="text-white font-bold text-lg mb-6 border-l-4 border-green-500 pl-4">Quick Links</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home') }}" class="flex items-center gap-2 text-zinc-400 hover:text-green-400 transition-colors group">
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="flex items-center gap-2 text-zinc-400 hover:text-green-400 transition-colors group">
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services.index') }}" class="flex items-center gap-2 text-zinc-400 hover:text-green-400 transition-colors group">
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                            Services
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('training.index') }}" class="flex items-center gap-2 text-zinc-400 hover:text-green-400 transition-colors group">
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                            Training
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('equipment.index') }}" class="flex items-center gap-2 text-zinc-400 hover:text-green-400 transition-colors group">
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                            Equipment Rental
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="flex items-center gap-2 text-zinc-400 hover:text-green-400 transition-colors group">
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                            Contact
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 3: Top Services -->
            <div>
                <h3 class="text-white font-bold text-lg mb-6 border-l-4 border-green-500 pl-4">Top Services</h3>
                <ul class="space-y-3">
                    @foreach($topServices as $service)
                        <li>
                            <a href="{{ route('services.index') }}#category-{{ $service->slug }}"
                               class="flex items-center gap-2 text-zinc-400 hover:text-green-400 transition-colors group">
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                                {{ Str::limit($service->name, 30) }}
                            </a>
                        </li>
                    @endforeach
                    @if($topServices->count() > 0)
                        <li class="pt-2">
                            <a href="{{ route('services.index') }}"
                               class="inline-flex items-center gap-2 text-green-500 hover:text-green-400 font-semibold transition-colors group">
                                <span>View All Services</span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- Column 4: Accreditations & Certifications -->
            <div>
                <h3 class="text-white font-bold text-lg mb-6 border-l-4 border-green-500 pl-4">Accreditations</h3>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-zinc-400">DoEL Approved</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-zinc-400">SACNASP Registered</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-zinc-400">EAPASA Accredited</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-zinc-400">GBCSA Member</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-zinc-400">WISA Member</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-zinc-400">IIAV (Int'l Institute of Acoustics & Vibration)</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-zinc-400">IAIAsa Member</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-zinc-700 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm">
                <div class="text-zinc-500 text-center md:text-left">
                    <div class="flex items-center gap-2 justify-center md:justify-start mb-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>&copy; {{ date('Y') }} KMG Environmental Solutions (Pty) Ltd. All rights reserved.</span>
                    </div>
                    <div class="text-xs text-zinc-600">
                        Registration No: 2008/014273/07 | VAT No: 4350263982 | B-BBEE Level 2
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <a href="{{ route('contact') }}" class="text-zinc-500 hover:text-green-400 transition-colors">Contact</a>
                    <span class="text-zinc-600">|</span>
                    <div class="flex items-center gap-2 text-zinc-500">
                        <span>Proudly</span>
                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                        <span>South African</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
