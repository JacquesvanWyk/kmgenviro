<?php

namespace App\Http\Controllers;

use App\Models\Slug;
use App\Models\TrainingCourse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrainingCourseController extends Controller
{
    public function index(Request $request): View
    {
        $trainingCourses = TrainingCourse::all();

        return view('training.index', [
            'courses' => $courses,
            'schedules' => $schedules,
        ]);
    }

    public function show(Request $request, TrainingCourse $trainingCourse): View
    {
        $slug = Slug::find($slug);

        return view('training.show', [
            'course' => $course,
            'schedules' => $schedules,
        ]);
    }
}
