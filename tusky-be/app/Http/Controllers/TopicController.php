<?php

namespace App\Http\Controllers;

use App\Topic;
use App\User;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Retrieve all topics
     *
     * @return array of topics
     */
    public function index()
    {
        $topics = Topic::all();
        return $topics;
    }


    /**
     * Retrieve topics for specified user
     *
     * @param \App\User $user
     * @return array of topics
     */
    public function userIndex(User $user)
    {
        $topics = $user->topics;
        return $topics;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Topic $topic
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user, Topic $topic)
    {
        //TODO
        $user->topics()->attach($topic);

        return response()->json(['success' => true], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic $topic
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Topic $topic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topic $topic)
    {
        //
    }

    /**
     * Remove the topic of the specified user.
     *
     * @param  \App\User $user
     * @param  \App\Topic $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Topic $topic)
    {
        $user->topics()->detach($topic);
        return response()->json(['success' => true], 200);
    }
}
