<?php

use App\Filament\Resources\AccreditationResource;
use App\Filament\Resources\ContactSubmissionResource;
use App\Filament\Resources\EquipmentResource;
use App\Filament\Resources\ServiceResource;
use App\Filament\Resources\TrainingBookingResource;
use App\Filament\Resources\TrainingCourseResource;
use App\Models\Accreditation;
use App\Models\ContactSubmission;
use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\TrainingBooking;
use App\Models\TrainingCourse;
use App\Models\TrainingSchedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('service resource can create service with category relationship', function () {
    $category = ServiceCategory::factory()->create();

    Livewire::test(ServiceResource\Pages\CreateService::class)
        ->fillForm([
            'service_category_id' => $category->id,
            'name' => 'Environmental Compliance',
            'slug' => 'environmental-compliance',
            'short_description' => 'Complete compliance services',
            'full_description' => '<p>Full compliance management</p>',
            'sort_order' => 1,
            'is_active' => true,
            'is_featured' => true,
        ])
        ->call('create')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('services', [
        'name' => 'Environmental Compliance',
        'service_category_id' => $category->id,
        'is_featured' => true,
    ]);
});

test('service resource duplicate action creates copy with modified name', function () {
    $category = ServiceCategory::factory()->create();
    $service = Service::factory()->create([
        'service_category_id' => $category->id,
        'name' => 'Original Service',
        'slug' => 'original-service',
    ]);

    Livewire::test(ServiceResource\Pages\ListServices::class)
        ->callTableAction('replicate', $service)
        ->assertHasNoErrors();

    expect(Service::where('name', 'Original Service (Copy)')->exists())->toBeTrue();
});

test('training course resource displays with relationship counts', function () {
    $course = TrainingCourse::factory()->create(['name' => 'Safety Training']);
    TrainingSchedule::factory()->count(3)->create(['training_course_id' => $course->id]);

    Livewire::test(TrainingCourseResource\Pages\ListTrainingCourses::class)
        ->assertCanSeeTableRecords([$course])
        ->assertSuccessful();

    expect($course->trainingSchedules()->count())->toBe(3);
});

test('training booking resource can update status and notes', function () {
    $schedule = TrainingSchedule::factory()->create();
    $booking = TrainingBooking::factory()->create([
        'training_schedule_id' => $schedule->id,
        'training_course_id' => $schedule->training_course_id,
        'status' => 'pending',
    ]);

    Livewire::test(TrainingBookingResource\Pages\EditTrainingBooking::class, [
        'record' => $booking->getRouteKey(),
    ])
        ->assertFormSet([
            'status' => 'pending',
        ])
        ->fillForm([
            'status' => 'confirmed',
            'notes' => 'Payment received, confirmed by phone',
        ])
        ->call('save')
        ->assertHasNoErrors();

    expect($booking->fresh()->status)->toBe('confirmed');
    expect($booking->fresh()->notes)->toBe('Payment received, confirmed by phone');
});

test('contact submission resource can change status', function () {
    $submission = ContactSubmission::factory()->create([
        'type' => 'general_inquiry',
        'status' => 'new',
    ]);

    Livewire::test(ContactSubmissionResource\Pages\EditContactSubmission::class, [
        'record' => $submission->getRouteKey(),
    ])
        ->fillForm([
            'status' => 'contacted',
            'notes' => 'Called client, left voicemail',
        ])
        ->call('save')
        ->assertHasNoErrors();

    expect($submission->fresh()->status)->toBe('contacted');
});

test('equipment resource displays with category relationship', function () {
    $category = EquipmentCategory::factory()->create(['name' => 'Monitoring Equipment']);
    $equipment = Equipment::factory()->create([
        'equipment_category_id' => $category->id,
        'name' => 'Air Quality Monitor',
        'daily_rate' => 15000,
    ]);

    Livewire::test(EquipmentResource\Pages\ListEquipment::class)
        ->assertCanSeeTableRecords([$equipment])
        ->assertSuccessful();

    expect($equipment->equipmentCategory->name)->toBe('Monitoring Equipment');
});

test('accreditation resource displays expired and valid dates', function () {
    $expired = Accreditation::factory()->create([
        'name' => 'ISO 9001',
        'valid_until' => now()->subDays(30),
    ]);
    $valid = Accreditation::factory()->create([
        'name' => 'ISO 14001',
        'valid_until' => now()->addMonths(6),
    ]);

    Livewire::test(AccreditationResource\Pages\ListAccreditations::class)
        ->assertCanSeeTableRecords([$expired, $valid])
        ->assertSuccessful();

    expect($expired->valid_until->isPast())->toBeTrue();
    expect($valid->valid_until->isFuture())->toBeTrue();
});
