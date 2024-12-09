<?php

namespace App\Http\Controllers;

use App\Imports\StudentsImport;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mengambil semua data mahasiswa dari database
        $search = $request->input('search');

        // Query untuk mengambil data mahasiswa berdasarkan pencarian
        $students = Student::when($search, function ($query, $search) {
            return $query->where('nim', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");
        })
            ->paginate(5);

        // Mengecek role dari pengguna yang sedang login
        if (auth()->user()->role_id === 1) {
            // Return view untuk superadmin
            return view('1_superadmin.studentsData.index', compact('students'));
        } elseif (auth()->user()->role_id === 2) {
            // Return view untuk admin
            return view('2_admin.studentsData.index', compact('students'));
        } else {
            // Jika role tidak sesuai, tampilkan error 403
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role_id === 1) {
            // Return view untuk superadmin
            return view('1_superadmin.studentsData.index', compact('students'));
        } else if (auth()->user()->role_id === 2) {
            // Return view untuk admin
            return view('2_admin.studentsData.create');
        } else {
            // Opsional: Jika role tidak sesuai, bisa redirect atau tampilkan error
            abort(403, 'Unauthorized action1.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nim' => 'required|unique:students,nim|max:10',
            'name' => 'required|max:255',
            'angkatan' => 'required|in:2019,2020,2021,2023',
            'gender' => 'required|in:L,P',
            'status' => 'required|in:Aktif,Non-Aktif',
        ]);

        Student::create($validatedData);

        return redirect()->route('admin.students.index')->with('success', 'Data mahasiswa berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    public function edit(Student $student)
    {
        // Return view untuk menampilkan form edit, dengan data mahasiswa
        return view('2_admin.studentsData.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'angkatan' => 'required|digits:4',
            'gender' => 'required|in:L,P',
            'status' => 'required|in:Aktif,Non-Aktif',
        ]);

        // Update data di database
        $student->update($validatedData);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.students.index')->with('success', 'Data mahasiswa berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        // Soft delete data
        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Data mahasiswa berhasil dihapus!');
    }
    public function trashed()
    {
        // Mengambil data mahasiswa yang dihapus (soft delete)
        $students = Student::onlyTrashed()->paginate(10);

        return view('2_admin.studentsData.trashed', compact('students'));
    }

    /**
     * Restore the specified soft deleted student.
     */
    public function restore($nim)
    {
        // Restore data mahasiswa yang dihapus
        $student = Student::onlyTrashed()->findOrFail($nim);
        $student->restore();

        return redirect()->route('admin.students.index')->with('success', 'Data mahasiswa berhasil dikembalikan!');
    }

    /**
     * Permanently delete the specified soft deleted student.
     */
    public function forceDelete($nim)
    {
        // Hapus data secara permanen
        $student = Student::onlyTrashed()->findOrFail($nim);
        $student->forceDelete();

        return redirect()->route('admin.trashed')->with('success', 'Data mahasiswa berhasil dihapus secara permanen!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx',
        ]);

        try {
            Excel::import(new StudentsImport, $request->file('file'));

            // Beri tahu user bahwa import sukses
            return redirect()->route('admin.students.index')->with('success', 'Data mahasiswa berhasil diimpor.');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            // Periksa pesan error untuk mendeteksi duplikasi
            if (strpos($errorMessage, 'Duplicate entry') !== false) {
                return redirect()->route('admin.students.index')->with('error', 'Terjadi duplikasi data saat mengimpor.');
            } else {
                // Jika error bukan duplikasi, tampilkan pesan error default
                return redirect()->route('admin.students.index')->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $errorMessage);
            }
        }
    }
}