<?php

use function Livewire\Volt\{computed, layout, title};
use App\Models\TeamMember;

layout('components.layouts.public');
title('Our Team | KMG Environmental Solutions');

$members = computed(fn() =>
    TeamMember::where('is_active', true)
        ->orderBy('sort_order')
        ->orderBy('name')
        ->paginate(12)
);

?>

<div>
    <x-public.breadcrumb :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Our Team']
    ]" />

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-5xl font-bold mb-6 text-gray-900">Our Team</h1>
            <p class="text-xl text-gray-600 mb-12 max-w-3xl">
                Meet our team of dedicated environmental professionals committed to delivering
                sustainable solutions across South Africa.
            </p>

            @if($this->members->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($this->members as $member)
                        <x-public.team-member-card :member="$member" />
                    @endforeach
                </div>

                @if($this->members->hasPages())
                    <div class="mt-12">
                        {{ $this->members->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <p class="text-gray-600 text-lg">No team members available at this time.</p>
                </div>
            @endif
        </div>
    </section>
</div>
