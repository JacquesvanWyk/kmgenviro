<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Slug;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipmentController extends Controller
{
    public function index(Request $request): View
    {
        $equipment = Equipment::all();

        return view('equipment.index', [
            'equipment' => $equipment,
            'categories' => $categories,
        ]);
    }

    public function show(Request $request, Equipment $equipment): View
    {
        $slug = Slug::find($slug);

        return view('equipment.show', [
            'equipment' => $equipment,
        ]);
    }
}
