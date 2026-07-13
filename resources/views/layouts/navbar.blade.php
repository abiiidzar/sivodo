<nav class="navbar-sivodo sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo & Brand -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-gold-15 border-2 border-gold flex items-center justify-center">
                    <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-white font-bold text-lg leading-tight">SIVODO</h1>
                    <p class="text-blue-muda text-xs">PT. Lentera Edukasi ENBI</p>
                </div>
            </div>

            <!-- Center: Progress (khusus mahasiswa) -->
            @auth
                @role('mahasiswa')
                    @php
                        $mahasiswa = Auth::user()->mahasiswa;
                        $totalDosen = \App\Models\Dosen::count();
                        $sudahVoting = \App\Models\Voting::where('mahasiswa_id', $mahasiswa->id)->count();
                        $progress = $totalDosen > 0 ? round(($sudahVoting / $totalDosen) * 100) : 0;
                    @endphp
                    <div class="hidden md:flex items-center flex-1 max-w-md mx-8">
                        <div class="w-full">
                            <div class="flex justify-between text-xs text-white/70 mb-1">
                                <span>Progress Voting</span>
                                <span class="text-gold font-bold">{{ $progress }}%</span>
                            </div>
                            <div class="w-full h-2 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-gold rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>
                    </div>
                @endrole
            @endauth

            <!-- Right: User Menu -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- Notifikasi (belum) -->
                    <button class="text-white/70 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </button>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-gold transition group">
                            <div class="w-8 h-8 rounded-full bg-gold/20 border border-gold/50 flex items-center justify-center overflow-hidden">
                                @if(Auth::user()->foto)
                                    <img src="{{ Storage::url(Auth::user()->foto) }}" alt="Profile" class="w-full h-full object-cover">
                                @else
                                    <span class="text-gold font-bold text-sm">{{ substr(Auth::user()->nama, 0, 2) }}</span>
                                @endif
                            </div>
                            <span class="hidden md:inline text-sm">{{ Auth::user()->nama }}</span>
                            <svg class="w-4 h-4 text-white/50 group-hover:text-gold transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-100">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <span class="mr-2">👤</span> Profil
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <span class="mr-2">⚙️</span> Pengaturan
                            </a>
                            <hr class="my-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <span class="mr-2">🚪</span> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-white hover:text-gold transition">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
