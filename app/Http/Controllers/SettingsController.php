<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index()
    {
        $user = User::where('id', Auth::id())->first();
        return Inertia::render('Settings', [
            'user' => $user
        ]);
    }
    public function destroyTasks()
    {
        request()->validate([
            'user_id' => 'required',
        ]);
        Task::where('user_id', request('user_id'))->delete();
        return redirect('/settings');
    }
    public function updateImage()
    {
        request()->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'type' => 'required'
        ]);
        $file = request()->file('file');
        $user = Auth::user();
        $user->clearMediaCollection('profile');
        $user->addMedia($file)->toMediaCollection('profile');
        if (request('type') == "setup")
        {
            $step = session('step');
            session(['step' => ++$step]);
            return redirect()->back();
        }
        else{
            return redirect('/setting');
        }
    }
    public function destroyUser()
    {
        request()->validate([
            'user_id' => 'required',
        ]);
        $user = User::where('id', request('user_id'))->first();
        Task::where('user_id', $user->id)->delete();
        Project::where('user_id', $user->id)->delete();
        $user->clearMediaCollection('profile');
        Auth::logout();
        $user->delete();
        return redirect('/');
    }
    public function changePassword()
    {
        request()->validate([
            'current' => 'required',
            'newPassword' => 'required|min:8',
        ]);
        $user = User::where('id', Auth::id())->first();
        if (Hash::check(request('current'), $user->password))
        {
            $newPassword = Hash::make(request('newPassword'));
            $user->update(['password' => $newPassword]);
        }
        return redirect()->back();
    }
    public function changeEmail()
    {
        $validation = request()->validate([
            'newEmail' => 'required|email|unique:users,email',
        ]);
        $user = User::where('id', Auth::id())->first();
        if ($validation)
        {
            $user->update(['email' => request('newEmail')]);
        }
        return redirect()->back();
    }
    public function changeName()
    {
        $validation = request()->validate([
            'newName' => 'required|unique:users,email',
        ]);
        $user = User::where('id', Auth::id())->first();
        if ($validation)
        {
            $user->update(['name' => request('newName')]);
        }
        return redirect()->back();
    }
}
