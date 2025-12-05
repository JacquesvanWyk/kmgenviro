<?php

use function Livewire\Volt\{computed, layout, state, title, rules};
use App\Models\{TrainingCourse, TrainingSchedule, TrainingBooking};
use Illuminate\Support\Carbon;

layout('components.layouts.public');
title('Training & Events | Accredited Environmental Training | KMG');

state([
    'activeCategory' => 'all',
    'showBookingForm' => false,
    'selectedCourse' => null,
    'selectedSchedule' => null,
    // Booking form fields
    'bookingName' => '',
    'bookingEmail' => '',
    'bookingPhone' => '',
    'bookingCompany' => '',
    'bookingCourseId' => '',
    'bookingScheduleId' => '',
    'bookingPreferredDate' => '',
    'bookingDelegates' => 1,
    'bookingDelegateNames' => '',
    'bookingSpecialRequirements' => '',
    'bookingPaymentMethod' => 'invoice',
    'bookingSubmitted' => false,
]);

$courses = computed(fn() =>
    TrainingCourse::where('is_active', true)
        ->with(['trainingSchedules' => fn($q) => $q->where('is_active', true)->where('start_date', '>=', now())->orderBy('start_date')])
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get()
);

$upcomingSchedules = computed(fn() =>
    TrainingSchedule::where('is_active', true)
        ->where('start_date', '>=', now())
        ->with('trainingCourse')
        ->orderBy('start_date')
        ->limit(10)
        ->get()
);

$courseCategories = computed(fn() => [
    'environmental' => [
        'name' => 'Environmental Training',
        'icon' => 'leaf',
        'color' => 'bg-green-500',
        'keywords' => ['environmental', 'eia', 'impact', 'assessment'],
    ],
    'waste' => [
        'name' => 'Waste & Asbestos Training',
        'icon' => 'trash-bin-minimalistic',
        'color' => 'bg-orange-500',
        'keywords' => ['waste', 'asbestos', 'hazardous'],
    ],
    'ohs' => [
        'name' => 'Occupational Hygiene & OHS',
        'icon' => 'shield-user',
        'color' => 'bg-red-500',
        'keywords' => ['safety', 'health', 'hygiene', 'ohs', 'occupational'],
    ],
    'esg' => [
        'name' => 'ESG & Sustainability',
        'icon' => 'chart-2',
        'color' => 'bg-blue-500',
        'keywords' => ['esg', 'sustainability', 'carbon', 'climate'],
    ],
    'graduate' => [
        'name' => 'Student & Graduate Programmes',
        'icon' => 'graduation-cap',
        'color' => 'bg-purple-500',
        'keywords' => ['student', 'graduate', 'intern', 'mentorship'],
    ],
]);

$submitBooking = function () {
    $this->validate([
        'bookingName' => 'required|string|max:255',
        'bookingEmail' => 'required|email|max:255',
        'bookingPhone' => 'required|string|max:20',
        'bookingCompany' => 'nullable|string|max:255',
        'bookingCourseId' => 'required|exists:training_courses,id',
        'bookingDelegates' => 'required|integer|min:1|max:20',
        'bookingPaymentMethod' => 'required|in:invoice,eft',
    ]);

    TrainingBooking::create([
        'training_course_id' => $this->bookingCourseId,
        'training_schedule_id' => $this->bookingScheduleId ?: null,
        'name' => $this->bookingName,
        'email' => $this->bookingEmail,
        'phone' => $this->bookingPhone,
        'company' => $this->bookingCompany,
        'number_of_delegates' => $this->bookingDelegates,
        'delegate_names' => $this->bookingDelegateNames,
        'special_requirements' => $this->bookingSpecialRequirements,
        'preferred_date' => $this->bookingPreferredDate ?: null,
        'status' => 'pending',
        'notes' => 'Payment method: ' . $this->bookingPaymentMethod,
    ]);

    $this->bookingSubmitted = true;
    $this->reset(['bookingName', 'bookingEmail', 'bookingPhone', 'bookingCompany', 'bookingCourseId', 'bookingScheduleId', 'bookingPreferredDate', 'bookingDelegates', 'bookingDelegateNames', 'bookingSpecialRequirements']);
};

$openBookingForm = function ($courseId = null, $scheduleId = null) {
    $this->bookingCourseId = $courseId;
    $this->bookingScheduleId = $scheduleId;

    if ($scheduleId) {
        $schedule = TrainingSchedule::find($scheduleId);
        if ($schedule) {
            $this->bookingPreferredDate = $schedule->start_date->format('Y-m-d');
        }
    }

    $this->showBookingForm = true;
    $this->bookingSubmitted = false;
};

?>

<div x-data="{ activeCategory: @entangle('activeCategory'), showBookingForm: @entangle('showBookingForm') }">
    <!-- Hero Section -->
    <section class="relative py-24 bg-zinc-900 overflow-hidden">
        @if(file_exists(public_path('images/gallery/training-session.jpg')))
            <img src="{{ asset('images/gallery/training-session.jpg') }}"
                 alt="KMG Training Session"
                 class="absolute inset-0 w-full h-full object-cover opacity-30">
        @endif
        <div class="absolute inset-0 bg-gradient-to-b from-zinc-900/80 to-zinc-900/95"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4">
            <x-public.breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Training']
            ]" class="mb-8" />

            <div class="max-w-4xl">
                <h1 class="text-5xl md:text-6xl font-black text-white mb-6">
                    Training & <span class="text-green-500">Events</span>
                </h1>
                <p class="text-xl text-zinc-300 leading-relaxed mb-8">
                    KMG is a SACNASP & EAPASA accredited training provider, delivering practical environmental and occupational health training to professionals across South Africa. Our courses combine regulatory knowledge with hands-on field experience.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="#upcoming"
                       class="inline-flex items-center gap-3 px-6 py-3 bg-green-500 hover:bg-green-400 text-zinc-950 font-bold transition-all">
                        <x-solar-icon name="calendar" size="20" />
                        View Upcoming Courses
                    </a>
                    <button @click="showBookingForm = true; $dispatch('scroll-to-booking')"
                            class="inline-flex items-center gap-3 px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-bold transition-all border border-white/20">
                        <x-solar-icon name="clipboard-list" size="20" />
                        Book Training
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Accreditation Badges -->
    <section class="py-8 bg-zinc-100 border-b border-zinc-200">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-wrap items-center justify-center gap-8 md:gap-16">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                        <x-solar-icon name="diploma-verified" size="24" class="text-white" />
                    </div>
                    <div>
                        <div class="font-bold text-zinc-950">SACNASP</div>
                        <div class="text-sm text-zinc-500">Accredited Provider</div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                        <x-solar-icon name="diploma-verified" size="24" class="text-white" />
                    </div>
                    <div>
                        <div class="font-bold text-zinc-950">EAPASA</div>
                        <div class="text-sm text-zinc-500">CPD Points Accredited</div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center">
                        <x-solar-icon name="users-group-rounded" size="24" class="text-white" />
                    </div>
                    <div>
                        <div class="font-bold text-zinc-950">500+</div>
                        <div class="text-sm text-zinc-500">Delegates Trained</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Training Overview - Compact -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="flex items-center gap-3 p-4 bg-zinc-50">
                    <x-solar-icon name="user-check-rounded" size="24" class="text-green-500" />
                    <div>
                        <div class="font-bold text-zinc-950 text-sm">Expert Instructors</div>
                        <div class="text-xs text-zinc-500">15+ years experience</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-4 bg-zinc-50">
                    <x-solar-icon name="map-point" size="24" class="text-green-500" />
                    <div>
                        <div class="font-bold text-zinc-950 text-sm">Field-Based</div>
                        <div class="text-xs text-zinc-500">Practical learning</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-4 bg-zinc-50">
                    <x-solar-icon name="diploma" size="24" class="text-green-500" />
                    <div>
                        <div class="font-bold text-zinc-950 text-sm">CPD Points</div>
                        <div class="text-xs text-zinc-500">EAPASA accredited</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-4 bg-zinc-50">
                    <x-solar-icon name="buildings" size="24" class="text-green-500" />
                    <div>
                        <div class="font-bold text-zinc-950 text-sm">On-Site Training</div>
                        <div class="text-xs text-zinc-500">Teams of 10+</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Training Calendar -->
    <section id="upcoming" class="py-12 bg-zinc-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-black text-zinc-950 mb-2">
                    Upcoming Training
                </h2>
                <p class="text-zinc-600">
                    Browse scheduled sessions and book your spot
                </p>
            </div>

            <!-- Special Sessions Notice -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 text-sm">
                    <div class="flex items-center gap-2">
                        <x-solar-icon name="calendar-add" size="20" class="text-green-600" />
                        <span class="text-zinc-700"><strong>Special Sessions:</strong> Can be arranged with the admin team at <a href="mailto:bookings@kmgenviro.co.za" class="text-green-600 font-semibold hover:underline">bookings@kmgenviro.co.za</a></span>
                    </div>
                    <div class="hidden sm:block w-px h-6 bg-green-300"></div>
                    <div class="flex items-center gap-2">
                        <x-solar-icon name="square-academic-cap" size="20" class="text-green-600" />
                        <span class="text-zinc-700"><strong>Universities:</strong> Can arrange suitable dates for sessions</span>
                    </div>
                </div>
            </div>

            @if($this->upcomingSchedules->count() > 0)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-zinc-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-zinc-950">Course</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-zinc-950">Date</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-zinc-950">Location</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-zinc-950">Price</th>
                                    <th class="px-6 py-4 text-left text-sm font-bold text-zinc-950">Availability</th>
                                    <th class="px-6 py-4 text-right text-sm font-bold text-zinc-950">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100">
                                @foreach($this->upcomingSchedules as $schedule)
                                    <tr class="hover:bg-zinc-50">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-zinc-950">{{ $schedule->trainingCourse->name }}</div>
                                            <div class="text-sm text-zinc-500">{{ $schedule->trainingCourse->duration }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($schedule->end_date && $schedule->end_date != $schedule->start_date)
                                                <div class="font-medium text-zinc-950">{{ Carbon::parse($schedule->start_date)->format('d') }}-{{ Carbon::parse($schedule->end_date)->format('d M Y') }}</div>
                                            @else
                                                <div class="font-medium text-zinc-950">{{ Carbon::parse($schedule->start_date)->format('d M Y') }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($schedule->is_online)
                                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 text-blue-700 text-sm rounded-full">
                                                    <x-solar-icon name="monitor" size="14" />
                                                    Online
                                                </span>
                                            @else
                                                <span class="text-zinc-700">{{ $schedule->location }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $price = $schedule->price_override ?? $schedule->trainingCourse->price;
                                            @endphp
                                            @if($price)
                                                <span class="font-bold text-green-600">R {{ number_format($price, 0) }}</span>
                                                <span class="text-sm text-zinc-500">pp</span>
                                            @else
                                                <span class="text-zinc-500">Contact us</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($schedule->available_seats > 5)
                                                <span class="text-green-600 font-medium">{{ $schedule->available_seats }} seats</span>
                                            @elseif($schedule->available_seats > 0)
                                                <span class="text-orange-600 font-medium">{{ $schedule->available_seats }} left</span>
                                            @else
                                                <span class="text-red-600 font-medium">Fully booked</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if($schedule->available_seats > 0)
                                                <button wire:click="openBookingForm({{ $schedule->training_course_id }}, {{ $schedule->id }})"
                                                        class="px-4 py-2 bg-green-500 hover:bg-green-400 text-zinc-950 font-bold text-sm transition-all">
                                                    Book Now
                                                </button>
                                            @else
                                                <button wire:click="openBookingForm({{ $schedule->training_course_id }})"
                                                        class="px-4 py-2 bg-zinc-200 hover:bg-zinc-300 text-zinc-700 font-bold text-sm transition-all">
                                                    Join Waitlist
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- No scheduled sessions - show courses with enquiry option -->
                <div class="bg-white rounded-lg p-8 text-center">
                    <x-solar-icon name="calendar" size="64" class="text-zinc-300 mx-auto mb-4" />
                    <h3 class="text-xl font-bold text-zinc-950 mb-2">No Public Sessions Currently Scheduled</h3>
                    <p class="text-zinc-600 mb-6 max-w-lg mx-auto">
                        We run training on demand for groups of 5 or more. Contact us to schedule a session or register your interest in upcoming courses.
                    </p>
                    <button @click="showBookingForm = true"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-green-500 hover:bg-green-400 text-zinc-950 font-bold transition-all">
                        <x-solar-icon name="pen-new-square" size="20" />
                        Register Interest
                    </button>
                </div>
            @endif
        </div>
    </section>

    <!-- Course Categories -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-black text-zinc-950 mb-2">
                    Course Categories
                </h2>
                <p class="text-zinc-600">
                    Browse our training offerings by category
                </p>
            </div>

            <!-- Category Filter Tabs -->
            <div class="flex flex-wrap justify-center gap-2 mb-8">
                <button @click="activeCategory = 'all'"
                        :class="activeCategory === 'all' ? 'bg-green-500 text-zinc-950' : 'bg-zinc-100 text-zinc-700 hover:bg-zinc-200'"
                        class="px-5 py-2 font-semibold transition-colors rounded-full">
                    All Courses
                </button>
                @foreach($this->courseCategories as $key => $category)
                    <button @click="activeCategory = '{{ $key }}'"
                            :class="activeCategory === '{{ $key }}' ? '{{ $category['color'] }} text-white' : 'bg-zinc-100 text-zinc-700 hover:bg-zinc-200'"
                            class="px-5 py-2 font-semibold transition-colors rounded-full">
                        {{ $category['name'] }}
                    </button>
                @endforeach
            </div>

            <!-- Courses Grid -->
            @if($this->courses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($this->courses as $course)
                        <div x-show="activeCategory === 'all' ||
                            @php
                                $courseSlug = strtolower($course->name . ' ' . ($course->short_description ?? ''));
                                $categoryMatches = [];
                                foreach($this->courseCategories as $key => $cat) {
                                    foreach($cat['keywords'] as $keyword) {
                                        if(str_contains($courseSlug, $keyword)) {
                                            $categoryMatches[] = $key;
                                            break;
                                        }
                                    }
                                }
                                echo "['". implode("','", array_unique($categoryMatches)) ."'].includes(activeCategory)";
                            @endphp"
                             x-transition
                             class="bg-white border border-zinc-200 rounded-lg overflow-hidden hover:shadow-lg hover:border-green-500 transition-all flex flex-col">

                            @if($course->thumbnail)
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ Storage::url($course->thumbnail) }}"
                                         alt="{{ $course->name }}"
                                         class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="h-48 bg-gradient-to-br from-green-600 to-green-800 flex items-center justify-center">
                                    <x-solar-icon name="graduation-cap" size="64" class="text-white/50" />
                                </div>
                            @endif

                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="text-xl font-bold text-zinc-950 mb-2">{{ $course->name }}</h3>

                                @if($course->short_description)
                                    <p class="text-zinc-600 text-sm mb-4 flex-grow line-clamp-3">
                                        {{ $course->short_description }}
                                    </p>
                                @endif

                                <div class="space-y-2 mb-4">
                                    @if($course->duration)
                                        <div class="flex items-center gap-2 text-sm text-zinc-600">
                                            <x-solar-icon name="clock-circle" size="16" class="text-green-500" />
                                            <span>{{ $course->duration }}</span>
                                        </div>
                                    @endif

                                    @if($course->accreditation)
                                        <div class="flex items-center gap-2 text-sm text-zinc-600">
                                            <x-solar-icon name="diploma-verified" size="16" class="text-green-500" />
                                            <span>{{ $course->accreditation }}</span>
                                        </div>
                                    @endif

                                    @if($course->price)
                                        <div class="flex items-center gap-2">
                                            <x-solar-icon name="tag-price" size="16" class="text-green-500" />
                                            <span class="text-lg font-bold text-green-600">R {{ number_format($course->price, 0) }}</span>
                                            <span class="text-sm text-zinc-500">per delegate</span>
                                        </div>
                                    @endif

                                    @if($course->trainingSchedules->count() > 0)
                                        <div class="flex items-center gap-2 text-sm text-blue-600">
                                            <x-solar-icon name="calendar-mark" size="16" />
                                            <span>{{ $course->trainingSchedules->count() }} upcoming {{ Str::plural('session', $course->trainingSchedules->count()) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-auto flex gap-3">
                                    <a href="{{ route('training.show', $course) }}"
                                       class="flex-1 px-4 py-2 text-center font-semibold text-zinc-700 bg-zinc-100 hover:bg-zinc-200 transition-colors">
                                        View Details
                                    </a>
                                    <button wire:click="openBookingForm({{ $course->id }})"
                                            class="flex-1 px-4 py-2 text-center font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-colors">
                                        Book Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-zinc-50 rounded-lg">
                    <x-solar-icon name="graduation-cap" size="64" class="text-zinc-300 mx-auto mb-4" />
                    <p class="text-zinc-500">No courses available at this time.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Booking Form Modal -->
    <div x-show="showBookingForm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 bg-zinc-900/75" @click="showBookingForm = false"></div>

            <div x-show="showBookingForm"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto overflow-hidden">

                <!-- Modal Header -->
                <div class="bg-green-500 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-zinc-950">Book Training</h3>
                        <button @click="showBookingForm = false" class="text-zinc-950/70 hover:text-zinc-950">
                            <x-solar-icon name="close-circle" size="24" />
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6 max-h-[70vh] overflow-y-auto">
                    @if($bookingSubmitted)
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <x-solar-icon name="check-circle" size="40" class="text-green-600" />
                            </div>
                            <h4 class="text-2xl font-bold text-zinc-950 mb-2">Booking Request Submitted!</h4>
                            <p class="text-zinc-600 mb-6">
                                Thank you for your interest. Our training team will contact you within 24 hours to confirm your booking and provide payment details.
                            </p>
                            <button @click="showBookingForm = false"
                                    class="px-6 py-3 bg-green-500 hover:bg-green-400 text-zinc-950 font-bold transition-all">
                                Close
                            </button>
                        </div>
                    @else
                        <form wire:submit="submitBooking" class="space-y-6">
                            <!-- Contact Details -->
                            <div>
                                <h4 class="font-bold text-zinc-950 mb-4 flex items-center gap-2">
                                    <x-solar-icon name="user" size="20" class="text-green-500" />
                                    Contact Details
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Full Name *</label>
                                        <input type="text" wire:model="bookingName" required
                                               class="w-full px-4 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        @error('bookingName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Email Address *</label>
                                        <input type="email" wire:model="bookingEmail" required
                                               class="w-full px-4 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        @error('bookingEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Phone Number *</label>
                                        <input type="tel" wire:model="bookingPhone" required
                                               class="w-full px-4 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        @error('bookingPhone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Organisation</label>
                                        <input type="text" wire:model="bookingCompany"
                                               class="w-full px-4 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Course Selection -->
                            <div>
                                <h4 class="font-bold text-zinc-950 mb-4 flex items-center gap-2">
                                    <x-solar-icon name="graduation-cap" size="20" class="text-green-500" />
                                    Course Selection
                                </h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Select Course *</label>
                                        <select wire:model="bookingCourseId" required
                                                class="w-full px-4 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                            <option value="">-- Select a course --</option>
                                            @foreach($this->courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('bookingCourseId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Preferred Date</label>
                                        <input type="date" wire:model="bookingPreferredDate"
                                               class="w-full px-4 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        <p class="text-xs text-zinc-500 mt-1">Leave blank if flexible on dates</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Delegates -->
                            <div>
                                <h4 class="font-bold text-zinc-950 mb-4 flex items-center gap-2">
                                    <x-solar-icon name="users-group-rounded" size="20" class="text-green-500" />
                                    Delegates
                                </h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Number of Delegates *</label>
                                        <input type="number" wire:model="bookingDelegates" min="1" max="20" required
                                               class="w-full px-4 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                        @error('bookingDelegates') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Delegate Names (if known)</label>
                                        <textarea wire:model="bookingDelegateNames" rows="2"
                                                  placeholder="Enter names separated by commas"
                                                  class="w-full px-4 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 mb-1">Special Requirements / Dietary Needs</label>
                                        <textarea wire:model="bookingSpecialRequirements" rows="2"
                                                  class="w-full px-4 py-2 border border-zinc-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <h4 class="font-bold text-zinc-950 mb-4 flex items-center gap-2">
                                    <x-solar-icon name="wallet" size="20" class="text-green-500" />
                                    Payment Method
                                </h4>
                                <div class="space-y-2">
                                    <label class="flex items-center gap-3 p-3 border border-zinc-200 rounded-lg cursor-pointer hover:border-green-500 transition-colors">
                                        <input type="radio" wire:model="bookingPaymentMethod" value="invoice" class="text-green-500 focus:ring-green-500">
                                        <div>
                                            <span class="font-medium text-zinc-950">Request Invoice</span>
                                            <span class="text-sm text-zinc-500 block">We'll send a tax invoice for payment</span>
                                        </div>
                                    </label>
                                    <label class="flex items-center gap-3 p-3 border border-zinc-200 rounded-lg cursor-pointer hover:border-green-500 transition-colors">
                                        <input type="radio" wire:model="bookingPaymentMethod" value="eft" class="text-green-500 focus:ring-green-500">
                                        <div>
                                            <span class="font-medium text-zinc-950">EFT / Bank Transfer</span>
                                            <span class="text-sm text-zinc-500 block">We'll send banking details</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="pt-4 border-t border-zinc-200">
                                <button type="submit"
                                        class="w-full px-6 py-4 bg-green-500 hover:bg-green-400 text-zinc-950 font-bold text-lg transition-all flex items-center justify-center gap-2">
                                    <x-solar-icon name="check-circle" size="24" />
                                    Submit Booking Request
                                </button>
                                <p class="text-xs text-zinc-500 text-center mt-3">
                                    By submitting, you agree to be contacted about this training enquiry.
                                </p>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Download Prospectus CTA -->
    <section class="py-12 bg-zinc-900 text-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-2xl md:text-3xl font-black text-white mb-3">
                Download Our <span class="text-green-500">Training Prospectus</span>
            </h2>
            <p class="text-zinc-400 mb-6">
                Complete course catalogue with outlines, pricing, and CPD information.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}?subject=Training%20Prospectus%20Request"
                   class="inline-flex items-center justify-center gap-2 px-8 py-3 font-bold text-zinc-950 bg-green-500 hover:bg-green-400 transition-all">
                    <x-solar-icon name="download-minimalistic" size="20" />
                    Download Prospectus
                </a>
                <a href="mailto:marabekg@kmgenviro.co.za?subject=Custom%20Training%20Request"
                   class="inline-flex items-center justify-center gap-2 px-8 py-3 font-bold text-white bg-white/10 hover:bg-white/20 border border-white/20 transition-all">
                    <x-solar-icon name="chat-round-dots" size="20" />
                    Request Custom Training
                </a>
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="py-12 bg-zinc-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-white p-6 md:p-8 shadow-sm border border-zinc-100">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h2 class="text-2xl font-black text-zinc-950 mb-2">
                            Need Custom Training?
                        </h2>
                        <p class="text-zinc-600">
                            On-site training for teams of 10+, customised to your industry and compliance requirements.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 items-center">
                        <a href="tel:0114804822" class="text-2xl font-black text-green-600 hover:text-green-700 transition-colors whitespace-nowrap">
                            011 480 4822
                        </a>
                        <a href="mailto:marabekg@kmgenviro.co.za"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-green-500 hover:bg-green-400 text-zinc-950 font-bold transition-all whitespace-nowrap">
                            <x-solar-icon name="letter" size="20" />
                            marabekg@kmgenviro.co.za
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
