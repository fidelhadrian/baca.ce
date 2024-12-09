@extends('2_admin.layouts.base')

@section('title', 'Index Students')

@section('content')
    <div class="card">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Data Mahasiswa</h3>
        </div> <!-- /.card-header -->

        <div class="card-body">
            <div class="row mb-3">
                <!-- Tombol Tambah Mahasiswa berada di kiri -->
                <a href="{{ route('admin.students.create') }}" class="btn btn-success col-12 col-md-2">
                    Tambah Mahasiswa
                </a>

                <!-- Search Form di kanan -->
                <form action="{{ route('admin.students.index') }}" method="GET"
                    class="form-inline col-12 col-md-10 d-flex justify-content-md-end">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..."
                        value="{{ request('search') }}" style="width: 250px;">
                    <button type="submit" class="btn btn-primary btn-sm ml-2">Cari</button>
                </form>
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Angkatan</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th> <!-- Kolom untuk action Edit dan Hapus -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $index => $student)
                        <tr class="align-middle">
                            <td>{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
                            <td>{{ $student->nim }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->angkatan }}</td>
                            <td>{{ $student->gender }}</td>
                            <td>{{ $student->status }}</td>
                            <td>{{ $student->created_at }}</td>
                            <td>{{ $student->updated_at }}</td>
                            <td>
                                <!-- Tombol Edit -->
                                <a href="{{ route('admin.students.edit', $student->nim) }}"
                                    class="btn btn-warning btn-sm">Edit</a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('admin.students.destroy', $student->nim) }}" method="POST"
                                    style="display:inline-block;"
                                    onsubmit="return confirm('Are you sure you want to delete this student?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> <!-- /.card-body -->

        <div class="card-footer clearfix d-flex justify-content-between">
            <!-- Pagination -->
            {{ $students->links('pagination::bootstrap-4') }}
        </div>
    </div> <!-- /.card -->

    <!-- Tombol untuk menghapus data yang terhapus -->
    <a href="{{ route('admin.trashed') }}" class="btn btn-danger rounded-circle"
        style="position: fixed; bottom: 20px; right: 20px; width: 50px; height: 50px; display: flex; justify-content: center; align-items: center;">
        <i class="bi bi-trash"></i>
    </a>

@endsection
