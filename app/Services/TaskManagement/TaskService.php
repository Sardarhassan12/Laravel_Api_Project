<?php
namespace App\Services\TaskManagement;

use App\DTO\TaskManagement\TaskDTO;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TaskService {
    //
    public function getAllTasks(){

        return auth()->user()->tasks;

    }

    public function addTask(TaskDTO $validatedData){
        
        return Task::create([
            'title' => $validatedData->title,
            'description' => $validatedData->description,
            'deadline' => $validatedData->deadline->toDateTimeString(),
            'user_id' => Auth::id()
        ]);
    }

    public function updateTask(TaskDTO $validatedData, $id){
        
        $task = auth()->user()->tasks()->findOrFail($id);
        
        return $task->update([
            'title' => $validatedData->title,
            'description' => $validatedData->description,
            'deadline' => $validatedData->deadline->toDateTimeString()
        ]);

    }

    public function deleteTask($id){
        $task = auth()->user()->tasks()->findOrFail($id);
        $task->delete();
    }
}