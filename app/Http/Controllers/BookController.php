<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books')); // Display list of books
    }

    public function create()
    {
        return view('books.create'); // Form to add a new book
    }

    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'required|string|unique:books',
            'title' => 'required|string',
            'author' => 'required|string',
            'category' => 'required|string',
            'stock' => 'required|integer|min:1',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Book added successfully.');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book')); // Form to edit an existing book
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'category' => 'required|string',
            'stock' => 'required|integer|min:1',
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
