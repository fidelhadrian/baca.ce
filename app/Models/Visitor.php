<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = ['nim', 'check_in_at', 'check_out_at'];

    protected $dates = ['check_in_at', 'check_out_at'];

    /**
     * Define relationship to Student.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'nim', 'nim'); // Assuming 'nim' is the linking field in both tables
    }

    /**
     * Record attendance for a visitor.
     */
    public static function recordAttendance($nim)
    {
        $visitor = self::where('nim', $nim)
                       ->whereDate('check_in_at', Carbon::today())
                       ->whereNull('check_out_at')
                       ->first();
    
        if ($visitor) {
            // If already checked in, update with check-out time
            $visitor->update(['check_out_at' => now()]);
        } else {
            // If not checked in today, create a new check-in entry
            self::create([
                'nim' => $nim,
                'check_in_at' => now(),
            ]);
        }
    }
}
