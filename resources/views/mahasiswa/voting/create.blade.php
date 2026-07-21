@extends('layouts.app')

@section('title', 'Form Voting')
@section('header', 'Form Penilaian Dosen')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Informasi Dosen -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-gold-10 border border-gold/30 flex items-center justify-center overflow-hidden flex-shrink-0">
                @if($dosen->foto)
                    <img src="{{ Storage::url($dosen->foto) }}" alt="{{ $dosen->nama }}" class="w-full h-full object-cover">
                @else
                    <span class="text-gold text-xl font-bold">{{ substr($dosen->nama, 0, 2) }}</span>
                @endif
            </div>
            <div>
                <h3 class="text-xl font-bold text-navy">{{ $dosen->nama }}</h3>
                <p class="text-sm text-gray-500">NIDN: {{ $dosen->nidn }} | {{ $dosen->program_studi }}</p>
                <div class="flex flex-wrap gap-2 mt-1">
                    @foreach($dosen->mataKuliahs as $mk)
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded">{{ $mk->nama }} ({{ $mk->kelas ?? '-' }})</span>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between text-sm text-gray-500">
            <span>Semester: <strong class="text-navy">{{ $semesterAktif->tahun_ajaran }} - {{ $semesterAktif->semester }}</strong></span>
            <span>Mahasiswa: <strong class="text-navy">{{ $mahasiswa->nama }} ({{ $mahasiswa->nim }})</strong></span>
        </div>
    </div>

    <!-- Form Voting -->
    <form action="{{ route('mahasiswa.voting.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        @csrf
        <input type="hidden" name="dosen_id" value="{{ $dosen->id }}">
        <input type="hidden" name="mata_kuliah_id" value="{{ $dosen->mataKuliahs->first()->id ?? '' }}">

        <!-- Pertanyaan -->
        <div class="space-y-6">
            <h4 class="font-semibold text-navy text-lg">Kuisioner Penilaian</h4>
            <p class="text-sm text-gray-500">Berikan penilaian dengan mengklik bintang di bawah ini.</p>

            <div class="border-t border-gray-100 pt-4 space-y-6">
                @foreach($pertanyaans as $index => $pertanyaan)
                    <div class="flex flex-col md:flex-row md:items-start gap-4 p-4 bg-gray-50 rounded-lg">
                        <div class="md:w-1/3">
                            <p class="text-sm font-semibold text-navy">{{ $index + 1 }}. {{ $pertanyaan->kategori }}</p>
                        </div>
                        <div class="md:w-2/3">
                            <p class="text-sm text-gray-600 mb-3">{{ $pertanyaan->pertanyaan }}</p>
                            <div class="flex items-center gap-1" id="rating-{{ $pertanyaan->id }}">
                                <input type="hidden" name="nilai[{{ $pertanyaan->id }}]" id="nilai-{{ $pertanyaan->id }}" value="0" required>
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button"
                                            class="rating-star focus:outline-none transition-transform hover:scale-110"
                                            data-pertanyaan="{{ $pertanyaan->id }}"
                                            data-nilai="{{ $i }}"
                                            onclick="setRating({{ $pertanyaan->id }}, {{ $i }})">
                                        <svg class="w-8 h-8 text-gray-300 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20" id="star-{{ $pertanyaan->id }}-{{ $i }}">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </button>
                                @endfor
                            </div>
                            <div class="flex justify-between text-xs text-gray-400 mt-1">
                                <span>Sangat Kurang</span>
                                <span>Sangat Baik</span>
                            </div>
                            @error("nilai.{$pertanyaan->id}")
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Kritik & Saran -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-100">
            <div>
                <label for="kritik" class="block text-sm font-medium text-navy mb-1">Kritik</label>
                <textarea id="kritik" name="kritik" rows="3"
                          class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input"
                          placeholder="Masukkan kritik untuk dosen..."></textarea>
            </div>
            <div>
                <label for="saran" class="block text-sm font-medium text-navy mb-1">Saran</label>
                <textarea id="saran" name="saran" rows="3"
                          class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input"
                          placeholder="Masukkan saran untuk dosen..."></textarea>
            </div>
        </div>

        <!-- Tombol -->
        <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
            <button type="submit"
                    class="px-6 py-2.5 bg-navy text-white rounded-lg hover:bg-navy/90 transition font-medium">
                Kirim Voting
            </button>
            <a href="{{ route('mahasiswa.voting') }}"
               class="px-6 py-2.5 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition font-medium">
                Batal
            </a>
        </div>

        <p class="text-xs text-gray-400 mt-3 flex items-center gap-1">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Pastikan penilaian Anda objektif. Voting tidak dapat diubah setelah dikirim.
        </p>
    </form>
</div>

@push('scripts')
<script>
    function setRating(pertanyaanId, nilai) {
        // Set nilai hidden
        document.getElementById('nilai-' + pertanyaanId).value = nilai;

        // Update semua bintang untuk pertanyaan ini
        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById('star-' + pertanyaanId + '-' + i);
            if (i <= nilai) {
                // Bintang terisi warna biru (navy)
                star.classList.remove('text-gray-300');
                star.classList.add('text-navy');
            } else {
                // Bintang kosong warna abu-abu
                star.classList.remove('text-navy');
                star.classList.add('text-gray-300');
            }
        }
    }

    // Inisialisasi: semua bintang abu-abu
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($pertanyaans as $pertanyaan)
            for (let i = 1; i <= 5; i++) {
                const star = document.getElementById('star-{{ $pertanyaan->id }}-' + i);
                if (star) {
                    star.classList.remove('text-navy');
                    star.classList.add('text-gray-300');
                }
            }
        @endforeach
    });

    // Optional: Hover effect untuk preview
    document.querySelectorAll('.rating-star').forEach(button => {
        button.addEventListener('mouseenter', function() {
            const pertanyaanId = this.dataset.pertanyaan;
            const nilai = parseInt(this.dataset.nilai);

            // Preview bintang saat hover
            for (let i = 1; i <= 5; i++) {
                const star = document.getElementById('star-' + pertanyaanId + '-' + i);
                if (i <= nilai) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-navy');
                } else {
                    star.classList.remove('text-navy');
                    star.classList.add('text-gray-300');
                }
            }
        });

        button.addEventListener('mouseleave', function() {
            const pertanyaanId = this.dataset.pertanyaan;
            const selectedValue = parseInt(document.getElementById('nilai-' + pertanyaanId).value);

            // Kembalikan ke nilai yang sudah dipilih
            for (let i = 1; i <= 5; i++) {
                const star = document.getElementById('star-' + pertanyaanId + '-' + i);
                if (i <= selectedValue) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-navy');
                } else {
                    star.classList.remove('text-navy');
                    star.classList.add('text-gray-300');
                }
            }
        });
    });
</script>
@endpush
@endsection
