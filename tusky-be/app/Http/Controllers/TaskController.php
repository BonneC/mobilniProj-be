<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\Topic;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Retrieve all tasks
     *
     * @return array of tasks
     */
    public function index()
    {
        $tasks = Task::all();
        return $tasks;
    }

    /**
     * Retrieve all tasks for user
     *
     * @param User $user
     * @return array of tasks
     */
    public function userIndex(User $user)
    {
        $tasks = $user->tasks;
        return $tasks;
    }

    /**
     * Retrieve all tasks for topic
     *
     * @param Topic $topic
     * @return array of tasks
     */
    public function topicIndex(Topic $topic)
    {
        $tasks = $topic->tasks;
        return $tasks;
    }

}
