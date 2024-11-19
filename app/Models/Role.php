<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = ['name'];

    // Relasi Many-to-Many dengan User
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,      // Model relasi
            'role_user',      // Nama tabel pivot
            'role_id',        // Foreign key di tabel pivot yang merujuk ke roles
            'personal_id',    // Foreign key di tabel pivot yang merujuk ke users
            'id',             // Kolom primary key di tabel roles
            'personal_id'     // Kolom lokal di tabel users
        );
    }
}
