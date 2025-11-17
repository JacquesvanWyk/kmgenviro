<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\TeamMember;

uses(RefreshDatabase::class);

it('can perform complete crud cycle for service category', function () {
    // Create
    $category = ServiceCategory::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'description' => 'Test category description',
        'sort_order' => 1,
        'is_active' => true,
        'meta_title' => 'Test Meta Title',
        'meta_description' => 'Test meta description',
    ]);

    // Read/Find by ID
    $found = ServiceCategory::find($category->id);
    expect($found->name)->toBe('Test Category');
    expect($found->slug)->toBe('test-category');

    // Update
    $category->update(['name' => 'Updated Category', 'description' => 'Updated description']);
    expect($category->fresh()->name)->toBe('Updated Category');
    expect($category->fresh()->description)->toBe('Updated description');

    // Soft Delete
    $category->delete();
    expect(ServiceCategory::find($category->id))->toBeNull();
    expect(ServiceCategory::withTrashed()->find($category->id))->not->toBeNull();
    expect(ServiceCategory::withTrashed()->find($category->id)->deleted_at)->not->toBeNull();
});

it('can perform complete crud cycle for service', function () {
    $category = ServiceCategory::factory()->create();

    // Create
    $service = Service::create([
        'service_category_id' => $category->id,
        'name' => 'Test Service',
        'slug' => 'test-service',
        'short_description' => 'Test short description',
        'full_description' => 'Test full description',
        'sort_order' => 1,
        'is_active' => true,
        'is_featured' => false,
        'meta_title' => 'Test Service Meta Title',
        'meta_description' => 'Test service meta description',
    ]);

    // Read/Find by ID
    $found = Service::find($service->id);
    expect($found->name)->toBe('Test Service');
    expect($found->service_category_id)->toBe($category->id);

    // Update
    $service->update([
        'name' => 'Updated Service',
        'is_featured' => true
    ]);
    expect($service->fresh()->name)->toBe('Updated Service');
    expect($service->fresh()->is_featured)->toBeTrue();

    // Soft Delete
    $service->delete();
    expect(Service::find($service->id))->toBeNull();
    expect(Service::withTrashed()->find($service->id))->not->toBeNull();
});

it('can perform complete crud cycle for team member', function () {
    // Create
    $member = TeamMember::create([
        'name' => 'Test Member',
        'slug' => 'test-member',
        'title' => 'Test Position',
        'email' => 'test@example.com',
        'phone' => '+27 12 345 6789',
        'bio' => 'Test biography',
        'qualifications' => 'Test qualifications',
        'registrations' => 'Test registrations',
        'sort_order' => 1,
        'is_active' => true,
    ]);

    // Read/Find by ID
    $found = TeamMember::find($member->id);
    expect($found->name)->toBe('Test Member');
    expect($found->email)->toBe('test@example.com');

    // Update
    $member->update([
        'title' => 'Updated Position',
        'email' => 'updated@example.com'
    ]);
    expect($member->fresh()->title)->toBe('Updated Position');
    expect($member->fresh()->email)->toBe('updated@example.com');

    // Soft Delete
    $member->delete();
    expect(TeamMember::find($member->id))->toBeNull();
    expect(TeamMember::withTrashed()->find($member->id))->not->toBeNull();
});