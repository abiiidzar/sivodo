@extends('layouts.app')

@section('title', 'Data Mata Kuliah')
@section('header', 'Data Mata Kuliah')

@section('content')
<div class="space-y-6">
    <!-- Alert -->
    @if(session('success'))
        <div class="banner-success rounded-lg p-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-emerald-700">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    @if(session('info'))
        <div class="banner-info rounded-lg p-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-navy">{{ session('info') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-navy hover:text-navy/70">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Toolbar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <!-- Search -->
                <div class="flex items-center w-full sm:w-56 h-11 border border-gray-300 rounded-lg overflow-hidden">
                    <div class="flex items-center justify-center w-10 bg-gray-100">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <input type="text" id="searchMatakuliah" placeholder="Cari Kode/Nama..."
                               value="{{ request('search') }}"
                               class="w-full h-full px-3 border-0 focus:ring-0 focus:outline-none">
                    </div>
                </div>

                <!-- Filter Dosen -->
                <select id="filterDosen" class="h-11 rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input text-sm">
                    <option value="">Semua Dosen</option>
                    @foreach($dosens as $dosen)
                        <option value="{{ $dosen->id }}" {{ request('dosen_id') == $dosen->id ? 'selected' : '' }}>
                            {{ $dosen->nama }}
                        </option>
                    @endforeach
                </select>

                <!-- Filter Semester -->
                <select id="filterSemester" class="h-11 rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input text-sm">
                    <option value="">Semua Semester</option>
                    <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                </select>

                <!-- Filter Kelas -->
                <select id="filterKelas" class="h-11 rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input text-sm">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>
                            Kelas {{ $kelas }}
                        </option>
                    @endforeach
                </select>

                <button id="btnSearch" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy/90 transition text-sm font-medium h-11">
                    Cari
                </button>
                <button id="btnReset" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium h-11">
                    Reset
                </button>
            </div>

            <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.matakuliah.create') }}" class="flex items-center space-x-2 px-4 py-2 bg-gold text-navy rounded-lg hover:bg-gold/90 transition text-sm font-medium h-11">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tambah MK</span>
                </a>
                <button onclick="importData()" class="flex items-center space-x-2 px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium h-11">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    <span>Import</span>
                </button>
            </div>
        </div>

        <!-- Info Hasil Pencarian -->
        @if(request()->filled('search') || request()->filled('dosen_id') || request()->filled('semester') || request()->filled('kelas'))
            <div class="mt-3 text-sm text-gray-500">
                Menampilkan hasil untuk:
                @if(request()->filled('search'))
                    <span class="font-medium text-navy">"{{ request('search') }}"</span>
                @endif
                @if(request()->filled('dosen_id'))
                    @if(request()->filled('search')) - @endif
                    <span class="font-medium text-navy">Dosen: {{ optional(\App\Models\Dosen::find(request('dosen_id')))->nama }}</span>
                @endif
                @if(request()->filled('semester'))
                    @if(request()->filled('search') || request()->filled('dosen_id')) - @endif
                    <span class="font-medium text-navy">{{ request('semester') }}</span>
                @endif
                @if(request()->filled('kelas'))
                    @if(request()->filled('search') || request()->filled('dosen_id') || request()->filled('semester')) - @endif
                    <span class="font-medium text-navy">Kelas {{ request('kelas') }}</span>
                @endif
                <span class="text-gray-400 ml-2">
                    ({{ $matakuliahs->total() }} data ditemukan)
                </span>
                <a href="{{ route('admin.matakuliah.index') }}" class="text-gold hover:underline ml-2">Hapus filter</a>
            </div>
        @endif
    </div>

    <!-- Tabel Data Mata Kuliah -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">No</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Kode</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Nama Mata Kuliah</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Dosen Pengampu</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Semester</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Kelas</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($matakuliahs as $index => $matakuliah)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $loop->iteration + ($matakuliahs->currentPage() - 1) * $matakuliahs->perPage() }}</td>
                        <td class="py-3 px-4 font-mono text-xs font-semibold text-navy">{{ $matakuliah->kode }}</td>
                        <td class="py-3 px-4 font-medium text-navy">{{ $matakuliah->nama }}</td>
                        <td class="py-3 px-4">
                            <span class="text-sm text-navy font-medium">
                                {{ $matakuliah->dosen->nama ?? 'Tidak ada' }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $matakuliah->semester == 'Ganjil' ? 'bg-blue-50 text-blue-700' : 'bg-orange-50 text-orange-700' }}">
                                {{ $matakuliah->semester }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                {{ $matakuliah->kelas ?? '-' }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.matakuliah.show', $matakuliah->id) }}"
                                   class="text-gray-400 hover:text-blue-600 transition" title="Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.matakuliah.edit', $matakuliah->id) }}"
                                   class="text-gray-400 hover:text-gold transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <button onclick="confirmDelete({{ $matakuliah->id }}, '{{ $matakuliah->nama }}')"
                                        class="text-gray-400 hover:text-red-600 transition" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-400">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <p class="text-sm">Belum ada data mata kuliah</p>
                            <a href="{{ route('admin.matakuliah.create') }}" class="text-gold hover:underline text-sm mt-2 inline-block">
                                Tambah mata kuliah pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-gray-100">
            {{ $matakuliahs->links() }}
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/50" onclick="closeDeleteModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6 relative">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto bg-red-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-navy mb-2">Konfirmasi Hapus</h3>
                <p class="text-gray-500 text-sm mb-6">
                    Apakah Anda yakin ingin menghapus mata kuliah <span id="deleteName" class="font-semibold text-navy"></span>?
                    <br>Data yang dihapus tidak dapat dikembalikan.
                </p>
                <div class="flex justify-center gap-3">
                    <button onclick="closeDeleteModal()"
                            class="px-6 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Search & Filter
    document.getElementById('btnSearch').addEventListener('click', function() {
        const search = document.getElementById('searchMatakuliah').value;
        const dosen = document.getElementById('filterDosen').value;
        const semester = document.getElementById('filterSemester').value;
        const kelas = document.getElementById('filterKelas').value;

        let url = '{{ route("admin.matakuliah.index") }}?';
        if (search) url += 'search=' + encodeURIComponent(search) + '&';
        if (dosen) url += 'dosen_id=' + encodeURIComponent(dosen) + '&';
        if (semester) url += 'semester=' + encodeURIComponent(semester) + '&';
        if (kelas) url += 'kelas=' + encodeURIComponent(kelas);

        window.location.href = url;
    });

    document.getElementById('btnReset').addEventListener('click', function() {
        window.location.href = '{{ route("admin.matakuliah.index") }}';
    });

    // Enter key search
    document.getElementById('searchMatakuliah').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('btnSearch').click();
        }
    });

    // Confirm Delete
    function confirmDelete(id, name) {
        document.getElementById('deleteName').textContent = name;
        document.getElementById('deleteForm').action = '{{ route("admin.matakuliah.index") }}/' + id;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    function importData() {
        alert('Fitur import dalam pengembangan');
    }
</script>
@endpush
@endsection
