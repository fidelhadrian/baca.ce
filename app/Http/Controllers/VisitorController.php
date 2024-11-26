<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Visitor;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar kehadiran harian
     */
    public function index(Request $request)
    {
        $todayVisitors = Visitor::whereDate('check_in_at', Carbon::today())->get();
        return view('visitors.index', compact('todayVisitors'));
    }

    public function store(Request $request)
    {
        $request->validate(['nim' => 'required|string']);
    
        // Find student data based on NIM
        $student = Student::where('nim', $request->nim)->first();
    
        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Mahasiswa tidak ditemukan.']);
        }
    
        // Check if there is an existing entry for today with no check-out
        $visitor = Visitor::where('nim', $request->nim)
                          ->whereDate('check_in_at', Carbon::today())
                          ->whereNull('check_out_at')
                          ->first();
    
        if ($visitor) {
            // If already checked in, update with check-out time
            $visitor->check_out_at = Carbon::now();
            $visitor->save();
            return response()->json(['success' => true, 'message' => 'Berhasil check-out.']);
        } else {
            // If not checked in today, create a new check-in entry
            Visitor::create([
                'nim' => $request->nim,
                'name' => $student->name,

                'check_in_at' => Carbon::now(),
            ]);
            return response()->json(['success' => true, 'message' => 'Berhasil check-in.']);
        }
    }
    
    

    /**
     * Display the specified resource.
     * Menampilkan detail kehadiran mahasiswa berdasarkan ID
     */
    public function show(Visitor $visitor)
    {
        return view('visitors.show', compact('visitor'));
    }

    /**
     * Update the specified resource in storage.
     * Update data visitor, misalnya jam keluar
     */
    public function update(Request $request, Visitor $visitor)
    {
        $visitor->update($request->only(['check_out_at']));
        return redirect()->route('visitors.index')->with('success', 'Data kehadiran diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus data kehadiran visitor
     */
    public function destroy(Visitor $visitor)
    {
        $visitor->delete();
        return redirect()->route('visitors.index')->with('success', 'Data kehadiran dihapus');
    }
}
