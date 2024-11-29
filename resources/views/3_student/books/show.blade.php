<!-- resources/views/3_student/books/show.blade.php -->
<x-app-layout>
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-4">Book Details</h2>

                <!-- Book Details -->
                <div class="mb-6">
                    <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/default-cover.jpg') }}" 
                         alt="Cover" class="w-32 h-48 object-cover rounded-md mb-4">
                    <p><strong>Title:</strong> {{ $book->title }}</p>
                    <p><strong>Author:</strong> {{ $book->author }}</p>
                    <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                    <p><strong>Specialization:</strong> {{ $book->specialization->name }}</p>
                    <p><strong>Synopsis:</strong> {{ $book->desc ?? 'No description available' }}</p>
                </div>

                <!-- Borrowing Rules -->
                <div class="mb-6">
                    <h3 class="font-semibold">Borrowing Rules:</h3>
                    <ul class="list-disc ml-5">
                        <li>Maximum of 2 books at a time.</li>
                        <li>Loan period is 2 weeks, with an option to renew once.</li>
                        <li>If the book is lost, a replacement must be provided.</li>
                        <li>Student ID card (KTM) will be taken during return.</li>
                        <li>A fine of IDR 1000 per day is charged for overdue returns.</li>
                    </ul>
                </div>

                <!-- Borrow Action -->
                @auth
                    @if (Auth::user()->role === 'student' && $book->stock > 0)
                        <form method="POST" action="{{ route('student.books.borrow', $book->isbn) }}">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Borrow Book</button>
                        </form>
                    @elseif ($book->stock <= 0)
                        <p class="text-red-500 mt-2">This book is out of stock.</p>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md">Login to Borrow</a>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>
