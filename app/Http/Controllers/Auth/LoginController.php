<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\ActivityLog;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

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

        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->role === 'pimpinan') {
            return redirect()->intended(route('pimpinan.dashboard'));
        } elseif ($user->role === 'mahasiswa') {
            return redirect()->intended(route('mahasiswa.dashboard'));
        }

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        // Catat aktivitas logout
        if (Auth::check()) {
            ActivityLog::logActivity(
                Auth::id(),
                'Logout',
                'User ' . Auth::user()->nama . ' logout dari sistem'
            );
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
