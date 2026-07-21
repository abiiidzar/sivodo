@extends('layouts.app')

@section('title', 'Edit Pertanyaan')
@section('header', 'Edit Pertanyaan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.pertanyaan.update', $pertanyaan->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Kategori -->
            <div>
                <label for="kategori" class="block text-sm font-medium text-navy mb-1">Kategori <span class="text-red-500">*</span></label>
                <input type="text" id="kategori" name="kategori" value="{{ old('kategori', $pertanyaan->kategori) }}"
                       class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('kategori') border-red-500 @enderror"
                       placeholder="Contoh: Penguasaan Materi" required>
                @error('kategori')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pertanyaan -->
            <div>
                <label for="pertanyaan" class="block text-sm font-medium text-navy mb-1">Pertanyaan <span class="text-red-500">*</span></label>
                <textarea id="pertanyaan" name="pertanyaan" rows="3"
                          class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('pertanyaan') border-red-500 @enderror"
                          placeholder="Masukkan pertanyaan kuisioner" required>{{ old('pertanyaan', $pertanyaan->pertanyaan) }}</textarea>
                @error('pertanyaan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Urutan (Readonly) -->
            <div>
                <label class="block text-sm font-medium text-navy mb-1">Urutan</label>
                <input type="text" value="{{ $pertanyaan->urutan }}" readonly
                       class="w-full rounded-lg border-gray-200 bg-gray-50 text-gray-500">
                <p class="mt-1 text-xs text-gray-400">Untuk mengubah urutan, gunakan fitur reorder pada halaman utama</p>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-navy mb-1">Status</label>
                <select id="status" name="status"
                        class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('status') border-red-500 @enderror">
                    <option value="1" {{ old('status', $pertanyaan->status) == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status', $pertanyaan->status) == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="px-6 py-2.5 bg-navy text-white rounded-lg hover:bg-navy/90 transition font-medium">
                    Update Pertanyaan
                </button>
                <a href="{{ route('admin.pertanyaan.index') }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
