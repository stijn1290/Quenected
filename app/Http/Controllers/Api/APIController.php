<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;

class APIController extends Controller
{
    public function users()
    {
        $users = User::all()->count();
        return response()->json($users);
    }
    public function teams()
    {
        $teams = Team::all()->count();
        return response()->json($teams);
    }
    public function tasks()
    {
        $tasks = Task::all()->count();
        return response()->json($tasks);
    }
}
