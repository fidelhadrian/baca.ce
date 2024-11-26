<?php

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Student Data Fetching Route
Route::get('/students/{nim}', function ($nim) {
    // Attempt to find the student by the provided NIM
    $student = Student::where('nim', $nim)->first();

    // Return 404 response if student not found
    if (!$student) {
        return response()->json([
            'success' => false,
            'message' => 'Student not found',
        ], 404);
    }

    // Return student data in structured JSON response if found
    return response()->json([
        'success' => true,
        'data' => [
            'name' => $student->name,
            'gender' => $student->gender,
            'angkatan' => $student->angkatan,
        ],
    ]);
});
