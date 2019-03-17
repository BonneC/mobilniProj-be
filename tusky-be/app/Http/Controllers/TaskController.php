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
     * @param \App\Topic $topic
     * @return array of tasks
     */
    public function topicIndex(Topic $topic)
    {
        $tasks = $topic->tasks;
        return $tasks;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Task $task
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user, Task $task)
    {
        //TODO
        $response = $user->addTask($task);

        if ($response['status'])
            return response()->json(['success' => true], 200);

        return response()->json(['success' => false,
            'message' => $response['message']], 401);
    }


    /**
     * Retrieve task
     *
     * @param \App\User $user
     * @param \App\Task $task
     * @return task
     */
    public function show(User $user, Task $task)
    {

    }

    /**
     *Delete task for user
     *
     * @param \App\User $user
     * @param \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Task $task)
    {
        $user->tasks()->detach($task);
        return response()->json(['success' => true], 200);
    }
}
