<?php

namespace App\Http\Controllers\task;

use App\Http\Controllers\Controller;
use App\Models\Task as ModelsTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Task extends Controller
{
  public function index1()
  {
    return view('content.tasks.tasks');
  }

  public function newpage (){
    return view('content.tasks.tasksUpdate');

  }

  public function index()
    {
        $tasks = ModelsTask::where('statut_corbeille', '=', 1)->paginate(5);
        if ($tasks->isEmpty()) {
            return view('content.tasks.tasks', ['tasks' => null , 'layout'=>'index']);
        }
        return view('content.tasks.tasks', ['tasks' => $tasks , 'layout'=>'index']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'task_name'=> 'required|:tasks',
            'details'=> 'required|:tasks',
        ]);
        if($validated->fails()){
            return response()->json($validated->errors(), 400);
        }

        $categorie = ModelsTask::create($request->all());

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
        
        $task = ModelsTask::find($id);
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
    public function edit(Task $task)
{
    return view('tasks.edit', compact('task'));
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $task = ModelsTask::find($request->input('update_id'));
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
    
        // Mise à jour de la tâche
        $task->update($request->all());
    
        // Mise à jour automatique du statut en fonction de la valeur de la propriété "statut" dans la demande
        if ($request->has('statut')) {
            if ($request->input('statut') == 'Scheduled') {
                $task->statut = 1;
            }else if($request->input('statut') == 'Pending') {

            }else {
                $task->statut = 2;
            }
            
            $task->save();
        }
    
        return response()->json($task);
    }
    

    /**
     * Met à jour le champ "favoris" d'une tâche existante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateFavorite(Request $request, $id)
    {
        $task = ModelsTask::findOrFail($id);
    
        // Valider la valeur du champ "favoris" reçue en paramètre
        $validatedData = $request->validate([
            'favoris' => 'required|in:0,1'
        ]);
    
        // Mettre à jour la tâche
        $task->update([
            'favoris' => $validatedData['favoris']
        ]);
    
        return response()->json([
            'message' => 'Favorite updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = ModelsTask::find($id);
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
     
        // echo '<script>alert("La suppression a été effectuée avec succès !");</script>';
        
    }


}
