<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Slug;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $projects = Project::all();

        return view('projects.index', [
            'projects' => $projects,
        ]);
    }

    public function show(Request $request, Project $project): View
    {
        $slug = Slug::find($slug);

        return view('projects.show', [
            'project' => $project,
        ]);
    }
}
