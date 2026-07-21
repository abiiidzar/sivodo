@extends('layouts.app')

@section('title', 'Tambah Mata Kuliah')
@section('header', 'Tambah Mata Kuliah')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.matakuliah.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Kode -->
            <div>
                <label for="kode" class="block text-sm font-medium text-navy mb-1">Kode Mata Kuliah <span class="text-red-500">*</span></label>
                <input type="text" id="kode" name="kode" value="{{ old('kode') }}"
                       class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('kode') border-red-500 @enderror"
                       placeholder="Contoh: IF-101" required>
                @error('kode')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama -->
            <div>
                <label for="nama" class="block text-sm font-medium text-navy mb-1">Nama Mata Kuliah <span class="text-red-500">*</span></label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                       class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('nama') border-red-500 @enderror"
                       placeholder="Contoh: Pemrograman Web" required>
                @error('nama')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dosen Pengampu -->
            <div>
                <label for="dosen_id" class="block text-sm font-medium text-navy mb-1">Dosen Pengampu <span class="text-red-500">*</span></label>
                <select id="dosen_id" name="dosen_id"
                        class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input @error('dosen_id') border-red-500 @enderror" required>
                    <option value="">Pilih Dosen</option>
                    @foreach($dosens as $dosen)
                        <option value="{{ $dosen->id }}" {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>
                            {{ $dosen->nama }} ({{ $dosen->nidn }})
                        </option>
                    @endforeach
                </select>
                @error('dosen_id')
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
                        <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
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

            <!-- Tombol -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="px-6 py-2.5 bg-navy text-white rounded-lg hover:bg-navy/90 transition font-medium">
                    Simpan Mata Kuliah
                </button>
                <a href="{{ route('admin.matakuliah.index') }}"
                   class="px-6 py-2.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
