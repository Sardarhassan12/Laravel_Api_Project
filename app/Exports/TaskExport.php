<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TaskExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Task::select('title', 'description', 'deadline')->get();
        // return Task::all();
    }

    public function headings(): array{
        return ['Title', 'Description', 'DeadLine'];
    }
}
