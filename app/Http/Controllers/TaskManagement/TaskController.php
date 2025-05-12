<?php

namespace App\Http\Controllers\TaskManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskManagement\AddTask;
use App\Http\Requests\TaskManagement\UpdateTask;
use App\Models\Task;
use App\Services\TaskManagement\TaskService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use F9Web\ApiResponseHelpers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{

    //
    use ApiResponseHelpers;

    public function __construct(private readonly TaskService $task_service) {
        
    }
    public function list(){

        $tasks = $this->task_service->getAllTasks();

        return $this->respondWithSuccess([
            'message' => 'displaying all tasks',
            'tasks' => $tasks,
            'success' => true
        ]);
        
    }

    public function add(AddTask $request){

        $task = $this->task_service->addTask($request->validated());

        return $this->respondCreated([
            'message' => 'Task created successfully.',
            'success' => true,
            'task' => $task
        ]);

    }

    public function edit(UpdateTask $request, $id){

            $task = $this->task_service->updateTask($request->validated(), $id);

            return $this->respondWithSuccess([
                'message' => 'Task Found & Updated',
                'success' => true,
                'updated_task' => $task,
            ]);
       
    }

    public function destroy(Request $request, $id){
        
            $this->task_service->deleteTask($id);

            return $this->respondWithSuccess([
                'message' => 'Task Deleted Successfully',
                'success' => true,
            ]);

    }
}






    // public function add(Request $request){

    //     $validation = Validator::make($request->all(), [
    //         'title' => 'required|string',
    //         'description' => 'required|string',
    //         'deadline' => 'required|date',
    //     ]);

    //     if($validation->fails()){
    //         return response()->json([
    //             'message' => 'InValid Data',
    //             'errors' => $validation->errors()
    //         ],402);
    //     }

    //     $validatedData = $validation->validated();
    //     $validatedData['user_id'] = Auth::id();

    //     $task = Task::create($validatedData);

    //     return response()->json([
    //         'message'=> 'Data save successfully',
    //         'task' => $task
    //     ]);

    // }

    // public function edit(Request $request, $id){
        
    //     $task = Task::findOrFail($id);
        
    //     if(Auth::id() != $task->user->id ){
    //         return response()->json([
    //             'message' => 'This task does not belongs to you'
    //         ]);
    //     }

    //     $validation = Validator::make($request->all(), [
    //         'title' => 'required|string',
    //         'description' => 'required|string',
    //         'deadline' => 'required|date',
    //     ]);

    //     if($validation->fails()){
    //         return response()->json([
    //             'message' => 'InValid Data',
    //             'errors' => $validation->errors()
    //         ],402);
    //     }

    //     $validatedData = $validation->validated();

    //     $task->update($validatedData);

    //     return response()->json([
    //         'message' => 'Task Found & Updated',
    //         'updated_task' => $task
    //     ]);
    // }
