<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\Slug;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SectorController extends Controller
{
    public function index(Request $request): View
    {
        $sectors = Sector::all();

        return view('sectors.index', [
            'sectors' => $sectors,
        ]);
    }

    public function show(Request $request, Sector $sector): View
    {
        $slug = Slug::find($slug);

        return view('sectors.show', [
            'sector' => $sector,
            'projects' => $projects,
        ]);
    }
}
