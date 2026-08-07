<?php

use App\Models\BlogPost;
use App\Models\Service;
use App\Models\ServiceCategory;

test('sitemap returns valid xml', function () {
    $response = $this->get('/sitemap.xml');

    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'application/xml');

    $xml = simplexml_load_string($response->getContent());

    expect($xml)->not->toBeFalse();
    expect($response->getContent())->toContain(route('home'));
    expect($response->getContent())->toContain(route('contact'));
});

test('sitemap includes active services and published posts only', function () {
    $category = ServiceCategory::factory()->create(['is_active' => true]);

    $active = Service::factory()->create([
        'service_category_id' => $category->id,
        'slug' => 'active-service',
        'is_active' => true,
    ]);

    $inactive = Service::factory()->create([
        'service_category_id' => $category->id,
        'slug' => 'inactive-service',
        'is_active' => false,
    ]);

    $published = BlogPost::factory()->create([
        'slug' => 'published-post',
        'is_published' => true,
    ]);

    $draft = BlogPost::factory()->create([
        'slug' => 'draft-post',
        'is_published' => false,
    ]);

    $content = $this->get('/sitemap.xml')->getContent();

    expect($content)
        ->toContain(route('services.show', $active))
        ->toContain(route('blog.show', $published))
        ->not->toContain(route('services.show', $inactive))
        ->not->toContain(route('blog.show', $draft));
});

test('robots.txt points at the sitemap', function () {
    expect(file_get_contents(public_path('robots.txt')))
        ->toContain('Sitemap: https://kmgenviro.co.za/sitemap.xml');
});
