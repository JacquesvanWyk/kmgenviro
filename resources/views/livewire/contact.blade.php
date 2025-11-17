<?php

use function Livewire\Volt\{layout, title};

layout('components.layouts.public');
title('Contact Us | KMG Environmental Solutions');

?>

<div>
    <x-public.breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Contact']]" />
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold mb-6">Contact Us</h1>
            <p class="text-xl text-gray-600">Coming soon...</p>
        </div>
    </section>
</div>
