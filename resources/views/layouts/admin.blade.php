<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dasbor Admin') - Lab FEB UMPRI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen flex">
    
    <!-- Sidebar -->
    <aside class="bg-blue-900 text-white w-64 flex-shrink-0 flex flex-col hidden md:flex">
        <div class="h-16 flex items-center justify-center border-b border-blue-800 px-4">
            <img src="{{ asset('images/header_logo.png') }}" alt="Logo UMPRI" class="h-10 w-auto object-contain">
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-md hover:bg-blue-800 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800' : '' }}">Dasbor</a>
            <a href="{{ route('admin.laboratories.index') }}" class="block px-4 py-2 rounded-md hover:bg-blue-800 {{ request()->routeIs('admin.laboratories.*') ? 'bg-blue-800' : '' }}">Laboratorium</a>
            <a href="{{ route('admin.bookings.index') }}" class="block px-4 py-2 rounded-md hover:bg-blue-800 {{ request()->routeIs('admin.bookings.*') ? 'bg-blue-800' : '' }}">Peminjaman</a>
            <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 rounded-md hover:bg-blue-800 {{ request()->routeIs('admin.users.*') ? 'bg-blue-800' : '' }}">Pengguna</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Topbar -->
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6">
            <div class="flex items-center">
                <span class="text-xl font-bold text-gray-800">Admin Panel</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-gray-700" target="_blank">Lihat Website</a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">Logout</button>
                </form>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-6 overflow-y-auto">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
