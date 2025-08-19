<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // cek apakah sudah ada user dengan email yang sama
            $user = User::where('email', $googleUser->email)->first();
            $message = '';

            if ($user) {
                if (!$user->google_id) {
                    // akun manual → sekarang dihubungkan dengan Google
                    $user->update([
                        'google_id'        => $googleUser->id,
                        'avatar'           => $googleUser->avatar,
                        'email_verified_at'=> $user->email_verified_at ?? now(), // isi kalau masih null
                    ]);
                }
                $message = 'Anda berhasil masuk sebagai User.';
            } else {
                // kalau belum ada, buat user baru
                $user = User::create([
                    'google_id'        => $googleUser->id,
                    'name'             => $googleUser->name,
                    'email'            => $googleUser->email,
                    'avatar'           => $googleUser->avatar,
                    'role'             => 'user',
                    'password'         => bcrypt(Str::random(16)),
                    'email_verified_at'=> now(), // langsung verified
                    'remember_token'   => Str::random(60), // isi sekali saat create
                ]);
                $message = 'Anda berhasil masuk sebagai User.';
            }

            Auth::login($user);

            session()->flash('success', $message);
            return redirect()->route('user.aduan.riwayat');

        } catch (\Exception $e) {
            \Log::error('Google Login Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Gagal login: ' . $e->getMessage());
        }
    }
}
