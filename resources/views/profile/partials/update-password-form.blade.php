<form method="post" action="{{ route('password.update') }}" class="space-y-4">
    @csrf
    @method('put')

    <!-- Current Password -->
    <div>
        <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
        <input type="password" id="current_password" name="current_password"
               class="mt-1 w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input"
               autocomplete="current-password" required>
        @error('current_password')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- New Password -->
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
        <input type="password" id="password" name="password"
               class="mt-1 w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input"
               autocomplete="new-password" required>
        @error('password')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
               class="mt-1 w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input"
               autocomplete="new-password" required>
        @error('password_confirmation')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-4 pt-2">
        <button type="submit" class="px-6 py-2.5 bg-gold text-navy rounded-lg hover:bg-gold/90 transition font-medium">
            Ubah Password
        </button>

        @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
               class="text-sm text-emerald-600">
                Password berhasil diubah!
            </p>
        @endif
    </div>
</form>
