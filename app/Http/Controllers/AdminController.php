<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function indexUsers()
    {
        $users = User::all();
        $tasks = Task::all();
        return Inertia::render('Users', compact('users', 'tasks') );
    }
    public function indexTeams()
    {
        $teams = Team::with('users')->get();
        return Inertia('Teams', compact('teams') );
    }
    public function permissions()
    {
        request()->validate([
          "user_id" => "required",
        ]);
        $user = User::with('team')->where("id", request("user_id"))->first();
        $teams = Team::all();
        $roles = Role::all();
        $permissions = Permission::all();
        return Inertia('Permissions', [
            'user' => $user,
            'role' => $user->getRoleNames()->first(),
            'teams' => $teams,
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }
}
