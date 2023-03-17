<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::get();
        return response()->json(
            $tasks
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
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'task_name'=> 'required|unique:tasks',
            'details'=> 'required|:tasks',
        ]);
        if($validated->fails()){
            return response()->json($validated->errors(), 400);
        }

        $categorie = Task::create($request->all());

        return response()->json(
            $categorie
        ,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $task = Task::find($id);
        if (is_null($task)) {
            return response()->json([
                'message' => 'Task not found'
            ],404);
        }
        return response()->json(
          $task
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $task = Task::find($id);
        if (is_null($task)) {
            return response()->json([
                'message' => 'Task not found'
            ],404);
        }
        $validated = Validator::make($request->all(),[
            'task_name'=> 'required|:tasks',
            'details'=> 'required|:tasks',

        ]);
        if($validated->fails()){
            return response()->json($validated->errors(), 400);
        }
        $task -> update($request->all());
        return response()->json(
            $task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if (is_null($task)) {
            return response()->json([
                'message'=>'Task not found'
            ],404);
        }
        $copiecategorie = $task;
        $task->delete();
        return response()->json(
           $copiecategorie
        );
    }

}
