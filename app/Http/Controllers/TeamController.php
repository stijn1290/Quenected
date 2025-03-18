<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class TeamController extends Controller
{
    public function index()
    {
        $authUser = User::where('id', Auth::id())->first();
        $team = Team::where('id', $authUser->team_id)->first();
        $users = User::with(['team', 'tasks'])->where('team_id', $team->id)->get();
        $roles = Role::where('guard_name', 'web')->whereNotIn('id', [1,2])->get();
        $teamManagers = $users->filter(function ($user) use ($roles) {
            return $user->hasRole('teamManager');
        });
        $teamMembers = $users->filter(function ($user) use ($roles) {
            return $user->hasRole('teamUser');
        });
        return Inertia::render('Team', [
            'team' => $team,
            'teamMembers' => $teamMembers,
            'authUser' => $authUser,
            'roles' => $roles,
            'teamManagers' => $teamManagers,
        ]);
    }

    public function store()
    {
        request()->validate([
            'name' => 'required',
        ]);
        Team::create([
            'name' => request('name')
        ]);
        return redirect('/team');
    }

    public function join(Team $team)
    {
        if (Auth::check()) {
            $user = User::where('id', Auth::id())->first();
            $user->update([
                'team_id' => $team->id
            ]);
            $user->removeRole('normalUser');
            if ($user->hasRole('teamManager')) {
                $user->removeRole('teamManager');
            }
            $user->assignRole('teamUser');
            $authenticated= true;
        }
        else{
            $authenticated= false;
        }
        return Inertia::render('TeamRegistration', [
            'team' => $team,
            'authenticated' => $authenticated
        ]);
    }
}
