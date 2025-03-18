<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static inRandomOrder()
 */
class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "user_id",
        "team_id"
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
