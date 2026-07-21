@extends('layouts.app')

@section('title', 'Edit Semester')
@section('header', 'Edit Semester')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.semester.update', $semester->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Tahun Ajaran -->
            <div>
                <label for="tahun_ajaran" class="block text-sm font-medium text-navy mb-1">Tahun Ajaran <span class="text-red-500">*</span></label>
                <input type="text" id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran', $semester->tahun_ajaran) }}"
                       class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('tahun_ajaran') border-red-500 @enderror"
                       placeholder="Contoh: 2024/2025" required>
                <p class="mt-1 text-xs text-gray-400">Format: YYYY/YYYY (contoh: 2024/2025)</p>
                @error('tahun_ajaran')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Semester -->
            <div>
                <label for="semester" class="block text-sm font-medium text-navy mb-1">Semester <span class="text-red-500">*</span></label>
                <select id="semester" name="semester"
                        class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('semester') border-red-500 @enderror" required>
                    <option value="">Pilih Semester</option>
                    <option value="Ganjil" {{ old('semester', $semester->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap" {{ old('semester', $semester->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                </select>
                @error('semester')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-navy mb-1">Status <span class="text-red-500">*</span></label>
                <select id="status" name="status"
                        class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('status') border-red-500 @enderror" required>
                    <option value="">Pilih Status</option>
                    <option value="Aktif" {{ old('status', $semester->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ old('status', $semester->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @if(old('status', $semester->status) == 'Aktif')
                    <p class="mt-1 text-xs text-emerald-600">⚠️ Semester lain akan otomatis menjadi Tidak Aktif</p>
                @endif
                @error('status')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="px-6 py-2.5 bg-navy text-white rounded-lg hover:bg-navy/90 transition font-medium">
                    Update Semester
                </button>
                <a href="{{ route('admin.semester.index') }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('status').addEventListener('change', function() {
        const warning = this.parentElement.querySelector('.text-emerald-600');
        if (this.value === 'Aktif') {
            if (!warning) {
                const p = document.createElement('p');
                p.className = 'mt-1 text-xs text-emerald-600';
                p.textContent = '⚠️ Semester lain akan otomatis menjadi Tidak Aktif';
                this.parentElement.appendChild(p);
            }
        } else {
            if (warning) {
                warning.remove();
            }
        }
    });
</script>
@endpush
@endsection
