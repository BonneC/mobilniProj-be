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
     * @param Request $request
     * @param \App\Topic $topic
     * @return array of tasks
     */
    public function topicIndex(Request $request, Topic $topic)
    {
        $user = $request->user();
        $userTasks = $user->tasks()
            ->where('super_task', null)
            ->where('topic_id', $topic->id)
            ->get()->all();

        $userTasksIds = [];
        $allTasks = [];

        foreach ($userTasks as $userTask) {
            array_push($allTasks, $userTask);
            array_push($userTasksIds, $userTask->id);
        }

        foreach ($topic->tasks()->where('super_task', null)->get() as $task) {
            if (!in_array($task->id, $userTasksIds)) {
                array_push($allTasks, $task);
            }
        }

        return response()->json(['status' => 'success', 'task_list' => $allTasks], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Task $task
     * @param \App\User $user
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
     * @param integer
     * @return array
     */
    public function show(User $user, int $task)
    {
        return $user->getTaskInfo($task);
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
        $user->removeTask($task);
        return response()->json(['success' => true], 200);
    }
}
