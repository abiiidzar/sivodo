@auth
<!-- Hapus x-data dari sini, karena sudah di pakai di app.blade.php -->
<aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-white border-r border-gray-200 hidden md:block min-h-[calc(100vh-4rem)] transition-all duration-300 overflow-hidden flex-shrink-0">
    <div class="p-4 space-y-2">
        @php
            $user = Auth::user();
        @endphp

        <!-- TOMBOL TOGGLE SUDAH DIHAPUS DARI SINI -->

        @if($user->isAdmin())
            <!-- ==================== MENU ADMIN ==================== -->

            <!-- MENU UTAMA -->
            <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-2">Menu Utama</div>
            <div x-show="!sidebarOpen" class="border-b border-gray-100 my-2"></div>

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" title="Dashboard" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition whitespace-nowrap {{ request()->routeIs('admin.dashboard') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                <span x-show="sidebarOpen" x-transition.opacity.duration.200ms>Dashboard</span>
            </a>

            <!-- MASTER DATA - COLLAPSIBLE -->
            <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Master Data</div>
            <div x-show="!sidebarOpen" class="border-b border-gray-100 my-2"></div>

            <div x-data="{ open: {{ request()->routeIs('admin.dosen.*') || request()->routeIs('admin.mahasiswa.*') || request()->routeIs('admin.matakuliah.*') || request()->routeIs('admin.semester.*') || request()->routeIs('admin.pertanyaan.*') ? 'true' : 'false' }} }">
                <button @click="sidebarOpen ? open = !open : sidebarOpen = true" title="Master Data" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition whitespace-nowrap {{ request()->routeIs('admin.dosen.*') || request()->routeIs('admin.mahasiswa.*') || request()->routeIs('admin.matakuliah.*') || request()->routeIs('admin.semester.*') || request()->routeIs('admin.pertanyaan.*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity.duration.200ms>Master Data</span>
                    </div>
                    <svg x-show="sidebarOpen" class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.dosen.*') || request()->routeIs('admin.mahasiswa.*') || request()->routeIs('admin.matakuliah.*') || request()->routeIs('admin.semester.*') || request()->routeIs('admin.pertanyaan.*') ? 'text-white' : '' }}" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open && sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="ml-4 mt-1 space-y-1 border-l-2 border-gray-200 pl-2">
                    <a href="{{ route('admin.dosen.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.dosen.*') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Data Dosen</span></a>
                    <a href="{{ route('admin.mahasiswa.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.mahasiswa.*') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Data Mahasiswa</span></a>
                    <a href="{{ route('admin.matakuliah.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.matakuliah.*') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Data Mata Kuliah</span></a>
                    <a href="{{ route('admin.semester.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.semester.*') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Data Semester</span></a>
                    <a href="{{ route('admin.pertanyaan.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.pertanyaan.*') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Data Pertanyaan</span></a>
                </div>
            </div>

            <!-- LAPORAN - COLLAPSIBLE -->
            <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Laporan</div>
            <div x-show="!sidebarOpen" class="border-b border-gray-100 my-2"></div>

            <div x-data="{ open: {{ request()->routeIs('admin.laporan.*') || request()->routeIs('admin.grafik') || request()->routeIs('admin.ranking') ? 'true' : 'false' }} }">
                <button @click="sidebarOpen ? open = !open : sidebarOpen = true" title="Laporan" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition whitespace-nowrap {{ request()->routeIs('admin.laporan.*') || request()->routeIs('admin.grafik') || request()->routeIs('admin.ranking') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity.duration.200ms>Laporan</span>
                    </div>
                    <svg x-show="sidebarOpen" class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.laporan.*') || request()->routeIs('admin.grafik') || request()->routeIs('admin.ranking') ? 'text-white' : '' }}" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open && sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="ml-4 mt-1 space-y-1 border-l-2 border-gray-200 pl-2">
                    <a href="{{ route('admin.laporan.dosen') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.laporan.dosen') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Laporan Dosen</span></a>
                    <a href="{{ route('admin.laporan.matakuliah') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.laporan.matakuliah') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Laporan Mata Kuliah</span></a>
                    <a href="{{ route('admin.laporan.prodi') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.laporan.prodi') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Laporan Program Studi</span></a>
                    <a href="{{ route('admin.grafik') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.grafik') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Grafik & Ranking</span></a>
                </div>
            </div>

            <!-- Analisis -->
            <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Analisis</div>
            <div x-show="!sidebarOpen" class="border-b border-gray-100 my-2"></div>

            <a href="{{ route('admin.analisis.index') }}" title="Analisis Dosen" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition whitespace-nowrap {{ request()->routeIs('admin.analisis.*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span x-show="sidebarOpen" x-transition.opacity.duration.200ms>Analisis Dosen</span>
            </a>

            <!-- SISTEM - COLLAPSIBLE -->
            <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Sistem</div>
            <div x-show="!sidebarOpen" class="border-b border-gray-100 my-2"></div>

            <div x-data="{ open: {{ request()->routeIs('admin.activity-log') || request()->routeIs('admin.backup') ? 'true' : 'false' }} }">
                <button @click="sidebarOpen ? open = !open : sidebarOpen = true" title="Sistem" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition whitespace-nowrap {{ request()->routeIs('admin.activity-log') || request()->routeIs('admin.backup') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity.duration.200ms>Sistem</span>
                    </div>
                    <svg x-show="sidebarOpen" class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.activity-log') || request()->routeIs('admin.backup') ? 'text-white' : '' }}" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open && sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="ml-4 mt-1 space-y-1 border-l-2 border-gray-200 pl-2">
                    <a href="{{ route('admin.activity-log') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.activity-log') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Activity Log</span></a>
                    <a href="{{ route('admin.backup') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.backup') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Backup Database</span></a>
                </div>
            </div>
        @endif

        @if($user->isMahasiswa())
            <!-- ==================== MENU MAHASISWA ==================== -->

            <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-2">Menu Utama</div>
            <div x-show="!sidebarOpen" class="border-b border-gray-100 my-2"></div>

            <a href="{{ route('mahasiswa.dashboard') }}" title="Dashboard" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition whitespace-nowrap {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                <span x-show="sidebarOpen" x-transition.opacity.duration.200ms>Dashboard</span>
            </a>

            <a href="{{ route('mahasiswa.voting') }}" title="Form Voting" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition whitespace-nowrap {{ request()->routeIs('mahasiswa.voting*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
                <span x-show="sidebarOpen" x-transition.opacity.duration.200ms>Form Voting</span>

                @php
                    $mhs = Auth::user()->mahasiswa;
                    $sem = \App\Models\Semester::where('status', 'Aktif')->first();
                    $belumVoting = 0;

                    if ($mhs && $sem) {
                        $dosenIds = \App\Models\MataKuliah::where('semester', $sem->semester)
                            ->where('kelas', $mhs->kelas)
                            ->pluck('dosen_id')
                            ->unique();

                        $totalDosenKelas = $dosenIds->count();
                        $sudahVotingKelas = \App\Models\Voting::where('mahasiswa_id', $mhs->id)
                            ->where('semester_id', $sem->id)
                            ->whereIn('dosen_id', $dosenIds)
                            ->distinct('dosen_id')
                            ->count('dosen_id');

                        $belumVoting = $totalDosenKelas - $sudahVotingKelas;
                    }
                @endphp

                @if($belumVoting > 0)
                    <span x-show="sidebarOpen" class="ml-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $belumVoting }}</span>
                    <span x-show="!sidebarOpen" class="absolute right-2 mt-[-20px] ml-[-10px] bg-red-500 text-white text-[10px] w-4 h-4 flex items-center justify-center rounded-full">{{ $belumVoting }}</span>
                @endif
            </a>

            <a href="{{ route('mahasiswa.riwayat') }}" title="Riwayat Voting" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition whitespace-nowrap {{ request()->routeIs('mahasiswa.riwayat*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span x-show="sidebarOpen" x-transition.opacity.duration.200ms>Riwayat Voting</span>
            </a>
        @endif

        @if($user->isPimpinan())
            <!-- ==================== MENU PIMPINAN ==================== -->

            <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-2">Menu Utama</div>
            <div x-show="!sidebarOpen" class="border-b border-gray-100 my-2"></div>

            <a href="{{ route('pimpinan.dashboard') }}" title="Dashboard" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition whitespace-nowrap {{ request()->routeIs('pimpinan.dashboard') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                <span x-show="sidebarOpen" x-transition.opacity.duration.200ms>Dashboard</span>
            </a>

            <!-- LAPORAN & GRAFIK - COLLAPSIBLE -->
            <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Laporan & Grafik</div>
            <div x-show="!sidebarOpen" class="border-b border-gray-100 my-2"></div>

            <div x-data="{ open: {{ request()->routeIs('pimpinan.grafik') || request()->routeIs('pimpinan.ranking') || request()->routeIs('pimpinan.laporan.*') ? 'true' : 'false' }} }">
                <button @click="sidebarOpen ? open = !open : sidebarOpen = true" title="Laporan" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition whitespace-nowrap {{ request()->routeIs('pimpinan.grafik') || request()->routeIs('pimpinan.ranking') || request()->routeIs('pimpinan.laporan.*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity.duration.200ms>Laporan & Grafik</span>
                    </div>
                    <svg x-show="sidebarOpen" class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('pimpinan.grafik') || request()->routeIs('pimpinan.ranking') || request()->routeIs('pimpinan.laporan.*') ? 'text-white' : '' }}" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open && sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="ml-4 mt-1 space-y-1 border-l-2 border-gray-200 pl-2">
                    <a href="{{ route('pimpinan.grafik') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('pimpinan.grafik') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Grafik & Chart</span></a>
                    <a href="{{ route('pimpinan.ranking') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('pimpinan.ranking') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Ranking Dosen</span></a>
                    <a href="{{ route('pimpinan.laporan.dosen') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('pimpinan.laporan.dosen') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Laporan Dosen</span></a>
                    <a href="{{ route('pimpinan.laporan.matakuliah') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('pimpinan.laporan.matakuliah') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Laporan Mata Kuliah</span></a>
                    <a href="{{ route('pimpinan.laporan.prodi') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('pimpinan.laporan.prodi') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Laporan Program Studi</span></a>
                </div>
            </div>

            <!-- Analisis -->
            <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Analisis</div>
            <div x-show="!sidebarOpen" class="border-b border-gray-100 my-2"></div>

            <a href="{{ route('pimpinan.analisis.index') }}" title="Analisis Dosen" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition whitespace-nowrap {{ request()->routeIs('pimpinan.analisis.*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span x-show="sidebarOpen" x-transition.opacity.duration.200ms>Analisis Dosen</span>
            </a>

            <!-- EXPORT - COLLAPSIBLE -->
            <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Export</div>
            <div x-show="!sidebarOpen" class="border-b border-gray-100 my-2"></div>

            <div x-data="{ open: {{ request()->routeIs('pimpinan.export.*') ? 'true' : 'false' }} }">
                <button @click="sidebarOpen ? open = !open : sidebarOpen = true" title="Export" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition whitespace-nowrap {{ request()->routeIs('pimpinan.export.*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity.duration.200ms>Export</span>
                    </div>
                    <svg x-show="sidebarOpen" class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('pimpinan.export.*') ? 'text-white' : '' }}" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open && sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="ml-4 mt-1 space-y-1 border-l-2 border-gray-200 pl-2">
                    <a href="{{ route('pimpinan.export.pdf') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('pimpinan.export.pdf') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Export PDF</span></a>
                    <a href="{{ route('pimpinan.export.excel') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('pimpinan.export.excel') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}"><span>Export Excel</span></a>
                </div>
            </div>
        @endif

        <!-- ==================== PROFIL (Semua Role) ==================== -->
        <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Akun</div>
        <div x-show="!sidebarOpen" class="border-b border-gray-100 my-2"></div>

        <a href="{{ route('profile.edit') }}" title="Profil Saya" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition whitespace-nowrap {{ request()->routeIs('profile.edit') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span x-show="sidebarOpen" x-transition.opacity.duration.200ms>Profil Saya</span>
        </a>

        <!-- LOGOUT -->
        <div class="pt-4 border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Logout" class="w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg transition text-red-600 hover:bg-red-50 whitespace-nowrap">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span x-show="sidebarOpen" x-transition.opacity.duration.200ms>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
@endauth
