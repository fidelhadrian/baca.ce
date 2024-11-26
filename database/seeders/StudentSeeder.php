<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'name' => 'Fadhil Hadrian Azzami',
                'nim' => '21120121130120',
                'angkatan' => 2021,
                'gender' => 'laki',
                'status' => 'aktif',
            ],
            [
                'name' => 'Fikri Abdurrohim Ibnu Prabowo',
                'nim' => '21120121140033',
                'angkatan' => 2021,
                'gender' => 'laki',
                'status' => 'aktif',
            ],
            [
                'name' => 'Putrandi Agung Prabowo',
                'nim' => '21120121130074',
                'angkatan' => 2021,
                'gender' => 'laki',
                'status' => 'aktif',
            ],
        ];

        foreach ($students as $student) {
            Student::updateOrCreate(['nim' => $student['nim']], $student);
        }
    }
}