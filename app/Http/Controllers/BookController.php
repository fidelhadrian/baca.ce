<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Show the list of books (with search functionality).
     */
    public function index(Request $request)
    {
        // Query the books based on search
        $query = Book::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%$search%")
                  ->orWhere('author', 'like', "%$search%")
                  ->orWhere('isbn', 'like', "%$search%");
        }

        // Eager load the related specialization for filtering
        $books = $query->with('specialization')->get();

        // Use the correct view path: '3_student.books.index'
        return view('3_student.books.index', compact('books'));
    }

    /**
     * Show the details of a single book.
     */
    public function show($isbn)
    {
        // Find the book by ISBN
        $book = Book::where('isbn', $isbn)->firstOrFail();

        // Show the detailed view of the book
        return view('3_student.books.show', compact('book'));
    }

    /**
     * Borrow a book.
     */
    public function borrowBook(Request $request, $isbn)
    {
        $book = Book::where('isbn', $isbn)->firstOrFail();
        $user = Auth::user();

        // Ensure the student can borrow only up to 2 books
        $existingLoans = BookLoan::where('user_id', $user->id)
                                 ->where('status', 'borrowed')
                                 ->count();

        if ($existingLoans >= 2) {
            return redirect()->route('student.books.index')->withErrors('You can only borrow up to 2 books.');
        }

        // Check if the book is available in stock
        if ($book->stock <= 0) {
            return redirect()->route('student.books.index')->withErrors('The book is out of stock.');
        }

        // Create the loan record
        BookLoan::create([
            'isbn' => $book->isbn,
            'user_id' => $user->id,
            'loan_date' => now(),
            'due_date' => now()->addWeeks(2),
            'status' => 'borrowed',
        ]);

        // Decrease the stock of the book
        $book->decrement('stock');

        return redirect()->route('student.books.index')->with('success', 'Book borrowed successfully.');
    }
}
