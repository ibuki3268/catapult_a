<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;

class TaskShareController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, User $addUser)
    {
        // タスクの共有相手の追加を行う
        auth()->user()->sharedUsers()->attach($addUser->id);

        return redirect()->back()->with('success', 'タスクが共有されました。');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        auth()->user()->sharedUsers()->detach($user->id);
    }
}
