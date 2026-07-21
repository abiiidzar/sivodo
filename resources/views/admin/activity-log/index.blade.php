@extends('layouts.app')

@section('title', 'Activity Log')
@section('header', 'Activity Log')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('admin.activity-log') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs text-gray-400 mb-1">Cari</label>
                <input type="text" name="search" placeholder="Cari aktivitas..." value="{{ request('search') }}"
                       class="w-full h-11 rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input">
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">Role</label>
                <select name="role" class="h-11 rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input text-sm">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="mahasiswa" {{ request('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    <option value="pimpinan" {{ request('role') == 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy/90 transition text-sm font-medium h-11">Filter</button>
            <a href="{{ route('admin.activity-log') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium h-11">Reset</a>
            <form action="{{ route('admin.activity-log.clear') }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium h-11"
                        onclick="return confirm('Hapus semua activity log?')">Hapus Semua</button>
            </form>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">No</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">User</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Role</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Aktivitas</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Deskripsi</th>
                        <th class="text-left py-3 px-4 text-gray-500 font-medium">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $index => $log)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}</td>
                        <td class="py-3 px-4 font-medium text-navy">{{ $log->user->nama ?? 'User dihapus' }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 rounded-full text-xs
                                {{ $log->user->role == 'admin' ? 'bg-red-50 text-red-700' :
                                   ($log->user->role == 'mahasiswa' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700') }}">
                                {{ $log->user->role ?? '-' }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 rounded-full text-xs bg-gold-10 text-gold font-medium">
                                {{ $log->aktivitas }}
                            </span>
                        </td>
                        <td class="py-3 px-4">{{ Str::limit($log->deskripsi, 60) }}</td>
                        <td class="py-3 px-4 text-xs text-gray-400">{{ $log->created_at->format('d M Y H:i:s') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="py-12 text-center text-gray-400">Tidak ada activity log</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-100">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
