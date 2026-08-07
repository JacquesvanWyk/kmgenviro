<?php

namespace App\Support;

use App\Models\BlogPost;
use App\Models\Project;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\TrainingCourse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Resolves the SEO metadata and JSON-LD structured data for the current request.
 *
 * Route model binding has already resolved the page's subject by the time the
 * layout renders, so the metadata is derived from the route rather than being
 * threaded through every Volt component.
 */
class Seo
{
    protected ?string $routeName;

    protected ?Model $subject;

    public function __construct()
    {
        $this->routeName = request()->route()?->getName();
        $this->subject = $this->resolveSubject();
    }

    public function description(): string
    {
        $description = match (true) {
            $this->subject instanceof BlogPost => $this->subject->meta_description ?? $this->subject->excerpt,
            $this->subject instanceof Service,
            $this->subject instanceof Project,
            $this->subject instanceof TrainingCourse => $this->subject->meta_description ?? $this->subject->short_description,
            $this->subject instanceof ServiceCategory => $this->subject->meta_description ?? $this->subject->description,
            default => config('seo.pages')[$this->routeName] ?? null,
        };

        return $this->trim($description ?? config('seo.defaults.description'));
    }

    public function image(): string
    {
        $image = match (true) {
            $this->subject instanceof BlogPost,
            $this->subject instanceof Project => $this->subject->featured_image,
            $this->subject instanceof TrainingCourse => $this->subject->thumbnail,
            default => null,
        };

        if (! $image) {
            return asset(config('seo.defaults.image'));
        }

        return Str::startsWith($image, ['http://', 'https://'])
            ? $image
            : asset(Str::startsWith($image, 'storage/') ? $image : 'storage/'.ltrim($image, '/'));
    }

    public function type(): string
    {
        return $this->subject instanceof BlogPost ? 'article' : 'website';
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function structuredData(): array
    {
        return array_values(array_filter([
            $this->organizationSchema(),
            $this->websiteSchema(),
            $this->breadcrumbSchema(),
            $this->contentSchema(),
        ]));
    }

    /**
     * @return array<string, mixed>
     */
    protected function organizationSchema(): array
    {
        $organization = config('seo.organization');

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => url('/').'#organization',
            'name' => $organization['name'],
            'legalName' => $organization['legal_name'],
            'description' => $organization['description'],
            'url' => url('/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('images/logo.png'),
            ],
            'image' => asset(config('seo.defaults.image')),
            'email' => $organization['email'],
            'telephone' => $organization['telephones'][0],
            'areaServed' => $organization['area_served'],
            'sameAs' => $organization['social'],
            'address' => array_map(fn (array $address): array => [
                '@type' => 'PostalAddress',
                'streetAddress' => $address['street'],
                'addressLocality' => $address['locality'],
                'addressRegion' => $address['region'],
                'postalCode' => $address['postal_code'],
                'addressCountry' => 'ZA',
            ], $organization['addresses']),
            'contactPoint' => [
                [
                    '@type' => 'ContactPoint',
                    'contactType' => 'customer service',
                    'telephone' => $organization['telephones'][0],
                    'email' => $organization['email'],
                    'areaServed' => 'ZA',
                    'availableLanguage' => ['en'],
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function websiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => url('/').'#website',
            'name' => config('seo.organization.name'),
            'url' => url('/'),
            'inLanguage' => 'en-ZA',
            'publisher' => ['@id' => url('/').'#organization'],
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    protected function breadcrumbSchema(): ?array
    {
        $trail = $this->breadcrumbTrail();

        if (count($trail) < 2) {
            return null;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array_map(fn (array $crumb, int $index): array => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $crumb['name'],
                'item' => $crumb['url'],
            ], $trail, array_keys($trail)),
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    protected function contentSchema(): ?array
    {
        if ($this->subject instanceof BlogPost) {
            return [
                '@context' => 'https://schema.org',
                '@type' => 'BlogPosting',
                'headline' => Str::limit($this->subject->title, 110, ''),
                'description' => $this->description(),
                'image' => $this->image(),
                'url' => url()->current(),
                'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => url()->current()],
                'datePublished' => $this->subject->published_at?->toAtomString(),
                'dateModified' => $this->subject->updated_at?->toAtomString(),
                'author' => [
                    '@type' => $this->subject->author ? 'Person' : 'Organization',
                    'name' => $this->subject->author ?: config('seo.organization.name'),
                ],
                'publisher' => ['@id' => url('/').'#organization'],
            ];
        }

        if ($this->subject instanceof Service) {
            return [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => $this->subject->name,
                'description' => $this->description(),
                'url' => url()->current(),
                'serviceType' => $this->subject->serviceCategory?->name ?? 'Environmental consultancy',
                'areaServed' => config('seo.organization.area_served'),
                'provider' => ['@id' => url('/').'#organization'],
            ];
        }

        if ($this->subject instanceof TrainingCourse) {
            return array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'Course',
                'name' => $this->subject->name,
                'description' => $this->description(),
                'url' => url()->current(),
                'provider' => ['@id' => url('/').'#organization'],
            ]);
        }

        if ($this->subject instanceof ServiceCategory) {
            return [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => $this->subject->name,
                'description' => $this->description(),
                'url' => url()->current(),
                'isPartOf' => ['@id' => url('/').'#website'],
            ];
        }

        return null;
    }

    /**
     * @return array<int, array{name: string, url: string}>
     */
    protected function breadcrumbTrail(): array
    {
        $trail = [['name' => 'Home', 'url' => route('home')]];

        $sections = [
            'services.index' => ['Services', 'services.index'],
            'services.category' => ['Services', 'services.index'],
            'services.show' => ['Services', 'services.index'],
            'projects.index' => ['Projects', 'projects.index'],
            'projects.show' => ['Projects', 'projects.index'],
            'training.index' => ['Training', 'training.index'],
            'training.show' => ['Training', 'training.index'],
            'blog.index' => ['Blog', 'blog.index'],
            'blog.show' => ['Blog', 'blog.index'],
            'sectors.index' => ['Sectors', 'sectors.index'],
            'equipment.index' => ['Equipment', 'equipment.index'],
            'about' => ['About', 'about'],
            'contact' => ['Contact', 'contact'],
            'resources' => ['Resources', 'resources'],
            'gallery' => ['Gallery', 'gallery'],
        ];

        if (isset($sections[$this->routeName])) {
            [$name, $route] = $sections[$this->routeName];
            $trail[] = ['name' => $name, 'url' => route($route)];
        }

        if ($this->subject) {
            $trail[] = [
                'name' => $this->subject->title ?? $this->subject->name,
                'url' => url()->current(),
            ];
        }

        return $trail;
    }

    protected function resolveSubject(): ?Model
    {
        foreach (['post', 'service', 'project', 'course', 'category'] as $parameter) {
            $value = request()->route()?->parameter($parameter);

            if ($value instanceof Model) {
                return $value;
            }
        }

        return null;
    }

    protected function trim(string $description): string
    {
        return Str::limit(trim(strip_tags($description)), 158);
    }
}
