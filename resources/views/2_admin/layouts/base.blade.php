<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>RBC | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE v4 | Dashboard">
    <meta name="author" content="ColorlibHQ">
    <meta name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard">
    <!-- Link ke CSS MDB (Material Design Bootstrap) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" rel="stylesheet" />

    <!-- SweetAlert2 untuk menampilkan alert modal -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Link ke Font Awesome (untuk ikon pencarian) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />

    <!-- Link ke JS MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>

    <!-- Font tambahan -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous">

    <!-- Plugin Overlay Scrollbars untuk scroll pada konten -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css"
        integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">

    <!-- Plugin Bootstrap Icons untuk ikon tambahan -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css"
        integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">

    <!-- Link ke stylesheet AdminLTE untuk UI dashboard -->
    <link rel="stylesheet" href="{{ asset('../adminlte/dist/css/adminlte.css') }}">

    <!-- Link untuk ApexCharts, plugin untuk grafik -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous">

    <!-- Link untuk jsvectormap, plugin untuk peta -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
        integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">

        @include('2_admin.layouts.navbar')
        @include('2_admin.layouts.sidebar')

        <main class="app-main">
            @yield('content')
        </main>

        @include('2_admin.layouts.footer')
    </div>
    @include('2_admin.layouts.scripts')
    <!-- SweetAlert Logic untuk menampilkan notifikasi -->
    <!-- Menampilkan notifikasi success jika ada pesan success -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: '{{ session('success') }}', // Pesan yang ditampilkan dari session('success')
            });
        </script>
    @endif

    <!-- Menampilkan notifikasi error jika ada pesan error -->
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: '{{ session('error') }}', // Pesan yang ditampilkan dari session('error')
            });
        </script>
    @endif

    <!-- Menampilkan notifikasi error jika ada error form -->
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '@foreach ($errors->all() as $error) {{ $error }} @endforeach', // Menampilkan semua pesan error validasi
            });
        </script>
    @endif

    <!-- Menyertakan SweetAlert dari package (optional) -->
    @include('sweetalert::alert')
</body>

</html>
