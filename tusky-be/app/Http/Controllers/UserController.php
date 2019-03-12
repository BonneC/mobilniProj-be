<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user();
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //TODO put validator and token

        $newUser = User::create([
            'username' => $request->json('username'),
            'email' => $request->json('email'),
            'password' => bcrypt($request->json('password'))
        ]);

        // if creation is successful
        if ($newUser) {
            return response()->json([
                'success' => true], 201);
        }


        return response()->json(['success' => false], 500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //TODO put validator

        $user = $request->user();

        $user->username = $request->json('username');
        $user->email = $request->json('email');
        $user->password = bcrypt($request->json('password'));

        if ($user->save())
            return response()->json(['success' => true], 200);
        return response()->json(['success' => false], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->active = false;

        if ($user->save())
            return response()->json(['success' => true], 200);
        return response()->json(['success' => false], 500);
    }
}
