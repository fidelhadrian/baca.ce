<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'nim';
    protected $fillable = ['nim', 'name', 'angkatan', 'gender', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'nim', 'personal_id');
    }

    public function visitors()
    {
        return $this->hasMany(Visitor::class, 'nim', 'nim');
    }
}
