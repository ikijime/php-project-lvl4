<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TaskStatus extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function task()
    {
        return $this->hasMany(Task::class, 'status_id');
    }
}
