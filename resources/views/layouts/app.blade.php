<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Laboratorium FEB UMPRI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-primary text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Kiri (Logo) -->
                <div class="flex-1 flex justify-start">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <img src="{{ asset('images/header_logo.png') }}" alt="Logo UMPRI" class="h-8 w-auto max-w-[150px] object-contain">
                    </a>
                </div>
                
                <!-- Tengah (Teks) -->
                <div class="flex-shrink-0 flex justify-center">
                    <span class="font-bold text-lg md:text-lg tracking-tight text-white sm:block whitespace-nowrap">Laboratorium Fakultas Ekonomi dan Bisnis</span>
                </div>
                
                <!-- Kanan (Login) -->
                <div class="flex-1 flex justify-end">
                    <a href="{{ route('admin.login') }}" class="text-sm text-gray-200 hover:text-white transition whitespace-nowrap">Login Admin</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    @yield('hero')

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Fakultas Ekonomi dan Bisnis Universitas Muhammadiyah Pringsewu. All rights reserved.
        </div>
    </footer>
</body>
</html>
