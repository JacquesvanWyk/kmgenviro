<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Project;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\TrainingCourse;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = [];

        foreach ([
            'home' => ['1.0', 'weekly'],
            'about' => ['0.8', 'monthly'],
            'services.index' => ['0.9', 'weekly'],
            'sectors.index' => ['0.8', 'monthly'],
            'projects.index' => ['0.8', 'weekly'],
            'training.index' => ['0.8', 'weekly'],
            'equipment.index' => ['0.8', 'weekly'],
            'blog.index' => ['0.7', 'weekly'],
            'resources' => ['0.6', 'monthly'],
            'gallery' => ['0.6', 'monthly'],
            'contact' => ['0.7', 'monthly'],
        ] as $name => [$priority, $frequency]) {
            $urls[] = [route($name), null, $priority, $frequency];
        }

        foreach (ServiceCategory::query()->where('is_active', true)->get() as $category) {
            $urls[] = [route('services.category', $category), $category->updated_at, '0.7', 'monthly'];
        }

        foreach (Service::query()->where('is_active', true)->get() as $service) {
            $urls[] = [route('services.show', $service), $service->updated_at, '0.7', 'monthly'];
        }

        foreach (Project::query()->where('is_active', true)->get() as $project) {
            $urls[] = [route('projects.show', $project), $project->updated_at, '0.6', 'monthly'];
        }

        foreach (TrainingCourse::query()->where('is_active', true)->get() as $course) {
            $urls[] = [route('training.show', $course), $course->updated_at, '0.7', 'monthly'];
        }

        foreach (BlogPost::query()->where('is_published', true)->get() as $post) {
            $urls[] = [route('blog.show', $post), $post->updated_at, '0.6', 'monthly'];
        }

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }
}
