<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileSuperadminController extends Controller
{
    /**
     * Display the admin's profile form.
     */
    public function edit(Request $request): View
    {
        return view('superadmin.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the admin's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        // Upload foto
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto-profil', 'public');
            $user->foto = $fotoPath;
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nik' => $validated['nik'] ?? null,
            'nomor_telepon' => $validated['nomor_telepon'] ?? null,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('superadmin.profile.edit')->with('status', 'profile-updated');
    }

    public function resetFoto(Request $request)
    {
        $user = auth()->user();

        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->foto = null;
        $user->save();

        return redirect()->route('superadmin.profile.edit')->with('status', 'Foto berhasil direset.');
    }

    /**
     * Update the admin's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = $request->user();
        $user->password = Hash::make($validated['password']);
        $user->save();

        return Redirect::route('superadmin.profile.edit')->with('status', 'password-updated');
    }

    /**
     * Delete the admin account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'Your account has been deleted successfully.');
    }

    public function riwayat()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat riwayat aduan.');
        }

        $user = auth()->user();

        // Tidak peduli role-nya apa, ambil aduan berdasarkan siapa yang mengajukan (user_id)
        $aduan = Report::where('user_id', $user->id_user)
            ->latest()
            ->get(['id', 'tracking_id', 'judul', 'status', 'created_at']);

        return view('superadmin.daftar-aduan.riwayat', compact('aduan'));
    }

    public function riwayatWbs()
    {
        // Misal: pakai model WbsReport, atau kamu bisa sesuaikan sendiri
        if (auth()->user()->role === 'admin') {
            $aduan = Report::where('kategori_id', 999)
                ->latest()
                ->get(['id', 'tracking_id', 'judul', 'status', 'created_at']);
        } else {
            $aduan = Report::where('user_id', auth()->id())
                ->where('kategori_id', 999)
                ->latest()
                ->get(['id', 'tracking_id', 'judul', 'status', 'created_at']);
        }
        return view('superadmin.daftar-aduan.riwayat-wbs', compact('aduan'));
    }
}
