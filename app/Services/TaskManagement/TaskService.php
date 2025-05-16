<?php
namespace App\Services\TaskManagement;

use App\DTO\TaskManagement\TaskDTO;
use App\Exports\TaskExport;
use App\Imports\TaskImport;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class TaskService {
    //
    public function getAllTasks(){

        return auth()->user()->tasks()->paginate(4);

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

    public function importTask(Request $request){
       
        $importedTasks = new TaskImport;

        Excel::import($importedTasks, $request->file('file'));

        foreach($importedTasks->failures() as $failure){
            
            $failedTaskDetais[] = [
                'row' => $failure->row(),
                'attribute' => $failure->attribute(),
                'errors' => $failure->errors(),
                'values' => $failure->values()
            ];

        }

        return [

            'success' => count($failedTaskDetais) === 0,
            'message' => count($failedTaskDetais) === 0 ? "Task Imported Successfully" : "Task Imported With Some Issue",
            'imported task' => $importedTasks->rowsImportCount,
            'failed task' => count($failedTaskDetais),
            'Error' => $failedTaskDetais

        ];

    }

    public function exportTask(){
        Excel::download(new TaskExport, 'tasks.xlsx');
    }

    public function generatePDF(){

        $tasks = Task::all();

        $data = [
            'tasks' => $tasks
        ];

        return PDF::loadView('pdf', $data);

    }
}