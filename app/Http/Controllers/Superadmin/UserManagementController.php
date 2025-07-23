<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index() {
        $users = User::where('role', '!=', 'superadmin')->get();
        return view('superadmin.users.index', compact('users'));
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        return view('superadmin.users.edit', compact('user'));
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'role']));
        return redirect()->route('superadmin.users.index')->with('success', 'User diperbarui.');
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User dihapus.');
    }
}
