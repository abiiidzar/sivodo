@extends('layouts.app')

@section('title', 'Profile')
@section('header', 'Profile Saya')

@section('content')
<div class="w-full h-full">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sidebar Profile -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <div class="flex flex-col items-center text-center">
                    <div class="w-32 h-32 rounded-full bg-gold-15 border-2 border-gold flex items-center justify-center overflow-hidden mb-4">
                        @if(Auth::user()->foto)
                            <img src="{{ Storage::url(Auth::user()->foto) }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <span class="text-gold text-4xl font-bold">{{ substr(Auth::user()->nama, 0, 2) }}</span>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-navy">{{ Auth::user()->nama }}</h3>
                    <p class="text-gray-500 text-sm">{{ Auth::user()->email }}</p>
                    <span class="mt-2 px-3 py-1 bg-gold-10 text-gold text-xs font-semibold rounded-full uppercase">{{ Auth::user()->role }}</span>

                    @if(Auth::user()->isMahasiswa())
                        @php $mahasiswa = Auth::user()->mahasiswa; @endphp
                        <div class="w-full mt-4 pt-4 border-t border-gray-100 text-left">
                            <p class="text-xs text-gray-400">NIM</p>
                            <p class="text-sm font-semibold text-navy">{{ $mahasiswa->nim ?? '-' }}</p>
                            <p class="text-xs text-gray-400 mt-2">Program Studi</p>
                            <p class="text-sm font-semibold text-navy">{{ $mahasiswa->program_studi ?? '-' }}</p>
                            <p class="text-xs text-gray-400 mt-2">Semester</p>
                            <p class="text-sm font-semibold text-navy">Semester {{ $mahasiswa->semester ?? '-' }}</p>
                            <p class="text-xs text-gray-400 mt-2">Kelas</p>
                            <p class="text-sm font-semibold text-navy">{{ $mahasiswa->kelas ?? '-' }}</p>
                            <p class="text-xs text-gray-400 mt-2">Status Voting</p>
                            <p class="text-sm font-semibold {{ ($mahasiswa->status_voting ?? 'Belum') == 'Sudah' ? 'text-emerald-600' : 'text-red-500' }}">
                                {{ $sudah_voting ?? 0 }}/{{ $total_dosen ?? 0 }} {{ $mahasiswa->status_voting ?? 'Belum' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Form Profile -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Update Profile Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h4 class="font-semibold text-navy mb-4">Informasi Profil</h4>
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Update Password -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h4 class="font-semibold text-navy mb-4">Ubah Password</h4>
                @include('profile.partials.update-password-form')
            </div>

            <!-- Delete Account -->
            @if(!Auth::user()->isMahasiswa())
            <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6">
                <h4 class="font-semibold text-red-600 mb-4">Hapus Akun</h4>
                @include('profile.partials.delete-user-form')
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
