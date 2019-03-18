<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Returns all topics that the user is subscribed to
     */
    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'users_topics')->withTimestamps();
    }

    /**
     * Returns the tasks attached to this user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'users_tasks')
            ->withTimestamps()
            ->withPivot('completed');
    }


    public function addTask(Task $task)
    {
        if ($this->tasks->contains($task))
            return [
                'status' => 'false',
                'message' => 'Task already exists.'
            ];

        $this->tasks()->attach($task->id);
        $subtasks = $task->subTasks()->get();

        foreach ($subtasks as $subtask)
            $this->tasks()->attach($subtask->id);

        return [
            'status' => 'true',
            'message' => 'sukses'
        ];
    }

    public function removeTask(Task $task)
    {
        $this->tasks()->detach($task->id);
        $subtasks = $task->subTasks()->get();

        foreach ($subtasks as $subtask)
            $this->tasks()->detach($subtask->id);

        return [
            'status' => 'true',
            'message' => 'sukses'
        ];
    }

    public function getTasks()
    {
        return $this->tasks()
            ->where('super_task', null)
            ->wherePivot('completed', false)->get();
    }

    /**
     * Returns assoc array with task and sub-tasks (with pivots)
     * @param integer $task
     * @return array assoc with task and subTasks
     */
    public function getTaskInfo(int $task)
    {
        $subTasks = $this->tasks()->where('super_task', $task)->get();
        return [
            'task' => $this->tasks()->find($task),
            'subTasks' => $subTasks
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];

    }
}
