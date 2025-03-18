<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        $user = User::select('id', 'name', 'team_id')->where('id', Auth::id())->first();
        if ($user->team_id != 1) {
            $projects = Project::with('user', 'tasks')->where('team_id', $user->team_id )->get();
            $teamMembers = User::where('team_id', $user->team_id)->get();
            $teamManagers = $teamMembers->filter(function ($member) {
                return $member->hasRole('teamManager');
            });
        }
        else{
            $teamManagers = null;
            $projects = Project::where('user_id', $user->id)->get();
        }
        $projectsTasks = $projects->filter(function ($project) {
            return $project->task != null;
        });
        return Inertia::render('Projects',[
            'projects' => $projects,
            'teamManagers' => $teamManagers,
            'user' => $user,
            'projectsTasks' => $projectsTasks,
            'team_id' => $user->team_id,
        ]);
    }
    public function store()
    {
        request()->validate([
            'name' => 'required',
        ]);
        if (request('user'))
        {
            $user = User::where('name', request('user'))->first();
        }
        else{
            $user = User::where('id', Auth::id())->first();
        }
        Project::create([
            'name' => request('name'),
            'team_id' => $user->team_id,
            'user_id' => $user->id,
        ]);
        return redirect()->back();
    }
    public function destroy()
    {
        request()->validate([
            'project' => 'required',
        ]);
        Project::where('id', request('project'))->delete();
        return redirect()->back();
    }
}
