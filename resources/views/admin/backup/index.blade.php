@extends('layouts.app')

@section('title', 'Backup Database')
@section('header', 'Backup Database')

@section('content')
<div class="space-y-6">
    <!-- Create Backup -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="font-semibold text-navy">💾 Buat Backup Baru</h4>
                <p class="text-sm text-gray-500 mt-1">Membuat backup seluruh database ke file SQL</p>
            </div>
            <form action="{{ route('admin.backup.create') }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-2.5 bg-gold text-navy rounded-lg hover:bg-gold/90 transition font-medium">
                    + Buat Backup
                </button>
            </form>
        </div>
    </div>

    <!-- Restore -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h4 class="font-semibold text-navy mb-3">📂 Restore Database</h4>
        <form action="{{ route('admin.backup.restore') }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-end gap-4">
            @csrf
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs text-gray-400 mb-1">Pilih File SQL</label>
                <input type="file" name="file" accept=".sql" required
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gold-10 file:text-gold hover:file:bg-gold-20">
            </div>
            <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition text-sm font-medium h-11"
                    onclick="return confirm('Restore database akan mengganti semua data saat ini. Lanjutkan?')">
                Restore
            </button>
        </form>
    </div>

    <!-- Daftar Backup -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h4 class="font-semibold text-navy">📋 Daftar Backup</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">No</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Nama File</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Ukuran</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Tanggal</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($backupList as $index => $backup)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 font-medium text-navy">{{ $backup->name }}</td>
                        <td class="py-3 px-4">{{ number_format($backup->size / 1024, 2) }} KB</td>
                        <td class="py-3 px-4 text-xs">{{ date('d M Y H:i:s', $backup->date) }}</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.backup.download', $backup->name) }}"
                                   class="text-gray-400 hover:text-blue-600 transition" title="Download">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.backup.delete', $backup->name) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Hapus"
                                            onclick="return confirm('Hapus file backup ini?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-12 text-center text-gray-400">Belum ada file backup</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
