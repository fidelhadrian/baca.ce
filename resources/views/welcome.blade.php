<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RBC Teknik Komputer</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles and Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/welcome.css'])
    <style>
        /* Ensure proper styling here */
        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background-color: #ffffff;
        }

        .logo img {
            height: 50px;
        }

        .navigation a {
            margin-left: 20px;
            color: #1f2937; /* text-gray-800 */
            text-decoration: none;
            font-weight: 500;
        }

        .navigation a:hover {
            color: #4b5563; /* text-gray-600 */
        }

        .marquee {
            background-color: #f8fafc; /* light gray background for the marquee */
            padding: 10px 0;
            font-size: 1.2rem;
            color: #111827; /* dark gray text */
        }

        .hero {
            position: relative;
            height: 60vh; /* Adjusted height */
            overflow: hidden;
        }

        .hero video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.7);
        }

        .hero-content h1 {
            font-size: 3rem;
            font-weight: 600;
        }

        .hero-content p {
            margin-top: 10px;
            font-size: 1.2rem;
        }

        .search-bar {
            margin-top: 30px;
        }

        .footer {
            background-color: #1f2937; /* dark gray */
            color: white;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body class="font-sans antialiased">

    <!-- Header and Marquee -->
    <header class="header-container">
        <div class="logo">
            <img src="{{ asset('images/S1-Teknik-Komputer.png') }}" alt="Logo Teknik Komputer">
        </div>
        <nav class="navigation">
            @if (Route::has('login'))
                @auth
                    @if(auth()->user()->role->name === 'admin')
                        <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                    @elseif(auth()->user()->role->name === 'student')
                        <a href="{{ route('student.dashboard') }}">Dashboard Student</a>
                    @else
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            @endif
        </nav>
    </header>

    <!-- Marquee -->
    <div class="marquee">
        <marquee behavior="scroll" direction="left" scrollamount="7">
            Scan barcode KTM Anda di halaman ini untuk mengisi kehadiran di Ruang Baca Teknik Komputer!
        </marquee>
    </div>

    <!-- Hero Section with Video -->
    <section class="hero">
        <video autoplay loop muted>
            <source src="{{ asset('videos/video.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="hero-content">
            <h1>Ruang Baca Teknik Komputer</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque accumsan augue ac felis aliquet malesuada.</p>
            
            <!-- Search Bar -->
            <form action="{{ route('student.books.index') }}" method="GET" class="search-bar">
                <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        class="w-full p-3 pl-4 pr-20 rounded-lg shadow-lg border text-black border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
                        placeholder="Cari buku..."
                        required
                    />
                    <button 
                        type="submit" 
                        class="absolute top-0 right-0 mt-0 mr-0 p-2.5 px-4 h-full text-white bg-blue-600 rounded-r-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        Search
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Teknik Komputer Universitas Diponegoro</p>
        </div>
    </footer>

    <!-- Script for barcode detection and attendance handling -->
    <script>
        let barcode = '';
        let barcodeTimeout;

        function showNotification(message) {
            const notification = document.getElementById('notification');
            notification.innerText = message;
            notification.style.display = 'block';

            setTimeout(() => {
                notification.style.display = 'none';
            }, 4000);
        }

        function handleNimScan(nim) {
            fetch("{{ route('visitors.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ nim: nim })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message);
                    window.location.href = `{{ url('visitors') }}?nim=${nim}`;
                } else {
                    showNotification(`Error: ${data.message}`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification("Gagal mencatat kehadiran.");
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                if (barcode.length === 14 && !isNaN(barcode)) { // NIM detected
                    handleNimScan(barcode);
                } else { // Assume it’s an ISBN search
                    window.location.href = `{{ route('student.books.index') }}?search=${barcode}`;
                }
                barcode = '';
            } else {
                if (e.key.length === 1) {
                    barcode += e.key;
                    clearTimeout(barcodeTimeout);
                    barcodeTimeout = setTimeout(() => {
                        barcode = '';
                    }, 200);
                }
            }
        });
    </script>
</body>
</html>
