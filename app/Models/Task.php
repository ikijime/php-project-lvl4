<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function creator(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'created_by_id', 'id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo('App\Models\TaskStatus', 'status_id');
    }

    public function executor(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'assigned_to_id');
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Label', 'tasks_labels')->withTimestamps();
    }
}
