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

    /**
     * Return filtered tasks that are not marked as completed
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function uncompletedTasks()
    {
        return $this->tasks()->wherePivot('completed', true);
    }

    public function addTask(Task $task)
    {
        if ($this->tasks->contains($task))
            return [
                'status' => 'false',
                'message' => 'Task already exists.'
            ];

        $this->tasks()->attach($task);
        $subtasks = $task->subTasks();

        foreach ($subtasks as $subtask)
            $this->tasks()->attach($subtask);

        return [
            'status' => 'true',
            'message' => 'sukses'
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
