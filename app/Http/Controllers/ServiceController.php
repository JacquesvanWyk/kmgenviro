<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Slug;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $services = Service::all();

        return view('services.index', [
            'services' => $services,
        ]);
    }

    public function show(Request $request, Service $service): View
    {
        $slug = Slug::find($slug);

        return view('services.show', [
            'service' => $service,
        ]);
    }
}
