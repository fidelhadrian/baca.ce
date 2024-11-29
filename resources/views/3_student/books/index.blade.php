<!-- resources/views/3_student/books/index.blade.php -->
<x-app-layout>
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold">Available Books</h1>

                <!-- Search Form -->
                <form method="GET" action="{{ route('student.books.index') }}" class="flex space-x-4 mb-6">
                    <input type="text" id="isbnSearch" name="search" placeholder="Search by title, author, or ISBN" value="{{ request('search') }}" class="border-gray-300 rounded-md shadow-sm" autofocus>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Search</button>
                </form>

                <!-- Book List -->
                @if($books->isNotEmpty())
                    <table class="table-auto w-full mt-6">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Cover</th>
                                <th class="px-4 py-2">ISBN</th>
                                <th class="px-4 py-2">Title</th>
                                <th class="px-4 py-2">Author</th>
                                <th class="px-4 py-2">Stock</th>
                                <th class="px-4 py-2">Specialization</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                                <tr class="bg-gray-100">
                                    <td class="border px-4 py-2">
                                        <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/default-cover.jpg') }}" 
                                             alt="Cover" class="w-16 h-24 object-cover rounded-md">
                                    </td>
                                    <td class="border px-4 py-2">{{ $book->isbn }}</td>
                                    <td class="border px-4 py-2">{{ $book->title }}</td>
                                    <td class="border px-4 py-2">{{ $book->author }}</td>
                                    <td class="border px-4 py-2">{{ $book->stock }}</td>
                                    <td class="border px-4 py-2">{{ $book->specialization->name }}</td>
                                    <td class="border px-4 py-2">
                                        @if ($book->stock > 0)
                                            <!-- Action Button to show book details -->
                                            <a href="{{ route('student.books.show', $book->isbn) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Show</a>
                                        @else
                                            <span class="text-red-500">Out of Stock</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center mt-4">No books found.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
