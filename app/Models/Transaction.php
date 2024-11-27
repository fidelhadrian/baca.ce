<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['book_loan_id', 'transaction_type', 'amount'];

    const TRANSACTION_BORROW = 'borrow';
    const TRANSACTION_RENEWAL = 'renewal';
    const TRANSACTION_RETURN = 'return';
    const TRANSACTION_FINE = 'fine';

    public function bookLoan()
    {
        return $this->belongsTo(BookLoan::class);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('transaction_type', $type);
    }

    public function scopeByLoan($query, $loanId)
    {
        return $query->where('book_loan_id', $loanId);
    }
}
