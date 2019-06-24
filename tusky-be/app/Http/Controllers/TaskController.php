<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\Topic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        return response()->json([
            'success' => 'true',
            'task_list' => $tasks
        ], 200);
    }

    /**
     * Retrieve all tasks for topic
     *
     * @param Request $request
     * @param Topic $topic
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
     * @param Request $request
     * @param Task $task
     * @param User $user
     * @return JsonResponse
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
     * @param User $user
     * @param integer
     * @return array
     */
    public function show(User $user, int $task)
    {
        $task = $user->tasks()->find($task);
        $subTasks = $task->subTasks()->get();

        $taskList = [$task];
        foreach ($subTasks as $subTask) {
            $subTask = $user->tasks()->find($subTask->id);
            array_push($taskList, $subTask);
        }
        return response()->json([
            'success' => true,
            'task_list' => $taskList
        ], 200);
    }

    /**
     * Retrieve single task by id
     *
     * @param Request $request
     * @param Task $task
     * @return JsonResponse
     */
    public function getById(Request $request, Task $task)
    {
        $tasks = [];
        array_push($tasks, $task);

        foreach ($task->subTasks()->get() as $subTask) {
            array_push($tasks, $subTask);
        }

        return response()->json([
            'success' => true,
            'task_list' => $tasks
        ], 200);
    }

    /**
     * @param Request $request
     * @param User $user
     * @param int $task
     * @return JsonResponse
     */
    public function update(Request $request, User $user, int $task)
    {
        $user = $request->user();
        $status = $user->tasks()->updateExistingPivot($task, [
            'completed' => $request->json('completed', false)
        ]);
        if ($status) {
            return response()->json([
                'success' => true
            ], 200);
        }
        return response()->json([
            'success' => false,
        ], 500);
    }

    /**
     *Delete task for user
     *
     * @param User $user
     * @param Task $task
     * @return Response
     */
    public function destroy(User $user, Task $task)
    {
        $user->removeTask($task);
        return response()->json(['success' => true], 200);
    }
}
