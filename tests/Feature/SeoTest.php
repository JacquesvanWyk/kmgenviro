<?php

use App\Models\BlogPost;
use App\Models\Service;
use App\Models\ServiceCategory;

/**
 * @return array<int, array<string, mixed>>
 */
function jsonLdBlocks(string $html): array
{
    preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $matches);

    return array_map(function (string $json): array {
        $decoded = json_decode($json, true);

        expect(json_last_error())->toBe(JSON_ERROR_NONE);

        return $decoded;
    }, $matches[1]);
}

test('homepage has title, description, canonical, og tags and organization schema', function () {
    $html = $this->get('/')->assertSuccessful()->getContent();

    expect($html)
        ->toContain('<title>KMG Environmental Solutions | Environmental Consultancy South Africa</title>')
        ->toMatch('/<meta name="description" content="[^"]{80,}">/')
        ->toContain('<link rel="canonical" href="'.route('home').'">')
        ->toContain('<meta property="og:type" content="website">')
        ->toContain('<meta property="og:url" content="'.route('home').'">')
        ->toContain('<meta property="og:image"')
        ->toContain('<meta name="twitter:card" content="summary_large_image">');

    $types = array_column(jsonLdBlocks($html), '@type');

    expect($types)->toContain('Organization')->toContain('WebSite');
});

test('every static public page has a unique title and meta description', function () {
    $routes = ['home', 'about', 'services.index', 'sectors.index', 'projects.index',
        'training.index', 'equipment.index', 'blog.index', 'resources', 'gallery', 'contact'];

    $titles = [];
    $descriptions = [];

    foreach ($routes as $name) {
        $html = $this->get(route($name))->assertSuccessful()->getContent();

        expect($html)->toMatch('/<title>.{10,}<\/title>/');

        preg_match('/<title>(.*?)<\/title>/s', $html, $title);
        preg_match('/<meta name="description" content="(.*?)">/s', $html, $description);

        $text = html_entity_decode($description[1] ?? '', ENT_QUOTES);

        expect($text)->not->toBe('');
        expect(strlen($text))->toBeLessThanOrEqual(160);
        expect($text)->not->toEndWith('...');

        $titles[] = $title[1];
        $descriptions[] = $description[1];
    }

    expect($titles)->toHaveCount(count(array_unique($titles)));
    expect($descriptions)->toHaveCount(count(array_unique($descriptions)));
});

test('blog post page emits article og type, breadcrumbs and BlogPosting schema', function () {
    $post = BlogPost::factory()->create([
        'title' => 'Environmental Compliance In 2026',
        'slug' => 'environmental-compliance-2026',
        'meta_description' => 'What changed in South African environmental compliance this year.',
        'is_published' => true,
    ]);

    $html = $this->get(route('blog.show', $post))->assertSuccessful()->getContent();

    expect($html)
        ->toContain('<meta property="og:type" content="article">')
        ->toContain('What changed in South African environmental compliance this year.')
        ->toContain('<link rel="canonical" href="'.route('blog.show', $post).'">');

    $blocks = collect(jsonLdBlocks($html))->keyBy('@type');

    expect($blocks->keys())->toContain('BlogPosting')->toContain('BreadcrumbList');
    expect($blocks['BlogPosting']['headline'])->toBe('Environmental Compliance In 2026');
    expect($blocks['BlogPosting']['datePublished'])->not->toBeNull();
    expect($blocks['BreadcrumbList']['itemListElement'])->toHaveCount(3);
});

test('service page emits Service schema with the provider organization', function () {
    $category = ServiceCategory::factory()->create(['is_active' => true]);

    $service = Service::factory()->create([
        'service_category_id' => $category->id,
        'name' => 'Environmental Impact Assessment',
        'slug' => 'environmental-impact-assessment',
        'meta_description' => 'Full EIA studies for developments across South Africa.',
        'is_active' => true,
    ]);

    $html = $this->get(route('services.show', $service))->assertSuccessful()->getContent();

    $blocks = collect(jsonLdBlocks($html))->keyBy('@type');

    expect($html)->toContain('Full EIA studies for developments across South Africa.');
    expect($blocks->keys())->toContain('Service');
    expect($blocks['Service']['name'])->toBe('Environmental Impact Assessment');
    expect($blocks['Service']['provider']['@id'])->toBe(url('/').'#organization');
});

test('public pages are indexable', function () {
    $html = $this->get('/')->getContent();

    expect($html)
        ->toContain('max-image-preview:large')
        ->not->toContain('noindex');
});
