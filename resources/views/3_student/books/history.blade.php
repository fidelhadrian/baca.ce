<!-- resources/views/3_student/books/history.blade.php -->
<x-app-layout>
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold">Loan History</h1>

                <!-- Loan History Table -->
                @if($loans->isNotEmpty())
                    <table class="table-auto w-full mt-6">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">ISBN</th>
                                <th class="px-4 py-2">Title</th>
                                <th class="px-4 py-2">Loan Date</th>
                                <th class="px-4 py-2">Due Date</th>
                                <th class="px-4 py-2">Return Date</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loans as $loan)
                                <tr>
                                    <td class="border px-4 py-2">{{ $loan->book->isbn }}</td>
                                    <td class="border px-4 py-2">{{ $loan->book->title }}</td>
                                    <td class="border px-4 py-2">{{ $loan->loan_date->format('d/m/Y') }}</td>
                                    <td class="border px-4 py-2">{{ $loan->due_date->format('d/m/Y') }}</td>
                                    <td class="border px-4 py-2">
                                        @if($loan->return_date)
                                            {{ $loan->return_date->format('d/m/Y') }}
                                        @else
                                            <span class="text-red-500">Not Returned</span>
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        @if($loan->status === 'borrowed')
                                            <a href="{{ route('student.books.return', $loan->id) }}" class="bg-green-500 text-white px-4 py-2 rounded">Return</a>
                                        @elseif($loan->status === 'overdue')
                                            <a href="{{ route('student.books.renew', $loan->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Renew</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center mt-4">No loan history found.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
