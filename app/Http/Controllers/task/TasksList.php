<?php

namespace App\Http\Controllers\task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Task as ModelsTask;
use App\Models\TasksList as ModelsTasksList;



class TasksList extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = ModelsTasksList::get();
        return response()->json(
            $users
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function updateParent(Request $request,$id)
    {
       
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = ModelsTasksList::find($id);
        if (is_null($post)) {
            return response()->json([
                'message'=>'Post not found'
            ],404);
        }
        $copiecategorie = $post;
        $post->delete();
        return response()->json(
           $copiecategorie
        );
    }


    public function taskslist()
    {
        $tasks = ModelsTasksList::with('task')->get();
    
        return view('content.tasks.listview', ['tasks' => $tasks , 'layout'=>'taskslist']);
    }


    public function listTasks()
    {
        $tasksVide = ModelsTask::whereNull('tasks_list_id')->get();

        return view('content.tasks.listview', ['tasks' => $tasksVide , 'layout'=>'taskslist']);
    }

}


