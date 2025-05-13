<?php
namespace App\Services\TaskManagement;

use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TaskService {
    //
    public function getAllTasks(){

        return auth()->user()->tasks;

    }

    public function addTask(array $validatedData){
        
        $validatedData['user_id'] = Auth::id();

        return Task::create($validatedData);
    }

    public function updateTask(array $validatedData, $id){
        
        $task = auth()->user()->tasks()->findOrFail($id);
        
        $task->update($validatedData);

        return $task;

    }

    public function deleteTask($id){
        $task = auth()->user()->tasks()->findOrFail($id);
        $task->delete();
    }
}