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

    <!-- Foto dengan Preview -->
    <div>
        <label for="foto" class="block text-sm font-medium text-gray-700">Foto Profil</label>
        <div class="mt-1 flex items-center space-x-4">
            <!-- Preview Foto -->
            <div id="fotoPreviewContainer" class="w-16 h-16 rounded-full border-2 border-gray-200 overflow-hidden flex items-center justify-center bg-gray-50 flex-shrink-0">
                @if(Auth::user()->foto)
                    <img id="fotoPreview" src="{{ Storage::url(Auth::user()->foto) }}" alt="Foto" class="w-full h-full object-cover">
                @else
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                @endif
            </div>

            <div class="flex-1">
                <input type="file" id="foto" name="foto" accept="image/*"
                       onchange="previewFoto(event)"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gold-10 file:text-gold hover:file:bg-gold-20">
                <p class="mt-1 text-xs text-gray-400">Format: JPEG, PNG, JPG. Maksimal 2MB</p>
            </div>
        </div>
        @error('foto')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Hidden fields untuk data spesifik role -->
    @if(Auth::user()->isMahasiswa())
        @php $mahasiswa = Auth::user()->mahasiswa; @endphp
        <input type="hidden" name="nim" value="{{ $mahasiswa->nim ?? '' }}">
        <input type="hidden" name="program_studi" value="{{ $mahasiswa->program_studi ?? '' }}">
        <input type="hidden" name="semester" value="{{ $mahasiswa->semester ?? '' }}">
        <input type="hidden" name="kelas" value="{{ $mahasiswa->kelas ?? '' }}">

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
            <input type="text"
                   value="{{ $sudah_voting ?? 0 }}/{{ $total_dosen ?? 0 }} {{ ($sudah_voting ?? 0) > 0 ? 'Sudah' : 'Belum' }}"
                   readonly
                   class="mt-1 w-full rounded-lg border-gray-200 bg-gray-50 {{ ($sudah_voting ?? 0) > 0 ? 'text-emerald-600' : 'text-red-500' }}">
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

@push('scripts')
<script>
    function previewFoto(event) {
        const input = event.target;
        const previewContainer = document.getElementById('fotoPreviewContainer');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Hapus semua konten di preview container
                previewContainer.innerHTML = '';

                // Buat img baru
                const img = document.createElement('img');
                img.id = 'fotoPreview';
                img.src = e.target.result;
                img.alt = 'Preview Foto';
                img.className = 'w-full h-full object-cover';

                previewContainer.appendChild(img);
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            // Jika tidak ada file, kembalikan ke default
            const userFoto = '{{ Auth::user()->foto ? Storage::url(Auth::user()->foto) : '' }}';
            previewContainer.innerHTML = '';

            if (userFoto) {
                const img = document.createElement('img');
                img.id = 'fotoPreview';
                img.src = userFoto;
                img.alt = 'Foto';
                img.className = 'w-full h-full object-cover';
                previewContainer.appendChild(img);
            } else {
                const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                svg.setAttribute('class', 'w-8 h-8 text-gray-400');
                svg.setAttribute('fill', 'none');
                svg.setAttribute('stroke', 'currentColor');
                svg.setAttribute('viewBox', '0 0 24 24');

                const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                path.setAttribute('stroke-linecap', 'round');
                path.setAttribute('stroke-linejoin', 'round');
                path.setAttribute('stroke-width', '2');
                path.setAttribute('d', 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z');

                svg.appendChild(path);
                previewContainer.appendChild(svg);
            }
        }
    }
</script>
@endpush
