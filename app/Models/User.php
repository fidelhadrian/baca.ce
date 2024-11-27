<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'personal_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['personal_id', 'password', 'name', 'role_id'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function bookLoans()
    {
        return $this->hasMany(BookLoan::class);
    }

    // Add user_type for polymorphic relation if needed
    public function userType()
    {
        return $this->morphTo();
    }
}
