<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'nim';
    protected $fillable = ['nim', 'name', 'angkatan', 'gender', 'status'];
    protected $dates = ['deleted_at']; // Tambahkan kolom deleted_at

    public function user()
    {
        return $this->belongsTo(User::class, 'nim', 'personal_id');
    }

    public function visitors()
    {
        return $this->hasMany(Visitor::class, 'nim', 'nim');
    }
}
