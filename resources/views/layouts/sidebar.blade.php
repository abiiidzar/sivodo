@auth
<aside class="w-64 bg-white border-r border-gray-200 hidden md:block min-h-[calc(100vh-4rem)]">
    <div class="p-4 space-y-2">
        @php
            $user = Auth::user();
        @endphp

        @if($user->isAdmin())

    @php
        $menus = [
            'Menu Utama' => [
                ['Dashboard', 'admin.dashboard', 'dashboard'],
            ],

            'Master Data' => [
                ['Data Dosen', 'admin.dosen.index', 'dosen'],
                ['Data Mahasiswa', 'admin.mahasiswa.index', 'mahasiswa'],
                ['Data Mata Kuliah', 'admin.matakuliah.index', 'matakuliah'],
                ['Data Semester', 'admin.semester.index', 'semester'],
                ['Data Pertanyaan', 'admin.pertanyaan.index', 'pertanyaan'],
            ],

            'Laporan' => [
                ['Laporan Dosen', 'admin.laporan.dosen', 'laporan'],
                ['Laporan Mata Kuliah', 'admin.laporan.matakuliah', 'matakuliah'],
                ['Laporan Program Studi', 'admin.laporan.prodi', 'prodi'],
                ['Grafik & Ranking', 'admin.grafik', 'grafik'],
            ],

            'Sistem' => [
                ['Activity Log', 'admin.activity-log', 'activity'],
                ['Backup Database', 'admin.backup', 'backup'],
            ],
        ];
    @endphp


    @foreach($menus as $title => $items)

        <div class="mb-6">

            {{-- Judul Menu --}}
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 mb-3">
                {{ $title }}
            </div>

            {{-- Daftar Menu --}}
            <div class="space-y-1">

                @foreach($items as $item)

                    @php
                        $name = $item[0];
                        $route = $item[1];
                        $icon = $item[2];

                        $active = request()->routeIs($route);
                    @endphp

                    <a href="{{ route($route) }}"
                       class="flex items-center gap-4 px-5 py-3 rounded-xl transition
                       {{ $active
                            ? 'bg-[#1a2744] text-white'
                            : 'text-[#1a2744] hover:bg-gray-100' }}">

                        {{-- ICON --}}
                        <span class="w-6 h-6 flex items-center justify-center">

                            @if($icon == 'dashboard')

                                {{-- Dashboard --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                                </svg>

                            @elseif($icon == 'dosen' || $icon == 'mahasiswa')

                                {{-- User / Dosen / Mahasiswa --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M3 21v-2a6 6 0 0 1 12 0v2"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    <path d="M21 21v-2a4 4 0 0 0-3-3.87"/>
                                </svg>

                            @elseif($icon == 'matakuliah')

                                {{-- Buku --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                </svg>

                            @elseif($icon == 'semester')

                                {{-- Kalender --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>

                            @elseif($icon == 'pertanyaan')

                                {{-- Question --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 2-3 2"/>
                                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                                </svg>

                            @elseif($icon == 'laporan')

                                {{-- Laporan --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <rect x="3" y="4" width="8" height="16" rx="2"/>
                                    <rect x="13" y="4" width="8" height="16" rx="2"/>
                                </svg>

                            @elseif($icon == 'prodi')

                                {{-- Gedung --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path d="M3 21h18"/>
                                    <path d="M5 21V7l7-4 7 4v14"/>
                                    <path d="M9 21v-4h6v4"/>
                                </svg>

                            @elseif($icon == 'grafik')

                                {{-- Grafik --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <line x1="18" y1="20" x2="18" y2="10"/>
                                    <line x1="12" y1="20" x2="12" y2="4"/>
                                    <line x1="6" y1="20" x2="6" y2="14"/>
                                </svg>

                            @elseif($icon == 'activity')

                                {{-- Activity --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <circle cx="12" cy="12" r="9"/>
                                    <polyline points="12 7 12 12 15 14"/>
                                </svg>

                            @elseif($icon == 'backup')

                                {{-- Database --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-6 h-6"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <ellipse cx="12" cy="5" rx="9" ry="3"/>
                                    <path d="M3 5v14c0 1.66 4.03 3 9 3s9-1.34 9-3V5"/>
                                    <path d="M3 12c0 1.66 4.03 3 9 3s9-1.34 9-3"/>
                                </svg>

                            @endif

                        </span>

                        {{-- Nama Menu --}}
                        <span>{{ $name }}</span>

                    </a>

                @endforeach

            </div>
        </div>

    @endforeach

@endif

                @if($user->isMahasiswa())
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-2">Menu Utama</div>

            <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('mahasiswa.voting') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('mahasiswa.voting*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                <span>Form Voting</span>
                @php
                    $totalDosen = \App\Models\Dosen::count();
                    $sudahVoting = \App\Models\Voting::where('mahasiswa_id', Auth::user()->mahasiswa->id ?? 0)->count();
                    $belumVoting = $totalDosen - $sudahVoting;
                @endphp
                @if($belumVoting > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $belumVoting }}</span>
                @endif
            </a>

            <a href="{{ route('mahasiswa.riwayat') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('mahasiswa.riwayat*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Riwayat Voting</span>
            </a>

            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Hasil</div>

            <a href="{{ route('mahasiswa.hasil') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('mahasiswa.hasil*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span>Hasil Penilaian</span>
            </a>

            <a href="{{ route('mahasiswa.ranking') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('mahasiswa.ranking*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                <span>Ranking Dosen</span>
            </a>
        @endif

                @if($user->isPimpinan())
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-2">Menu Utama</div>

            <a href="{{ route('pimpinan.dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('pimpinan.dashboard') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('pimpinan.grafik') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('pimpinan.grafik') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span>Grafik & Chart</span>
            </a>

            <a href="{{ route('pimpinan.ranking') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('pimpinan.ranking') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                <span>Ranking Dosen</span>
            </a>

            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Laporan</div>

            <a href="{{ route('pimpinan.laporan.dosen') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('pimpinan.laporan.dosen') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
                <span>Laporan Dosen</span>
            </a>

            <a href="{{ route('pimpinan.laporan.matakuliah') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('pimpinan.laporan.matakuliah') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <span>Laporan Mata Kuliah</span>
            </a>

            <a href="{{ route('pimpinan.laporan.prodi') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('pimpinan.laporan.prodi') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span>Laporan Program Studi</span>
            </a>

            <a href="{{ route('pimpinan.export.pdf') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('pimpinan.export.pdf') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span>Export PDF/Excel</span>
            </a>
        @endif

        <!-- Profil (semua role) -->
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Akun</div>

        <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('profile.edit') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span>Profil Saya</span>
        </a>

        <!-- Logout -->
        <div class="pt-4 border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg transition text-red-600 hover:bg-red-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
@endauth
