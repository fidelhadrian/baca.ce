@extends('2_admin.layouts.base')

@section('title', 'Insert Data Student')

@section('content')
    <div class="card mx-5">
        <div class="card-header">
            <h3 class="card-title">Tambah Data Mahasiswa</h3>
        </div> <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" required>
                </div>
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="angkatan">Angkatan</label>
                    <select name="angkatan" id="angkatan" class="form-control" required>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2023">2023</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" class="form-control" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Non-Aktif">Non-Aktif</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file">Upload Data Mahasiswa (Excel)</label>
                    <input type="file" name="file" id="file" class="form-control" accept=".xls,.xlsx" required>
                </div>
                <button type="submit" class="btn btn-primary">Import</button>
            </form>
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
@endsection
