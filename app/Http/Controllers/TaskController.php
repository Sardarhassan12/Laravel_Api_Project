<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    //

    public function list(){
        // $tasks = Task::where('user_id', Auth::id())->with('User');
        $tasks = auth()->user()->tasks;
        // $tasks = auth()->user()->tasks()->findOrFail;
        return response()->json([
            'message' => 'displaying all tasks',
            'tasks' => $tasks
        ]);
        
    }

    public function add(Request $request){

        $validation = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'deadline' => 'required|date',
        ]);

        if($validation->fails()){
            return response()->json([
                'message' => 'InValid Data',
                'errors' => $validation->errors()
            ],402);
        }

        $validatedData = $validation->validated();
        $validatedData['user_id'] = Auth::id();

        $task = Task::create($validatedData);

        return response()->json([
            'message'=> 'Data save successfully',
            'task' => $task
        ]);

    }

    public function edit(Request $request, $id){
        
        //Token Ability condition
        // if($request->user()->tokenCan('update')){
            
        // }
        
        $task = Task::findOrFail($id);
        
        if(Auth::id() != $task->user->id ){
            return response()->json([
                'message' => 'This task does not belongs to you'
            ]);
        }

        $validation = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'deadline' => 'required|date',
        ]);

        if($validation->fails()){
            return response()->json([
                'message' => 'InValid Data',
                'errors' => $validation->errors()
            ],402);
        }

        $validatedData = $validation->validated();

        $task->update($validatedData);

        return response()->json([
            'message' => 'Task Found & Updated',
            'updated_task' => $task
        ]);
    }

    public function destroy(Request $request){

    }
}
