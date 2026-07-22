<nav class="navbar-sivodo sticky top-0 z-50">
    <div class="w-full px-6 md:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo & Brand -->
            <div class="flex items-center space-x-3">
                <img src="{{ asset('img/enbi1.png') }}"
                    alt="Logo"
                    class="h-10 w-auto">
                <div>
                    <h1 class="text-white font-bold text-lg leading-tight">SIVODO</h1>
                    <p class="text-blue-muda text-xs">PT. Lentera Edukasi ENBI Nusantara</p>
                </div>
            </div>

            <!-- Center: Progress (khusus mahasiswa) -->
            @auth
                @php
                    $user = Auth::user();
                @endphp
                @if($user->role === 'mahasiswa' || $user->isMahasiswa())
                    @php
                        // Cek apakah mahasiswa memiliki relasi
                        $mahasiswa = $user->mahasiswa;
                        $totalDosen = \App\Models\Dosen::count();
                        $sudahVoting = 0;
                        $progress = 0;

                        if ($mahasiswa && $totalDosen > 0) {
                            $sudahVoting = \App\Models\Voting::where('mahasiswa_id', $mahasiswa->id)->count();
                            $progress = round(($sudahVoting / $totalDosen) * 100);
                        }
                    @endphp
                    
                @endif
            @endauth

            <!-- Right: User Menu -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- Notifikasi -->
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
                                    <span class="text-gold font-bold text-sm">{{ substr(Auth::user()->nama ?? 'User', 0, 2) }}</span>
                                @endif
                            </div>
                            <span class="hidden md:inline text-sm">{{ Auth::user()->nama ?? 'User' }}</span>
                            <svg class="w-4 h-4 text-white/50 group-hover:text-gold transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div
                            x-show="open"
                            @click.away="open = false"
                            x-transition
                            class="absolute right-0 mt-2 w-52 bg-white rounded-lg shadow-lg border border-gray-100 py-2 z-50"
                        >
                            <!-- Profil -->
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-gray-100 transition">

                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>

                                <span>Profil Saya</span>
                            </a>

                            <!-- Pengaturan -->
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-gray-100 transition">

                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">

                                    <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>

                                <span>Pengaturan</span>
                            </a>

                            <div class="my-2 border-t border-gray-100"></div>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-red-600 hover:bg-red-50 transition"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>

                                    <span>Logout</span>
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
