<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'super_task',
        'topic_id'
    ];

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

    /**
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function rootTasks()
    {
        return Task::where('super_task', null);
    }
}
