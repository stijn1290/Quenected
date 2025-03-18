<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::share([
            'auth' => function () {
                if (Auth::check()) {
                    $user = User::where('id', Auth::id())->first();
                    return [
                        'normalUser' => $user->hasRole('normalUser'),
                        'admin' => $user->hasRole('admin'),
                        'teamUser' => $user->hasRole('teamUser'),
                        'teamManager' => $user->hasRole('teamManager'),
                    ];
                }
                else {
                    return [
                        'normalUser' => false,
                        'admin' => false,
                        'teamUser' => false,
                        'teamManager' => false,
                    ];
                }
            }
        ]);
    }
}
