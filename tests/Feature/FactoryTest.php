<?php

use App\Models\Project;
use App\Models\Sector;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('service category factory creates valid data', function () {
    $category = ServiceCategory::factory()->create();

    expect($category->name)->not->toBeNull();
    expect($category->slug)->not->toBeNull();
    expect($category->description)->not->toBeNull();
    expect($category->is_active)->toBeBool();
    expect($category->sort_order)->toBeInt();
    expect($category->meta_title)->not->toBeNull();
    expect($category->meta_description)->not->toBeNull();
});

it('service factory creates valid data', function () {
    $category = ServiceCategory::factory()->create();
    $service = Service::factory()->create([
        'service_category_id' => $category->id,
    ]);

    expect($service->name)->not->toBeNull();
    expect($service->slug)->not->toBeNull();
    expect($service->short_description)->not->toBeNull();
    expect($service->full_description)->not->toBeNull();
    expect($service->service_category_id)->toBe($category->id);
    expect($service->is_active)->toBeBool();
    expect($service->is_featured)->toBeBool();
    expect($service->sort_order)->toBeInt();
});

it('team member factory creates valid data', function () {
    $member = TeamMember::factory()->create();

    expect($member->name)->not->toBeNull();
    expect($member->slug)->not->toBeNull();
    expect($member->title)->not->toBeNull();
    expect($member->email)->not->toBeNull();
    expect($member->bio)->not->toBeNull();
    expect($member->qualifications)->not->toBeNull();
    expect($member->registrations)->not->toBeNull();
    expect($member->is_active)->toBeBool();
    expect($member->sort_order)->toBeInt();
});

it('project factory creates valid data', function () {
    $sector = Sector::factory()->create();
    $project = Project::factory()->create([
        'sector_id' => $sector->id,
    ]);

    expect($project->title)->not->toBeNull();
    expect($project->slug)->not->toBeNull();
    expect($project->client_name)->not->toBeNull();
    expect($project->location)->not->toBeNull();
    expect($project->province)->not->toBeNull();
    expect($project->short_description)->not->toBeNull();
    expect($project->full_description)->not->toBeNull();
    expect($project->services_provided)->not->toBeNull();
    expect($project->gallery_images)->not->toBeNull();
    expect($project->sector_id)->toBe($sector->id);
    expect($project->is_featured)->toBeBool();
    expect($project->is_active)->toBeBool();
    expect($project->sort_order)->toBeInt();
});
