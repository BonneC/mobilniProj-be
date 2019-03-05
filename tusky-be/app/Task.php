<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function superTask()
    {
        return $this->belongsTo(Task::class, 'super_task');
    }

    public function subTasks()
    {
        return $this->hasMany(Task::class, 'super_task');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_tasks')->withTimestamps();
    }
}
