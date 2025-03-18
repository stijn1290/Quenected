<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
    {
        $project = Project::where('id', request('project'))->first();
        $authUser = User::where('id', Auth::id())->first();
        $team = Team::find($authUser->team_id);
        if ($team->name == "none") {
            $users = null;
        }
        else {
            $users = User::where('team_id', $authUser->team->id)->get();
        }
        $toDoTasks = Task::with('user', 'project')->where('project_id', $project->id)->where('status', 'not done')->get()->toArray();
        $inProgressTasks = Task::with('user')->where('project_id', $project->id)->where('status', 'in progress')->get()->toArray();
        $completedTasks = Task::with('user')->where('project_id', $project->id)->where('status', 'completed')->get()->toArray();
        return Inertia::render('Tasks', [
            'completedTasks' => $completedTasks,
            'inProgressTasks' => $inProgressTasks,
            'toDoTasks' => $toDoTasks,
            'user' => $authUser,
            'users' => $users,
            'activeProject' => $project,
        ]);
    }

    public function edit(Task $task)
    {
        $user = User::where('id', Auth::id())->first();
        if (!$user->hasRole('teamManager') && !$user->hasRole('normalUser')) {
            return redirect()->back()->withErrors([
                'noAccess' => "You do not have permission to edit task: {$task->title}",
            ]);
        }

        return view('edittask', [
            'task' => $task,
        ]);
    }

    public function store()
    {
        request()->validate([
            'title' => 'required',
            'description' => 'required',
            'deadline' => 'required',
            'project' => 'required',
            'user' => 'required',
        ]);
        $userId = User::where('name', request('user'))->pluck('id')->first();
        $projectId = Project::where('name', request('project'))->pluck('id')->first();
        Task::create([
            'title' => request('title'),
            'description' => request('description'),
            'status' => request('status'),
            'deadline' => request('deadline'),
            'user_id' => $userId,
            'project_id' => $projectId,
        ]);
        return redirect()->back();
    }

    public function destroy()
    {
        request()->validate([
            'id' => 'required',
        ]);
        Task::findOrFail(request('id'))->delete();
        return redirect('/tasks');
    }

    public function editTitle()
    {
        request()->validate([
            'title' => 'required',
            'id' => 'required',
        ]);
        $task = Task::where('id', request('id'))->first();
        $task->update([
            'title' => request('title'),
        ]);
        return redirect()->back();
    }

    public function editDescription(Task $task)
    {
        request()->validate([
            'description' => 'required',
        ]);
        $task->update([
            'description' => request('description'),
        ]);
        return redirect('/tasks');
    }

    public function editStatus()
    {
        $user = User::where('id', Auth::id())->first();
        request()->validate([
            "task" => "required",
            "status" => "required",
        ]);
        $task = Task::where('id', request('task'))->first();
        $task->update([
            'status' => request('status'),
        ]);
        $summary = "Status updated to {$task->status}";
        Comment::create([
            "description" => $summary,
            "task_id" => $task->id,
            "team_id" => $user->team->id,
            "user_id" => $user->id,
        ]);
        return redirect()->back();
    }

    public function editDeadline(Task $task)
    {
        $user = User::where('id', Auth::id())->first();
        request()->validate([
            'deadline' => 'required'
        ]);
        $task->update([
            'deadline' => request('deadline')
        ]);
        $summary = "Deadline updated to {$task->deadline}";
        Comment::create([
            "description" => $summary,
            "task_id" => $task->id,
            "team_id" => $user->team->id,
            "user_id" => $user->id,
        ]);
        return redirect()->back();
    }

    public function search()
    {
        $authUser = User::where('id', Auth::id())->first();
        $tasks = collect();
        $activeProject = Project::where('id', request('project'))->first();
        if (request('project') != null) {
            if ($activeProject) {
                $tasks = $activeProject->tasks;
            }
        }
        if (request('keyword') != null) {
            $tasks = Task::where('title', 'like', '%' . request('keyword') . '%')->get();
        }
        if (request('keyword') == null && request('project') == null) {
            $team = Team::find($authUser->team_id);
            if ($team !== 1) {
                $usersIds = User::where('team_id', $team->id)->pluck('id');
            }
            else{
                $usersIds = $authUser->pluck('id');
            }
            $tasks = Task::with('user', 'user.media')->whereIn('user_id', $usersIds)->get();
        }
        $toDoTasks = [];
        $inProgressTasks = [];
        $completedTasks = [];
        if (request('status') == "Completed") {
            $completedTasks = $tasks->filter(fn($task) => $task->status === 'completed');
        } elseif (request('status') == "To do") {
            $toDoTasks = $tasks->filter(fn($task) => $task->status === 'not done');
        } elseif (request('status') == "In progress") {
            $inProgressTasks = $tasks->filter(fn($task) => $task->status === 'in progress');
        } else {
            $toDoTasks = $tasks->filter(fn($task) => $task->status === 'not done');
            $inProgressTasks = $tasks->filter(fn($task) => $task->status === 'in progress');
            $completedTasks = $tasks->filter(fn($task) => $task->status === 'completed');
        }
        $users = $tasks->pluck('user')->unique();
        return Inertia::render('Tasks', [
            'completedTasks' => $completedTasks,
            'inProgressTasks' => $inProgressTasks,
            'toDoTasks' => $toDoTasks,
            'user' => $authUser,
            'activeProject' => $activeProject,
            'users' => $users,
        ]);
    }


    public function changeUser(Task $task)
    {
        request()->validate([
            'user' => 'required',
        ]);
        $userId = User::where('name', request('user'))->pluck('id')->first();
        $task->update([
            'user_id' => $userId,
        ]);

        return redirect()->back();
    }

    public function commentary(Task $task)
    {
        $user = User::where('id', $task->user_id)->first();
        $comments = Comment::where('task_id', $task->id)->get();
        $authUser = User::where('id', Auth::id())->first();
        return Inertia::render('Commentary', [
            'task' => $task,
            'comments' => $comments,
            'user' => $user->team->id,
            'authUser' => $authUser
        ]);
    }
}
