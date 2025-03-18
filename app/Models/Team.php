<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'team_manager',
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
