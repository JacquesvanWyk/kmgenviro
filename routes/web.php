<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

// Public Routes
Volt::route('/', 'home')->name('home');
Volt::route('/about', 'about')->name('about');

Volt::route('/services', 'services.index')->name('services.index');
Volt::route('/services/category/{category:slug}', 'services.category')->name('services.category');
Volt::route('/services/{service:slug}', 'services.show')->name('services.show');

Volt::route('/sectors', 'sectors.index')->name('sectors.index');
Volt::route('/projects', 'projects.index')->name('projects.index');
Volt::route('/projects/{project:slug}', 'projects.show')->name('projects.show');

Volt::route('/training', 'training.index')->name('training.index');
Volt::route('/training/{course:slug}', 'training.show')->name('training.show');

Volt::route('/equipment', 'equipment.index')->name('equipment.index');

Volt::route('/blog', 'blog.index')->name('blog.index');
Volt::route('/blog/{post:slug}', 'blog.show')->name('blog.show');

Volt::route('/resources', 'resources')->name('resources');
Volt::route('/gallery', 'gallery')->name('gallery');
Volt::route('/contact', 'contact')->name('contact');

// PDF Downloads
Route::get('/download/company-profile', function () {
    $pdf = Pdf::loadView('pdf.company-profile');
    $pdf->setPaper('a4', 'portrait');

    return $pdf->download('KMG-Enviro-Company-Profile.pdf');
})->name('download.company-profile');

// PDF Design Previews (temporary routes for design selection)
Route::get('/preview/company-profile/{design?}', function (?string $design = null) {
    $view = match ($design) {
        'brutalist' => 'pdf.company-profile-designs.design-1-brutalist',
        'organic' => 'pdf.company-profile-designs.design-2-organic',
        'editorial' => 'pdf.company-profile-designs.design-3-editorial',
        'artdeco' => 'pdf.company-profile-designs.design-4-artdeco',
        'swiss' => 'pdf.company-profile-designs.design-5-swiss',
        default => 'pdf.company-profile',
    };

    $pdf = Pdf::loadView($view);
    $pdf->setPaper('a4', 'portrait');

    return $pdf->stream('KMG-Enviro-Company-Profile-'.($design ?? 'original').'.pdf');
})->name('preview.company-profile');

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
