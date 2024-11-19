<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $primaryKey = 'nik'; 
    public $incrementing = false; 

    protected $fillable = ['nik', 'name', 'division', 'phone'];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'nik', 'personal_id');
    }

    
}
