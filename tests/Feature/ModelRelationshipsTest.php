<?php

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\Project;
use App\Models\Sector;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('service category has many services', function () {
    $category = ServiceCategory::factory()->create();
    $services = Service::factory()->count(3)->create([
        'service_category_id' => $category->id,
    ]);

    expect($category->services)->toHaveCount(3);
    expect($category->services->first())->toBeInstanceOf(Service::class);
    expect($category->services->first()->serviceCategory->id)->toBe($category->id);
});

it('service belongs to service category', function () {
    $category = ServiceCategory::factory()->create();
    $service = Service::factory()->create([
        'service_category_id' => $category->id,
    ]);

    expect($service->serviceCategory)->toBeInstanceOf(ServiceCategory::class);
    expect($service->serviceCategory->id)->toBe($category->id);
    expect($service->serviceCategory->name)->toBe($category->name);
});

it('sector has many projects', function () {
    $sector = Sector::factory()->create();
    $projects = Project::factory()->count(2)->create([
        'sector_id' => $sector->id,
    ]);

    expect($sector->projects)->toHaveCount(2);
    expect($sector->projects->first())->toBeInstanceOf(Project::class);
    expect($sector->projects->first()->sector->id)->toBe($sector->id);
});

it('equipment belongs to equipment category', function () {
    $category = EquipmentCategory::factory()->create();
    $equipment = Equipment::factory()->create([
        'equipment_category_id' => $category->id,
    ]);

    expect($equipment->equipmentCategory)->toBeInstanceOf(EquipmentCategory::class);
    expect($equipment->equipmentCategory->id)->toBe($category->id);
    expect($equipment->equipmentCategory->name)->toBe($category->name);
});
