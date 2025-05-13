<?php

namespace App\DTO\TaskManagement;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;

class TaskDTO{

    public string $title;
    public string $description;
    public Carbon $deadline;

    public function store(array $data){
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->deadline = Carbon::parse($data['deadline']);
    }

    public function toArray(): array{
        return [
            'title' => $this->title,
            'description' => $this->description,
            'deadline' => $this->deadline->toDateTimeString(),
            'user_id' => Auth::id()
        ];
    }
}