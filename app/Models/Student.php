<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'nim'; 
    public $incrementing = false; 

    protected $fillable = ['nim', 'name', 'angkatan', 'gender', 'status'];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'nim', 'personal_id');
    }
}
