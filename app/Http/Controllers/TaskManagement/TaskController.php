<?php

namespace App\Http\Controllers\TaskManagement;

use App\DTO\TaskManagement\TaskDTO;
use App\Exports\TaskExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskManagement\AddTask;
use App\Http\Requests\TaskManagement\UpdateTask;
use App\Imports\TaskImport;
use App\Models\Task;
use App\Services\TaskManagement\TaskService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use F9Web\ApiResponseHelpers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class TaskController extends Controller
{

    use ApiResponseHelpers;

    public function __construct(private readonly TaskService $task_service) {
        
    }
    public function list()
    {

        $tasks = $this->task_service->getAllTasks();

        return $this->respondWithSuccess([
            'success' => true,
            'message' => 'displaying all tasks',
            'data' => $tasks->items(),
            'total_records' => $tasks->total(),
            'current_page' => $tasks->currentPage(),
            'per_page' => $tasks->perPage(),
            'last_page' => $tasks->lastPage(),
            'prev_page_url' => $tasks->previousPageUrl(),
            'next_page_url' => $tasks->nextPageUrl()            
        ]);
        
    }

    public function add(AddTask $request)
    {

        $task = $this->task_service->addTask(TaskDTO::fromApiAddTask($request));

        return $this->respondCreated([
            'message' => 'Task created successfully.',
            'success' => true,
            'task' => $task
        ]);

    }

    public function edit(UpdateTask $request, $id)
    {
        
            $task = $this->task_service->updateTask(TaskDTO::fromApiEditTask($request), $id);

            return $this->respondWithSuccess([
                'message' => 'Task Found & Updated',
                'success' => true,
                'updated_task' => $task,
            ]);
       
    }

    public function destroy(Request $request, $id)
    {
        
            $this->task_service->deleteTask($id);

            return $this->respondWithSuccess([
                'message' => 'Task Deleted Successfully',
                'success' => true,
            ]);

    }

    //Import and Export
    public function import(Request $request)
    {
        $response = $this->task_service->importTask($request);

        return $this->respondWithSuccess([
            'response' => $response
        ]);

    }

    public function export()
    {
        $this->task_service->exportTask();
        return $this->respondWithSuccess([
            'message' => 'Tasks exported successfully.',
            'success' => true
        ]);
    }

    public function generatePdf(){
       
        $pdf = $this->task_service->generatePDF();

        return $pdf->download('All Tasks.pdf');
        
    }
}



