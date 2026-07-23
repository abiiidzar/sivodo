@auth
<aside class="w-64 bg-white border-r border-gray-200 hidden md:block min-h-[calc(100vh-4rem)]">
    <div class="p-4 space-y-2">
        @php
            $user = Auth::user();
        @endphp

        @if($user->isAdmin())
            <!-- ==================== MENU ADMIN ==================== -->

            <!-- MENU UTAMA -->
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-2">Menu Utama</div>

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- MASTER DATA - COLLAPSIBLE -->
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Master Data</div>

            <div x-data="{ open: {{ request()->routeIs('admin.dosen.*') || request()->routeIs('admin.mahasiswa.*') || request()->routeIs('admin.matakuliah.*') || request()->routeIs('admin.semester.*') || request()->routeIs('admin.pertanyaan.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.dosen.*') || request()->routeIs('admin.mahasiswa.*') || request()->routeIs('admin.matakuliah.*') || request()->routeIs('admin.semester.*') || request()->routeIs('admin.pertanyaan.*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span>Master Data</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.dosen.*') || request()->routeIs('admin.mahasiswa.*') || request()->routeIs('admin.matakuliah.*') || request()->routeIs('admin.semester.*') || request()->routeIs('admin.pertanyaan.*') ? 'text-white' : '' }}" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="ml-4 mt-1 space-y-1 border-l-2 border-gray-200 pl-2">
                    <a href="{{ route('admin.dosen.index') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.dosen.*') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Data Dosen</span>
                    </a>
                    <a href="{{ route('admin.mahasiswa.index') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.mahasiswa.*') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Data Mahasiswa</span>
                    </a>
                    <a href="{{ route('admin.matakuliah.index') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.matakuliah.*') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Data Mata Kuliah</span>
                    </a>
                    <a href="{{ route('admin.semester.index') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.semester.*') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Data Semester</span>
                    </a>
                    <a href="{{ route('admin.pertanyaan.index') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.pertanyaan.*') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Data Pertanyaan</span>
                    </a>
                </div>
            </div>

            <!-- LAPORAN - COLLAPSIBLE -->
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Laporan</div>

            <div x-data="{ open: {{ request()->routeIs('admin.laporan.*') || request()->routeIs('admin.grafik') || request()->routeIs('admin.ranking') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.laporan.*') || request()->routeIs('admin.grafik') || request()->routeIs('admin.ranking') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
                        </svg>
                        <span>Laporan</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.laporan.*') || request()->routeIs('admin.grafik') || request()->routeIs('admin.ranking') ? 'text-white' : '' }}" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="ml-4 mt-1 space-y-1 border-l-2 border-gray-200 pl-2">
                    <a href="{{ route('admin.laporan.dosen') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.laporan.dosen') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Laporan Dosen</span>
                    </a>
                    <a href="{{ route('admin.laporan.matakuliah') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.laporan.matakuliah') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Laporan Mata Kuliah</span>
                    </a>
                    <a href="{{ route('admin.laporan.prodi') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.laporan.prodi') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Laporan Program Studi</span>
                    </a>
                    <a href="{{ route('admin.grafik') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.grafik') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Grafik & Ranking</span>
                    </a>
                </div>
            </div>

            <!-- SISTEM - COLLAPSIBLE -->
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Sistem</div>

            <div x-data="{ open: {{ request()->routeIs('admin.activity-log') || request()->routeIs('admin.backup') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.activity-log') || request()->routeIs('admin.backup') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Sistem</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('admin.activity-log') || request()->routeIs('admin.backup') ? 'text-white' : '' }}" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="ml-4 mt-1 space-y-1 border-l-2 border-gray-200 pl-2">
                    <a href="{{ route('admin.activity-log') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.activity-log') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Activity Log</span>
                    </a>
                    <a href="{{ route('admin.backup') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('admin.backup') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Backup Database</span>
                    </a>
                </div>
            </div>
        @endif

        @if($user->isMahasiswa())
            <!-- ==================== MENU MAHASISWA ==================== -->
            <!-- TETAP, TIDAK COLLAPSIBLE -->

            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-2">Menu Utama</div>

            <a href="{{ route('mahasiswa.dashboard') }}"
               class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('mahasiswa.voting') }}"
               class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('mahasiswa.voting*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
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

            <a href="{{ route('mahasiswa.riwayat') }}"
               class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('mahasiswa.riwayat*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Riwayat Voting</span>
            </a>

            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Hasil</div>

            <a href="{{ route('mahasiswa.hasil') }}"
               class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('mahasiswa.hasil*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span>Hasil Penilaian</span>
            </a>

            <a href="{{ route('mahasiswa.ranking') }}"
               class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('mahasiswa.ranking*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                <span>Ranking Dosen</span>
            </a>
        @endif

        @if($user->isPimpinan())
            <!-- ==================== MENU PIMPINAN ==================== -->

            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-2">Menu Utama</div>

            <!-- Dashboard -->
            <a href="{{ route('pimpinan.dashboard') }}"
               class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('pimpinan.dashboard') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- LAPORAN & GRAFIK - COLLAPSIBLE -->
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Laporan & Grafik</div>

            <div x-data="{ open: {{ request()->routeIs('pimpinan.grafik') || request()->routeIs('pimpinan.ranking') || request()->routeIs('pimpinan.laporan.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition {{ request()->routeIs('pimpinan.grafik') || request()->routeIs('pimpinan.ranking') || request()->routeIs('pimpinan.laporan.*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>Laporan & Grafik</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('pimpinan.grafik') || request()->routeIs('pimpinan.ranking') || request()->routeIs('pimpinan.laporan.*') ? 'text-white' : '' }}" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="ml-4 mt-1 space-y-1 border-l-2 border-gray-200 pl-2">
                    <a href="{{ route('pimpinan.grafik') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('pimpinan.grafik') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Grafik & Chart</span>
                    </a>
                    <a href="{{ route('pimpinan.ranking') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('pimpinan.ranking') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Ranking Dosen</span>
                    </a>
                    <a href="{{ route('pimpinan.laporan.dosen') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('pimpinan.laporan.dosen') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Laporan Dosen</span>
                    </a>
                    <a href="{{ route('pimpinan.laporan.matakuliah') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('pimpinan.laporan.matakuliah') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Laporan Mata Kuliah</span>
                    </a>
                    <a href="{{ route('pimpinan.laporan.prodi') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('pimpinan.laporan.prodi') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Laporan Program Studi</span>
                    </a>
                </div>
            </div>

            <!-- EXPORT - COLLAPSIBLE -->
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Export</div>

            <div x-data="{ open: {{ request()->routeIs('pimpinan.export.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition {{ request()->routeIs('pimpinan.export.*') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span>Export</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200 {{ request()->routeIs('pimpinan.export.*') ? 'text-white' : '' }}" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="ml-4 mt-1 space-y-1 border-l-2 border-gray-200 pl-2">
                    <a href="{{ route('pimpinan.export.pdf') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('pimpinan.export.pdf') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Export PDF</span>
                    </a>
                    <a href="{{ route('pimpinan.export.excel') }}"
                       class="flex items-center space-x-2 px-3 py-2 rounded-lg transition text-sm {{ request()->routeIs('pimpinan.export.excel') ? 'bg-navy/10 text-navy font-medium' : 'text-gray-500 hover:bg-gray-100' }}">
                        <span>Export Excel</span>
                    </a>
                </div>
            </div>
        @endif

        <!-- ==================== PROFIL (Semua Role) ==================== -->
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 pt-4">Akun</div>

        <a href="{{ route('profile.edit') }}"
           class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('profile.edit') ? 'bg-navy text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span>Profil Saya</span>
        </a>

        <!-- LOGOUT -->
        <div class="pt-4 border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg transition text-red-600 hover:bg-red-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
@endauth
