<?php

namespace App\Http\Controllers;

use App\Models\BookLoan;
use App\Models\Transaction;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookLoanController extends Controller
{
    // Borrow a book
    public function borrowBook(Request $request, $bookId)
    {
        $book = Book::findOrFail($bookId);
        $user = $request->user(); // Get the authenticated user

        // Ensure the user is a student
        if ($user->role->name !== 'student') {
            return response()->json(['error' => 'Only students can borrow books.'], 403);
        }

        // Check if the user has already borrowed 2 books
        $existingLoans = BookLoan::where('user_id', $user->id)
                                 ->where('status', 'borrowed')
                                 ->count();
        if ($existingLoans >= 2) {
            return response()->json(['error' => 'You can only borrow a maximum of 2 books.'], 400);
        }

        // Check if book is available for loan (stock > 0)
        if ($book->stock <= 0) {
            return response()->json(['error' => 'This book is not available for loan.'], 400);
        }

        // Create a new BookLoan
        $loan = BookLoan::create([
            'book_id' => $book->id,
            'user_id' => $user->id,
            'loan_date' => now(),
            'due_date' => now()->addWeeks(2), // Set due date to 2 weeks from now
            'status' => 'borrowed',
            'renewal_count' => 0, // Initial loan
            'fine_amount' => 0, // Initial fine
        ]);

        // Reduce book stock
        $book->decrement('stock', 1);

        // Create a Transaction for the loan
        Transaction::create([
            'book_loan_id' => $loan->id,
            'transaction_type' => Transaction::TRANSACTION_BORROW,
            'amount' => 0, // No fine yet
        ]);

        return response()->json(['message' => 'Book borrowed successfully.'], 200);
    }

    // Renew a loan
    public function renewLoan(Request $request, $loanId)
    {
        $loan = BookLoan::findOrFail($loanId);
        $user = $request->user();

        if ($loan->user_id !== $user->id) {
            return response()->json(['error' => 'You cannot renew someone else\'s loan.'], 403);
        }

        // Check if overdue
        $overdueDays = now()->diffInDays($loan->due_date, false);
        if ($overdueDays < 0) {
            // Calculate fine for overdue
            $fineAmount = abs($overdueDays) * 1000;
            $loan->fine_amount += $fineAmount; // Add to the total fine
        }

        // Allow only 1 renewal
        if ($loan->renewal_count >= 1) {
            return response()->json(['error' => 'You can only renew this book once.'], 400);
        }

        // Update loan details
        $loan->renewal_count++;
        $loan->due_date = now()->addWeeks(2); // Extend due date by 2 weeks
        $loan->save();

        // Create a Transaction for the renewal
        Transaction::create([
            'book_loan_id' => $loan->id,
            'transaction_type' => Transaction::TRANSACTION_RENEWAL,
            'amount' => $loan->fine_amount, // Fine applied
        ]);

        return response()->json(['message' => 'Loan renewed successfully.'], 200);
    }

    // Return a book
    public function returnBook(Request $request, $loanId)
    {
        $loan = BookLoan::findOrFail($loanId);
        $user = $request->user();

        if ($loan->user_id !== $user->id) {
            return response()->json(['error' => 'You cannot return someone else\'s book.'], 403);
        }

        // Mark book as returned
        $loan->status = 'returned';
        $loan->save();

        // Increase the book stock
        $book = $loan->book;
        $book->increment('stock', 1);

        // Create a Transaction for the return
        Transaction::create([
            'book_loan_id' => $loan->id,
            'transaction_type' => Transaction::TRANSACTION_RETURN,
            'amount' => $loan->fine_amount, // Include any fine amount
        ]);

        return response()->json(['message' => 'Book returned successfully.'], 200);
    }

    // Pay fine
    public function payFine(Request $request, $loanId)
    {
        $loan = BookLoan::findOrFail($loanId);
        $user = $request->user();

        if ($loan->user_id !== $user->id) {
            return response()->json(['error' => 'You cannot pay someone else\'s fine.'], 403);
        }

        $fineAmount = $loan->fine_amount;

        if ($fineAmount <= 0) {
            return response()->json(['error' => 'No fine to pay.'], 400);
        }

        // Pay fine and reset fine_amount
        $loan->fine_amount = 0;
        $loan->save();

        // Create a Transaction for the fine payment
        Transaction::create([
            'book_loan_id' => $loan->id,
            'transaction_type' => Transaction::TRANSACTION_FINE,
            'amount' => $fineAmount,
        ]);

        return response()->json(['message' => 'Fine paid successfully.'], 200);
    }
}
