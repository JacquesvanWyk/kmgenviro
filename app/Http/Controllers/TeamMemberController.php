<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    public function index(Request $request): View
    {
        $teamMembers = TeamMember::all();

        return view('team.index', [
            'team_members' => $team_members,
        ]);
    }
}
