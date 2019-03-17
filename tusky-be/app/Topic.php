<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description',
    ];

    /**
     * Return all users that subscribe to this topic
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_topics')->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Returns all root level tasks for the topic
     * @return \Illuminate\Database\Eloquent\Collection Collection of all root level tasks
     */
    public function rootTasks()
    {
        return $this->tasks()->where('super_task', null)->get();
    }
}
