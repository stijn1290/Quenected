<?php
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\CommentController;
use \App\Http\Controllers\AdminController;
use \App\Http\Middleware\checkIfAdmin;
use \App\Http\Controllers\Api\APIController;

Route::get('/', function () {
    return Inertia::render('Login');
});
Route::get('/register', function () {
    return Inertia::render('Register');
});
Route::get('/resetPassword', function () {
    return Inertia::render('ResetPassword');
});
Route::post('/register/store', [UserController::class, 'store']);
Route::get('/setup', [UserController::class, 'setup']);
Route::get('/nextStep', [UserController::class, 'nextStep']);
Route::post('/login/user', [UserController::class, 'loginUser']);
Route::get('/userStatistics', [UserController::class, 'userStatistics']);
Route::get('/logout', [UserController::class, 'logoutUser'])->middleware('auth');
Route::get('/profile/{id}', [UserController::class, 'index'])->middleware('auth');
Route::post('/user/changeTeamRole', [UserController::class, 'changeTeamRole'])->middleware('auth');
Route::get('/admin/users', [AdminController::class, 'indexUsers'])->middleware('auth', checkIfAdmin::class);
Route::get('/admin/users/permissions', [AdminController::class, 'permissions'])->middleware('auth', checkIfAdmin::class);
Route::patch('/admin/users/permissions/changePermission', [UserController::class, 'changePermission'])->middleware('auth', checkIfAdmin::class);
Route::get('/admin/teams', [AdminController::class, 'indexTeams'])->middleware('auth', checkIfAdmin::class);
Route::patch('/admin/changeRole', [UserController::class, 'changeRole'])->middleware('auth', checkIfAdmin::class);
//task routes
Route::patch('/tasks/edit/title', [TaskController::class, 'editTitle'])->middleware('auth');
Route::patch('/tasks/edit/Description/{task}', [TaskController::class, 'editDescription'])->middleware('auth');
Route::patch('/tasks/edit/status', [TaskController::class, 'editStatus'])->middleware('auth');
Route::patch('/tasks/edit/deadline/{task}', [TaskController::class, 'editDeadline'])->middleware('auth');
Route::post('/task/create', [TaskController::class, 'store'])->middleware('auth');
Route::delete('/tasks/delete', [TaskController::class, 'destroy'])->middleware('auth');
Route::get('/tasks/project', [TaskController::class, 'index'])->middleware('auth');
Route::get('/tasks/edit/{task}', [TaskController::class, 'edit'])->middleware('auth');
Route::get('/tasks/search', [TaskController::class, 'search'])->middleware('auth');
Route::patch('/tasks/task/changeUser/{task}', [TaskController::class, 'changeUser'])->middleware('auth');
Route::get('/tasks/task/commentary/{task}', [TaskController::class, 'commentary'])->middleware('auth');

//project routes
Route::get('/projects', [ProjectController::class, 'index'])->middleware('auth');
Route::delete('/project/delete', [ProjectController::class, 'destroy'])->middleware('auth');
Route::post('/project/create', [ProjectController::class, 'store'])->middleware('auth');

//team routes
Route::get('/team', [TeamController::class, 'index'])->middleware('auth');
Route::post('/team/create', [TeamController::class, 'store'])->middleware('auth');
Route::patch('/team/join', [UserController::class, 'joinTeam'])->middleware('auth');
Route::patch('/team/leave', [UserController::class, 'leaveTeam'])->middleware('auth');
Route::get('/join/{team}', [TeamController::class, 'join']);

//meeting routes
Route::get('/meetingDashboard', [CommentController::class, 'index'])->middleware('auth');
Route::post('/comment/create', [CommentController::class, 'store'])->middleware('auth');

//settings routes
Route::get('/settings', [SettingsController::class, 'index'])->middleware('auth');
Route::post('/settings/update-profile', [SettingsController::class, 'updateImage'])->middleware('auth');
Route::delete('/settings/delete-user', [SettingsController::class, 'destroyUser'])->middleware('auth');
Route::delete('/settings/delete-tasks', [SettingsController::class, 'destroyTasks'])->middleware('auth');
Route::patch('/settings/change-password', [SettingsController::class, 'changePassword'])->middleware('auth');
Route::patch('/settings/change-email', [SettingsController::class, 'changeEmail'])->middleware('auth');
Route::patch('/settings/change-name', [SettingsController::class, 'changeName'])->middleware('auth');

//new meeting
Route::get('/task/fullTask', [CommentController::class, 'newMeeting'])->middleware('auth');

//api
Route::get('/v1/users', [APIController::class, 'users']);
Route::get('/v1/tasks', [APIController::class, 'tasks']);
Route::get('/v1/teams', [APIController::class, 'teams']);
