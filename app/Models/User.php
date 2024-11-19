<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['personal_id', 'password'];

    protected $hidden = ['password', 'remember_token'];

    // Override untuk autentikasi menggunakan personal_id
    public function getAuthIdentifierName(): string
    {
        return 'personal_id';
    }

    // Relasi Many-to-Many dengan Role
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,      // Model relasi
            'role_user',      // Nama tabel pivot
            'personal_id',    // Foreign key di tabel pivot yang merujuk ke users
            'role_id',        // Foreign key di tabel pivot yang merujuk ke roles
            'personal_id',    // Kolom lokal di tabel users
            'id'              // Kolom primary key di tabel roles
        );
    }

    // Relasi One-to-One dengan Student
    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'nim', 'personal_id');
    }

    // Relasi One-to-One dengan Lecturer
    public function lecturer(): HasOne
    {
        return $this->hasOne(Lecturer::class, 'nip', 'personal_id');
    }

    // Relasi One-to-One dengan Employee
    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class, 'nik', 'personal_id');
    }

    // Periksa apakah user memiliki role tertentu
    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }
}
