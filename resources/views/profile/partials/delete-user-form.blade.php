<div class="space-y-4">
    <p class="text-sm text-gray-600">
        Setelah akun Anda dihapus, semua data yang terkait akan dihapus secara permanen.
    </p>

    <button type="button" x-data @click="$dispatch('open-modal', 'confirm-user-deletion')"
            class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
        Hapus Akun
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                Apakah Anda yakin ingin menghapus akun?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Setelah akun dihapus, semua data akan hilang permanen. Masukkan password untuk konfirmasi.
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" name="password"
                       class="mt-1 w-full rounded-lg border-gray-200 focus:border-gold focus:ring-gold login-input"
                       placeholder="Masukkan password" required>
                @error('password', 'userDeletion')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <button type="button" x-on:click="$dispatch('close')"
                        class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 transition">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</div>
