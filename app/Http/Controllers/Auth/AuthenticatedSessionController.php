<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
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
        // Authenticate the user
        $request->authenticate();

        // Regenerate session to prevent session fixation
        $request->session()->regenerate();

        $user = Auth::user();

        // Flash message based on role
        if ($user->role === 'admin') {
            session()->flash('success', 'Anda berhasil masuk sebagai Admin.');
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'superadmin') {
            session()->flash('success', 'Anda berhasil masuk sebagai Super Admin.');
            return redirect()->route('superadmin.dashboard');
        }

        session()->flash('success', 'Anda berhasil masuk sebagai User.');
        return redirect()->route('user.aduan.riwayat');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user(); // Simpan data user sebelum logout

        // Logout user
        Auth::guard('web')->logout();

        // Invalidate session dan regenerate token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Flash message berdasarkan peran user
        if ($user) {
            if ($user->role === 'admin') {
                $request->session()->flash('success', 'Anda berhasil log out dari Admin.');
            } elseif ($user->role === 'superadmin') {
                $request->session()->flash('success', 'Anda berhasil log out dari Super Admin.');
            } else {
                $request->session()->flash('success', 'Anda berhasil log out dari User.');
            }
        }

        return redirect('/login');
    }
}
