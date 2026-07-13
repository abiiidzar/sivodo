<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIVODO') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('scripts')
    </head>
    <body class="font-sans antialiased bg-[#f5f3ef]">
        <div class="min-h-screen bg-[#f5f3ef]">
            <!-- Navbar -->
            <nav class="bg-[#1a2744] border-b border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Left Side -->
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center">
                                <span class="text-white font-bold text-xl">SIVODO</span>
                                <span class="text-[#bfdbfe] text-sm ml-2 hidden sm:block">| PT. Lentera Edukasi</span>
                            </div>
                        </div>

                        <!-- Right Side -->
                        <div class="flex items-center gap-4">
                            <span class="text-white text-sm hidden md:block">{{ Auth::user()->nama }}</span>
                            <span class="text-xs px-2 py-1 bg-[rgba(201,162,39,0.20)] text-[#e8c560] rounded-full capitalize">
                                {{ Auth::user()->role }}
                            </span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-300 hover:text-white text-sm">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="flex">
                <!-- Sidebar -->
                <div class="w-64 min-h-screen bg-white shadow-lg hidden md:block">
                    <div class="p-4">
                        <h3 class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-4">Menu</h3>
                        <nav class="space-y-1">
                            @if(Auth::user()->role == 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-[#1a2744] hover:bg-[rgba(26,39,68,0.05)] rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-[rgba(26,39,68,0.08)] font-semibold' : '' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                    Dashboard
                                </a>
                                <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-[rgba(26,39,68,0.05)] rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    Master Data
                                </a>
                                <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-[rgba(26,39,68,0.05)] rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    Laporan
                                </a>
                            @elseif(Auth::user()->role == 'mahasiswa')
                                <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-[#1a2744] hover:bg-[rgba(26,39,68,0.05)] rounded-lg {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-[rgba(26,39,68,0.08)] font-semibold' : '' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                    Dashboard
                                </a>
                                <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-[rgba(26,39,68,0.05)] rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    Daftar Dosen
                                </a>
                                <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-[rgba(26,39,68,0.05)] rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    Ranking
                                </a>
                            @elseif(Auth::user()->role == 'pimpinan')
                                <a href="{{ route('pimpinan.dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-[#1a2744] hover:bg-[rgba(26,39,68,0.05)] rounded-lg {{ request()->routeIs('pimpinan.dashboard') ? 'bg-[rgba(26,39,68,0.08)] font-semibold' : '' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                    Dashboard
                                </a>
                                <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-[rgba(26,39,68,0.05)] rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    Grafik
                                </a>
                                <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-[rgba(26,39,68,0.05)] rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    Laporan
                                </a>
                            @endif
                        </nav>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="flex-1">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
