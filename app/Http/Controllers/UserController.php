<?php

namespace App\Http\Controllers;

use App\Mail\DeadlineToday;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index($id)
    {
        $tasks = Task::where('user_id', $id)->get();
        $user = User::where('id', $id)->first();
        $url = $user->getFirstMediaUrl('profile');
        $team = \App\Models\Team::where('id', $user->team_id)->first();
        return Inertia::render('UserPage', [
            'user' => $user,
            'tasks' => $tasks,
            'url' => $url,
            'team' => $team->name,
            'teamManager' => $user->hasRole('teamManager'),
            'teamUser' => $user->hasRole('teamUser'),
        ]);
    }
    public function store()
    {
        $validated = request()->validate([
            'name' => 'required|unique:users|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'team_id' => 'required|integer'
        ]);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'team_id' => $validated['team_id']
        ]);
        if ($validated['team_id'] != 1) {
            $user->assignRole('teamUser');
            session(['step' => 2]);
        } else {
            $user->assignRole('normalUser');
            session(['step' => 1]);
        }
        Auth::login($user);
        return redirect('/setup');
    }
    public function loginUser()
    {
        $credentials = request()->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt($credentials)) {
            if (Auth::user()->hasRole('admin')) {
                return redirect('/admin/users');
            }
            else {
                return redirect('/projects');
            }
        }
        else {
            return redirect()->back()->withErrors([
                'email' => 'Incorrect email, username or password',
                'password' => 'Incorrect email, username or password.',
            ]);
        }
    }
    public function logoutUser()
    {
        Auth::logout();
        return redirect('/');
    }
    public function userStatistics()
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        $team = Team::where('id', $user->team_id)->first();
        if ($team->name == "none") {
            $members = null;
        }
        else{
            $members = User::where('team_id', $team->id)->get()->pluck("name");
        }
        $projects = Project::with('tasks')->where('team_id', $team->id)->get()->pluck("name");
        $user = User::where('id', Auth::id())->first();
        if ($user->hasRole('admin')) {
            return view('admin');
        }
        return Inertia::render('Dashboard',[
                'members' => $members,
                'projects' => $projects,
            ]);
    }

    public function joinTeam()
    {
        request()->validate([
            'name' => 'required',
            'type' => 'required'
        ]);
        $user = Auth::user();
        $team = Team::where('name', request('name'))->first();
        $user->update([
            'team_id' => $team->id
        ]);
        $user->removeRole('normalUser');
        $user->assignRole('teamUser');
        if (request('type') == 'setup') {
            $step = session('step');
            session(['step' => ++$step]);
            return redirect()->back();
        }
        else
        {
            return redirect('/team');
        }
    }
    public function leaveTeam()
    {
        request()->validate([
            'id' => 'required',
        ]);
        $user = User::where('id', Auth::id())->first();
        $user->update([
            'team_id' => request('id')
        ]);
        return redirect('/team');
    }
    public function nextStep()
    {
       $step = session('step');
       session(['step' => ++$step]);
       return redirect()->back();
    }
    public function changeRole()
    {
        request()->validate([
           'newRole' => 'required',
            'userId' => 'required'
        ]);
        $newRole = request('newRole');
        $user = User::where('id', request('userId'))->first();
        $user->syncRoles($newRole);
        return redirect()->back();
    }
    public function changeTeamRole()
    {
        request()->validate([
            'role' => 'required',
            'userName' => 'required'
        ]);
        $newRole = request('role');
        $user = User::where('name', request('userName'))->first();
        $user->syncRoles($newRole);
        return redirect()->back();
    }
    public function changePermission()
    {
        request()->validate([
            'permissionName' => 'required',
            'submitValue' => 'required',
            'userId' => 'required'
        ]);
        $user = User::where('id', request('userId'))->first();
        if (request('submit') == "NO") {
            $user->revokePermissionTo(request('permissionName'));
        }
        elseif (request('submit') == "YES") {
            $user->givePermissionTo(request('permissionName'));
        }
        return redirect()->back();
    }
    public function setup()
    {
        return Inertia::render('Setup', [
            'step' => session('step')
        ]);
    }
}
