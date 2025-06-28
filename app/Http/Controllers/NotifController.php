<?php

namespace App\Http\Controllers;

use App\Models\Notif;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotifController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // User hanya lihat notifikasi miliknya
        if ($user->role === 'user') {
            $notifs = Notif::where('id_user', $user->id_user)->latest()->get();
        } else {
            // Admin dan pimpinan bisa lihat semua
            $notifs = Notif::with('user')->latest()->get();
        }

        return view('notifs.index', compact('notifs'));
    }

    public function create()
    {
        // Hanya admin yang bisa buat notifikasi manual
        if (Auth::user()->role !== 'admin') abort(403);

        $users = User::where('role', 'user')->get();
        return view('notifs.form', ['users' => $users, 'notif' => null]);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $request->validate([
            'id_user'       => 'required|exists:users,id_user',
            'jenis_notif'   => 'required|string|max:255',
            'keterangan'    => 'required|string|max:500',
            'status'        => 'in:terbaca,belum terbaca',
        ]);

        Notif::create([
            'id_user'     => $request->id_user,
            'jenis_notif' => $request->jenis_notif,
            'keterangan'  => $request->keterangan,
            'status'      => $request->status ?? 'belum terbaca',
            'tanggal'     => now()->toDateString(),
            'waktu'       => now()->format('H:i'),
        ]);

        return redirect()->route('notifs.index')->with('success', 'Notifikasi berhasil ditambahkan.');
    }

    public function edit(Notif $notif)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $users = User::where('role', 'user')->get();
        return view('notifs.form', compact('notif', 'users'));
    }

    public function update(Request $request, Notif $notif)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $request->validate([
            'id_user'       => 'required|exists:users,id_user',
            'jenis_notif'   => 'required|string|max:255',
            'keterangan'    => 'required|string|max:500',
            'status'        => 'in:terbaca,belum terbaca',
        ]);

        $notif->update([
            'id_user'       => $request->id_user,
            'jenis_notif'   => $request->jenis_notif,
            'keterangan'    => $request->keterangan,
            'status'        => $request->status,
        ]);

        return redirect()->route('notifs.index')->with('success', 'Notifikasi berhasil diperbarui.');
    }

    public function destroy(Notif $notif)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $notif->delete();
        return redirect()->route('notifs.index')->with('success', 'Notifikasi berhasil dihapus.');
    }

public function show(Notif $notif)
{
    $user = Auth::user();

    // Hanya role user dan hanya notifikasinya sendiri yang bisa lihat
    if ($user->role !== 'user' || $user->id_user !== $notif->id_user) {
        abort(403);
    }

    // Ubah status menjadi terbaca jika belum
    if ($notif->status === 'belum terbaca') {
        $notif->update(['status' => 'terbaca']);
    }

    return view('notifs.show', compact('notif'));
}

}
