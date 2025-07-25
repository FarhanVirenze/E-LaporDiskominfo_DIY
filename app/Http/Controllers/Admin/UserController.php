<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->input('role');

        $users = User::when($role, function ($query) use ($role) {
            return $query->where('role', $role);
        })->whereIn('role', ['user', 'admin'])->get();

        return view('admin.kelola-user.index', compact('users', 'role'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'nik' => 'required',
            'nomor_telepon' => 'required',
            'role' => 'required|in:user,admin,pimpinan,superadmin',
        ]);

        $user->update($request->only(['name', 'email', 'nik', 'nomor_telepon', 'role']));

        return redirect()->route('admin.kelola-user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.kelola-user.index')->with('success', 'User berhasil dihapus.');
    }
}
