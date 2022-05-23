<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Task extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $guarded = [];
    protected $fillable = [
        'name',
        'created_by_id',
        'description',
        'status_id',
        'assigned_to_id'
    ];

    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'created_by_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\TaskStatus', 'status_id');
    }

    public function executor()
    {
        return $this->belongsTo('App\Models\User', 'assigned_to_id');
    }

    public function labels()
    {
        return $this->belongsToMany('App\Models\Label', 'tasks_labels')->withTimestamps();
    }
}
