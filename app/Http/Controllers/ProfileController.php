<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Mahasiswa;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $mahasiswa = null;

        // Ambil data mahasiswa jika role-nya mahasiswa
        if ($user->isMahasiswa()) {
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        }

        return view('profile.edit', [
            'user' => $user,
            'mahasiswa' => $mahasiswa,
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Update user data
        $user->fill([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            $path = $request->file('foto')->store('profile-photos', 'public');
            $user->foto = $path;
        }

        $user->save();

        // Update data mahasiswa jika role-nya mahasiswa
        if ($user->isMahasiswa()) {
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            if ($mahasiswa) {
                $mahasiswa->update([
                    'nim' => $request->nim,
                    'nama' => $request->nama,
                    'program_studi' => $request->program_studi,
                    'semester' => $request->semester,
                    'kelas' => $request->kelas,
                ]);
            }
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Hapus foto jika ada
        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
