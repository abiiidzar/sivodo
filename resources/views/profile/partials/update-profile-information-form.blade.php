<form method="post" action="{{ route('profile.update') }}" class="space-y-4" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <!-- Nama -->
    <div>
        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" value="{{ old('nama', Auth::user()->nama) }}"
               class="mt-1 w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input" required>
        @error('nama')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Username -->
    <div>
        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
        <input type="text" id="username" name="username" value="{{ old('username', Auth::user()->username) }}"
               class="mt-1 w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input" required>
        @error('username')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}"
               class="mt-1 w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input" required>
        @error('email')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- No HP -->
    <div>
        <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor HP</label>
        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', Auth::user()->no_hp) }}"
               class="mt-1 w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input">
        @error('no_hp')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Foto -->
    <div>
        <label for="foto" class="block text-sm font-medium text-gray-700">Foto Profil</label>
        <div class="mt-1 flex items-center space-x-4">
            @if(Auth::user()->foto)
                <img src="{{ Storage::url(Auth::user()->foto) }}" alt="Foto" class="w-16 h-16 rounded-full object-cover border border-gray-200">
            @endif
            <input type="file" id="foto" name="foto" accept="image/*"
                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gold-10 file:text-gold hover:file:bg-gold-20">
        </div>
        @error('foto')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Hidden fields untuk data spesifik role -->
    @if(Auth::user()->isMahasiswa())
        @php $mahasiswa = Auth::user()->mahasiswa; @endphp
        <!-- Data Mahasiswa (readonly) -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">NIM</label>
                <input type="text" value="{{ $mahasiswa->nim ?? '-' }}" readonly
                       class="mt-1 w-full rounded-lg border-gray-200 bg-gray-50 text-gray-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Program Studi</label>
                <input type="text" value="{{ $mahasiswa->program_studi ?? '-' }}" readonly
                       class="mt-1 w-full rounded-lg border-gray-200 bg-gray-50 text-gray-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Semester</label>
                <input type="text" value="Semester {{ $mahasiswa->semester ?? '-' }}" readonly
                       class="mt-1 w-full rounded-lg border-gray-200 bg-gray-50 text-gray-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Kelas</label>
                <input type="text" value="{{ $mahasiswa->kelas ?? '-' }}" readonly
                       class="mt-1 w-full rounded-lg border-gray-200 bg-gray-50 text-gray-500">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Status Voting</label>
            <input type="text" value="{{ $mahasiswa->status_voting ?? 'Belum' }}" readonly
                   class="mt-1 w-full rounded-lg border-gray-200 bg-gray-50 {{ ($mahasiswa->status_voting ?? 'Belum') == 'Sudah' ? 'text-emerald-600' : 'text-red-500' }}">
        </div>
    @endif

    @if(Auth::user()->isAdmin())
        <!-- Data Admin (tambah field opsional) -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Role</label>
            <input type="text" value="{{ ucfirst(Auth::user()->role) }}" readonly
                   class="mt-1 w-full rounded-lg border-gray-200 bg-gray-50 text-gray-500">
        </div>
    @endif

    @if(Auth::user()->isPimpinan())
        <!-- Data Pimpinan -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Role</label>
            <input type="text" value="{{ ucfirst(Auth::user()->role) }}" readonly
                   class="mt-1 w-full rounded-lg border-gray-200 bg-gray-50 text-gray-500">
        </div>
    @endif

    <div class="flex items-center gap-4 pt-4">
        <button type="submit" class="px-6 py-2.5 bg-navy text-white rounded-lg hover:bg-navy/90 transition font-medium">
            Simpan Perubahan
        </button>

        @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
               class="text-sm text-emerald-600">
                Profil berhasil diperbarui!
            </p>
        @endif
    </div>
</form>
