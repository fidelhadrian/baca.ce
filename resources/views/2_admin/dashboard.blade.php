@extends('2_admin.layouts.base')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <h1>Welcome To Admin Page</h1>
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-primary">
                    <div class="inner">
                        <h3>{{ $total ?? 'Tidak ada data' }}</h3> <!-- Menampilkan jumlah mahasiswa -->
                        <p>Total Siswa</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
