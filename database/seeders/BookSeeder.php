<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Specialization;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create dummy specializations if not already present
        $specializations = Specialization::firstOrCreate(['name' => 'Software']);
        $specializations->firstOrCreate(['name' => 'Networking']);
        $specializations->firstOrCreate(['name' => 'Multimedia']);
        $specializations->firstOrCreate(['name' => 'Embedded System']);

        // Create dummy books data
        Book::create([
            'isbn' => '978-1-234-56789-7',
            'title' => 'Introduction to Software Engineering',
            'author' => 'John Doe',
            'stock' => 10,
            'specialization_id' => $specializations->where('name', 'Software')->first()->id,
        ]);

        Book::create([
            'isbn' => '978-0-123-45678-9',
            'title' => 'Networking Basics',
            'author' => 'Jane Smith',
            'stock' => 8,
            'specialization_id' => $specializations->where('name', 'Networking')->first()->id,
        ]);

        Book::create([
            'isbn' => '978-1-987-65432-1',
            'title' => 'Multimedia Design and Applications',
            'author' => 'Michael Lee',
            'stock' => 5,
            'specialization_id' => $specializations->where('name', 'Multimedia')->first()->id,
        ]);

        Book::create([
            'isbn' => '978-1-234-98765-4',
            'title' => 'Embedded Systems Programming',
            'author' => 'Sarah Connors',
            'stock' => 3,
            'specialization_id' => $specializations->where('name', 'Embedded System')->first()->id,
        ]);
    }
}
