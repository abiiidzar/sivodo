<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#1a2744] leading-tight">
            {{ __('Dashboard Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Info Mahasiswa -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 rounded-full bg-[#1a2744] text-white flex items-center justify-center text-3xl font-bold">
                        {{ substr($mahasiswa->nama, 0, 2) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-[#1a2744]">{{ $mahasiswa->nama }}</h3>
                        <p class="text-gray-500">{{ $mahasiswa->nim }} • {{ $mahasiswa->program_studi }}</p>
                        <p class="text-sm">Semester {{ $mahasiswa->semester }} • Kelas {{ $mahasiswa->kelas }}</p>
                        <p class="text-sm mt-1">
                            Status Voting:
                            <span class="font-semibold {{ $mahasiswa->status_voting == 'Sudah' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $mahasiswa->status_voting }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Semester Aktif -->
            <div class="bg-[rgba(201,162,39,0.08)] border border-[rgba(201,162,39,0.25)] rounded-lg p-4 mb-8">
                <p class="text-[#1a2744]">
                    <span class="font-bold">Semester Aktif:</span>
                    {{ $semesterAktif->tahun_ajaran ?? 'Belum Ada' }} -
                    {{ $semesterAktif->semester ?? '' }}
                </p>
            </div>

            <!-- Daftar Dosen -->
            <h3 class="font-semibold text-[#1a2744] text-lg mb-4">Daftar Dosen Semester Ini</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($dosens as $dosen)
                    <div class="bg-white rounded-lg shadow p-6 {{ isset($statusVoting[$dosen->id]) && $statusVoting[$dosen->id] ? 'opacity-70' : '' }}">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 rounded-full bg-[#1a2744] text-white flex items-center justify-center font-bold text-lg">
                                {{ substr($dosen->nama, 0, 2) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-[#1a2744]">{{ $dosen->nama }}</h4>
                                <p class="text-sm text-gray-500">{{ $dosen->nidn }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">{{ $dosen->program_studi }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xs px-2 py-1 bg-[rgba(26,39,68,0.10)] text-[#1a2744] rounded">
                                {{ $dosen->status_dosen }}
                            </span>
                            @if(isset($statusVoting[$dosen->id]) && $statusVoting[$dosen->id])
                                <span class="text-xs px-2 py-1 bg-green-500 text-white rounded">Sudah Dinilai</span>
                            @else
                                <a href="{{ route('mahasiswa.voting.create', $dosen->id) }}"
                                   class="text-sm text-[#1a2744] hover:text-[#c9a227] font-medium">
                                    Mulai Penilaian →
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
