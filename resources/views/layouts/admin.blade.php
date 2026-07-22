<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') - Lab FEB UMPRI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen flex">
    
    <!-- Sidebar -->
    <aside class="bg-blue-900 text-white w-64 flex-shrink-0 flex flex-col hidden md:flex">
        <div class="h-16 flex items-center justify-center border-b border-blue-800 px-4">
            <img src="{{ asset('images/header_logo.png') }}" alt="Logo UMPRI" class="h-10 w-auto object-contain">
        </div>
        <nav class="flex-1 py-6 flex flex-col">
            <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-4 px-6 py-3 hover:bg-blue-800 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800 border-r-4 border-blue-300' : 'border-r-4 border-transparent' }}">
                <svg class="w-5 h-5 text-blue-300 opacity-80 group-hover:scale-125 group-hover:opacity-100 group-hover:text-white transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="{{ route('admin.laboratories.index') }}" class="group flex items-center gap-4 px-6 py-3 hover:bg-blue-800 transition-colors {{ request()->routeIs('admin.laboratories.*') ? 'bg-blue-800 border-r-4 border-blue-300' : 'border-r-4 border-transparent' }}">
                <svg class="w-5 h-5 text-blue-300 opacity-80 group-hover:scale-125 group-hover:opacity-100 group-hover:text-white transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <span class="font-medium">Laboratorium</span>
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="group flex items-center gap-4 px-6 py-3 hover:bg-blue-800 transition-colors {{ request()->routeIs('admin.bookings.*') ? 'bg-blue-800 border-r-4 border-blue-300' : 'border-r-4 border-transparent' }}">
                <svg class="w-5 h-5 text-blue-300 opacity-80 group-hover:scale-125 group-hover:opacity-100 group-hover:text-white transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="font-medium">Peminjaman</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="group flex items-center gap-4 px-6 py-3 hover:bg-blue-800 transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-blue-800 border-r-4 border-blue-300' : 'border-r-4 border-transparent' }}">
                <svg class="w-5 h-5 text-blue-300 opacity-80 group-hover:scale-125 group-hover:opacity-100 group-hover:text-white transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="font-medium">Pengguna</span>
            </a>
            <div class="my-2 border-t border-blue-800/50"></div>
            <a href="{{ route('admin.settings.hero') }}" class="group flex items-center gap-4 px-6 py-3 hover:bg-blue-800 transition-colors {{ request()->routeIs('admin.settings.hero') ? 'bg-blue-800 border-r-4 border-blue-300' : 'border-r-4 border-transparent' }}">
                <svg class="w-5 h-5 text-blue-300 opacity-80 group-hover:scale-125 group-hover:opacity-100 group-hover:text-white transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="font-medium">Pengaturan Beranda</span>
            </a>
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
                <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium hidden sm:inline-flex items-center gap-1" target="_blank">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    Lihat Website
                </a>
                <div class="h-6 w-px bg-gray-200 hidden sm:block"></div>
                
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="hidden sm:block">
                        <div class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</div>
                    </div>
                </div>

                <div class="h-6 w-px bg-gray-200 hidden sm:block"></div>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
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
