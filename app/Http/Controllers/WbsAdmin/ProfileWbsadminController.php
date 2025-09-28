<?php

namespace App\Http\Controllers\WbsAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileWbsadminController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('wbs_admin.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
     public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        // 🔹 Upload foto langsung ke public/foto-profil
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('foto-profil');

            // Buat folder jika belum ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Pindahkan file ke folder public/foto-profil
            $file->move($destinationPath, $filename);

            // Simpan path relatif agar bisa dipanggil asset()
            $user->foto = 'foto-profil/' . $filename;
        }

        // 🔹 Update data user
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nik' => $validated['nik'] ?? null,
            'nomor_telepon' => $validated['nomor_telepon'] ?? null,
        ]);

        // 🔹 Reset email_verified_at jika email berubah
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('wbs_admin.profile.edit')->with('status', 'Profile updated successfully.');
    }

    public function resetFoto(Request $request)
    {
        $user = auth()->user();

        // 🔹 Hapus file foto lama langsung dari public
        if ($user->foto && file_exists(public_path($user->foto))) {
            unlink(public_path($user->foto));
        }

        $user->foto = null;
        $user->save();

        return redirect()->route('wbs_admin.profile.edit')->with('status', 'Foto berhasil direset.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        // Validate the password
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = $request->user();

        // Update the user's password securely
        $user->password = Hash::make($validated['password']);
        $user->save();

        // Redirect with success message
        return Redirect::route('wbs_admin.profile.edit')
            ->with('status', 'password-updated')
            ->with('active_tab', 'tab-password'); // tambahkan session active_tab
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validate the password before deleting the account
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Log out the user after deletion
        Auth::logout();

        // Delete the user from the database
        $user->delete();

        // Invalidate the session and regenerate the token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the homepage with a success message
        return Redirect::to('/')->with('status', 'Your account has been deleted successfully.');
    }
}
