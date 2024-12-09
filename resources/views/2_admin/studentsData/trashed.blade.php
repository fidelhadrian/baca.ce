@extends('2_admin.layouts.base')

@section('title', 'Trashed Students')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Mahasiswa yang Terhapus</h3>
        </div>
        <div class="card-body">
            @if ($students->isEmpty())
                <div class="alert alert-info">
                    <i class="icon fas fa-info"></i>
                    Tidak ada data mahasiswa yang terhapus.
                </div>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Angkatan</th>
                            <th>Gender</th>
                            <th>Status</th>
                            <th>Deleted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $index => $student)
                            <tr>
                                <td>{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
                                <td>{{ $student->nim }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->angkatan }}</td>
                                <td>{{ $student->gender }}</td>
                                <td>{{ $student->status }}</td>
                                <td>{{ $student->deleted_at }}</td>
                                <td>
                                    <!-- Restore -->
                                    <form action="{{ route('admin.restore', $student->nim) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                    </form>

                                    <!-- Force Delete -->
                                    <form action="{{ route('admin.forceDelete', $student->nim) }}" method="POST"
                                        style="display:inline-block;"
                                        onsubmit="return confirm('Are you sure you want to permanently delete this student?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Force Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="card-footer clearfix">
            {{ $students->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
