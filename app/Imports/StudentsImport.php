<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsImport implements ToModel
{
    public function model(array $row)
    {
        return new Student([
            'nim' => $row[0], // Sesuaikan dengan kolom yang ada pada file Excel
            'name' => $row[1],
            'angkatan' => $row[2],
            'gender' => $row[3],
            'status' => $row[4],
        ]);
    }
}