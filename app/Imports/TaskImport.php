<?php

namespace App\Imports;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TaskImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use SkipsFailures;

    public int $rowsImportCount = 0;

    public function model(array $row)
    {
        $this->rowsImportCount++;
        
        return new Task([
            'title' => $row['title'],
            'description' => $row['description'],
            'deadline' => \Carbon\Carbon::parse($row['deadline'])->toDateTimeString(),
            'user_id' => Auth::id()
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string|min:10',
            'deadline' => 'required|date|after:today',
        ];
    }

    
}
