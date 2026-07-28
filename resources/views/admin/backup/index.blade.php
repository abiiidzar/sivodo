@extends('layouts.app')

@section('title', 'Backup Database')
@section('header', 'Backup Database')

@section('content')
<div class="space-y-6">

    <!-- Notifikasi Success -->
    @if(session('success'))
        <div class="banner-success rounded-lg p-4 flex items-center justify-between bg-emerald-50 border border-emerald-200">
            <div class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-emerald-700 font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Notifikasi Error Sistem -->
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-start space-x-3">
            <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="flex-1">
                <p class="text-sm font-semibold text-red-700">Terjadi Error!</p>
                <!-- whitespace-pre-line agar notifikasi error dengan enter (\n) terbaca rapi -->
                <p class="text-sm text-red-600 whitespace-pre-line">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Notifikasi Error Validasi Laravel -->
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-start space-x-3">
            <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm font-semibold text-red-700">Validasi Gagal!</p>
                <ul class="text-sm text-red-600 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Card: Buat Backup Baru -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h4 class="font-semibold text-navy">Buat Backup Baru</h4>
                <p class="text-sm text-gray-500 mt-1">Membuat backup seluruh database ke file SQL secara langsung.</p>
            </div>
            <form action="{{ route('admin.backup.create') }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-2.5 bg-gold text-navy rounded-lg hover:bg-gold/90 transition font-medium flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span>Buat Backup Sekarang</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Card: Restore Upload File -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h4 class="font-semibold text-navy mb-3">Restore Database (Upload File)</h4>
        <p class="text-sm text-red-500 mb-4 flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span>Restore akan mengganti SEMUA data saat ini. Pastikan Anda sudah backup terlebih dahulu!</span>
        </p>
        <form action="{{ route('admin.backup.restore') }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-end gap-4">
            @csrf
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs text-gray-400 mb-1">Pilih File SQL dari Komputer</label>
                <input type="file" name="file" accept=".sql" required
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gold-10 file:text-gold hover:file:bg-gold-20 cursor-pointer">
            </div>
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium h-11 flex items-center space-x-2"
                    onclick="return confirm('⚠️ PERINGATAN: Restore akan mengganti SEMUA data saat ini!\n\nApakah Anda yakin ingin melanjutkan?')">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Restore Database</span>
            </button>
        </form>
    </div>

    <!-- Card: Daftar Backup -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h4 class="font-semibold text-navy">Daftar File Backup di Server</h4>
            <p class="text-sm text-gray-500 mt-1">File-file backup yang tersimpan di dalam folder storage aplikasi.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">No</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Nama File</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Ukuran</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Tanggal Dibuat</th>
                        <th class="text-center py-3 px-4 text-gray-500 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($backupList as $index => $backup)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 font-medium text-navy">{{ $backup->name }}</td>
                        <td class="py-3 px-4">{{ number_format($backup->size / 1024, 2) }} KB</td>
                        <td class="py-3 px-4 text-xs text-gray-500">{{ date('d M Y H:i:s', $backup->date) }}</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center justify-center space-x-3">

                                <!-- Tombol Restore dari Daftar -->
                                <form action="{{ route('admin.backup.restore-list', $backup->name) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-400 hover:text-emerald-600 transition" title="Restore (Pulihkan) Database Ini"
                                            onclick="return confirm('⚠️ PERINGATAN: Restore akan mengganti SEMUA data saat ini dengan file ini!\n\nApakah Anda yakin ingin melanjutkan?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                    </button>
                                </form>

                                <!-- Tombol Download -->
                                <a href="{{ route('admin.backup.download', $backup->name) }}"
                                   class="text-gray-400 hover:text-blue-600 transition" title="Download File">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                </a>

                                <!-- Tombol Preview -->
                                <a href="{{ route('admin.backup.preview', $backup->name) }}" target="_blank"
                                   class="text-gray-400 hover:text-amber-600 transition" title="Preview Isi File">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('admin.backup.delete', $backup->name) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Hapus File Backup"
                                            onclick="return confirm('Hapus file backup ini dari server?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            Belum ada file backup tersimpan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
