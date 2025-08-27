<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan form registrasi
     */
    public function create(): View
    {
        return view('auth.register'); // pastikan view ini ada
    }

    /**
     * Proses penyimpanan user baru
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['nullable', 'string', 'max:50', 'unique:users,nik'],
            'nomor_telepon' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'nomor_telepon' => $request->nomor_telepon,
            'email' => $request->email,
            'role' => 'user', // default role
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),              // ✅ langsung dianggap verified
            'remember_token' => Str::random(60),    // ✅ sama kayak admin
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('beranda')->with('success', 'Anda berhasil masuk sebagai User.');
    }
}