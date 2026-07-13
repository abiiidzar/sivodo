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

        // Catat aktivitas login
        ActivityLog::logActivity(
            Auth::id(),
            'Login',
            'User ' . Auth::user()->nama . ' login ke sistem'
        );

        // Redirect berdasarkan role
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->isPimpinan()) {
            return redirect()->intended(route('pimpinan.dashboard'));
        } elseif ($user->isMahasiswa()) {
            return redirect()->intended(route('mahasiswa.dashboard'));
        }

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
     public function destroy(Request $request): RedirectResponse
    {
        // Catat aktivitas logout
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Logout',
                'deskripsi' => 'User ' . Auth::user()->nama . ' logout dari sistem',
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
