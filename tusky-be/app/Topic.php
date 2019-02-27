<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    /**
     * Return all users that subscribe to this topic
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_topics');
    }
}