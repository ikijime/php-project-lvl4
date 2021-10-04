<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Task extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;
    
    protected $guarded = [];
    protected $fillable = [
        'name',
        'author_id',
        'description',
        'status_id',
        'assigned_to_id'
    ];

    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\TaskStatus', 'status_id');
    }

    public function executor()
    {
        return $this->belongsTo('App\Models\User', 'assigned_to_id');
    }
}