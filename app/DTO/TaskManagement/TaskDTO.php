<?php

namespace App\DTO\TaskManagement;

use App\Http\Requests\TaskManagement\AddTask;
use App\Http\Requests\TaskManagement\UpdateTask;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;

class TaskDTO{

    public function __construct(
        public string $title,
        public string $description,
        public Carbon $deadline
        
    ) {}

    public static function fromApiAddTask(AddTask $request) : self
    {

        return new self(
            $request->validated(['title']),
            $request->validated(['description']),
            Carbon::parse($request->validated(['deadline']))
        );

    }

    public static function fromApiEditTask(UpdateTask $request) : self
    {
        return new self(
            $request->validated(['title']),
            $request->validated(['description']),
            Carbon::parse($request->validated(['deadline']))
        );
    }

}
