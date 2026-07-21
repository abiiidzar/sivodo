@extends('layouts.app')

@section('title', 'Data Semester')
@section('header', 'Data Semester')

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
                        <input type="text" id="searchSemester" placeholder="Cari Tahun Ajaran..."
                               value="{{ request('search') }}"
                               class="w-full h-full px-3 border-0 focus:ring-0 focus:outline-none">
                    </div>
                </div>

                <!-- Filter Semester -->
                <select id="filterSemester" class="h-11 rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input text-sm">
                    <option value="">Semua Semester</option>
                    <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                </select>

                <!-- Filter Status -->
                <select id="filterStatus" class="h-11 rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input text-sm">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>

                <button id="btnSearch" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy/90 transition text-sm font-medium h-11">
                    Cari
                </button>
                <button id="btnReset" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium h-11">
                    Reset
                </button>
            </div>

            <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.semester.create') }}" class="flex items-center space-x-2 px-4 py-2 bg-gold text-navy rounded-lg hover:bg-gold/90 transition text-sm font-medium h-11">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tambah Semester</span>
                </a>
            </div>
        </div>

        <!-- Info Hasil Pencarian -->
        @if(request()->filled('search') || request()->filled('semester') || request()->filled('status'))
            <div class="mt-3 text-sm text-gray-500">
                Menampilkan hasil untuk:
                @if(request()->filled('search'))
                    <span class="font-medium text-navy">"{{ request('search') }}"</span>
                @endif
                @if(request()->filled('semester'))
                    @if(request()->filled('search')) - @endif
                    <span class="font-medium text-navy">{{ request('semester') }}</span>
                @endif
                @if(request()->filled('status'))
                    @if(request()->filled('search') || request()->filled('semester')) - @endif
                    <span class="font-medium text-navy">{{ request('status') }}</span>
                @endif
                <span class="text-gray-400 ml-2">
                    ({{ $semesters->total() }} data ditemukan)
                </span>
                <a href="{{ route('admin.semester.index') }}" class="text-gold hover:underline ml-2">Hapus filter</a>
            </div>
        @endif
    </div>

    <!-- Tabel Data Semester -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">No</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Tahun Ajaran</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Semester</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Status</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($semesters as $index => $semester)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $loop->iteration + ($semesters->currentPage() - 1) * $semesters->perPage() }}</td>
                        <td class="py-3 px-4 font-medium text-navy">{{ $semester->tahun_ajaran }}</td>
                        <td class="py-3 px-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $semester->semester == 'Ganjil' ? 'bg-blue-50 text-blue-700' : 'bg-orange-50 text-orange-700' }}">
                                {{ $semester->semester }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $semester->status == 'Aktif' ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $semester->status }}
                            </span>
                            @if($semester->status == 'Aktif')
                                <span class="ml-2 text-xs text-emerald-600 font-medium">(Aktif)</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.semester.edit', $semester->id) }}"
                                   class="text-gray-400 hover:text-gold transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                @if($semester->status != 'Aktif')
                                    <form action="{{ route('admin.semester.set-aktif', $semester->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-gray-400 hover:text-emerald-600 transition" title="Set Aktif"
                                                onclick="return confirm('Aktifkan semester {{ $semester->tahun_ajaran }} - {{ $semester->semester }}?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                                <button onclick="confirmDelete({{ $semester->id }}, '{{ $semester->tahun_ajaran }} - {{ $semester->semester }}')"
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
                        <td colspan="5" class="py-12 text-center text-gray-400">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm">Belum ada data semester</p>
                            <a href="{{ route('admin.semester.create') }}" class="text-gold hover:underline text-sm mt-2 inline-block">
                                Tambah semester pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-gray-100">
            {{ $semesters->links() }}
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
                    Apakah Anda yakin ingin menghapus semester <span id="deleteName" class="font-semibold text-navy"></span>?
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
        const search = document.getElementById('searchSemester').value;
        const semester = document.getElementById('filterSemester').value;
        const status = document.getElementById('filterStatus').value;

        let url = '{{ route("admin.semester.index") }}?';
        if (search) url += 'search=' + encodeURIComponent(search) + '&';
        if (semester) url += 'semester=' + encodeURIComponent(semester) + '&';
        if (status) url += 'status=' + encodeURIComponent(status);

        window.location.href = url;
    });

    document.getElementById('btnReset').addEventListener('click', function() {
        window.location.href = '{{ route("admin.semester.index") }}';
    });

    // Enter key search
    document.getElementById('searchSemester').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('btnSearch').click();
        }
    });

    // Confirm Delete
    function confirmDelete(id, name) {
        document.getElementById('deleteName').textContent = name;
        document.getElementById('deleteForm').action = '{{ route("admin.semester.index") }}/' + id;
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
</script>
@endpush
@endsection
