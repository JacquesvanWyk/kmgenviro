<?php

use App\Models\Accreditation;
use App\Models\BlogPost;
use App\Models\ClientLogo;
use App\Models\Project;
use App\Models\ServiceCategory;
use App\Models\TeamMember;

test('homepage renders successfully', function () {
    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertSee('Environmental Solutions for Sustainable Growth');
});

test('homepage displays active service categories', function () {
    ServiceCategory::factory()->create([
        'name' => 'Environmental Impact Assessment',
        'is_active' => true,
    ]);

    ServiceCategory::factory()->create([
        'name' => 'Inactive Service',
        'is_active' => false,
    ]);

    $response = $this->get('/');

    $response->assertSee('Environmental Impact Assessment');
    $response->assertDontSee('Inactive Service');
});

test('homepage displays featured projects', function () {
    $sector = \App\Models\Sector::factory()->create();

    Project::factory()->create([
        'title' => 'Featured Project One',
        'is_featured' => true,
        'is_active' => true,
        'sector_id' => $sector->id,
    ]);

    Project::factory()->create([
        'title' => 'Not Featured Project',
        'is_featured' => false,
        'is_active' => true,
        'sector_id' => $sector->id,
    ]);

    $response = $this->get('/');

    $response->assertSee('Featured Project One');
    $response->assertDontSee('Not Featured Project');
});

test('homepage displays client logos', function () {
    ClientLogo::factory()->create([
        'name' => 'Test Client',
        'is_active' => true,
    ]);

    $response = $this->get('/');

    $response->assertSee('Trusted by Leading Organizations');
    $response->assertSee('Test Client');
});

test('homepage displays latest blog posts', function () {
    BlogPost::factory()->create([
        'title' => 'Latest Blog Post',
        'is_published' => true,
        'published_at' => now(),
    ]);

    BlogPost::factory()->create([
        'title' => 'Unpublished Post',
        'is_published' => false,
    ]);

    $response = $this->get('/');

    $response->assertSee('Latest Blog Post');
    $response->assertDontSee('Unpublished Post');
});

test('homepage displays correct counts', function () {
    TeamMember::factory()->count(5)->create(['is_active' => true]);
    Accreditation::factory()->count(3)->create(['is_active' => true]);
    Project::factory()->count(10)->create();

    $response = $this->get('/');

    $response->assertSee('5+ environmental professionals');
    $response->assertSee('3+ industry accreditations');
    $response->assertSee('10+ successful projects');
});

test('homepage shows both office addresses', function () {
    $response = $this->get('/');

    $response->assertSee('08 Hillside Road, Metropolitan Building, 1st Floor B, Parktown, Johannesburg, 2193');
    $response->assertSee('Aston Manor House, 128 Monument Road, Kempton Park');
});

test('contact page shows both office addresses', function () {
    $response = $this->get('/contact');

    $response->assertSuccessful();
    $response->assertSee('Head Office &mdash; Johannesburg', false);
    $response->assertSee('Branch Office &mdash; Kempton Park', false);
    $response->assertSee('128 Monument Road');
});

test('footer shows both office addresses', function () {
    $response = $this->get('/');

    $response->assertSee('Head Office');
    $response->assertSee('Branch Office');
    $response->assertSee('Aston Manor House, 128 Monument Road,', false);
});

test('homepage has correct navigation links when sections have content', function () {
    ServiceCategory::factory()->create(['is_active' => true]);
    $sector = \App\Models\Sector::factory()->create();
    Project::factory()->create(['is_featured' => true, 'is_active' => true, 'sector_id' => $sector->id]);
    BlogPost::factory()->create(['is_published' => true, 'published_at' => now()]);

    $response = $this->get('/');

    $response->assertSee('Our Services');
    $response->assertSee('Get a Quote');
    $response->assertSee('View All Services');
    $response->assertSee('View All Projects');
    $response->assertSee('Read Our Blog');
    $response->assertSee('Contact Us');
});
