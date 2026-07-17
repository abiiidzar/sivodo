@extends('layouts.app')

@section('title', 'Tambah Dosen')
@section('header', 'Tambah Dosen')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.dosen.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- NIDN -->
            <div>
                <label for="nidn" class="block text-sm font-medium text-navy mb-1">NIDN/NIP <span class="text-red-500">*</span></label>
                <input type="text" id="nidn" name="nidn" value="{{ old('nidn') }}"
                       class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('nidn') border-red-500 @enderror"
                       placeholder="Masukkan NIDN/NIP" required>
                @error('nidn')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama -->
            <div>
                <label for="nama" class="block text-sm font-medium text-navy mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                       class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('nama') border-red-500 @enderror"
                       placeholder="Masukkan nama lengkap" required>
                @error('nama')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Program Studi -->
            <div>
                <label for="program_studi" class="block text-sm font-medium text-navy mb-1">Program Studi <span class="text-red-500">*</span></label>
                <input type="text" id="program_studi" name="program_studi" value="{{ old('program_studi') }}"
                       class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('program_studi') border-red-500 @enderror"
                       placeholder="Contoh: Informatika" required>
                @error('program_studi')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Dosen -->
            <div>
                <label for="status_dosen" class="block text-sm font-medium text-navy mb-1">Status Dosen <span class="text-red-500">*</span></label>
                <select id="status_dosen" name="status_dosen"
                        class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('status_dosen') border-red-500 @enderror" required>
                    <option value="">Pilih Status</option>
                    <option value="PNS" {{ old('status_dosen') == 'PNS' ? 'selected' : '' }}>PNS</option>
                    <option value="Yayasan" {{ old('status_dosen') == 'Yayasan' ? 'selected' : '' }}>Yayasan</option>
                    <option value="Luar Biasa" {{ old('status_dosen') == 'Luar Biasa' ? 'selected' : '' }}>Luar Biasa</option>
                </select>
                @error('status_dosen')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto -->
            <div>
                <label for="foto" class="block text-sm font-medium text-navy mb-1">Foto</label>
                <div class="mt-1 flex items-center space-x-4">
                    <div id="fotoPreview" class="w-24 h-24 rounded-full bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <input type="file" id="foto" name="foto" accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gold-10 file:text-gold hover:file:bg-gold-20"
                           onchange="previewImage(event)">
                </div>
                <p class="mt-1 text-xs text-gray-400">Format: JPEG, PNG, JPG. Maksimal 2MB</p>
                @error('foto')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="px-6 py-2.5 bg-navy text-white rounded-lg hover:bg-navy/90 transition font-medium">
                    Simpan Dosen
                </button>
                <a href="{{ route('admin.dosen.index') }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('fotoPreview');
            output.innerHTML = `<img src="${reader.result}" alt="Preview" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
@endsection
