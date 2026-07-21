@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')
@section('header', 'Tambah Mahasiswa')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.mahasiswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

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

            <!-- NIM -->
            <div>
                <label for="nim" class="block text-sm font-medium text-navy mb-1">NIM <span class="text-red-500">*</span></label>
                <input type="text" id="nim" name="nim" value="{{ old('nim') }}"
                       class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('nim') border-red-500 @enderror"
                       placeholder="Masukkan NIM" required>
                @error('nim')
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

            <!-- Semester & Kelas -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="semester" class="block text-sm font-medium text-navy mb-1">Semester <span class="text-red-500">*</span></label>
                    <select id="semester" name="semester"
                            class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('semester') border-red-500 @enderror" required>
                        <option value="">Pilih Semester</option>
                        @for($i = 1; $i <= 14; $i++)
                            <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                        @endfor
                    </select>
                    @error('semester')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="kelas" class="block text-sm font-medium text-navy mb-1">Kelas</label>
                    <input type="text" id="kelas" name="kelas" value="{{ old('kelas') }}"
                           class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('kelas') border-red-500 @enderror"
                           placeholder="Contoh: A">
                    @error('kelas')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Username & Email -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-navy mb-1">Username <span class="text-red-500">*</span></label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}"
                           class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('username') border-red-500 @enderror"
                           placeholder="Username login" required>
                    @error('username')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-navy mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('email') border-red-500 @enderror"
                           placeholder="email@example.com" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Password & No HP -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-navy mb-1">Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password" name="password"
                           class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('password') border-red-500 @enderror"
                           placeholder="Minimal 6 karakter" required>
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="no_hp" class="block text-sm font-medium text-navy mb-1">No. HP</label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                           class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('no_hp') border-red-500 @enderror"
                           placeholder="081234567890">
                    @error('no_hp')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
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
                    Simpan Mahasiswa
                </button>
                <a href="{{ route('admin.mahasiswa.index') }}"
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
