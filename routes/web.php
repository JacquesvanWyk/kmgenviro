<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

// Public Routes
Volt::route('/', 'home')->name('home');
Volt::route('/about', 'about')->name('about');
Volt::route('/team', 'team')->name('team');
Volt::route('/accreditations', 'accreditations')->name('accreditations');

Volt::route('/services', 'services.index')->name('services.index');
Volt::route('/services/category/{category:slug}', 'services.category')->name('services.category');
Volt::route('/services/{service:slug}', 'services.show')->name('services.show');

Volt::route('/sectors', 'sectors.index')->name('sectors.index');
Volt::route('/projects', 'projects.index')->name('projects.index');
Volt::route('/projects/{project:slug}', 'projects.show')->name('projects.show');

Volt::route('/training', 'training.index')->name('training.index');
Volt::route('/training/{course:slug}', 'training.show')->name('training.show');

Volt::route('/equipment', 'equipment.index')->name('equipment.index');
Volt::route('/equipment/{equipment:slug}', 'equipment.show')->name('equipment.show');

Volt::route('/blog', 'blog.index')->name('blog.index');
Volt::route('/blog/{post:slug}', 'blog.show')->name('blog.show');

Volt::route('/resources', 'resources')->name('resources');
Volt::route('/gallery', 'gallery')->name('gallery');
Volt::route('/contact', 'contact')->name('contact');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
