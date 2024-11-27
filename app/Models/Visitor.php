<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Visitor extends Model
{
    protected $fillable = ['nim', 'check_in_at', 'check_out_at'];
    protected $dates = ['check_in_at', 'check_out_at'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'nim', 'nim');
    }

    public static function recordAttendance($nim)
    {
        $visitor = self::where('nim', $nim)
                       ->whereDate('check_in_at', Carbon::today())
                       ->whereNull('check_out_at')
                       ->first();

        if ($visitor) {
            $visitor->update(['check_out_at' => now()]);
        } else {
            self::create([
                'nim' => $nim,
                'check_in_at' => now(),
            ]);
        }
    }
}
