<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Ambil user setelah authenticate
        $user = Auth::user();

        // Catat aktivitas login - PAKAI CREATE LANGSUNG
        ActivityLog::create([
            'user_id' => $user->id,
            'aktivitas' => 'Login',
            'deskripsi' => 'User ' . $user->nama . ' login ke sistem',
        ]);

        // Redirect berdasarkan role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isPimpinan()) {
            return redirect()->route('pimpinan.dashboard');
        } elseif ($user->isMahasiswa()) {
            return redirect()->route('mahasiswa.dashboard');
        }

        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     */
     public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            ActivityLog::create([
                'user_id' => $user->id,
                'aktivitas' => 'Logout',
                'deskripsi' => 'User ' . $user->nama . ' logout dari sistem',
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
