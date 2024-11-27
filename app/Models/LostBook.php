<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LostBook extends Model
{
    protected $fillable = ['book_loan_id', 'book_id', 'user_id', 'date_reported', 'replacement_status'];

    public function bookLoan()
    {
        return $this->belongsTo(BookLoan::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
