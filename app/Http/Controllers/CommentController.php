<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CommentController extends Controller
{
    public function index()
    {
        $authUser = User::where('id', Auth::id())->first();
        $team = Team::find($authUser->team_id);
        $usersIds = User::where('team_id', $team->id)->pluck('id');
        $tasks = Task::with('user', 'user.media')->whereIn('user_id', $usersIds)->get();
        $meetings = Comment::orderBy('id', 'desc')->take(3)->get();
        return Inertia::render('MeetingDashboard', [
            'tasks' => $tasks,
            'meetings' => $meetings
        ]);
    }
    public function newMeeting()
    {
        request()->validate([
            "task" => "required",
        ]);
        if (request("instance") == "meeting") {
            $task = Task::where('title', request('task'))->first();
        }
        else
        {
            $task = Task::where('id', request('task'))->first();
        }
        $user = User::where('id', $task->user_id)->first();
        $users = $user->team->users;
        $authUser = User::with('team')->where('id', Auth::id())->first();
        $comments = Comment::with('user')->where('task_id', $task->id)->get();
        return Inertia::render('FullTask', [
            'task' => $task,
            'users' => $users,
            'user' => $user,
            'authUser' => $authUser,
            'comments' => $comments,
        ]);
    }
    public function store()
    {
        request()->validate([
            "summary" => "required",
            "team_id" => "required",
            "user_id" => "required",
            "task" => "required",
        ]);
        $summary = request("summary");
        $task = Task::where('id', request("task"))->first();
        if (!empty(trim($summary))) {
            Comment::create([
                "description" => $summary,
                "task_id" => $task->id,
                "team_id" => request('team_id'),
                "user_id" => request('user_id'),
            ]);
        }
        else{
            Comment::create([
                "description" => "No summary available",
                "task_id" => $task->id,
                "team_id" => request('team_id'),
                "user_id" => request('user_id'),
            ]);
        }
        return redirect()->back();
    }
}
