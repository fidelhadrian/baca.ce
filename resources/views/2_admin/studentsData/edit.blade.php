@extends('2_admin.layouts.base')

@section('title', 'Edit Data Mahasiswa')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Data Mahasiswa</h3>
        </div> <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('admin.students.update', $student->nim) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" name="nim" id="nim" class="form-control" value="{{ $student->nim }}"
                        readonly>
                </div>
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $student->name }}"
                        required>
                </div>
                <div class="form-group">
                    <label for="angkatan">Angkatan</label>
                    <input type="number" name="angkatan" id="angkatan" class="form-control"
                        value="{{ $student->angkatan }}" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" class="form-control" required>
                        <option value="L" {{ $student->gender == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ $student->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="Aktif" {{ $student->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non-Aktif" {{ $student->status == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
@endsection
