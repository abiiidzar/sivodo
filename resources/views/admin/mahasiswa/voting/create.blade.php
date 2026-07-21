@extends('layouts.app')

@section('title', 'Form Voting')
@section('header', 'Form Penilaian Dosen')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header Dosen -->
        <div class="bg-gradient-navy px-6 py-6 flex items-center space-x-4">
            <div class="w-16 h-16 rounded-full border-2 border-gold bg-white flex items-center justify-center overflow-hidden">
                @if($dosen->foto)
                    <img src="{{ Storage::url($dosen->foto) }}" alt="{{ $dosen->nama }}" class="w-full h-full object-cover">
                @else
                    <span class="text-navy text-xl font-bold">{{ substr($dosen->nama, 0, 2) }}</span>
                @endif
            </div>
            <div>
                <h2 class="text-white font-bold text-xl">{{ $dosen->nama }}</h2>
                <p class="text-blue-muda text-sm">{{ $dosen->nidn }} - {{ $dosen->program_studi }}</p>
                <p class="text-blue-muda text-xs">
                    Mata Kuliah:
                    @foreach($dosen->mataKuliahs as $mk)
                        {{ $mk->nama }} ({{ $mk->kelas ?? '-' }})@if(!$loop->last), @endif
                    @endforeach
                </p>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('mahasiswa.voting.store') }}" method="POST" class="p-6 space-y-6" id="votingForm">
            @csrf
            <input type="hidden" name="dosen_id" value="{{ $dosen->id }}">
            <input type="hidden" name="mata_kuliah_id" value="{{ $dosen->mataKuliahs->first()->id ?? '' }}">

            <!-- Info -->
            <div class="banner-info rounded-lg p-4">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-gold mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-navy">Petunjuk Pengisian</p>
                        <ul class="text-sm text-gray-600 space-y-1 mt-1">
                            <li>• Berikan penilaian dengan jujur dan objektif.</li>
                            <li>• Pilih nilai 1-5 untuk setiap pertanyaan.</li>
                            <li>• Nilai 1 = Sangat Kurang, 5 = Sangat Baik.</li>
                            <li class="text-red-500">• Voting hanya dapat dilakukan satu kali dan tidak dapat diubah.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Pertanyaan -->
            <div class="space-y-4">
                @foreach($pertanyaans as $pertanyaan)
                <div class="border border-gray-200 rounded-lg p-4 hover:border-gold/50 transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2">
                                <span class="text-xs font-bold text-gold bg-gold-10 px-2 py-0.5 rounded">
                                    {{ $pertanyaan->kategori }}
                                </span>
                                <span class="text-xs text-gray-400">#{{ $pertanyaan->urutan }}</span>
                            </div>
                            <p class="text-navy font-medium mt-1">{{ $pertanyaan->pertanyaan }}</p>
                        </div>
                        <div class="flex items-center space-x-1 ml-4" id="rating-{{ $pertanyaan->id }}">
                            @for($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer">
                                    <input type="radio" name="nilai[{{ $pertanyaan->id }}]" value="{{ $i }}"
                                           class="hidden peer" required
                                           onchange="updateStars({{ $pertanyaan->id }}, {{ $i }})">
                                    <svg class="w-8 h-8 rating-star rating-star-default peer-checked:rating-star-{{ $i }} transition"
                                         data-id="{{ $pertanyaan->id }}" data-value="{{ $i }}"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </label>
                            @endfor
                        </div>
                    </div>
                    @error("nilai.{$pertanyaan->id}")
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                @endforeach
            </div>

            <!-- Kritik & Saran -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="kritik" class="block text-sm font-medium text-navy mb-1">Kritik</label>
                    <textarea id="kritik" name="kritik" rows="3"
                              class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input"
                              placeholder="Masukkan kritik Anda...">{{ old('kritik') }}</textarea>
                </div>
                <div>
                    <label for="saran" class="block text-sm font-medium text-navy mb-1">Saran</label>
                    <textarea id="saran" name="saran" rows="3"
                              class="w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input"
                              placeholder="Masukkan saran Anda...">{{ old('saran') }}</textarea>
                </div>
            </div>

            <!-- Tombol -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="confirmSubmit()"
                        class="px-8 py-3 bg-navy text-white rounded-lg hover:bg-navy/90 transition font-medium text-lg">
                    Kirim Voting
                </button>
                <a href="{{ route('mahasiswa.voting') }}"
                   class="px-6 py-3 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div id="confirmModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/50" onclick="closeConfirmModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6 relative">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto bg-gold-10 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-navy mb-2">Konfirmasi Voting</h3>
                <p class="text-gray-500 text-sm mb-6">
                    Apakah Anda yakin dengan penilaian yang telah diberikan?
                    <br>
                    <span class="text-red-500 font-semibold">Voting tidak dapat diubah setelah dikirim!</span>
                </p>
                <div class="flex justify-center gap-3">
                    <button onclick="closeConfirmModal()"
                            class="px-6 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
                        Periksa Kembali
                    </button>
                    <button onclick="submitForm()"
                            class="px-6 py-2 bg-gold text-navy rounded-lg hover:bg-gold/90 transition text-sm font-medium">
                        Ya, Kirim Voting
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Update stars on selection
    function updateStars(questionId, value) {
        const stars = document.querySelectorAll(`#rating-${questionId} .rating-star`);
        stars.forEach((star, index) => {
            const starValue = parseInt(star.dataset.value);
            if (starValue <= value) {
                star.classList.remove('rating-star-default');
                star.classList.add(`rating-star-${starValue}`);
            } else {
                star.classList.remove(`rating-star-${starValue}`);
                star.classList.add('rating-star-default');
            }
        });
    }

    // Hover effect for stars
    document.querySelectorAll('.rating-star').forEach(star => {
        star.addEventListener('mouseenter', function() {
            const questionId = this.dataset.id;
            const value = parseInt(this.dataset.value);
            const stars = document.querySelectorAll(`#rating-${questionId} .rating-star`);
            stars.forEach((s, index) => {
                const sv = parseInt(s.dataset.value);
                if (sv <= value) {
                    s.classList.remove('rating-star-default');
                    s.classList.add(`rating-star-${sv}`);
                } else {
                    s.classList.remove(`rating-star-${sv}`);
                    s.classList.add('rating-star-default');
                }
            });
        });

        star.addEventListener('mouseleave', function() {
            const questionId = this.dataset.id;
            const checked = document.querySelector(`input[name="nilai[${questionId}]"]:checked`);
            const stars = document.querySelectorAll(`#rating-${questionId} .rating-star`);
            stars.forEach(s => {
                const sv = parseInt(s.dataset.value);
                s.classList.remove(`rating-star-${sv}`);
                if (checked && sv <= parseInt(checked.value)) {
                    s.classList.add(`rating-star-${sv}`);
                } else {
                    s.classList.add('rating-star-default');
                }
            });
        });
    });

    // Confirm Submit
    function confirmSubmit() {
        // Check if all questions answered
        const totalQuestions = {{ $pertanyaans->count() }};
        const answered = document.querySelectorAll('input[name^="nilai"]:checked').length;

        if (answered < totalQuestions) {
            alert('Silahkan jawab semua pertanyaan terlebih dahulu!');
            return;
        }

        document.getElementById('confirmModal').classList.remove('hidden');
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }

    function submitForm() {
        document.getElementById('votingForm').submit();
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeConfirmModal();
        }
    });
</script>
@endpush
@endsection
