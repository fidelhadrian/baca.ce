@extends('2_admin.layouts.base') <!-- Memanggil layout base sebagai template dasar halaman -->

@section('title', 'Insert Data Student') <!-- Menetapkan title halaman untuk bagian head -->

@section('content') <!-- Konten utama halaman -->

    <div class="card mx-5"> <!-- Membungkus form dalam sebuah card untuk tampilan lebih baik -->

        <div class="card-header">
            <h3 class="card-title"><a href="javascript:history.back()" class="me-3">
                    <i class="bi bi-arrow-left-circle"></i>
                </a>Tambah Data Mahasiswa</h3> <!-- Judul form -->
        </div> <!-- /.card-header -->
        <div class="card-body">

            <form action="{{ route('admin.students.store') }}" method="POST"> <!-- Form untuk menyimpan data mahasiswa -->
                @csrf <!-- Menambahkan token CSRF untuk keamanan -->

                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim') }}"
                        required> <!-- Input untuk NIM -->
                    @error('nim')
                        <!-- Menampilkan pesan error jika ada validasi gagal -->
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                        required> <!-- Input untuk nama -->
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="angkatan">Angkatan</label>
                    <select name="angkatan" id="angkatan" class="form-control" required>
                        <!-- Dropdown untuk memilih angkatan -->
                        <option value="2019" {{ old('angkatan') == '2019' ? 'selected' : '' }}>2019</option>
                        <option value="2020" {{ old('angkatan') == '2020' ? 'selected' : '' }}>2020</option>
                        <option value="2021" {{ old('angkatan') == '2021' ? 'selected' : '' }}>2021</option>
                        <option value="2023" {{ old('angkatan') == '2023' ? 'selected' : '' }}>2023</option>
                    </select>
                    @error('angkatan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" class="form-control" required>
                        <!-- Dropdown untuk memilih gender -->
                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <!-- Dropdown untuk memilih status -->
                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non-Aktif" {{ old('status') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit</button> <!-- Tombol untuk submit form -->
            </form>

            <!-- Form untuk upload file Excel -->
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
